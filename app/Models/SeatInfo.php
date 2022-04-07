<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Transport;
use App\Models\PurchasedTicket;

class SeatInfo extends Model
{
    use HasFactory;

    protected $table='seat_infos';
    public $timestamps = false;

    public function transport(){
        return $this->belongsTo(Transport::class,'transport_id');
    }
    public function purchasedticket(){
        return $this->belongsTo(PurchasedTicket::class,'ticket_id');
    }
}
