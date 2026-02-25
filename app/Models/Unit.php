<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = [
        'name',
        'address',
        'email',
        'phone',
        'foreman_id',
        'coordinates',
    ];

    public function foreman()
    {
        return $this->belongsTo(User::class, 'foreman_id');
    }
}
