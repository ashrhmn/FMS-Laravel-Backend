<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\SeatInfo;
use App\Models\Stopage;

class PurchasedTicket extends Model
{
    use HasFactory;

    protected $table = 'purchased_tickets';
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'purchased_by');
    }
    public function seatinfos()
    {
        return $this->hasMany(SeatInfo::class, 'ticket_id');
    }
    public function fromstopage()
    {
        return $this->belongsTo(Stopage::class, 'from_stopage_id');
    }
    public function tostopage()
    {
        return $this->belongsTo(Stopage::class, 'to_stopage_id');
    }
}
