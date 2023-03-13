@php
    $grandTotalVehicle = 0;
    $grandTotalDone = 0;
    $grandTotalInProgress = 0;
    $grandTotalPercent = 0;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>VTL CKMN</title>
</head>
<body>
    <table class="table-custom stripe no-footer" style="width: 100%;">
        <thead>
            <tr>
                <th colspan="5" style="height: 50px;border: 1px solid #444444;">
                    {{$assessment_title}} Kenderaan JKR (Persekutuan Dan Negeri) Tahun {{$year_selected}}
                </th>
            </tr>
            <tr>
                <th>Bil</th>
                <th>Cawangan Kejuruteraan Mekanikal</th>
                <th>Jumlah Kenderaan Persekutuan Dan Negeri</th>
                <th>Jumlah Penilaian Selesai</th>
                <th>Peratus Selesai (%)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($list as $index => $state)
                @php
                    $grandTotalVehicle += $state['total_vehicle'];
                    $grandTotalDone += $state['total_done'];
                    $grandTotalInProgress += $state['total_inprogress'];
                @endphp
                <tr>
                    <td>{{$index + 1}}</td>
                    <td>{{$state['name']}}</td>
                    <td>{{$state['total_vehicle']}}</td>
                    <td>{{$state['total_done']}}</td>
                    <td>{{$state['total_done_percent'].'%'}}</td>
                </tr>
            @endforeach
            @if(count($list) == 0)
                <tr>
                    <td colspan="5">Tiada Rekod</td>
                </tr>
                @else
                <tr>
                    <td colspan="2" style="text-align: right; padding-right: 5px; text-transform: uppercase; font-weight: bolder;">Jumlah</td>
                    <td>{{$grandTotalVehicle}}</td>
                    <td>{{$grandTotalDone}}</td>
                    <td>{{ $grandTotalInProgress > 0 ? round(($grandTotalDone/$grandTotalInProgress) * 100) : 100}}%</td>
                </tr>
            @endif
        </tbody>
    </table>
</body>
</html>