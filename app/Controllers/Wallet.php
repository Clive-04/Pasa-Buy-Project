<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PaymentModel;

class Wallet extends BaseController
{
    public function index()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/login')->with('error', 'Please login first.');
        }

        $userId = session('user_id');

        $userModel = new UserModel();
        $paymentModel = new PaymentModel();

        $user = $userModel->find($userId);

        $transactions = $paymentModel
            ->where('user_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('wallet_page', [
            'title' => 'Wallet | Pasa-Buy',
            'user' => $user,
            'transactions' => $transactions
        ]);
    }

    public function topUp()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/login')->with('error', 'Please login first.');
        }

        $userId = session('user_id');
        $amount = (float) $this->request->getPost('amount');
        $source = trim((string) $this->request->getPost('source'));
        $referenceNo = trim((string) $this->request->getPost('reference_no'));

        $allowedSources = ['gcash', 'maya', 'bank_transfer'];

        if ($amount <= 0) {
            return redirect()->back()->with('error', 'Please enter a valid top-up amount.');
        }

        if (!in_array($source, $allowedSources, true)) {
            return redirect()->back()->with('error', 'Please select a valid top-up method.');
        }

        $db = db_connect();
        $userModel = new UserModel();
        $paymentModel = new PaymentModel();

        $db->transStart();

        $user = $userModel->find($userId);
        $currentBalance = (float) ($user['wallet_balance'] ?? 0);
        $newBalance = $currentBalance + $amount;

        $userModel->update($userId, [
            'wallet_balance' => $newBalance
        ]);

        $paymentModel->insert([
            'user_id' => $userId,
            'request_id' => null,
            'receiver_id' => null,
            'amount' => $amount,
            'type' => 'top_up',
            'source' => $source,
            'status' => 'completed',
            'reference_no' => $referenceNo ?: null,
            'description' => 'Wallet top-up via ' . ucfirst(str_replace('_', ' ', $source)),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $db->transComplete();

        if (!$db->transStatus()) {
            return redirect()->back()->with('error', 'Top-up failed.');
        }

        return redirect()->to('/wallet')->with('success', 'Wallet topped up successfully.');
    }
}