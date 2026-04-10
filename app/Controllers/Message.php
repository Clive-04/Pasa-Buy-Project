<?php

namespace App\Controllers;

use App\Models\MessageModel;
use App\Models\UserModel;

class Message extends BaseController
{
    public function index()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/login')->with('error', 'Please login first.');
        }

        $messageModel = new MessageModel();
        $userModel = new UserModel();
        $db = db_connect();

        $loggedInUserId = session('user_id');
        $selectedUserId = $this->request->getGet('user_id');
        $requestId = $this->request->getGet('request_id');

        // Mark message notifications as read for the selected conversation
        if (!empty($selectedUserId)) {
            $messageIds = $db->table('messages')
                ->select('id')
                ->groupStart()
                    ->groupStart()
                        ->where('sender_id', $selectedUserId)
                        ->where('receiver_id', $loggedInUserId)
                    ->groupEnd()
                    ->orGroupStart()
                        ->where('sender_id', $loggedInUserId)
                        ->where('receiver_id', $selectedUserId)
                    ->groupEnd()
                ->groupEnd()
                ->get()
                ->getResultArray();

            $messageIds = array_column($messageIds, 'id');

            if (!empty($messageIds)) {
                $db->table('notifications')
                    ->where('user_id', $loggedInUserId)
                    ->where('sender_id', $selectedUserId)
                    ->where('type', 'message')
                    ->whereIn('message_id', $messageIds)
                    ->update(['is_read' => 1]);
            }
        }

        $search = trim((string) $this->request->getGet('search'));

        $selectedUser = null;
        $messages = [];

        if (!empty($selectedUserId) && (string) $selectedUserId !== (string) $loggedInUserId) {
            $selectedUser = $userModel->find($selectedUserId);

            $builder = $messageModel
                ->groupStart()
                    ->groupStart()
                        ->where('sender_id', $loggedInUserId)
                        ->where('receiver_id', $selectedUserId)
                    ->groupEnd()
                    ->orGroupStart()
                        ->where('sender_id', $selectedUserId)
                        ->where('receiver_id', $loggedInUserId)
                    ->groupEnd()
                ->groupEnd();

            if (!empty($requestId)) {
                $builder->where('request_id', $requestId);
            }

            $messages = $builder
                ->orderBy('created_at', 'ASC')
                ->findAll();
        }

        $searchSql = '';
        $params = [
            $loggedInUserId,
            $loggedInUserId,
            $loggedInUserId,
            $loggedInUserId,
            $loggedInUserId,
            $loggedInUserId
        ];

        if ($search !== '') {
            $searchSql = " AND (
                u.first_name LIKE ?
                OR u.last_name LIKE ?
                OR m1.message LIKE ?
            )";

            $like = '%' . $search . '%';
            $params[] = $like;
            $params[] = $like;
            $params[] = $like;
        }

        $conversationQuery = $db->query("
            SELECT
                m1.id,
                m1.sender_id,
                m1.receiver_id,
                m1.request_id,
                m1.message,
                m1.attachment_name,
                m1.attachment_path,
                m1.attachment_type,
                m1.created_at,
                u.id AS user_id,
                u.first_name,
                u.last_name,
                (
                    SELECT COUNT(*)
                    FROM notifications n
                    INNER JOIN messages m2 ON m2.id = n.message_id
                    WHERE n.user_id = ?
                    AND n.sender_id = u.id
                    AND n.type = 'message'
                    AND n.is_read = 0
                ) AS unread_count
            FROM messages m1
            INNER JOIN (
                SELECT
                    CASE
                        WHEN sender_id = ? THEN receiver_id
                        ELSE sender_id
                    END AS other_user_id,
                    MAX(created_at) AS latest_time
                FROM messages
                WHERE sender_id = ? OR receiver_id = ?
                GROUP BY other_user_id
            ) latest
                ON (
                    (
                        (m1.sender_id = ? AND m1.receiver_id = latest.other_user_id)
                        OR
                        (m1.receiver_id = ? AND m1.sender_id = latest.other_user_id)
                    )
                    AND m1.created_at = latest.latest_time
                )
            INNER JOIN users u ON u.id = latest.other_user_id
            WHERE 1=1
            $searchSql
            ORDER BY m1.created_at DESC
        ", $params);

        $data['title'] = 'Messages | Pasa-Buy';
        $data['selectedUserId'] = $selectedUserId;
        $data['selectedUser'] = $selectedUser;
        $data['messages'] = $messages;
        $data['requestId'] = $requestId;
        $data['conversations'] = $conversationQuery->getResultArray();
        $data['search'] = $search;

        return view('messages_page', $data);
    }

    public function send()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/login')->with('error', 'Please login first.');
        }

        $messageModel = new MessageModel();
        $db = db_connect();

        $senderId = session('user_id');
        $receiverId = $this->request->getPost('receiver_id');
        $requestId = $this->request->getPost('request_id');
        $message = trim((string) $this->request->getPost('message'));
        $attachment = $this->request->getFile('attachment');

        $attachmentName = null;
        $attachmentPath = null;
        $attachmentType = null;

        if ($attachment && $attachment->getName() !== '') {
            if (!$attachment->isValid()) {
                return redirect()->back()->with('error', 'File upload failed: ' . $attachment->getErrorString());
            }

            if ($attachment->hasMoved()) {
                return redirect()->back()->with('error', 'The uploaded file is no longer available.');
            }

            $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'pdf', 'doc', 'docx'];
            $extension = strtolower($attachment->getClientExtension());

            if (!in_array($extension, $allowedExtensions, true)) {
                return redirect()->back()->with('error', 'Invalid file type. Allowed: JPG, PNG, WEBP, PDF, DOC, DOCX.');
            }

            if ($attachment->getSize() > 5 * 1024 * 1024) {
                return redirect()->back()->with('error', 'File size must not exceed 5MB.');
            }

            $uploadPath = FCPATH . 'uploads/message_attachments/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $newName = $attachment->getRandomName();
            $attachment->move($uploadPath, $newName);

            $attachmentName = $attachment->getClientName();
            $attachmentPath = 'uploads/message_attachments/' . $newName;
            $attachmentType = $extension;
        }

        if (empty($receiverId)) {
            return redirect()->back()->with('error', 'Message could not be sent.');
        }

        if ((string) $senderId === (string) $receiverId) {
            return redirect()->back()->with('error', 'You cannot message yourself.');
        }

        if ($message === '' && empty($attachmentPath)) {
            return redirect()->back()->with('error', 'Please type a message or attach a file.');
        }

        $messageId = $messageModel->insert([
            'sender_id'       => $senderId,
            'receiver_id'     => $receiverId,
            'request_id'      => !empty($requestId) ? $requestId : null,
            'message'         => $message,
            'attachment_name' => $attachmentName,
            'attachment_path' => $attachmentPath,
            'attachment_type' => $attachmentType
        ]);

        $db->table('notifications')->insert([
            'user_id'    => $receiverId,
            'sender_id'  => $senderId,
            'message_id' => $messageId,
            'type'       => 'message',
            'is_read'    => 0,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $redirectUrl = 'messages?user_id=' . $receiverId;
        if (!empty($requestId)) {
            $redirectUrl .= '&request_id=' . $requestId;
        }

        return redirect()->to(base_url($redirectUrl))->with('success', 'Message sent.');
    }
}