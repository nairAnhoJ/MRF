<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NonChargeableRequest extends Model
{
    use HasFactory;

    protected $table = 'mrf_non_chargeable_requests';

    public function siteDetails() {
        return $this->belongsTo(Site::class, 'site');
    }
}
