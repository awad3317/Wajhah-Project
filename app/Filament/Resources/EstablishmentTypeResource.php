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
                    ->avatar()
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
                // الأيقونة في الأعلى
                Tables\Columns\ImageColumn::make('icon')
                    ->label('')
                    ->disk('public')
                    ->width(120)  // عرض ثابت للأيقونة
                    ->height(120)  // ارتفاع ثابت للأيقونة
                    ->grow(false)
                    ->alignCenter()
                    ->extraAttributes(['class' => 'rounded-full border-2 border-white shadow-md']),,  // توسيط الأيقونة
                
                // العنوان
                Tables\Columns\TextColumn::make('name')
                    ->label('')
                    ->weight('bold')
                    ->searchable()
                    ->alignCenter(),  // توسيط العنوان
                
                // الوصف
                Tables\Columns\TextColumn::make('description')
                    ->label('')
                    ->limit(100)  // زيادة الحد الأقصى للأحرف
                    ->color('gray')
                    ->alignCenter()  // توسيط الوصف
                    ->size('sm'),  // حجم أصغر للوصف
                Tables\Actions\Action::make('view')
        ->label('عرض التفاصيل')
        ->button()
        ->size('sm')
        ->url(fn ($record) => route('filament.resources.your-resource.view', $record))

            ])
            ->space(3)  // زيادة المسافة بين العناصر
            ->alignCenter()
            ->extraAttributes(['class' => 'hover:shadow-lg transition-shadow'])
            ->extraAttributes(['class' => 'h-64'])
            ->extraAttributes(['class' => 'border rounded-lg']),  // توسيط جميع محتويات البطاقة
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
