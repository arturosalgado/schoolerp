@php
    $schedule = $getRecord();
    $student = auth()->user()->student;
    $assessmentPattern = $schedule->assessmentPattern;
    
    // Get student's grades for this schedule
    $studentData = null;
    if ($student && $schedule->students) {
        $studentData = $schedule->students->where('id', $student->id)->first();
    }
    
    // Filter out ext column and sort components
    $filteredComponents = $assessmentPattern ? 
        $assessmentPattern->components->filter(function($component) {
            return $component->column_name !== 'ext';
        })->sortBy('order_index') : collect();
@endphp

<div {{ $getExtraAttributeBag() }} class="h-full w-full flex flex-col">
    @if ($assessmentPattern && $filteredComponents->count() > 0)
        <table class="border-collapse border border-gray-300 dark:border-gray-600 text-xs w-full h-full flex-1">
            <thead>
                <tr class="h-1/2">
                    @foreach ($filteredComponents as $component)
                        <th class="px-1 py-1 text-center font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-xs align-middle" style="width: {{ 100 / $filteredComponents->count() }}% !important;">
                            {{ Str::limit($component->component_name, 10) }}
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <tr class="h-1/2">
                    @foreach ($filteredComponents as $component)
                        @php
                            $grade = $studentData ? $studentData->pivot->{$component->column_name} : null;
                        @endphp
                        <td class="px-1 py-1 text-center border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 align-middle" style="width: {{ 100 / $filteredComponents->count() }}% !important;">
                            @if ($grade !== null)
                                <span class="text-xs font-semibold" style="color: {{ $grade >= 6 ? '#10b981' : '#ef4444' }} !important;">
                                    {{ number_format($grade, 1) }}
                                </span>
                            @else
                                <span class="text-gray-400 dark:text-gray-500 text-xs">-</span>
                            @endif
                        </td>
                    @endforeach
                </tr>
            </tbody>
        </table>
    @else
        <div class="flex items-center justify-center h-full text-gray-400 dark:text-gray-500 text-xs">No pattern</div>
    @endif
</div>
