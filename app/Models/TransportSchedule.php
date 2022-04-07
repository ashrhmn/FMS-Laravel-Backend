<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Transport;
use App\Models\Stopage;

class TransportSchedule extends Model
{
    use HasFactory;

    protected $table='transport_schedules';
    public $timestamps = false;

    public function transport(){
        return $this->belongsTo(Transport::class,'transport_id');
    }

    public function fromstopage(){
        return $this->belongsTo(Stopage::class,'from_stopage_id'); 
    }
    public function tostopage(){
        return $this->belongsTo(Stopage::class,'to_stopage_id'); 
    }
}
