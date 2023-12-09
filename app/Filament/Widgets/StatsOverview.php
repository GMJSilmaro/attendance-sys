<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Student;
use App\Models\Event;
use App\Models\ClassSchedule;
use App\Models\Course;
use App\Models\User;

class StatsOverview extends BaseWidget
{
    protected static ?string $pollingInterval = '10s';

    protected static bool $isLazy = false;

    protected function getStats(): array
    {
        return [
            //
            Stat::make('Total Students', Student::query()->count())
            ->description('All Enrolled Students')
            ->descriptionIcon('heroicon-m-users')
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->color('success'),
            Stat::make('Total Events', Event::query()->count())
                ->description('All Events')
                ->descriptionIcon('heroicon-m-calendar')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('danger'),
            Stat::make('Total Users', User::query()->count())
                ->description('All Users')
                ->descriptionIcon('heroicon-m-user')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('warning'),
        ];
    }
}
