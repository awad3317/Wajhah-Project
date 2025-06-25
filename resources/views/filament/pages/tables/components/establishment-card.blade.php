<div class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
    <div class="p-4">
        <div class="flex items-start gap-4">
            <img 
                src="{{ $getImageUrl() }}" 
                alt="{{ $getRecord()->name }}"
                class="h-16 w-16 rounded-md object-cover"
            >
            
            <div class="flex-1">
                <h3 class="font-bold text-gray-900 dark:text-white">
                    {{ $getRecord()->name }}
                </h3>
                
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    {{ $getRecord()->type->name }} - {{ $getRecord()->region->name }}
                </p>
                
                <div class="mt-2 flex items-center gap-2">
                    @if($getRecord()->is_verified)
                        <x-heroicon-o-check-badge class="h-4 w-4 text-green-500" />
                        <span class="text-xs text-green-600">موثق</span>
                    @endif
                    
                    @if($getRecord()->is_active)
                        <x-heroicon-o-bolt class="h-4 w-4 text-blue-500" />
                        <span class="text-xs text-blue-600">نشط</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <div class="border-t border-gray-200 dark:border-gray-800 px-4 py-2 flex justify-end gap-2">
        {{ $getActions() }}
    </div>
</div>