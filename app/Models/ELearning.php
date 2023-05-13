<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ELearning extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function M202() {
        return $this->belongsTo(M202::class);
    }
}
