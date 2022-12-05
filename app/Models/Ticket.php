<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'concert_name',
        'concert_date',
        'concert_category',
        'concert_price',
    ];

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }
}
