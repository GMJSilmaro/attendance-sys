<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'fname',
        'mname',
        'lname',
        'course_id',
        'year',
        'class_schedule_id',
        'gender',
        'role',
        // Other attributes in your ClassSchedule model
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Set default value for 'role'
        $this->attributes['role'] = 3;
    }


    public function classSchedule()
    {
        return $this->belongsTo(ClassSchedule::class, 'class_schedule_id');
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
