@php
    $record = $getRecord();
    if ($record instanceof \App\Models\Student){
        $student = $record;
    }
    else{
        // Use the eager-loaded student relationship instead of querying
        $student = $record->student;
    }
    $url = $student?->getImageUrl();
@endphp

<div {{ $getExtraAttributeBag() }}>
    @if ($url)
    <img src="{{$url}}" alt="" width="100"
         style="width: 100px;border-radius: 10px;float:left;margin-right: 10px;margin-bottom: 10px;

    margin-top: 4px;
    " />
    @else
        <img src="" style="width:100px;min-height: 110px; float:left;margin-right: 10px;margin-bottom: 10px;">
    @endif


    <b>{{ $student->enrollment }}</b>
    <br>
    <span style="font-size: 16px;">
    {{ $student->full_name }}
    </span>
    <br>
    <span style="font-size: 20px;">
    📧
    </span>  {{$student->email}}


    <br>
    <span style="font-size: 20px;">
        ☎️
    </span>

    {{$student->mobile}}

</div>
