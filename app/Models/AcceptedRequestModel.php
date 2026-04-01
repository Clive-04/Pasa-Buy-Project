<?php

namespace App\Models;

use CodeIgniter\Model;

class AcceptedRequestModel extends Model
{
    protected $table = 'accepted_requests';
    protected $primaryKey = 'id';
    protected $allowedFields = ['request_id', 'runner_id', 'status', 'accepted_at'];
    protected $useTimestamps = false;
}