<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Officer extends Model
{
    use HasFactory;

    protected $fillable = [
        'fname',
        'mname',
        'lname',
        'email',
        'phone',
        'position',
        'gender',
        // Other attributes in your ClassSchedule model
    ];

    public function position()
    {
        return $this->belongsTo(Position::class, 'id');
    }

    public function events()
    {
        return $this->belongsTo(Event::class, 'id');
    }
}
