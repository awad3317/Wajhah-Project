<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EstablishmentTypeResource\Pages;
use App\Filament\Resources\EstablishmentTypeResource\RelationManagers;
use App\Models\EstablishmentType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EstablishmentTypeResource extends Resource
{
    protected static ?string $model = EstablishmentType::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'أنواع المنشآت';

     protected static ?string $pluralModelLabel = 'أنواع المنشآت';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('أسم المنشئة')
                    ->required()
                    ->maxLength(255),

                

                Forms\Components\Textarea::make('description')
                    ->label('الوصف')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),

                Forms\Components\FileUpload::make('icon')
                    ->label('الأيقونة')
                    ->required()
                    ->image() 
                    ->avatar()
                    ->directory('establishment-type-icons')
                    ->rules(['mimes:svg', 'mimetypes:image/svg+xml']),
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('icon')
                    ->label('الأيقونة')
                    ->square()
                    ->disk('public')
                    ->url(fn ($record) => asset( '/'.$record->icon)),

                Tables\Columns\TextColumn::make('name')
                    ->label('الأسم')
                    ->searchable(),

                Tables\Columns\TextColumn::make('description')
                    ->label('الوصف'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('أنشئ في')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('تم التعديل في ')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
                //
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageEstablishmentTypes::route('/'),
        ];
    }
}
