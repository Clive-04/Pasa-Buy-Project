<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        $data['title'] = "Login | Pasa-Buy";

        return view('login_page', $data);
    }

    public function register()
    {
        $data['title'] = "Register | Pasa-Buy";

        return view('register_page', $data);
    }

    public function process()
    {
        $userModel = new UserModel();

        // Get form data
        $password = $this->request->getPost('password');
        $confirmPassword = $this->request->getPost('confirm_password');

        if ($password !== $confirmPassword) {
            return redirect()->back()->with('error', 'Passwords do not match.');
        }

        $data = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'email' => $this->request->getPost('email'),
            'phone_number' => $this->request->getPost('phone'),
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'address' => $this->request->getPost('address'),
        ];

        // Basic validation
        if (empty($data['first_name']) || empty($data['last_name']) || empty($data['email']) || empty($data['phone_number']) || empty($data['password']) || empty($data['address'])) {
            return redirect()->back()->with('error', 'All fields are required.');
        }

        // Check if email or phone already exists
        if ($userModel->where('email', $data['email'])->first() || $userModel->where('phone_number', $data['phone_number'])->first()) {
            return redirect()->back()->with('error', 'Email or phone number already exists.');
        }

        // Save user
        if ($userModel->insert($data)) {
            return redirect()->to('/login')->with('success', 'Registration successful. Please login.');
        } else {
            return redirect()->back()->with('error', 'Registration failed. Please try again.');
        }
    }

    public function loginProcess()
    {
        $userModel = new UserModel();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Find user by email
        $user = $userModel->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            // Set session
            session()->set('user_id', $user['id']);
            session()->set('user_name', $user['first_name'] . ' ' . $user['last_name']);
            session()->set('user_email', $user['email']);

            return redirect()->to('/dashboard')->with('success', 'Login successful.');
        } else {
            return redirect()->back()->with('error', 'Invalid email or password.');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Logged out successfully.');
    }
}