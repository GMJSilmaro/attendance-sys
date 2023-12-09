<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use pxlrbt\FilamentActivityLog\Pages\ListActivities;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ListUserActivities extends ListActivities
{
    protected static string $resource = EventResource::class;
}

class Event extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'event_name',
        'place',
        'status',
        'date',
        'starts_at',
        'ends_at',
        'timeIn',
        'timeOut',
        'officers_assigned',
        // Other attributes in your ClassSchedule model
    ];

    public function getActivitylogOptions(): LogOptions
    {

        return LogOptions::defaults()
            ->logOnly(['event_name', 'place', 'status', 'officers.lname', 'starts_at', 'ends_at', 'timeIn', 'timeOut', 'date']);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function officers()
    {
        return $this->belongsTo(Officer::class);
    }
}
