<?php

namespace App\Filament\Resources\AiAssets\Pages;

use App\Filament\Resources\AiAssets\AiAssetResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageAiAssets extends ManageRecords
{
    protected static string $resource = AiAssetResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
