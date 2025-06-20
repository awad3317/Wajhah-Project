<?php

namespace App\Filament\Resources\UsersResource\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('إجمالي المستخدمين', User::count())
                ->description('عدد المستخدمين المسجلين في النظام')
                ->descriptionIcon('heroicon-o-users')
                ->color('primary')
                ->url(route('filament.admin.resources.users.index')),

            Stat::make('المستخدمون النشطون', User::where('is_banned', false)->count())
                ->description('المستخدمون غير المحظورين')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),
    
            Stat::make('المستخدمون المحظورون', User::where('is_banned', true)->count())
                ->description('المستخدمون المحظورين من النظام')
                ->descriptionIcon('heroicon-o-shield-exclamation')
                ->color('danger'),
        ];
    }
}
