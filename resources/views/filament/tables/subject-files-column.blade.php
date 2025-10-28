<?php
$record = $getRecord();
$subject = $record->subject;

if (!$subject) {
    echo '<span class="text-gray-400 text-xs">Sin materia</span>';
    return;
}

$fileTypes = [
    'programa_materia' => ['label' => 'Programa', 'icon' => '📄'],
    'temario' => ['label' => 'Temario', 'icon' => '📋'], 
    'bibliografia' => ['label' => 'Bibliografía', 'icon' => '📚']
];

$hasFiles = false;
?>

<div class="flex flex-col gap-1 min-w-max">
    @foreach ($fileTypes as $field => $config)
        @if (!empty($subject->$field))
            @php $hasFiles = true; @endphp
            <a href="{{ route('student.download-subject-file', ['subject' => $subject->id, 'type' => $field]) }}" 
               target="_blank" 
               class="inline-flex items-center gap-1 text-primary-600 hover:text-primary-800 text-xs font-medium bg-primary-50 px-2 py-1 rounded-md border border-primary-200 hover:bg-primary-100 transition-colors no-underline">
                <span>{{ $config['icon'] }}</span>
                <span>{{ $config['label'] }}</span>
            </a>
        @endif
    @endforeach
    
    @if (!$hasFiles)
        <span class="text-gray-400 text-xs px-2 py-1">Sin archivos</span>
    @endif
</div>