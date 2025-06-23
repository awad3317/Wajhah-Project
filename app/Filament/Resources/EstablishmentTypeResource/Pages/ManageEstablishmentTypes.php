<?php

namespace App\Filament\Resources\EstablishmentTypeResource\Pages;

use App\Filament\Resources\EstablishmentTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageEstablishmentTypes extends ManageRecords
{
    protected static string $resource = EstablishmentTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
