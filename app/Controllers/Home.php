<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data['title'] = "Login | Pasa-Buy";

        return view('login_page', $data);
    }
}