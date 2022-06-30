<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'city_id',
        'created_at',
        'updated_at',
    ];


    public function city()
    {
        return $this->hasOne(City::class, 'id', 'city_id');
    }
}
