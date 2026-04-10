<?php

namespace App\Models;

use CodeIgniter\Model;

class MessageModel extends Model
{
    protected $table = 'messages';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'sender_id',
        'receiver_id',
        'request_id',
        'message',
        'attachment_name',
        'attachment_path',
        'attachment_type',
        'created_at'
    ];

    protected $useTimestamps = false;
}