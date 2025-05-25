<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // ✅ Doğru


class Event extends Model
{
    use HasFactory;

    

        protected $casts = [
        'date' => 'datetime',
        ];

    protected $fillable = [
    'ticketmaster_id',
    'name',
    'date',
    'location',
    'description',
    'type',
    'remaining_tickets',
    'capacity',
    'price',
    'tickets',
];

}
