<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reference_admin extends Model
{
    use HasFactory;
    protected $fillable = ['admin_id','member_id','sender_id','msg'];
}
