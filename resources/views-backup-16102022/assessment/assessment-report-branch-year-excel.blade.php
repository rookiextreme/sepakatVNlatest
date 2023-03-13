<html>
<head>
<title>RINGKASAN TAHUNAN MENGIKUT CKMN</title>
</head>

@php

    $grandTotal = 0;

@endphp

<body class="content">
    <table class="table table-bordered table-custom no-footer" style="width: 100%;">
        <thead>
            <tr>
                <th colspan="{{count($year_range) + 3}}" style="height: 50px;border: 1px solid #444444;">
                    Tahunan Mengikut CKMN (Tahun {{$year_selected ?: "Keseluruhan"}})
                </th>
            </tr>
            <tr>
                <th rowspan="2" style="vertical-align: middle; text-align: center;">Bil</th>
                <th rowspan="2" style="vertical-align: middle; text-align: center;">CKMN</th>
                <th colspan="{{count($by_year)}}" style="vertical-align: middle; text-align: center;">Tahun</th>
                <th rowspan="2" style="vertical-align: middle; text-align: center;">Jumlah</th>
            </tr>
            <tr>
                @foreach ($year_range as $index_year => $year)
                <th style="text-align:center; vertical-align: middle; border-radius: 0px;border-bottom-color: #d7d7dd;">{{$year}}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($list as $index => $branch)
                <tr>
                    <td style="background-color: #d7d7dd;">{{$index + 1}}</td>
                    <td style="background-color: #d7d7dd;">{{$branch['name']}}</td>
                    @foreach ($branch['by_year'] as $index2 => $year)
                        <td style="background-color: #d7d7dd; text-align: center;">
                            {{$year}}
                        </td>
                    @endforeach
                    @php
                        $grandTotal += $branch['total'];
                    @endphp
                    <td style="background-color: #d7d7dd; text-align: center;">{{$branch['total']}}</td>
                </tr>
                @foreach ($branch['by_assessment'] as $index2 => $assessment)
                    <tr>
                        @php
                            $total_by_assessment = 0;
                        @endphp
                        @if($index2 == 1)
                            <td rowspan="{{count($branch['by_assessment'])}}"></td>
                        @endif
                        <td style="text-align: left !important; padding-left: 15px !important; border-left-style: none !important;">{{$assessment['name']}}</td>
                        @foreach ($assessment['by_year'] as $index3 => $a_year)
                        @php
                            $total_by_assessment += $a_year;
                        @endphp
                            <td style="text-align: center;">
                                {{$a_year}}
                            </td>
                        @endforeach
                        <td style="text-align: center;">{{$total_by_assessment}}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>
</html>
