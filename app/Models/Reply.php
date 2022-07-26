<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;

    protected $fillable = ['content' , 'ticket_id'];

    public function tickets() {
        return $this->belongsTo(Ticket::class);
    }
}
