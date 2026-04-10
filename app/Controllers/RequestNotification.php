<?php

namespace App\Controllers;

use App\Models\RequestNotificationModel;

class RequestNotification extends BaseController
{
    public function index()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/login')->with('error', 'Please login first.');
        }

        $notificationModel = new RequestNotificationModel();
        $userId = session('user_id');

        $notifications = $notificationModel
            ->select('request_notifications.*, users.first_name, users.last_name')
            ->join('users', 'users.id = request_notifications.sender_id', 'left')
            ->where('request_notifications.user_id', $userId)
            ->orderBy('request_notifications.created_at', 'DESC')
            ->findAll();

        return view('notifications_page', [
            'title' => 'Notifications | Pasa-Buy',
            'notifications' => $notifications
        ]);
    }

    public function open($id)
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/login')->with('error', 'Please login first.');
        }

        $notificationModel = new RequestNotificationModel();

        $notification = $notificationModel
            ->where('id', $id)
            ->where('user_id', session('user_id'))
            ->first();

        if (!$notification) {
            return redirect()->to('/notifications')->with('error', 'Notification not found.');
        }

        $notificationModel->update($id, ['is_read' => 1]);

        if (!empty($notification['request_id'])) {
            return redirect()->to(base_url('request-details/' . $notification['request_id']));
        }

        return redirect()->to('/notifications');
    }

    public function markAllRead()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/login')->with('error', 'Please login first.');
        }

        $notificationModel = new RequestNotificationModel();

        $notificationModel
            ->where('user_id', session('user_id'))
            ->where('is_read', 0)
            ->set(['is_read' => 1])
            ->update();

        return redirect()->to('/notifications')->with('success', 'All notifications marked as read.');
    }
}