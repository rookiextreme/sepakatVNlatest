<html>
<head>
    <title>Ringkasan Mengikut Kementerian</title>
</head>

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

    $total_by_month_agency = [
        1 => 0,
        2 => 0,
        3 => 0,
        4 => 0,
        5 => 0,
        6 => 0,
        7 => 0,
        8 => 0,
        9 => 0,
        10 => 0,
        11 => 0,
        12 => 0
    ];

    $grandTotal = 0;

@endphp

<table class="table table-bordered table-custom no-footer" style="width: 100%;">
    <thead>
        <tr>
            <th colspan="15" style="height: 50px;border: 1px solid #444444;">
                Bulanan Mengikut Kementerian (Tahun {{$year_selected}})
            </th>
        </tr>
        <tr>
            <th rowspan="2" style="vertical-align: middle; text-align: center; background-color: #dbdbdb; border: 1px solid #444444;">Bil</th>
            <th rowspan="2" style="vertical-align: middle; text-align: center; background-color: #dbdbdb; border: 1px solid #444444;">Nama Kementerian / Agensi</th>
            <th colspan="12" style="vertical-align: middle; text-align: center;height: 20px; background-color: #dbdbdb; border: 1px solid #444444;">Bulan</th>
            <th rowspan="2" style="vertical-align: middle; text-align: center;height: 20px; background-color: #dbdbdb; border: 1px solid #444444;">Jumlah</th>
        </tr>
        <tr>
            <th style="border-radius: 0px;height: 20px;background-color: #dbdbdb; border: 1px solid #444444;">Jan</th>
            <th style="height: 20px;background-color: #dbdbdb; border: 1px solid #444444;">Feb</th>
            <th style="height: 20px;background-color: #dbdbdb; border: 1px solid #444444;">Mac</th>
            <th style="height: 20px;background-color: #dbdbdb; border: 1px solid #444444;">Apr</th>
            <th style="height: 20px;background-color: #dbdbdb; border: 1px solid #444444;">Mei</th>
            <th style="height: 20px;background-color: #dbdbdb; border: 1px solid #444444;">Jun</th>
            <th style="height: 20px;background-color: #dbdbdb; border: 1px solid #444444;">Julai</th>
            <th style="height: 20px;background-color: #dbdbdb; border: 1px solid #444444;">Ogos</th>
            <th style="height: 20px;background-color: #dbdbdb; border: 1px solid #444444;">Sept</th>
            <th style="height: 20px;background-color: #dbdbdb; border: 1px solid #444444;">Okt</th>
            <th style="height: 20px;background-color: #dbdbdb; border: 1px solid #444444;">Nov</th>
            <th style="border-radius: 0px;background-color: #dbdbdb; border: 1px solid #444444;">Dec</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($list as $index => $agency)
            <tr>
                <td style="height: 20px;background-color: #dbdbdb; border: 1px solid #444444;">{{$index + 1}}</td>
                <td style="border: 1px solid #444444;">{{$agency['name']}}</td>
                @foreach ($agency['by_month'] as $index2 => $month)
                @php
                    $total_by_month_agency[$index2] += $agency['by_month'][$index2];
                @endphp
                    <td style="border: 1px solid #444444;">{{$agency['by_month'][$index2]}}</td>
                @endforeach
                @php
                    $grandTotal += $agency['total'];
                @endphp
                <td style="background-color: #dbdbdb; border: 1px solid #444444;">{{$agency['total']}}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="2" style="text-align: right;height: 20px;background-color: #dbdbdb; border: 1px solid #444444;">Jumlah</td>
            @foreach ($total_by_month_agency as $index2 => $month)
                <td id="by_month_{{$index2}}" style="background-color: #dbdbdb; border: 1px solid #444444;">{{$total_by_month_agency[$index2]}}</td>
            @endforeach
            <td style="background-color: #dbdbdb; border: 1px solid #444444;">{{$grandTotal}}</td>
        </tr>
    </tbody>
</table>

</body>
</html>

