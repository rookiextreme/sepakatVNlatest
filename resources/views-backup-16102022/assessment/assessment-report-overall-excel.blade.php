@php
    $yearList = [];
    $monthList = [];

    $yearRange = range(date('Y') - 10, date('Y'));

    foreach ($yearRange as $key) {
        array_push($yearList,$key);
    }

    for ($i=1; $i <= 12; $i++) {
        array_push($monthList,$i);
    }

@endphp
<html>
<head>
    <title>Senarai Pemeriksaan</title>
</head>

<table class="table-custom stripe no-footer" style="width: 100%">
    <thead>
        <tr>
            <td colspan="13" class="text-uppercase" style="font-size: 20px; font-weight: bolder;text-transform: uppercase; height: 50px; margin-top: 25px; margin-left: 5px; vertical-align: top; ">
                {{\Str::upper("Senarai Pemeriksaan (Keseluruhan)")}}
            </td>
        </tr>
        <tr>
            <th class="text-center" style="height: 30px; background-color: #dbdbdb;">Bil</th>
            <th class="text-left" style="height: 30px; background-color: #dbdbdb;">JKR Woksyop</th>
            <th class="text-left" style="height: 30px; background-color: #dbdbdb;">Jenis Penilaian</th>
            <th class="text-left" style="height: 30px; background-color: #dbdbdb;">Jenis Kenderaan</th>
            <th class="text-left" style="height: 30px; background-color: #dbdbdb;">Model</th>
            <th class="text-left" style="height: 30px; background-color: #dbdbdb;">No. Pendaftaran</th>
            <th class="text-left" style="height: 30px; background-color: #dbdbdb;">Kementerian</th>
            <th class="text-left" style="height: 30px; background-color: #dbdbdb;">Agensi Lain</th>
            <th class="text-left" style="height: 30px; background-color: #dbdbdb;">Pemohon</th>
            <th class="text-center" style="height: 30px; background-color: #dbdbdb;">Tarikh Mohon</th>
            <th class="text-center" style="height: 30px; background-color: #dbdbdb;">Tarikh Periksa</th>
            <th class="text-center" style="height: 30px; background-color: #dbdbdb;">Kaedah Penilaian</th>
            <th class="text-center" style="height: 30px; background-color: #dbdbdb;">Status Penilaian</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($list as $index => $key)
            <tr>
                <td>{{($index + 1) + $offset}}</td>
                <td>{{$key->workshop_name}}</td>
                <td>{{$key->assessment_name}}</td>
                <td>{{$key->v_type_name}}</td>
                <td>{{$key->model_name}}</td>
                <td>{{$key->plate_no}}</td>
                <td>{{$key->ministry_name}}</td>
                <td>{{$key->department_name}}</td>
                <td>{{$key->applicant_name}}</td>
                <td class="text-center">{{\Carbon\Carbon::parse($key->created_at)->format('d/m/Y')}}</td>
                <td class="text-center">{{\Carbon\Carbon::parse($key->foremen_dt)->format('d/m/Y')}}</td>
                <td class="text-center">{{$key->assessment_method}}</td>
                <td class="text-center">{{$key->app_status}}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
