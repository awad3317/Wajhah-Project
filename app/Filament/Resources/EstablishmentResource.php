<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EstablishmentResource\Pages;
use App\Filament\Resources\EstablishmentResource\RelationManagers;
use App\Models\Establishment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EstablishmentResource extends Resource
{
    protected static ?string $model = Establishment::class;

      protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
                '2xl' => 4,
            ])
            ->columns([
                Tables\Columns\ImageColumn::make('primary_image')
                    ->label('الصورة'),
                Tables\Columns\TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type.name')
                    ->label('النوع')
                    ->sortable(),
                Tables\Columns\TextColumn::make('region.name')
                    ->label('المنطقة')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_verified')
                    ->label('موثق')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('نشط')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->relationship('type', 'name')
                    ->label('فلترة حسب النوع'),
                    
                Tables\Filters\SelectFilter::make('region')
                    ->relationship('region', 'name')
                    ->label('فلترة حسب المنطقة'),
                    
                Tables\Filters\Filter::make('is_verified')
                    ->label('المنشآت الموثقة فقط')
                    ->query(fn (Builder $query): Builder => $query->where('is_verified', true)),
                    
                Tables\Filters\Filter::make('is_active')
                    ->label('المنشآت النشطة فقط')
                    ->query(fn (Builder $query): Builder => $query->where('is_active', true))
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEstablishments::route('/'),
            // 'create' => Pages\CreateEstablishment::route('/create'),
            // 'edit' => Pages\EditEstablishment::route('/{record}/edit'),
        ];
    }
}
