<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/login')->with('error', 'Please login first.');
        }

        $data['title'] = "Dashboard | Pasa-Buy";

        return view('dashboard_page', $data);
    }
}