<?php

namespace App\Models;

use CodeIgniter\Model;

class RequestNotificationModel extends Model
{
    protected $table = 'request_notifications';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',
        'sender_id',
        'request_id',
        'type',
        'title',
        'content',
        'is_read',
        'created_at'
    ];

    protected $useTimestamps = false;
}