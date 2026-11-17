<?php

namespace App\Filament\Resources\PostureChecks\Pages;

use App\Filament\Resources\PostureChecks\PostureCheckResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManagePostureChecks extends ManageRecords
{
    protected static string $resource = PostureCheckResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
