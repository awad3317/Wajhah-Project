<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BankResource\Pages;
use App\Filament\Resources\BankResource\RelationManagers;
use App\Models\bank;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BankResource extends Resource
{
    protected static ?string $model = bank::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationLabel = 'البنوك';
    protected static ?string $pluralModelLabel = 'البنوك';

    protected static ?string $modelLabel = 'بنك';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->lable('أسم البنك')
                    ->required()
                    ->maxLength(100)
                    ->unique(ignoreRecord: true),

                Forms\Components\FileUpload::make('icon')
                    ->label('الأيقونة')
                    ->required()
                    ->image() 
                    ->avatar()
                    ->directory('banks/logos')
                    // ->rules(['mimes:svg', 'mimetypes:image/svg+xml']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('icon')
                    ->label('الأيقونة')
                    ->disk('public')
                    ->width(80)  
                    ->height(80)  
                    ->grow(false)
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('name')
                    ->label('أسم البنك')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('أنشى في'),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBanks::route('/'),
            // 'create' => Pages\CreateBank::route('/create'),
            // 'edit' => Pages\EditBank::route('/{record}/edit'),
        ];
    }
}
