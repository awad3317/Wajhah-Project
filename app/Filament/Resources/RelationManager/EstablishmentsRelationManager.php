<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Establishment;

class EstablishmentsRelationManager extends RelationManager
{
    // هذا المتغير سيتم تعيينه من المورد الأب (UserResource أو RegionResource)
    protected static ?string $model =Establishment::class;

    // protected static ?string $relationship = null;

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        // تحديد العنوان بناءً على المورد الأب
        if ($ownerRecord instanceof \App\Models\User) {
            return 'المنشآت التابعة للمالك';
        } elseif ($ownerRecord instanceof \App\Models\Region) {
            return 'المنشآت في هذه المنطقة';
        }
        return 'المنشآت';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('اسم المنشأة')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('owner.name') // عرض اسم المالك
                    ->label('المالك')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('region.name') // عرض اسم المنطقة
                    ->label('المنطقة')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->filters([
                // يمكنك إضافة فلاتر هنا إذا أردت
            ])
            ->headerActions([
                // إذا أردت السماح بإنشاء منشأة جديدة من هذا التبويب
                // يجب أن تفكر في كيفية تعيين owner_id أو region_id تلقائيًا
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}