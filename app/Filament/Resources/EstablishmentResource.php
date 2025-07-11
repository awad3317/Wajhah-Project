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

    protected static ?string $modelLabel = 'منشأة';

    protected static ?string $pluralModelLabel = 'المنشآت';

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
            ->columns([
                Tables\Columns\ImageColumn::make('primary_image')
                    ->label('الصورة')
                    ->circular(),
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
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('تاريخ التحديث')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('النوع')
                    ->relationship('type', 'name'),
                Tables\Filters\SelectFilter::make('region')
                    ->label('المنطقة')
                    ->relationship('region', 'name'),
                Tables\Filters\Filter::make('verified')
                    ->label('الموثقين فقط')
                    ->query(fn (Builder $query): Builder => $query->where('is_verified', true)),
                Tables\Filters\Filter::make('active')
                    ->label('النشطين فقط')
                    ->query(fn (Builder $query): Builder => $query->where('is_active', true)),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            'create' => Pages\CreateEstablishment::route('/create'),
            'edit' => Pages\EditEstablishment::route('/{record}/edit'),
        ];
    }
}
