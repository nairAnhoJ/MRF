<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approver extends Model
{
    use HasFactory;

    protected $table = 'mrf_approvers';

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
