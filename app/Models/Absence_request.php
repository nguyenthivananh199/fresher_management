<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absence_request extends Model
{
    use HasFactory;
    protected $table = 'requests';
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
