<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class drop_kamety extends Model
{
    use HasFactory;
    protected $fillable = [
        'ekameti_id','user_id','kameti_number','drop_date','status'
    ];
}
