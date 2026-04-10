<?php

namespace App\Models;

use CodeIgniter\Model;

class WebsiteRatingModel extends Model
{
    protected $table = 'website_ratings';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id',
        'rating',
        'feedback',
        'created_at',
        'updated_at'
    ];
}