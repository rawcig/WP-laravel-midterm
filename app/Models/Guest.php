<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'event_id',
        'user_id',
        'status',
        'participation_type',
        'registration_status',
        'ticket_count',
        'notes',
        'dietary_requirements',
        'company',
        'position',
        'checked_in',
        'checked_in_at',
        'confirmed_at',
        'qr_code',
    ];

    protected $casts = [
        'checked_in' => 'boolean',
        'checked_in_at' => 'datetime',
        'confirmed_at' => 'datetime',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
