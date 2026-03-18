<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        $data['title'] = "Dashboard | Pasa-Buy";

        return view('dashboard', $data);
    }
}