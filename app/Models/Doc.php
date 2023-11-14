<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doc extends Model
{
    use HasFactory;

    protected $table = 'docs';

    protected $fillable = [
        'user_id','doc_type','doc_title','doc_path','remarks','is_verified'
    ];
}
