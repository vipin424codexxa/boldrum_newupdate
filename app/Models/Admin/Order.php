<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    public $timestamps=false;

    public function user()
    {
        return $this->belongsTo(User1::class);
    }
        public function club()
    {
        return $this->belongsTo(Club::class);
    }
}
