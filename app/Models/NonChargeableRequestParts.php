<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NonChargeableRequestParts extends Model
{
    use HasFactory;

    protected $table = 'mrf_rental_request_parts';
}
