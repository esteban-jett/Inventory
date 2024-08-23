<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class business_info extends Model
{
    use HasFactory;
    protected $table = 'business_info';
    public $timestamps = false;
    protected $fillable = [
        'businesslogo',
        'businessname',
        'businessemail',
        'businessphone',
        'businesstelephone',
        'businessfb',
        'businesssig',
        'businessx',
    ];
}
