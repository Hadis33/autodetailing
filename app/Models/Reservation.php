<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Service;
use App\Models\User;
use App\Models\Unit;

class Reservation extends Model
{
    protected $fillable = [
        'user_id',
        'unit_id',
        'service_id',
        'start',
        'end',
        'status',
    ];

    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($reservation) {

            if (!$reservation->end && $reservation->start && $reservation->service_id) {

                $service = Service::find($reservation->service_id);

                if ($service) {
                    $reservation->end = $reservation->start
                        ->copy()
                        ->addMinutes($service->duration);
                }
            }
        });
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
