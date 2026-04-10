<?php

namespace App\Controllers;

use App\Models\RequestModel;
use App\Models\UserModel;
use App\Models\AcceptedRequestModel;
use App\Models\PaymentModel;
use App\Models\RequestNotificationModel;

class Request extends BaseController
{
    public function create()
    {
        $data['title'] = 'Post Request | Pasa-Buy';
        return view('post_request_page', $data);
    }

    public function process()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/login')->with('error', 'Please login first.');
        }

        $requestModel = new RequestModel();
        $paymentMethod = trim((string) $this->request->getPost('payment_method'));

        $paymentStatus = $paymentMethod === 'cod' ? 'cod_pending' : 'unpaid';

        $data = [
            'user_id'           => session('user_id'),
            'item_name'         => $this->request->getPost('item_name'),
            'category'          => $this->request->getPost('category'),
            'quantity'          => $this->request->getPost('quantity') ?: 1,
            'brand'             => $this->request->getPost('brand'),
            'item_notes'        => $this->request->getPost('item_notes'),
            'store_name'        => $this->request->getPost('store_name'),
            'alt_store'         => $this->request->getPost('alt_store'),
            'store_address'     => $this->request->getPost('store_address'),
            'delivery_address'  => $this->request->getPost('delivery_address'),
            'contact_number'    => $this->request->getPost('contact_number'),
            'landmark'          => $this->request->getPost('landmark'),
            'delivery_notes'    => $this->request->getPost('delivery_notes'),
            'estimated_price'   => $this->request->getPost('estimated_price') ?: 0.00,
            'service_fee'       => $this->request->getPost('service_fee') ?: 0.00,
            'payment_method'    => $paymentMethod,
            'payment_status'    => $paymentStatus,
            'paid_at'           => null,
            'urgency'           => $this->request->getPost('urgency'),
            'status'            => 'pending'
        ];

        $requiredFields = [
            'item_name',
            'category',
            'store_name',
            'store_address',
            'delivery_address',
            'contact_number',
            'payment_method',
            'urgency'
        ];

        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                return redirect()->back()->with('error', 'Please fill in all required fields.');
            }
        }

        if ($requestModel->insert($data)) {
            return redirect()->to('/my-requests')->with('success', 'Request posted successfully!');
        }

        return redirect()->back()->with('error', 'Failed to post request. Please try again.');
    }

    public function browse()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/login')->with('error', 'Please login to browse requests.');
        }

        $requestModel = new RequestModel();

        $query = $requestModel
            ->where('status', 'pending')
            ->where('user_id !=', session('user_id'));

        $search   = $this->request->getGet('search');
        $category = $this->request->getGet('category');
        $urgency  = $this->request->getGet('urgency');
        $sort     = $this->request->getGet('sort');

        if (!empty($search)) {
            $query->groupStart()
                ->like('item_name', $search)
                ->orLike('store_name', $search)
                ->groupEnd();
        }

        if (!empty($category)) {
            $query->where('category', $category);
        }

        if (!empty($urgency)) {
            $query->where('urgency', $urgency);
        }

        if ($sort === 'highest_fee') {
            $query->orderBy('service_fee', 'DESC');
        } else {
            $query->orderBy('created_at', 'DESC');
        }

        $data['requests'] = $query->findAll();
        $data['title'] = 'Browse Requests | Pasa-Buy';

        return view('browse_requests_page', $data);
    }

    public function accept($id)
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/login')->with('error', 'Please login first.');
        }

        $requestModel = new RequestModel();
        $acceptedRequestModel = new AcceptedRequestModel();
        $userModel = new UserModel();
        $notificationModel = new RequestNotificationModel();

        $runnerId = session('user_id');
        $request = $requestModel->find($id);

        if (!$request || $request['status'] !== 'pending') {
            return redirect()->to('/browse-requests')->with('error', 'Request not available for acceptance.');
        }

        if ((string) $request['user_id'] === (string) $runnerId) {
            return redirect()->to('/browse-requests')->with('error', 'You cannot accept your own request.');
        }

        $existingAccepted = $acceptedRequestModel
            ->where('request_id', $id)
            ->first();

        if ($existingAccepted) {
            return redirect()->to('/browse-requests')->with('error', 'This request has already been accepted.');
        }

        $requestModel->update($id, ['status' => 'accepted']);

        $acceptedRequestModel->insert([
            'request_id'  => $id,
            'runner_id'   => $runnerId,
            'status'      => 'accepted',
            'accepted_at' => date('Y-m-d H:i:s')
        ]);

        $runner = $userModel->find($runnerId);
        $runnerName = trim(($runner['first_name'] ?? '') . ' ' . ($runner['last_name'] ?? ''));

        $notificationModel->insert([
            'user_id'    => $request['user_id'],
            'sender_id'  => $runnerId,
            'request_id' => $id,
            'type'       => 'request_accepted',
            'title'      => 'Your request was accepted',
            'content'    => $runnerName . ' accepted your request for ' . $request['item_name'] . '.',
            'is_read'    => 0,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/accepted-requests')->with('success', 'Request accepted successfully.');
    }

    public function acceptedRequests()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/login')->with('error', 'Please login first.');
        }

        $status = $this->request->getGet('status');

        $builder = db_connect()->table('accepted_requests ar')
            ->select('ar.id as accepted_id, ar.request_id, ar.runner_id, ar.status as accepted_status, ar.accepted_at, r.*, u.first_name, u.last_name, u.id as user_id')
            ->join('requests r', 'r.id = ar.request_id')
            ->join('users u', 'u.id = r.user_id')
            ->where('ar.runner_id', session('user_id'));

        if (!empty($status) && $status !== 'all') {
            $builder->where('ar.status', $status);
        }

        $data['acceptedRequests'] = $builder
            ->orderBy('ar.accepted_at', 'DESC')
            ->get()
            ->getResultArray();

        $data['title'] = 'Accepted Requests | Pasa-Buy';
        $data['currentStatus'] = $status;

        return view('accepted_requests_page', $data);
    }

    public function payRunner($requestId)
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/login')->with('error', 'Please login first.');
        }

        $requestModel = new RequestModel();
        $acceptedRequestModel = new AcceptedRequestModel();
        $userModel = new UserModel();
        $paymentModel = new PaymentModel();
        $notificationModel = new RequestNotificationModel();
        $db = db_connect();

        $request = $requestModel->find($requestId);

        if (!$request) {
            return redirect()->back()->with('error', 'Request not found.');
        }

        if ((int) $request['user_id'] !== (int) session('user_id')) {
            return redirect()->back()->with('error', 'Only the requester can make this payment.');
        }

        if ($request['payment_method'] === 'cod') {
            return redirect()->back()->with('error', 'COD requests are paid in person, not through wallet.');
        }

        if ($request['payment_status'] === 'paid') {
            return redirect()->back()->with('error', 'This request is already paid.');
        }

        if (!in_array($request['status'], ['accepted', 'on_the_way'], true)) {
            return redirect()->back()->with('error', 'You can only pay when the request is already accepted or on the way.');
        }

        $acceptedInfo = $acceptedRequestModel->where('request_id', $requestId)->first();

        if (!$acceptedInfo) {
            return redirect()->back()->with('error', 'No runner assigned yet.');
        }

        $requester = $userModel->find(session('user_id'));
        $runner = $userModel->find($acceptedInfo['runner_id']);

        if (!$runner) {
            return redirect()->back()->with('error', 'Runner not found.');
        }

        $amount = (float) $request['estimated_price'] + (float) $request['service_fee'];
        $requesterBalance = (float) ($requester['wallet_balance'] ?? 0);

        if ($requesterBalance < $amount) {
            return redirect()->back()->with('error', 'Insufficient wallet balance.');
        }

        $db->transStart();

        $userModel->update($requester['id'], [
            'wallet_balance' => $requesterBalance - $amount
        ]);

        $runnerBalance = (float) ($runner['wallet_balance'] ?? 0);
        $userModel->update($runner['id'], [
            'wallet_balance' => $runnerBalance + $amount
        ]);

        $paymentSource = $request['payment_method'];

        $paymentModel->insert([
            'user_id' => $requester['id'],
            'request_id' => $requestId,
            'receiver_id' => $runner['id'],
            'amount' => $amount,
            'type' => 'request_payment',
            'source' => $paymentSource,
            'status' => 'completed',
            'reference_no' => null,
            'description' => 'Paid runner for request #' . $requestId,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $paymentModel->insert([
            'user_id' => $runner['id'],
            'request_id' => $requestId,
            'receiver_id' => null,
            'amount' => $amount,
            'type' => 'commission_received',
            'source' => $paymentSource,
            'status' => 'completed',
            'reference_no' => null,
            'description' => 'Received payment for request #' . $requestId,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $requestModel->update($requestId, [
            'payment_status' => 'paid',
            'paid_at' => date('Y-m-d H:i:s')
        ]);

        $notificationModel->insert([
            'user_id'    => $runner['id'],
            'sender_id'  => $requester['id'],
            'request_id' => $requestId,
            'type'       => 'runner_paid',
            'title'      => 'Requester already paid',
            'content'    => 'The requester paid you for request #' . $requestId . '. You can now complete the delivery.',
            'is_read'    => 0,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $db->transComplete();

        if (!$db->transStatus()) {
            return redirect()->back()->with('error', 'Payment failed.');
        }

        return redirect()->back()->with('success', 'Runner paid successfully through wallet.');
    }

    public function updateAcceptedStatus($requestId)
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/login')->with('error', 'Please login first.');
        }

        $newStatus = $this->request->getPost('status');
        $codConfirmed = $this->request->getPost('cod_confirmed');
        $allowedStatuses = ['on_the_way', 'delivered'];

        if (!in_array($newStatus, $allowedStatuses, true)) {
            return redirect()->to('/accepted-requests')->with('error', 'Invalid status selected.');
        }

        $acceptedRequestModel = new AcceptedRequestModel();
        $requestModel = new RequestModel();
        $notificationModel = new RequestNotificationModel();

        $accepted = $acceptedRequestModel
            ->where('request_id', $requestId)
            ->where('runner_id', session('user_id'))
            ->first();

        if (!$accepted) {
            return redirect()->to('/accepted-requests')->with('error', 'Accepted request not found.');
        }

        if ($accepted['status'] === 'delivered') {
            return redirect()->to('/accepted-requests')->with('error', 'This request is already marked as delivered.');
        }

        if ($accepted['status'] === 'accepted' && $newStatus === 'delivered') {
            return redirect()->to('/accepted-requests')->with('error', 'Please mark the request as On the Way before Delivered.');
        }

        $request = $requestModel->find($requestId);

        if (!$request) {
            return redirect()->to('/accepted-requests')->with('error', 'Request not found.');
        }

        if ($newStatus === 'delivered') {
            if ($request['payment_method'] === 'cod') {
                if ($codConfirmed !== '1') {
                    return redirect()->to('/accepted-requests')->with('error', 'Please confirm that COD payment was received first.');
                }

                $requestModel->update($requestId, [
                    'payment_status' => 'paid_cod',
                    'paid_at' => date('Y-m-d H:i:s')
                ]);
            } else {
                if ($request['payment_status'] !== 'paid') {
                    return redirect()->to('/accepted-requests')->with('error', 'The requester must pay first before you can mark this as delivered.');
                }
            }
        }

        $acceptedRequestModel->update($accepted['id'], ['status' => $newStatus]);
        $requestModel->update($requestId, ['status' => $newStatus]);

        if ($newStatus === 'on_the_way') {
            $notificationModel->insert([
                'user_id'    => $request['user_id'],
                'sender_id'  => session('user_id'),
                'request_id' => $requestId,
                'type'       => 'on_the_way',
                'title'      => 'Your request is on the way',
                'content'    => 'The runner marked your request #' . $requestId . ' as on the way.',
                'is_read'    => 0,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }

        if ($newStatus === 'delivered') {
            $notificationModel->insert([
                'user_id'    => $request['user_id'],
                'sender_id'  => session('user_id'),
                'request_id' => $requestId,
                'type'       => 'delivered',
                'title'      => 'Your request was delivered',
                'content'    => 'The runner marked your request #' . $requestId . ' as delivered.',
                'is_read'    => 0,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            if ($request['payment_method'] === 'cod') {
                $notificationModel->insert([
                    'user_id'    => $request['user_id'],
                    'sender_id'  => session('user_id'),
                    'request_id' => $requestId,
                    'type'       => 'cod_paid',
                    'title'      => 'COD payment confirmed',
                    'content'    => 'The runner confirmed that COD payment was received for request #' . $requestId . '.',
                    'is_read'    => 0,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
        }

        return redirect()->to('/accepted-requests')->with(
            'success',
            'Request status updated to ' . ucfirst(str_replace('_', ' ', $newStatus)) . '.'
        );
    }

    public function details($id = null)
    {
        if (!$id || !session()->has('user_id')) {
            return redirect()->to('/browse-requests');
        }

        $requestModel = new RequestModel();
        $userModel = new UserModel();
        $acceptedRequestModel = new AcceptedRequestModel();

        $request = $requestModel->find($id);

        if (!$request) {
            return redirect()->to('/browse-requests')->with('error', 'Request not found.');
        }

        $requester = $userModel->find($request['user_id']);

        if (!$requester) {
            return redirect()->to('/browse-requests')->with('error', 'Requester not found.');
        }

        $acceptedInfo = $acceptedRequestModel->where('request_id', $id)->first();

        $data['request'] = $request;
        $data['requester'] = $requester;
        $data['acceptedInfo'] = $acceptedInfo;
        $data['title'] = 'Request Details | Pasa-Buy';
        $data['requestId'] = $id;

        return view('request_details_page', $data);
    }

    public function myRequests()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/login')->with('error', 'Please login first.');
        }

        $requestModel = new RequestModel();
        $userId = session('user_id');
        $status = $this->request->getGet('status');

        $query = $requestModel->where('user_id', $userId);

        if (!empty($status) && $status !== 'all') {
            $query->where('status', $status);
        }

        $data['requests'] = $query
            ->orderBy('created_at', 'DESC')
            ->findAll();

        $data['title'] = 'My Requests | Pasa-Buy';
        $data['currentStatus'] = $status;

        return view('my_requests_page', $data);
    }
}