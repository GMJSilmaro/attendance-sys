<?php

namespace App\Filament\Resources\ClassScheduleResource\Pages;

use App\Filament\Resources\ClassScheduleResource;
use App\Models\ClassSchedule;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateClassSchedule extends CreateRecord
{
    protected static string $resource = ClassScheduleResource::class;

    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {



        return $this->getResource()::getUrl('index');
    }

}
