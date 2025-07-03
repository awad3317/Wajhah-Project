<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdvertisementResource\Pages;
use App\Filament\Resources\AdvertisementResource\RelationManagers;
use Filament\Tables\Columns\Layout\Stack;
use App\Models\Advertisement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Support\Enums\Alignment;

class AdvertisementResource extends Resource
{
    protected static ?string $model = Advertisement::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'الإعلانات';
    protected static ?string $pluralModelLabel = 'الإعلانات';
    protected static ?string $modelLabel = 'إعلان';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->label('العنوان'),
                    
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->label('الوصف')
                    ->columnSpanFull(),
                    
                Forms\Components\FileUpload::make('image')
                    ->required()
                    ->image()
                    ->directory('advertisements')
                    ->label('الصورة'),
                    
                Forms\Components\Toggle::make('is_active')
                    ->required()
                    ->label('نشط')
                    ->default(true),
                    
                Forms\Components\DateTimePicker::make('start_date')
                    ->required()
                    ->label('تاريخ البدء'),
                    
                Forms\Components\DateTimePicker::make('end_date')
                    ->label('تاريخ الانتهاء')
                    ->nullable(),
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
                \Filament\Tables\Columns\Layout\Panel::make([ // استخدم Panel هنا
                    Stack::make([
                        Tables\Columns\ImageColumn::make('image')
                            ->disk('public')
                            ->height(200)
                            ->width('100%')
                            ->grow(false)
                            ->alignCenter()
                            ->extraImgAttributes(['style' => 'object-fit: cover;']),

                        Tables\Columns\TextColumn::make('title')
                            ->weight('bold')
                            ->searchable()
                            ->alignCenter(),

                        Tables\Columns\TextColumn::make('description')
                            ->limit(100)
                            ->color('gray')
                            ->alignCenter()
                            ->size('sm'),

                        Stack::make([
                            Tables\Columns\TextColumn::make('start_date')
                                ->dateTime('Y-m-d')
                                ->size('xs')
                                ->color('gray')
                                ->label('تاريخ البدء'),

                            Tables\Columns\TextColumn::make('end_date')
                                ->dateTime('Y-m-d')
                                ->size('xs')
                                ->color('gray')
                                ->label('تاريخ الانتهاء')
                                ->placeholder('لا يوجد تاريخ انتهاء'),
                        ])->space(1),

                        Tables\Columns\IconColumn::make('is_active')
                            ->boolean()
                            ->alignCenter()
                            ->label('الحالة'),
                    ])
                    ->space(3)
                    ->alignCenter(),
                ])
                ->extraAttributes(function (Advertisement $record): array {
                    return [
                        'class' => ($record->is_active ? 'border-l-4 border-green-500' : 'border-l-4 border-red-500'),
                    ];
                })
                ->alignment(Alignment::Center), // اختياري: ضبط محاذاة اللوحة
            ])
            ->filters([
                Tables\Filters\Filter::make('active')
                    ->label('النشطة فقط')
                    ->query(fn (Builder $query): Builder => $query->where('is_active', true)),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->checkIfRecordIsSelectableUsing(fn () => false);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageAdvertisements::route('/'),
        ];
    }
}
