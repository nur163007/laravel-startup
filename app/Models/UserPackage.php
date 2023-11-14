<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','registration_id','package_id','billing_period','registration_amount','is_extended_support','support_amount','billing_amount','activation_date','is_active','created_on'
    ];
}


