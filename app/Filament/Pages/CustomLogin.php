<?php

namespace App\Filament\Pages;

use Filament\Forms\Form;
use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Validation\ValidationException;
class CustomLogin extends BaseLogin
{
    
     public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getLoginFormComponent(),
                $this->getPasswordFormComponent(),
            ]);
    }
    protected function getLoginFormComponent(): \Filament\Forms\Components\Component
    {
        return \Filament\Forms\Components\TextInput::make('phone')
            ->label(' رقم الجوال')
            ->required()
            ->autocomplete()
            ->placeholder('مثال: 9665XXXXXXXX')
            ->maxLength(15)
            ->autofocus();
    }
    protected function getCredentialsFromFormData(array $data): array
    { 
        return [
            'phone' => $data['phone'],
            'password' => $data['password'],
        ];
    }

    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.phone' => __('auth.failed'),
        ]);
    }
    public function getHeading(): string
    {
        return "الدخول إلى وجهة"; 
    }

}
