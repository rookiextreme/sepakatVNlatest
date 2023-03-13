<html>
<head>
    <title>RINGKASAN BULANAN BY CKMN</title>
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

    $total_by_month_branch = [
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
                Bulanan Mengikut CKMN (Tahun {{$year_selected ?: "Keseluruhan"}})
            </th>
        </tr>
        <tr>
            <th rowspan="2" style="border: 1px solid #444444; vertical-align: middle; text-align: center;">Bil</th>
            <th rowspan="2" style="border: 1px solid #444444; vertical-align: middle; text-align: center;">CKMN</th>
            <th colspan="12" style="border: 1px solid #444444; vertical-align: middle; text-align: center;">Bulan</th>
            <th rowspan="2" style="border: 1px solid #444444; vertical-align: middle; text-align: center;">Jumlah</th>
        </tr>
        <tr>
            <th style="border: 1px solid #444444; text-align:center; vertical-align: middle; border-radius: 0px;border-bottom-color: #d7d7dd; border-left-width: 1px;">Jan</th>
            <th style="border: 1px solid #444444; text-align:center; vertical-align: middle; border-radius: 0px;border-bottom-color: #d7d7dd;">Feb</th>
            <th style="border: 1px solid #444444; text-align:center; vertical-align: middle; border-radius: 0px;border-bottom-color: #d7d7dd;">Mac</th>
            <th style="border: 1px solid #444444; text-align:center; vertical-align: middle; border-radius: 0px;border-bottom-color: #d7d7dd;">Apr</th>
            <th style="border: 1px solid #444444; text-align:center; vertical-align: middle; border-radius: 0px;border-bottom-color: #d7d7dd;">Mei</th>
            <th style="border: 1px solid #444444; text-align:center; vertical-align: middle; border-radius: 0px;border-bottom-color: #d7d7dd;">Jun</th>
            <th style="border: 1px solid #444444; text-align:center; vertical-align: middle; border-radius: 0px;border-bottom-color: #d7d7dd;">Julai</th>
            <th style="border: 1px solid #444444; text-align:center; vertical-align: middle; border-radius: 0px;border-bottom-color: #d7d7dd;">Ogos</th>
            <th style="border: 1px solid #444444; text-align:center; vertical-align: middle; border-radius: 0px;border-bottom-color: #d7d7dd;">Sept</th>
            <th style="border: 1px solid #444444; text-align:center; vertical-align: middle; border-radius: 0px;border-bottom-color: #d7d7dd;">Okt</th>
            <th style="border: 1px solid #444444; text-align:center; vertical-align: middle; border-radius: 0px;border-bottom-color: #d7d7dd;">Nov</th>
            <th style="border: 1px solid #444444; text-align:center; vertical-align: middle; border-radius: 0px;border-bottom-color: #d7d7dd; border-right-width: 1px;">Dec</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($list as $index => $branch)
            <tr>
                <td style="border: 1px solid #444444; background-color: #d7d7dd;">{{$index + 1}}</td>
                <td style="border: 1px solid #444444; background-color: #d7d7dd;">{{$branch['name']}}</td>
                @foreach ($branch['by_month'] as $index2 => $month)
                @php
                    $total_by_month_branch[$index2] += $branch['by_month'][$index2];
                @endphp
                    <td style="border: 1px solid #444444; background-color: #d7d7dd;text-align: center;">{{$branch['by_month'][$index2]}}</td>
                @endforeach
                @php
                    $grandTotal += $branch['total'];
                @endphp
                <td style="border: 1px solid #444444; background-color: #d7d7dd;text-align: center;">{{$branch['total']}}</td>
            </tr>
            @foreach ($branch['by_assessment'] as $index2 => $assessment)
                <tr>
                    @php
                        $total_by_assessment = 0;
                    @endphp
                    @if($index2 == 1)
                        <td style="border: 1px solid #444444;" rowspan="{{count($branch['by_assessment'])}}"></td>
                    @endif
                    <td style="border: 1px solid #444444; text-align: left !important; padding-left: 15px !important; border-left-style: none !important;">{{$assessment['name']}}</td>
                    @foreach ($assessment['by_month'] as $index3 => $a_month)
                    @php
                        $total_by_assessment += $a_month;
                    @endphp
                        <td style="border: 1px solid #444444;text-align: center;">{{$a_month}}</td>
                    @endforeach
                    <td style="border: 1px solid #444444;text-align: center;">{{$total_by_assessment}}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>
</body>
</html>
