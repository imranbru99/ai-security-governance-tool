<?php

namespace App\Filament\Resources\PolicyViolations\Pages;

use App\Filament\Resources\PolicyViolations\PolicyViolationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManagePolicyViolations extends ManageRecords
{
    protected static string $resource = PolicyViolationResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
