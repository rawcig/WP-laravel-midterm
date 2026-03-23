<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    
    protected $table = 'events';
    
    protected $fillable = [
        'title',
        'description',
        'date',
        'location',
        'status',
        'organizer_id',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function organizer() 
    {
        return $this->belongsTo(Organizer::class);
    }

    public function guests()
    {
        return $this->hasMany(Guest::class);
    }
}
