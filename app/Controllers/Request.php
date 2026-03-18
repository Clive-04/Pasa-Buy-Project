<?php

namespace App\Controllers;

class Request extends BaseController
{
    public function create()
    {
        $data['title'] = 'Post Request | Pasa-Buy';
        return view('post_request_page', $data);
    }

    public function browse()
    {
        $data['title'] = 'Browse Requests | Pasa-Buy';
        return view('browse_requests_page', $data);
    }

    public function details($id = null)
    {
        $data['title'] = 'Request Details | Pasa-Buy';
        $data['requestId'] = $id;
        return view('request_details_page', $data);
    }

    public function myRequests()
    {
        $data['title'] = 'My Requests | Pasa-Buy';
        return view('my_requests_page', $data);
    }
}