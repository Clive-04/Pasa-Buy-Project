<?php

namespace App\Controllers;

class Notification extends BaseController
{
    public function index()
    {
        $data['title'] = 'Notifications | Pasa-Buy';
        return view('notifications_page', $data);
    }
}