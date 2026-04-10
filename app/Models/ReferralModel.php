<?php

namespace App\Models;

use CodeIgniter\Model;

class ReferralModel extends Model
{
    protected $table = 'referrals';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id',
        'friend_name',
        'friend_email',
        'status',
        'created_at',
        'updated_at'
    ];
}