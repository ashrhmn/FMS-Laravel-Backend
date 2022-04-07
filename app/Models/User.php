<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PurchasedTicket;
use App\Models\City;
use App\Models\Family;
use App\Models\Transport;

class User extends Model
{
    use HasFactory;

    protected $table = "users";
    public $timestamps = false;

    public function purchasedtickets()
    {
        return $this->hasMany(PurchasedTicket::class, 'purchased_by');
    }
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
    public function family()
    {
        return $this->belongsTo(Family::class, 'family_id');
    }
    public function transports()
    {
        return $this->hasMany(Transport::class, 'created_by');
    }
}
