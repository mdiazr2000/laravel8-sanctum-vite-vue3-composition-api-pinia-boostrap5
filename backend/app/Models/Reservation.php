<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'lastname',
        'user_id',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
