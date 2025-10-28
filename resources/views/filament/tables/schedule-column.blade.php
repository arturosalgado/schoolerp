<?php
$days = [
   'mo' => ['label' => 'Lu'],
   'tu' => ['label' => 'Ma'],
   'we' => ['label' => 'Mi'],
   'th' => ['label' => 'Ju'],
   'fr' => ['label' => 'Vi'],
   'sa' => ['label' => 'Sa'],
   'su' => ['label' => 'Do'],
];
$record = $getRecord();
?>
<table style="border-collapse:collapse;border:1px solid green ;font-family:monospace;font-size:13px;background-color: transparent">
    <thead>
        <tr>
            @foreach ($days as $dayData)
                <th  style="width:46px; padding:5px;text-align:center;font-weight:bold;color:gray;background-color:#f0f0f0;">
                    {{ $dayData['label'] }}
                </th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        <tr>
            @foreach ($days as $day => $dayData)
                @php
                    $startField = $day . 's';
                    $endField = $day . 'e';
                    $startTime = $record->{$startField};
                    $endTime = $record->{$endField};
                @endphp
                <td style="text-align:center;border:1px solid gray;background-color: transparent">
                    @if ($startTime && $endTime)
                        <div  style="padding:3px">
                            {{ date('H:i', strtotime($startTime)) }}<br>
                            {{ date('H:i', strtotime($endTime)) }}
                        </div>
                    @else
                        <div style="color:gray;width: 40px">-<br>-</div>
                    @endif
                </td>
            @endforeach
        </tr>
    </tbody>
</table>
