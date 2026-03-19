<?php

namespace App\Controllers;

class Message extends BaseController
{
    public function index()
    {
        $data['title'] = 'Messages | Pasa-Buy';
        return view('messages_page', $data);
    }
}