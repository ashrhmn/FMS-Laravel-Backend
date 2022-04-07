<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\City;
use App\Models\PurchasedTicket;
use App\Models\TransportSchedule;

class Stopage extends Model
{
    use HasFactory;

    protected $table='stopages';
    public $timestamps = false;

    public function city(){
        return $this->belongsTo(City::class,'city_id');  
    }
    public function fromstopage_tickets(){
        return $this->hasMany(PurchasedTicket::class,'from_stopage_id');
    }
    public function tostopage_tickets(){
        return $this->hasMany(PurchasedTicket::class,'to_stopage_id');
    }
    public function fromstopage_transportschedules(){
        return $this->hasMany(TransportSchedule::class,'from_stopage_id');
    }
    public function tostopage_transportschedules(){
        return $this->hasMany(TransportSchedule::class,'to_stopage_id');
    }
}
