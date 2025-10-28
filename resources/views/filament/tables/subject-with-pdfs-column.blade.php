@php
    $record = $getRecord();
    
    // Check if this is a schedule record (has subject relation) or direct subject record
    $subject = isset($record->subject) ? $record->subject : $record;

    if (!$subject) {
        echo '<span class="text-gray-400 text-xs">Sin materia</span>';
        return;
    }

    $fileTypes = [
        'programa_materia' => ['label' => 'Programa', 'title' => 'P'],
        'temario' => ['label' => 'Temario', 'title' => 'T'],
        'bibliografia' => ['label' => 'Bibliografía', 'title' => 'B']
    ];
@endphp

<div class="flex items-center gap-2">
    <span>{{ $subject->name }}</span>
    
    @php
        $hasFiles = false;
        foreach ($fileTypes as $field => $config) {
            if (!empty($subject->$field)) {
                $hasFiles = true;
                break;
            }
        }
    @endphp
    
    @if ($hasFiles)
        <div class="flex items-center gap-1">
            @foreach ($fileTypes as $field => $config)
                @if (!empty($subject->$field))
                    <a href="{{ route('student.download-subject-file', ['subject' => $subject->id, 'type' => $field]) }}" 
                       target="_blank" 
                       class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium text-white bg-red-600 hover:bg-red-700 rounded transition-colors" 
                       title="Descargar {{ $config['label'] }}">
                        <span>{{ $config['title'] }}</span>
                        📄
                    </a>
                @endif
            @endforeach
        </div>
    @endif
</div>