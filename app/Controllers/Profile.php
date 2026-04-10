<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\RequestModel;
use App\Models\WebsiteRatingModel;
use App\Models\ReferralModel;
use App\Models\AcceptedRequestModel;

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
        $acceptedRequestModel = new AcceptedRequestModel();
        $websiteRatingModel = new WebsiteRatingModel();

        $user = $userModel->find($userId);

        if (!$user) {
            return redirect()->to('/login')->with('error', 'User not found.');
        }

        // Requests posted by the user
        $totalRequests = $requestModel
            ->where('user_id', $userId)
            ->countAllResults();

        // Requests accepted by the user as runner
        $acceptedRequests = $acceptedRequestModel
            ->where('runner_id', $userId)
            ->countAllResults();

        // Requests accepted by the user and already delivered
        $deliveredRequests = $acceptedRequestModel
            ->where('runner_id', $userId)
            ->where('status', 'delivered')
            ->countAllResults();

        $avgWebsiteRating = $websiteRatingModel
            ->selectAvg('rating', 'avg_rating')
            ->first();

        $data = [
            'title' => 'Profile | Pasa-Buy',
            'user' => $user,
            'totalRequests' => $totalRequests,
            'acceptedRequests' => $acceptedRequests,
            'deliveredRequests' => $deliveredRequests,
            'rating' => 5.0,
            'isOwnProfile' => true
        ];

        return view('profile_page', $data);
    }

    public function updateProfile()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/login')->with('error', 'Please login first.');
        }

        $userId = session('user_id');

        $fullName = trim((string) $this->request->getPost('full_name'));
        $username = trim((string) $this->request->getPost('username'));
        $aboutMe  = trim((string) $this->request->getPost('about_me'));

        $nameParts = explode(' ', $fullName, 2);
        $firstName = $nameParts[0] ?? '';
        $lastName  = $nameParts[1] ?? '';

        $userModel = new UserModel();
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
        if (!session()->has('user_id')) {
            return redirect()->to('/login')->with('error', 'Please login first.');
        }

        $userId = session('user_id');
        $rating = (int) $this->request->getPost('rating');
        $feedback = trim((string) $this->request->getPost('feedback'));

        if ($rating < 1 || $rating > 5) {
            return redirect()->back()->with('error', 'Please select a valid website rating.');
        }

        $websiteRatingModel = new WebsiteRatingModel();

        $existing = $websiteRatingModel
            ->where('user_id', $userId)
            ->first();

        $data = [
            'user_id' => $userId,
            'rating' => $rating,
            'feedback' => $feedback
        ];

        if ($existing) {
            $websiteRatingModel->update($existing['id'], $data);
            return redirect()->back()->with('success', 'Your website rating was updated.');
        }

        $websiteRatingModel->insert($data);

        return redirect()->back()->with('success', 'Thank you for rating the website.');
    }

    public function referFriend()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/login')->with('error', 'Please login first.');
        }

        $userId = session('user_id');
        $friendName = trim((string) $this->request->getPost('friend_name'));
        $friendEmail = trim((string) $this->request->getPost('friend_email'));

        if ($friendName === '' || $friendEmail === '') {
            return redirect()->back()->with('error', 'Friend name and email are required.');
        }

        if (!filter_var($friendEmail, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()->with('error', 'Please enter a valid email address.');
        }

        $userModel = new \App\Models\UserModel();
        $currentUser = $userModel->find($userId);

        if ($currentUser && !empty($currentUser['email']) && strtolower($friendEmail) === strtolower($currentUser['email'])) {
            return redirect()->back()->with('error', 'You cannot refer your own email.');
        }

        $referralModel = new \App\Models\ReferralModel();

        $existingReferral = $referralModel
            ->where('user_id', $userId)
            ->where('friend_email', $friendEmail)
            ->first();

        if ($existingReferral) {
            return redirect()->back()->with('error', 'You already referred this email.');
        }

        $referralModel->insert([
            'user_id' => $userId,
            'friend_name' => $friendName,
            'friend_email' => $friendEmail,
            'status' => 'pending'
        ]);

        return redirect()->back()->with('success', 'Referral sent successfully.');
    }
}