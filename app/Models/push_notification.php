<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class push_notification extends Model
{
    use HasFactory;
    protected $fillable = ['receiver_id','sender_id','msg','title'];
}
