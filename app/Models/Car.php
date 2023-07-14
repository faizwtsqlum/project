<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = ['brand', 'model', 'license_plate', 'rental_rate'];

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }
}