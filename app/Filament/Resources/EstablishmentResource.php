<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Establishment;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\Layout\Stack;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EstablishmentResource\Pages;
use App\Filament\Resources\EstablishmentResource\RelationManagers;

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
        ->contentGrid([
            'md' => 2,
            'xl' => 3,
            '2xl' => 4,
        ])
        ->columns([
            Stack::make([
                Tables\Columns\ImageColumn::make('primary_image')
                    ->disk('public')
                    ->height(150)
                    ->width('100%')
                    ->grow(false)
                    ->alignCenter(),
                
                Tables\Columns\TextColumn::make('name')
                    ->weight(FontWeight::Bold)
                    ->searchable()
                    ->alignCenter(),
                
                Tables\Columns\TextColumn::make('type.name')
                    ->label('النوع')
                    ->color('gray')
                    ->alignCenter()
                    ->size('sm'),
                
                Tables\Columns\TextColumn::make('region.name')
                    ->label('المنطقة')
                    ->color('gray')
                    ->alignCenter()
                    ->size('sm'),
                
                BadgeColumn::make('is_verified')
                    ->label('حالة التوثيق')
                    ->color(fn (string $state): string => $state ? 'success' : 'danger')
                    ->formatStateUsing(fn (string $state): string => $state ? 'موثق' : 'غير موثق')
                    ->alignCenter(),
            ])
            // ->space(3)
            ->alignCenter(),
        ])
        ->actions([
            Tables\Actions\ActionGroup::make([
                Tables\Actions\Action::make('changeVerification')
                    ->label('تغيير الحالة')
                    ->icon('heroicon-o-shield-check')
                    ->form([
                        Forms\Components\Select::make('verification_status')
                            ->label('حالة التوثيق')
                            ->options([
                                '1' => 'موثق',
                                '0' => 'غير موثق',
                            ])
                            ->required()
                            ->default(fn (Establishment $record) => $record->is_verified)
                    ])
                    ->action(function (Establishment $record, array $data) {
                        $record->update(['is_verified' => $data['verification_status']]);
                        Notification::make()
                            ->title('تم تحديث حالة التوثيق')
                            ->success()
                            ->send();
                    }),
            ])
            ->space(3)
            ->alignCenter(),
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
        ])
        ->actions([
            Tables\Actions\ViewAction::make()->iconButton(),
            Tables\Actions\EditAction::make()->iconButton(),
            Tables\Actions\DeleteAction::make()->iconButton(),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ]) ->checkIfRecordIsSelectableUsing(fn () => false);
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
