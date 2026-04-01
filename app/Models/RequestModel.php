<?php

namespace App\Models;

use CodeIgniter\Model;

class RequestModel extends Model
{
    protected $table = 'requests';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id',
        'item_name',
        'category',
        'quantity',
        'brand',
        'item_notes',
        'store_name',
        'alt_store',
        'store_address',
        'delivery_address',
        'contact_number',
        'landmark',
        'delivery_notes',
        'estimated_price',
        'service_fee',
        'payment_method',
        'urgency',
        'status'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}