<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SeatInfo;
use App\Models\TransportSchedule;
use App\Models\User;

class Transport extends Model
{
    use HasFactory;

    protected $table = 'transports';
    public $timestamps = false;

    public function seatinfos()
    {
        return $this->hasMany(SeatInfo::class, 'transport_id');
    }

    public function transportschedules()
    {
        return $this->hasMany(TransportSchedule::class, 'transport_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
