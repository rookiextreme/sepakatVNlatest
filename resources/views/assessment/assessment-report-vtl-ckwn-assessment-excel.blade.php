@php
    $overall_percentage_assessment_compeleted = 0.0;
    $overall_total_assessment = 0.0;
    $overall_total_fleet = 0.0;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PEMERIKSAAN KESELAMATAN & PRESTASI KENDERAAN JKR (PERSEKUTUAN DAN NEGERI) TAHUN {{\Carbon\Carbon::now()->format('Y')}}</title>
</head>
<body>
    <table class="table-custom stripe no-footer" style="width: 100%;">
        <thead>
            <tr>
                <th colspan="5" style="height: 50px;border: 1px solid #444444;">
                    PEMERIKSAAN KESELAMATAN & PRESTASI KENDERAAN JKR (PERSEKUTUAN DAN NEGERI) TAHUN 2021 {{$year_selected}}
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
            @foreach ($list as $index => $branch)
                @php
                    $percentage_assessment_compeleted = 0.0;
                    if($branch['total_assessment'] != 0 && $branch['total_fleet'] != 0){
                        $overall_total_assessment += $branch['total_assessment'];
                        $overall_total_fleet += $branch['total_fleet'];
                        $percentage_assessment_compeleted = ($branch['total_assessment'] / $branch['total_assessment']) * 100;
                    }
                    $overall_percentage_assessment_compeleted = $percentage_assessment_compeleted;
                @endphp
                <tr>
                    <td>{{$index + 1}}</td>
                    <td>{{$branch['name']}}</td>
                    <td>{{$branch['total_fleet']}}</td>
                    <td>{{$branch['total_assessment']}}</td>
                    <td>{{$percentage_assessment_compeleted.'%'}}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="2">Jumlah</td>
                <td>{{$overall_total_assessment}}</td>
                <td>{{$overall_total_fleet}}</td>
                <td>{{$overall_percentage_assessment_compeleted.'%'}}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
