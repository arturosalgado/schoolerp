@php
    $items = $this->getChecklistItems();
    $completedCount = $this->getCompletedCount();
    $totalCount = $this->getTotalCount();
@endphp

<x-filament-widgets::widget>
    <x-filament::section
        icon="heroicon-o-clipboard-document-check"
        :heading="__('fields.school_configuration')"
        :description="$completedCount . '/' . $totalCount . ' ' . __('fields.configured')"
    >
        <div style="display: flex; flex-direction: column; gap: 12px;">
            @foreach ($items as $item)
                <div style="display: flex; align-items: center; justify-content: space-between; gap: 12px;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        @if ($item['complete'])
                            <span style="color: #22c55e; font-size: 16px; line-height: 1;">✓</span>
                        @else
                            <span style="color: #6b7280; font-size: 16px; line-height: 1;">○</span>
                        @endif
                        <div>
                            <span style="font-size: 13px; font-weight: 500; color: #e5e7eb;">{{ $item['label'] }}</span>
                            <br>
                            <span style="font-size: 11px; color: #9ca3af;">{{ $item['description'] }}</span>
                        </div>
                    </div>

                    @if (! $item['complete'])
                        <a href="{{ $item['url'] }}"
                           style="display: inline-block; padding: 4px 12px; background: #f59e0b; color: #000; font-size: 12px; font-weight: 600; border-radius: 4px; text-decoration: none; white-space: nowrap;">
                            {{ __('fields.setup') }}
                        </a>
                    @endif
                </div>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
