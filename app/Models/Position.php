<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',

        // Other attributes in your ClassSchedule model
    ];

    public function officer()
    {
        return $this->hasMany(Officer::class);
    }
}
