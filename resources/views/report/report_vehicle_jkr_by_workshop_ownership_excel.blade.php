<html>
<body>
    <div class="detailing table-responsive">
        <table style='width:100%'>
            <thead>
                <tr>
                    <td colspan="9" style="height: 40px; font-size: 15px; font-weight: 900;">
                        RINGKASAN KENDERAAN MENGIKUT JKR WOKSYOP
                    </td>
                </tr>
                <tr>
                    <td class="col-mth header-depreciation text-center" style='color:black !important; font-family:mark-bold;' rowspan="3">Bil </td>
                    <td class="col-mth header-depreciation text-center" style='color:black !important; font-family:mark-bold;' rowspan="3">Woksyop </td>
                    <td class="col-mth header-depreciation text-center" style='color:black !important; font-family:mark-bold;' colspan="6" >Kategori</td>
                    <td class="col-mth header-depreciation text-center" style='color:black !important; font-family:mark-bold;' rowspan="3">Jumlah</td>
                </tr>
                <tr>
                    <td class="col-mth header-depreciation text-center" style='color:black !important; font-family:mark-bold;' colspan="2">Kenderaan Pengangkut</td>
                    <td class="col-mth header-depreciation text-center" style='color:black !important; font-family:mark-bold;' colspan="2">Kenderaan Penumpang</td>
                    <td class="col-mth header-depreciation text-center" style='color:black !important; font-family:mark-bold;' colspan="2">Loji / Jentera</td>
                </tr>
                <tr>
                    <td class="col-mth header-depreciation text-center" style='color:black !important; font-family:mark-bold;'>Persekutuan</td>
                    <td class="col-mth header-depreciation text-center" style='color:black !important; font-family:mark-bold;'>Negeri</td>
                    <td class="col-mth header-depreciation text-center" style='color:black !important; font-family:mark-bold;'>Persekutuan</td>
                    <td class="col-mth header-depreciation text-center" style='color:black !important; font-family:mark-bold;'>Negeri</td>
                    <td class="col-mth header-depreciation text-center" style='color:black !important; font-family:mark-bold;'>Persekutuan</td>
                    <td class="col-mth header-depreciation text-center" style='color:black !important; font-family:mark-bold;'>Negeri</td>
                </tr>
            </thead>
            <tbody>

                @php
                    $overall_federal_total_1 = 0;
                    $overall_federal_total_2 = 0;
                    $overall_federal_total_3 = 0;

                    $overall_state_total_1 = 0;
                    $overall_state_total_2 = 0;
                    $overall_state_total_3 = 0;

                    $grand_total = 0;
                @endphp

                @foreach ($list as $index => $key)
                    @php
                        $cat_federal_total_1 = $key->hasTotalByCategoryOwnership('03', '01');
                        $cat_federal_total_2 = $key->hasTotalByCategoryOwnership('01', '01');
                        $cat_federal_total_3 = $key->hasTotalByCategoryOwnership('02', '01');

                        $overall_federal_total_1 = $overall_federal_total_1 + $cat_federal_total_1;
                        $overall_federal_total_2 = $overall_federal_total_2 + $cat_federal_total_2;
                        $overall_federal_total_3 = $overall_federal_total_3 + $cat_federal_total_3;

                        $overall_federal = $cat_federal_total_1 + $cat_federal_total_2 + $cat_federal_total_3;

                        $cat_state_total_1 = $key->hasTotalByCategoryOwnership('03', '02');
                        $cat_state_total_2 = $key->hasTotalByCategoryOwnership('01', '02');
                        $cat_state_total_3 = $key->hasTotalByCategoryOwnership('02', '02');

                        $overall_state_total_1 = $overall_state_total_1 + $cat_state_total_1;
                        $overall_state_total_2 = $overall_state_total_2 + $cat_state_total_2;
                        $overall_state_total_3 = $overall_state_total_3 + $cat_state_total_3;

                        $overall_state = $cat_state_total_1 + $cat_state_total_2 + $cat_state_total_3;

                        $grand_total = $grand_total + ($overall_federal + $overall_state);
                    @endphp
                    <tr>
                        <td class="col-del">{{$index + 1}}</td>
                        <td class="text-left">
                            {{$key->hasState->desc}}
                        </td>
                        <td class="text-center">
                            {{number_format($cat_federal_total_1)}}
                        </td>
                        <td class="text-center">
                            {{number_format($cat_state_total_1)}}
                        </td>
                        <td class="text-center">
                            {{number_format($cat_federal_total_2)}}
                        </td>
                        <td class="text-center">
                            {{number_format($cat_state_total_2)}}
                        </td>
                        <td class="text-center">
                            {{number_format($cat_federal_total_3)}}
                        </td>
                        <td class="text-center">
                            {{number_format($cat_state_total_3)}}
                        </td>
                        <td class="text-center">
                            {{number_format($overall_federal)}}
                        </td>
                    </tr>
                @endforeach

            <tr>
                <td colspan="2" style="text-align: right; font-weight:bold;">Jumlah Keseluruhan</td>
                <td class="text-center">{{number_format($overall_federal_total_1)}}</td>
                <td class="text-center">{{number_format($overall_state_total_1)}}</td>
                <td class="text-center">{{number_format($overall_federal_total_2)}}</td>
                <td class="text-center">{{number_format($overall_state_total_2)}}</td>
                <td class="text-center">{{number_format($overall_federal_total_3)}}</td>
                <td class="text-center">{{number_format($overall_state_total_3)}}</td>
                <td class="text-center">{{number_format($grand_total)}}</td>
            </tr>

            </tbody>
        </table>
    </div>
</body>
</html>


