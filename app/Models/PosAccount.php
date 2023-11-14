<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_name','business_type','logo','website','email','mobile','nid','country','state','city','zip_code','address','contact_name','contact_number','username','package','billing_cycle','partner_id','created_by','created_at'
    ];
}
