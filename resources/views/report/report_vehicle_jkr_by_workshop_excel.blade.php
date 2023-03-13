<html>
<body>
    <div class="detailing table-responsive">
        <table style='width:100%'>
            <thead>
                <tr>
                    <td colspan="6" style="height: 40px; font-size: 15px; font-weight: 900;">
                        RINGKASAN KENDERAAN MENGIKUT JKR WOKSYOP
                    </td>
                </tr>
                <tr>
                    <td class="col-mth header-depreciation text-center" style='color:black !important; font-family:mark-bold;' rowspan="2">Bil </td>
                    <td class="col-mth header-depreciation text-center" style='color:black !important; font-family:mark-bold;' rowspan="2">Woksyop </td>
                    <td class="col-mth header-depreciation text-center" style='color:black !important; font-family:mark-bold;' colspan="3" >Kategori</td>
                    <td class="col-mth header-depreciation text-center" style='color:black !important; font-family:mark-bold;' rowspan="2">Jumlah</td>
                </tr>
                <tr>

                    <td class="col-mth header-depreciation text-center" style='color:black !important; font-family:mark-bold;' >Kenderaan Pengangkut</td>
                    <td class="col-mth header-depreciation text-center" style='color:black !important; font-family:mark-bold;' >Kenderaan Penumpang</td>
                    <td class="col-mth header-depreciation text-center" style='color:black !important; font-family:mark-bold;' >Loji / Jentera</td>

                </tr>
            </thead>
            <tbody>

                @php
                    $overall_total_1 = 0;
                    $overall_total_2 = 0;
                    $overall_total_3 = 0;
                    $grand_total = 0;
                @endphp

                @foreach ($list as $index => $key)
                    @php
                        $cat_total_1 = $key->hasTotalByCategory('03');
                        $cat_total_2 = $key->hasTotalByCategory('01');
                        $cat_total_3 = $key->hasTotalByCategory('02');

                        $overall_total_1 = $overall_total_1 + $cat_total_1;
                        $overall_total_2 = $overall_total_2 + $cat_total_2;
                        $overall_total_3 = $overall_total_3 + $cat_total_3;

                        $overall = $cat_total_1 + $cat_total_2 + $cat_total_3;

                        $grand_total = $grand_total + $overall;
                    @endphp
                    <tr>
                        <td class="col-del">{{$index + 1}}</td>
                        <td class="text-left">
                            {{$key->hasState->desc}}
                        </td>
                        <td class="text-center">
                            {{number_format($cat_total_1)}}
                        </td>
                        <td class="text-center">
                            {{number_format($cat_total_2)}}
                        </td>
                        <td class="text-center">
                            {{number_format($cat_total_3)}}
                        </td>
                        <td class="text-center">
                            {{number_format($overall)}}
                        </td>
                    </tr>
                @endforeach

            <tr>
                <td colspan="2" style="text-align: right; font-weight:bold;">Jumlah Keseluruhan</td>
                <td class="text-center">{{number_format($overall_total_1)}}</td>
                <td class="text-center">{{number_format($overall_total_2)}}</td>
                <td class="text-center">{{number_format($overall_total_3)}}</td>
                <td class="text-center">{{number_format($grand_total)}}</td>
            </tr>

            </tbody>
        </table>
    </div>
</body>
</html>


