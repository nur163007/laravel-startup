<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $fillable = [
        'content_type','meta_tag','meta_description','keywords','is_active','content','is_published','created_by','approved','created_at','updated_at'
    ];
}
