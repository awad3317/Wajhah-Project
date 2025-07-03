<?php

namespace App\Filament\Resources\DvertisementResource\Pages;

use App\Filament\Resources\DvertisementResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageDvertisements extends ManageRecords
{
    protected static string $resource = DvertisementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
