<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kameti_member extends Model
{
    use HasFactory;
    protected $fillable = ['member_id','ekameti_id','add_by','total_ekameti','pending_kameti','payable_amount','status','created_at'];

}
