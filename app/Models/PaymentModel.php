<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentModel extends Model
{
    protected $table = 'payments';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',
        'request_id',
        'receiver_id',
        'amount',
        'type',
        'source',
        'status',
        'reference_no',
        'description',
        'created_at'
    ];

    protected $useTimestamps = false;
}