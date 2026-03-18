<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data['title'] = "Pasa-Buy";

        return view('landing_page', $data);
    }
}