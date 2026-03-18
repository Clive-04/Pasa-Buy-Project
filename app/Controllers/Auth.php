<?php

namespace App\Controllers;

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

    public function loginProcess()
    {
        // temporary only
        return redirect()->to('/dashboard_page');
    }

    public function logout()
    {
        // temporary only
        return redirect()->to('/login_page');
    }
}