<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resume extends Model
{
    protected $fillable = [
        'user_id', 'name', 'email', 'contact_number',
        'education', 'skills', 'experience'
    ];
}
