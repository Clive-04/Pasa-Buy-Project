<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\RequestModel;

class Profile extends BaseController
{
    public function index()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/login')->with('error', 'Please login first.');
        }

        $userId = session('user_id');

        $userModel = new UserModel();
        $requestModel = new RequestModel();

        $user = $userModel->find($userId);

        if (!$user) {
            return redirect()->to('/login')->with('error', 'User not found.');
        }

        $totalRequests = $requestModel
            ->where('user_id', $userId)
            ->countAllResults();

        $acceptedRequests = $requestModel
            ->where('user_id', $userId)
            ->where('status', 'accepted')
            ->countAllResults();

        $deliveredRequests = $requestModel
            ->where('user_id', $userId)
            ->where('status', 'delivered')
            ->countAllResults();

        $data = [
            'title' => 'Profile | Pasa-Buy',
            'user' => $user,
            'totalRequests' => $totalRequests,
            'acceptedRequests' => $acceptedRequests,
            'deliveredRequests' => $deliveredRequests,
            'rating' => 5.0
        ];

        return view('profile_page', $data);
    }

    public function updateProfile()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/login')->with('error', 'Please login first.');
        }

        $userId = session('user_id');

        $fullName = trim($this->request->getPost('full_name'));
        $username = trim($this->request->getPost('username'));
        $aboutMe  = trim($this->request->getPost('about_me'));

        $nameParts = explode(' ', $fullName, 2);
        $firstName = $nameParts[0] ?? '';
        $lastName  = $nameParts[1] ?? '';

        $userModel = new \App\Models\UserModel();
        $user = $userModel->find($userId);

        $updateData = [
            'first_name' => $firstName,
            'last_name'  => $lastName,
            'username'   => $username,
            'about_me'   => $aboutMe
        ];

        $photo = $this->request->getFile('profile_photo');

        if ($photo && $photo->isValid() && !$photo->hasMoved()) {
            $newName = $photo->getRandomName();
            $photo->move(FCPATH . 'uploads/profile_photos', $newName);

            if (!empty($user['profile_photo']) && file_exists(FCPATH . 'uploads/profile_photos/' . $user['profile_photo'])) {
                unlink(FCPATH . 'uploads/profile_photos/' . $user['profile_photo']);
            }

            $updateData['profile_photo'] = $newName;
        }

        $updated = $userModel->update($userId, $updateData);

        if (!$updated) {
            return redirect()->back()->with('error', 'Profile update failed.');
        }

        session()->set('user_name', trim($firstName . ' ' . $lastName));

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    public function rateWebsite()
    {
        $rating = $this->request->getPost('rating');
        $feedback = $this->request->getPost('feedback');

        return redirect()->back()->with('success', 'Thank you for rating the website.');
    }

    public function referFriend()
    {
        $friendName = $this->request->getPost('friend_name');
        $friendEmail = $this->request->getPost('friend_email');

        return redirect()->back()->with('success', 'Referral sent successfully.');
    }
}