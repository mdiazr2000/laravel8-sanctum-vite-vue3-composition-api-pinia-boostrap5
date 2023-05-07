<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Client extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'lastname',
        'ci'
    ];

    public function user(): MorphOne
    {
        return $this->morphOne(User::class, 'profile');
    }

    public function reservation()
    {
        return $this->hasMany(Reservation::class);
    }
}
