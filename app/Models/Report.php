<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $table = 'financial_report';

    protected $primaryKey = 'report_Id';

    public $timestamps = true;

    protected $fillable = [
        'business_Id',
        'report_date',
        'total_sales',
        'net_profit',
    ];
}
    