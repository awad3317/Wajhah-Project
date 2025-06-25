<?php

namespace App\Filament\Resources\EstablishmentResource\Pages;

use App\Filament\Resources\EstablishmentResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListEstablishments extends ListRecords
{
    protected static string $resource = EstablishmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    public function getTabs(): array
    {
        return [
            'all' => Tab::make('الكل'),
            'verified' => Tab::make('موثق')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_verified', true)),
            'active' => Tab::make('نشط')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_active', true)),
        ];
    }
    protected function getTableContentGrid(): ?array
    {
        return [
            'md' => 2,
            'xl' => 3,
            '2xl' => 4,
        ];
    }
}
