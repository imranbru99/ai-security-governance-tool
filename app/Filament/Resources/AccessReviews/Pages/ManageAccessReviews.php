<?php

namespace App\Filament\Resources\AccessReviews\Pages;

use App\Filament\Resources\AccessReviews\AccessReviewResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageAccessReviews extends ManageRecords
{
    protected static string $resource = AccessReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
