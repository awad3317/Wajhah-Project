<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EstablishmentTypeResource\Pages;
use App\Filament\Resources\EstablishmentTypeResource\RelationManagers;
use App\Models\EstablishmentType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EstablishmentTypeResource extends Resource
{
    protected static ?string $model = EstablishmentType::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'الاعدادات'; 

    protected static ?string $navigationLabel = 'أنواع المنشآت';

    protected static ?string $pluralModelLabel = 'أنواع المنشآت';

    protected static ?string $modelLabel = 'نوع المنشأة';


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
                    ->maxLength(65535),

                Forms\Components\FileUpload::make('icon')
                    ->label('الأيقونة')
                    ->required()
                    ->image() 
                    ->directory('establishment-type-icons')
                    ->rules(['mimes:svg', 'mimetypes:image/svg+xml']),
                
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
                Tables\Columns\ImageColumn::make('icon')
                    ->disk('public')
                    ->width(80)  
                    ->height(80)  
                    ->grow(false)
                    ->alignCenter(), 
            
                Tables\Columns\TextColumn::make('name')
                    ->weight('bold')
                    ->searchable()
                    ->alignCenter(),  
                
                Tables\Columns\TextColumn::make('description')
                    ->limit(100)  
                    ->color('gray')
                    ->alignCenter()  
                    ->size('sm'),  
            ])
            ->space(3)  
            ->alignCenter(),  
        ])
        ->actions([
            Tables\Actions\EditAction::make()->iconButton(),
            Tables\Actions\DeleteAction::make()->iconButton(),
        ]);
}

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageEstablishmentTypes::route('/'),
        ];
    }
}
