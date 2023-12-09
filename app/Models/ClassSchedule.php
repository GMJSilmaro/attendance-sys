<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        // Other attributes in your ClassSchedule model
    ];

    public function reports()
    {
        return $this->hasMany(Report::class);
    }


}
