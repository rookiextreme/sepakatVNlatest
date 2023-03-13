<html>
    <div class="detailing table-responsive">
        <table style='width:100%'>
            <thead>
                <tr style="background-color: #a2d3f0;">
                    <td class="col-mth header-depreciation" style='background-color: #a2d3f0;border: 1px solid black;color:black !important; font-family:mark-bold;' rowspan="2" colspan="2">Pemilik / Cawangan </td>
                    <td class="col-mth header-depreciation" style='background-color: #a2d3f0;border: 1px solid black;color:black !important; font-family:mark-bold;' rowspan="2">Negeri Penempatan </td>
                    <td class="col-mth header-depreciation" style='background-color: #a2d3f0;border: 1px solid black;color:black !important; font-family:mark-bold;' colspan="3" >Pengeluar Saman</td>
                    <td class="col-mth header-depreciation" style='background-color: #a2d3f0;border: 1px solid black;color:black !important; font-family:mark-bold;' rowspan="2">Jumlah</td>
                    <td class="col-mth header-depreciation" style='background-color: #a2d3f0;border: 1px solid black;color:black !important; font-family:mark-bold;' rowspan="2">No Pendaftaran</td>
                    <td class="col-mth header-depreciation" style='background-color: #a2d3f0;border: 1px solid black;color:black !important; font-family:mark-bold;' rowspan="2">No Notis Saman</td>
                    <td class="col-mth header-depreciation" style='background-color: #a2d3f0;border: 1px solid black;color:black !important; font-family:mark-bold;' rowspan="2">Tarikh Kesalahan</td>
                    <td class="col-mth header-depreciation" style='background-color: #a2d3f0;border: 1px solid black;color:black !important; font-family:mark-bold;' rowspan="2">Tarikh Terima Surat Saman (CDPK)</td>
                    <td class="col-mth header-depreciation" style='background-color: #a2d3f0;border: 1px solid black;color:black !important; font-family:mark-bold;' rowspan="2">Tarikh Notis Saman</td>
                    <td class="col-mth header-depreciation" style='background-color: #a2d3f0;border: 1px solid black;color:black !important; font-family:mark-bold;' rowspan="2">Jenis Saman</td>
                    <td class="col-mth header-depreciation" style='background-color: #a2d3f0;border: 1px solid black;color:black !important; font-family:mark-bold;' rowspan="2">Status</td>
                </tr>
                <tr>

                    <td class="col-mth header-depreciation"  style='background-color: #a2d3f0;border: 1px solid black;color:black !important; font-family:mark-bold;' >PDRM</td>
                    <td class="col-mth header-depreciation" style='background-color: #a2d3f0;border: 1px solid black;color:black !important; font-family:mark-bold;' >JPJ</td>
                    <td class="col-mth header-depreciation" style='background-color: #a2d3f0;border: 1px solid black;color:black !important; font-family:mark-bold;' >PBT</td>

                </tr>
            </thead>
            <tbody>

                @php
                    $totalPDRM = 0;
                    $totalJPJ = 0;
                    $totalPBT = 0;
                @endphp

                @foreach ($samanList as $index => $saman)

                @php
                    $rowspan = $saman['rowspan'];
                @endphp

                <tr>
                    <td
                    @if($rowspan > 0)
                        rowspan = "{{$rowspan}}"
                    @endif
                    >{{$index + 1}}</td>
                    <td 
                    style="text-align: left; @if($rowspan == 0) height: 20px; @endif"
                    @if($rowspan > 0)
                        rowspan = "{{$rowspan}}"
                    @endif
                    >{{$saman['name']}}</td>

                    @foreach($saman['has_many_state'] as $index2 => $state)
                        @if($index2 == 0)
                                <td style="vertical-align: middle;text-align:center;display: table-cell;" rowspan="{{count($state['has_many_summon'])}}">{{$state['name']}}</td>
                                @foreach ($state['has_many_summon'] as $index3 => $summon)

                                    @if($index3 == 0)
                                        <td>
                                            @if($summon->summon_code == '01')
                                            @php
                                                $totalPDRM += $summon->total;
                                            @endphp
                                            {{$summon->total}}
                                            @else 0
                                            @endif
                                        </td>
                                        <td>
                                            @if($summon->summon_code == '02')
                                            @php
                                                $totalJPJ += $summon->total;
                                            @endphp
                                            {{$summon->total}}
                                            @else 0
                                            @endif
                                        </td>
                                        <td>
                                            @if($summon->summon_code == '03')
                                            @php
                                                $totalPBT += $summon->total;
                                            @endphp
                                            {{$summon->total}}
                                            @else 0
                                            @endif
                                        </td>
                                        <td rowspan="{{$rowspan}}">{{$saman['total_summon']}}</td>
                                        <td>{{$summon->no_pendaftaran}}</td>
                                        <td>{{$summon->summon_notice_no}}</td>
                                        <td>{{Carbon\Carbon::parse($summon->mistake_date)->format('d/m/Y')}}</td>
                                        <td>{{Carbon\Carbon::parse($summon->receive_notice_date)->format('d/m/Y')}}</td>
                                        <td>{{Carbon\Carbon::parse($summon->notice_date)->format('d/m/Y')}}</td>
                                        <td>{{$summon->summon_type}}</td>
                                        <td>Belum Selesai</td>

                                    @endif

                                @endforeach
                        @endif
                    @endforeach

                    @if(count($saman['has_many_state']) == 0)
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    @endif

                </tr>

                @foreach($saman['has_many_state'] as $index2 => $state)
                    @if($index2 > 0)
                        <tr>
                            <td style="vertical-align: middle;text-align:center;display: table-cell;" rowspan="{{count($state['has_many_summon'])}}">{{$state['name']}}</td>

                            @foreach ($state['has_many_summon'] as $index3 => $summon)

                            @if($index3 == 0)
                                <td style="height: 15px;">
                                    @if($summon->summon_code == '01')
                                    @php
                                        $totalPDRM += $summon->total;
                                    @endphp
                                    {{$summon->total}}
                                    @else 0
                                    @endif
                                </td>
                                <td style="height: 15px;">
                                    @if($summon->summon_code == '02')
                                    @php
                                        $totalJPJ += $summon->total;
                                    @endphp
                                    {{$summon->total}}
                                    @else 0
                                    @endif
                                </td>
                                <td style="height: 15px;">
                                    @if($summon->summon_code == '03')
                                    @php
                                        $totalPBT += $summon->total;
                                    @endphp
                                    {{$summon->total}}
                                    @else 0
                                    @endif
                                </td>
                                <td>{{$summon->no_pendaftaran}}</td>
                                <td>{{$summon->summon_notice_no}}</td>
                                <td>{{Carbon\Carbon::parse($summon->mistake_date)->format('d/m/Y')}}</td>
                                <td>{{Carbon\Carbon::parse($summon->receive_notice_date)->format('d/m/Y')}}</td>
                                <td>{{Carbon\Carbon::parse($summon->notice_date)->format('d/m/Y')}}</td>
                                <td>{{$summon->summon_type}}</td>
                                <td>Belum Selesai</td>
                            @endif
                            
                        @endforeach

                        </tr>
                    @endif

                    @foreach ($state['has_many_summon'] as $index3 => $summon)

                        @if($index3 > 0)
                            <tr>
                                <td style="height: 15px;">
                                    @if($summon->summon_code == '01')
                                    @php
                                        $totalPDRM += $summon->total;
                                    @endphp
                                    {{$summon->total}}
                                    @else 0
                                    @endif
                                </td>
                                <td style="height: 15px;">
                                    @if($summon->summon_code == '02')
                                    @php
                                        $totalJPJ += $summon->total;
                                    @endphp
                                    {{$summon->total}}
                                    @else 0
                                    @endif
                                </td>
                                <td style="height: 15px;">
                                    @if($summon->summon_code == '03')
                                    @php
                                        $totalPBT += $summon->total;
                                    @endphp
                                    {{$summon->total}}
                                    @else 0
                                    @endif
                                </td>
                                <td>{{$summon->no_pendaftaran}}</td>
                                <td>{{$summon->summon_notice_no}}</td>
                                <td>{{Carbon\Carbon::parse($summon->mistake_date)->format('d/m/Y')}}</td>
                                <td>{{Carbon\Carbon::parse($summon->receive_notice_date)->format('d/m/Y')}}</td>
                                <td>{{Carbon\Carbon::parse($summon->notice_date)->format('d/m/Y')}}</td>
                                <td>{{$summon->summon_type}}</td>
                                <td>Belum Selesai</td>
                            </tr>
                        @endif
                        
                    @endforeach

                @endforeach

                @endforeach

            <tr>
                <td colspan="3" style="text-align: right; font-weight:bold;">Jumlah Saman</td>
                <td>{{$totalPDRM}}</td>
                <td>{{$totalJPJ}}</td>
                <td>{{$totalPBT}}</td>
                <td>{{$totalPDRM+$totalJPJ+$totalPBT}}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            </tbody>
        </table>
    </div>
</html>