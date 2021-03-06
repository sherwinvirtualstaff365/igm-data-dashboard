<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataEntry extends Model
{
    use HasFactory;

    protected $table = 'data_entries';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
