<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    protected $table = 'friends';
    
    protected $fillable = [
        'id', 'user_id', 'friend_id', 'accepted'
    ];    
}
