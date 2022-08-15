<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ekameti extends Model
{
    use HasFactory;
    protected $fillable = [
        'created_at','withdraw_date','withdraw_kameties'
    ];
}
