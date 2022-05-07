<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'fullname',
        'profile_id',
        'skills'
    ];

    public function users()
    {
        $this->belongsTo(User::class, 'user_id', 'id');
    }
}
