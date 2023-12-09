<?php

namespace App\Filament\Widgets;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use App\Filament\Resources\EventResource;
use App\Models\Event;


class CalendarWidget extends FullCalendarWidget
{
    protected static ?int $sort = 1;

    public Model|string|null $model = Event::class;

    // public function fetchEvents(array $fetchInfo): array
    // {
    //     // Get the current server time
    //     $serverTime = Carbon::now();

    //     return Event::where('starts_at', '>=', $fetchInfo['start'])
    //         ->where('ends_at', '<=', $fetchInfo['end'])
    //         ->get()
    //         ->map(function (Event $events) use ($serverTime) {
    //             return [
    //                 'id' => $events->id,
    //                 'title' => $events->event_name,
    //                 'start' => $events->starts_at,
    //                 'end' => $events->ends_at,
    //                 'serverTime' => $serverTime->toDateTimeString(), // Add server time to the event data
    //             ];

    //         })
    //         ->toArray();
    // }
    public function fetchEvents(array $fetchInfo): array
    {
        return Event::query()
            ->where('starts_at', '>=', $fetchInfo['start'])
            ->where('ends_at', '<=', $fetchInfo['end'])
            ->get()
            ->map(
                fn (Event $event) => [
                    'id' => $event->id,
                    'title' => $event->event_name,
                    'start' => $event->starts_at,
                    'end' => $event->ends_at,
                    'url' => EventResource::getUrl(name: 'view', parameters: ['record' => $event]),
                    // 'shouldOpenUrlInNewTab' => false
                ]
            )
            ->all();
    }


    public static function canView(): bool
    {
        return false;
    }
}
