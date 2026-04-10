<?php

namespace App\Models;

use CodeIgniter\Model;

class UserRatingModel extends Model
{
    protected $table = 'user_ratings';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'rater_id',
        'rated_user_id',
        'rating',
        'feedback',
        'created_at',
        'updated_at'
    ];
}