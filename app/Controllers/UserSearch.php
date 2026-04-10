<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\UserRatingModel;
use App\Models\RequestModel;

class UserSearch extends BaseController
{
    public function index()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/login')->with('error', 'Please login first.');
        }

        $keyword = trim((string) $this->request->getGet('q'));
        $userModel = new UserModel();

        $users = [];

        if ($keyword !== '') {
            $users = $userModel
                ->groupStart()
                    ->like('first_name', $keyword)
                    ->orLike('last_name', $keyword)
                    ->orLike('username', $keyword)
                    ->orLike('email', $keyword)
                ->groupEnd()
                ->where('id !=', session('user_id'))
                ->findAll();
        }

        return view('user_search_page', [
            'title' => 'Search Users | Pasa-Buy',
            'keyword' => $keyword,
            'users' => $users
        ]);
    }

    public function view($id)
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/login')->with('error', 'Please login first.');
        }

        $userModel = new UserModel();
        $requestModel = new RequestModel();
        $userRatingModel = new UserRatingModel();

        $user = $userModel->find($id);

        if (!$user) {
            return redirect()->to('/users/search')->with('error', 'User not found.');
        }

        $ratingData = $userRatingModel
            ->selectAvg('rating', 'avg_rating')
            ->where('rated_user_id', $id)
            ->first();

        $myRating = $userRatingModel
            ->where('rater_id', session('user_id'))
            ->where('rated_user_id', $id)
            ->first();

        $totalRequests = $requestModel->where('user_id', $id)->countAllResults();

        return view('user_public_profile_page', [
            'title' => 'User Profile | Pasa-Buy',
            'profileUser' => $user,
            'totalRequests' => $totalRequests,
            'averageRating' => number_format((float)($ratingData['avg_rating'] ?? 0), 1),
            'myRating' => $myRating,
            'isOwnProfile' => ((string) session('user_id') === (string) $id)
        ]);
    }

    public function rate($id)
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/login')->with('error', 'Please login first.');
        }

        $raterId = (int) session('user_id');
        $ratedUserId = (int) $id;
        $rating = (int) $this->request->getPost('rating');
        $feedback = trim((string) $this->request->getPost('feedback'));

        if ($raterId === $ratedUserId) {
            return redirect()->back()->with('error', 'You cannot rate your own account.');
        }

        if ($rating < 1 || $rating > 5) {
            return redirect()->back()->with('error', 'Please select a valid rating.');
        }

        $userModel = new UserModel();
        $ratedUser = $userModel->find($ratedUserId);

        if (!$ratedUser) {
            return redirect()->to('/users/search')->with('error', 'User not found.');
        }

        $userRatingModel = new UserRatingModel();

        $existing = $userRatingModel
            ->where('rater_id', $raterId)
            ->where('rated_user_id', $ratedUserId)
            ->first();

        $data = [
            'rater_id' => $raterId,
            'rated_user_id' => $ratedUserId,
            'rating' => $rating,
            'feedback' => $feedback
        ];

        if ($existing) {
            $userRatingModel->update($existing['id'], $data);
            return redirect()->back()->with('success', 'Your rating for this user was updated.');
        }

        $userRatingModel->insert($data);

        return redirect()->back()->with('success', 'User rated successfully.');
    }
}