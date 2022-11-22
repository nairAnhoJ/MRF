<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mrf extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'area',
        'brand',
        'fleet_no',
        'supervisor',
        'parts',
        'service',
        'rental',
        'mri',
        'edoc_no',
        'dr',
        'requester',
        'request_for',
        'order_type',
        'mri_no',
        'edoc_no',
        'dr_no',
        'date_needed',
        'customer_address',
    ];
}
