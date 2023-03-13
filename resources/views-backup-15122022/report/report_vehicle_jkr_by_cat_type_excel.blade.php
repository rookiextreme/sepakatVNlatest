@php
    $owner_type_desc = "Milik JKR Persekutuan";

    if(Request('owner_type_code') == '02'){
        $owner_type_desc = "Milik JKR Negeri";
    }
@endphp
<html>
    <body>
        <div class="detailing table-responsive">
            <table style='width:100%'>
                <thead>
                    <tr>
                        <td colspan="19" style="height: 40px; font-size: 15px; font-weight: 900; vertical-align: middle;">
                            PECAHAN KENDERAAN MENGIKUT JENIS ({{$owner_type_desc}})
                        </td>
                    </tr>
                    <tr>
                        <td class="col-mth header-depreciation text-center" style='color:black !important; font-family:mark-bold;' rowspan="2">Bil </td>
                        <td class="col-mth header-depreciation text-center" style='color:black !important; font-family:mark-bold;' rowspan="2">Jenis </td>
                        <td class="col-mth header-depreciation text-center" style='color:black !important; font-family:mark-bold; text-align: center;' colspan="{{count($state_list)}}" >Negeri</td>
                        <td class="col-mth header-depreciation text-center" style='color:black !important; font-family:mark-bold;' rowspan="2">Jumlah</td>
                    </tr>
                    <tr>
                        @foreach ($state_list as $state)
                            <td class="col-mth header-depreciation text-center" style='color:black !important; font-family:mark-bold;text-align: center;'>{{$state->desc}}</td>
                        @endforeach
                    </tr>
                </thead>
                <tbody>

                    @php
    
                        foreach ($state_list as $index_state => $state) {
                            $overall_total_ = 0;
                            ${"overall_total_$state->code"} = 0;
                        }
                        
                        $grand_total = 0;
                    @endphp
    
                    @foreach ($list as $index => $key)
                        @php
                            $overall = 0;
                            foreach ($state_list as $index_state => $state) {
                                ${"cat_total_$state->code"} = $key->hasTotalByState($state->code,Request('owner_type_code'));
                                $overall = $overall + ${"cat_total_$state->code"};
    
                                ${"overall_total_$state->code"} = ${"overall_total_$state->code"} + ${"cat_total_$state->code"};
    
                            }
    
                            $grand_total = $grand_total + $overall;
                        @endphp
                        <tr>
                            <td class="col-del">{{$index + 1}}</td>
                            <td class="text-left">
                                {{$key->name}}
                            </td>
                            @foreach ($state_list as $index_state => $state)
                                <td style="text-align:center;">
                                    @if(${"cat_total_$state->code"} > 0)
                                    {{number_format(${"cat_total_$state->code"})}}
                                    @else
                                    -
                                    @endif
                                </td>
                            @endforeach
                            <td style="text-align:center;">
                                @if($overall > 0)
                                {{number_format($overall)}}
                                @else
                                -
                                @endif
                            </td>
                        </tr>
                    @endforeach
    
                <tr>
                    <td colspan="2" style="text-align: right; font-weight:bold;">Jumlah Keseluruhan</td>
                    @foreach ($state_list as $index_state => $state)
                        <td style="text-align:center;">
                            @if(${"overall_total_$state->code"} > 0)
                            {{number_format(${"overall_total_$state->code"})}}
                            @else
                            -
                            @endif
                        </td>
                    @endforeach
                    <td style="text-align:center;">{{number_format($grand_total)}}</td>
                </tr>
    
                </tbody>
            </table>
        </div>
    </body>
</html>
