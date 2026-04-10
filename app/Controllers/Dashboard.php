<?php

namespace App\Controllers;

use App\Models\RequestModel;
use App\Models\AcceptedRequestModel;
use App\Models\UserModel;
use App\Models\PaymentModel;
use App\Models\RequestNotificationModel;

class Dashboard extends BaseController
{
    public function index()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/login')->with('error', 'Please login first.');
        }

        $userId = session('user_id');

        $requestModel = new RequestModel();
        $acceptedRequestModel = new AcceptedRequestModel();
        $userModel = new UserModel();
        $paymentModel = new PaymentModel();
        $requestNotificationModel = new RequestNotificationModel();

        $user = $userModel->find($userId);

        $activeRequests = $requestModel
            ->where('user_id', $userId)
            ->whereIn('status', ['pending', 'accepted', 'on_the_way'])
            ->countAllResults();

        $acceptedTasks = $acceptedRequestModel
            ->where('runner_id', $userId)
            ->whereIn('status', ['accepted', 'on_the_way'])
            ->countAllResults();

        $completedOrders = $acceptedRequestModel
            ->where('runner_id', $userId)
            ->where('status', 'delivered')
            ->countAllResults();

        $walletBalance = (float) ($user['wallet_balance'] ?? 0);

        $myActiveRequests = $requestModel
            ->where('user_id', $userId)
            ->whereIn('status', ['pending', 'accepted', 'on_the_way'])
            ->orderBy('created_at', 'DESC')
            ->findAll(5);

        $availableRequests = $requestModel
            ->where('status', 'pending')
            ->where('user_id !=', $userId)
            ->orderBy('created_at', 'DESC')
            ->findAll(5);

        $recentActivity = $requestNotificationModel
            ->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->findAll(5);

        return view('dashboard_page', [
            'title' => 'Dashboard | Pasa-Buy',
            'activeRequests' => $activeRequests,
            'acceptedTasks' => $acceptedTasks,
            'completedOrders' => $completedOrders,
            'walletBalance' => $walletBalance,
            'myActiveRequests' => $myActiveRequests,
            'availableRequests' => $availableRequests,
            'recentActivity' => $recentActivity
        ]);
    }
}