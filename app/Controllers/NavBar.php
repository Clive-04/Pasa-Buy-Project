<?php

namespace App\Controllers;

class NavBar extends BaseController
{
    public function about()
    {
        $data['title'] = "About | Pasa-Buy";

        return view('about_page', $data);
    }

    public function contact()
    {
        $data['title'] = "Contact | Pasa-Buy";

        return view('contact_page', $data);
    }
}