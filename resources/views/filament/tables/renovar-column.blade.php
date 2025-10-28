@php
    $record = $getRecord();
    $url = route('subscription.show', [
        'renew' => true,
        'tenant_id' => $record->school_id,
        'plan' => $record->plan_type,
        'billing_cycle' => $record->billing_cycle
    ]);
@endphp

<div {{ $getExtraAttributeBag() }}>
    <a href="{{ $url }}" 
       class="inline-flex items-center px-2 py-1 bg-green-100 hover:bg-green-200 dark:bg-green-900 dark:hover:bg-green-800 text-green-800 dark:text-green-300 text-xs font-medium rounded transition-colors duration-200 ease-in-out">
        Renovar
    </a>
</div>
