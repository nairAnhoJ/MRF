<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    use HasFactory;

    public function part_brand() {
        return $this->belongsTo(PartsBrand::class, 'brand');
    }
}
