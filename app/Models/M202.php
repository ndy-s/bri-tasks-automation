<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M202 extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function elearning() {
        return $this->hasMany(ELearning::class);
    }
}
