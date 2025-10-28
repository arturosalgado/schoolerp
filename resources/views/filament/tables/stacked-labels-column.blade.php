<div {{ $getExtraAttributeBag()->class(['flex flex-col gap-1']) }} style="display: flex !important; flex-direction: column !important; gap: 0.25rem !important;">
    @php
        $labels = $getState();
        $record = $getRecord();
        
        // If it's a relationship, get the collection
        if($record && method_exists($record, 'labels')) {
            $labelsCollection = $record->labels;
        } else {
            $labelsCollection = collect($labels);
        }
    @endphp
    
    @if($labelsCollection && $labelsCollection->isNotEmpty())
        @foreach($labelsCollection as $label)
            <div class="fi-badge flex items-center justify-center gap-x-1 rounded-md text-xs font-medium ring-1 ring-inset px-2 min-h-6 fi-color-custom bg-custom-50 text-custom-600 ring-custom-600/10 dark:bg-custom-400/10 dark:text-custom-400 dark:ring-custom-400/30" style="--c-50:var(--primary-50);--c-400:var(--primary-400);--c-600:var(--primary-600); display: block !important; margin-bottom: 0.25rem !important;">
                {{ is_string($label) ? $label : $label->name }}
            </div>
        @endforeach
    @else
        <span class="text-gray-500 dark:text-gray-400 text-xs">-</span>
    @endif
</div>
