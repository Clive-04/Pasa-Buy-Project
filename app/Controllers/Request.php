<?php

namespace App\Controllers;

use App\Models\RequestModel;
use App\Models\UserModel;
use App\Models\AcceptedRequestModel;

class Request extends BaseController
{
    public function create()
    {
        $data['title'] = 'Post Request | Pasa-Buy';
        return view('post_request_page', $data);
    }

    public function process()
    {
        // Check if user is logged in
        if (!session()->has('user_id')) {
            return redirect()->to('/login')->with('error', 'Please login first.');
        }

        $requestModel = new RequestModel();

        // Get form data
        $data = [
            'user_id' => session('user_id'),
            'item_name' => $this->request->getPost('item_name'),
            'category' => $this->request->getPost('category'),
            'quantity' => $this->request->getPost('quantity') ?: 1,
            'brand' => $this->request->getPost('brand'),
            'item_notes' => $this->request->getPost('item_notes'),
            'store_name' => $this->request->getPost('store_name'),
            'alt_store' => $this->request->getPost('alt_store'),
            'store_address' => $this->request->getPost('store_address'),
            'delivery_address' => $this->request->getPost('delivery_address'),
            'contact_number' => $this->request->getPost('contact_number'),
            'landmark' => $this->request->getPost('landmark'),
            'delivery_notes' => $this->request->getPost('delivery_notes'),
            'estimated_price' => $this->request->getPost('estimated_price') ?: 0.00,
            'service_fee' => $this->request->getPost('service_fee') ?: 0.00,
            'payment_method' => $this->request->getPost('payment_method'),
            'urgency' => $this->request->getPost('urgency'),
            'status' => 'pending'
        ];

        // Basic validation
        $requiredFields = ['item_name', 'category', 'store_name', 'store_address', 'delivery_address', 'contact_number', 'payment_method', 'urgency'];
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                return redirect()->back()->with('error', 'Please fill in all required fields.');
            }
        }

        // Save to database
        if ($requestModel->insert($data)) {
            return redirect()->to('/my-requests')->with('success', 'Request posted successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to post request. Please try again.');
        }
    }

    public function browse()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/login')->with('error', 'Please login to browse requests.');
        }

        $requestModel = new RequestModel();
        $requests = $requestModel->where('status', 'pending')->where('user_id !=', session('user_id'))->findAll();

        $data['title'] = 'Browse Requests | Pasa-Buy';
        $data['requests'] = $requests;

        return view('browse_requests_page', $data);
    }

    public function accept($id)
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/login')->with('error', 'Please login first.');
        }

        $requestModel = new RequestModel();
        $acceptedRequestModel = new AcceptedRequestModel();

        // Check if request exists and is pending
        $request = $requestModel->find($id);
        if (!$request || $request['status'] !== 'pending') {
            return redirect()->to('/browse-requests')->with('error', 'Request not available for acceptance.');
        }

        // Update request status
        $requestModel->update($id, ['status' => 'accepted']);

        // Insert into accepted_requests
        $acceptedRequestModel->insert([
            'request_id' => $id,
            'runner_id' => session('user_id'),
            'status' => 'accepted',
            'accepted_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/browse-requests')->with('success', 'Request accepted successfully.');
    }

    public function details($id = null)
    {
        if (!$id || !session()->has('user_id')) {
            return redirect()->to('/browse-requests');
        }

        $requestModel = new RequestModel();
        $userModel = new UserModel();

        // Get the request details
        $request = $requestModel->find($id);

        if (!$request) {
            return redirect()->to('/browse-requests')->with('error', 'Request not found.');
        }

        // Get the requester's profile
        $requester = $userModel->find($request['user_id']);

        if (!$requester) {
            return redirect()->to('/browse-requests')->with('error', 'Requester not found.');
        }

        $data['request'] = $request;
        $data['requester'] = $requester;
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

        // Get user's requests ordered by newest first
        $data['requests'] = $requestModel->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        $data['title'] = 'My Requests | Pasa-Buy';
        return view('my_requests_page', $data);
    }
}