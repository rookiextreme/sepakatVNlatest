<div class="detailing" style='overflow-x: scroll;'>
    <table><tr><td  colspan='12' > <div class="small-title" style='margin-bottom:15px'>AGENSI LUAR - PENYATA KEMAJUAN PERBELANJAAN BULAN {{strtoupper($monthDesc[$selectedMonth])}} {{$selectedYear}}</div></td></tr></table>
    <table>
        <tr>
            <td class="col-mth header-depreciation left" rowspan='2'>NEGERI</td>

            <td class="col-mth header-depreciation" colspan='4'>PERUNTUKAN (RM)</td>
            <td class="col-mth header-depreciation" colspan='3'>PERBELANJAAN (RM)</td>
            <td class="col-mth header-depreciation" rowspan='2'>BAKI (RM)</td>
            <td class="col-mth header-depreciation" colspan='3'>PERATUS (%)</td>


        </tr>
        <tr>
            <td class="col-mth header-depreciation">PERUNTUKAN</td>

            <td class="col-mth header-depreciation" >TAMBAHAN</td>
            <td class="col-mth header-depreciation" >TARIK BALIK</td>
            <td class="col-mth header-depreciation" >JUMLAH</td>
            <td class="col-mth header-depreciation" >PERBELANJAAN</td>
            <td class="col-mth header-depreciation" >TANGGUNGAN</td>
            <td class="col-mth header-depreciation" >JUMLAH</td>
            <td class="col-mth header-depreciation" >PERBELANJAAN</td>
            <td class="col-mth header-depreciation" >TANGGUNGAN</td>
            <td class="col-mth header-depreciation" >KEWANGAN</td>
        </tr>
        <tbody>
            @if(count($osolExternal)> 0)
            @foreach ($osolExternal as $osolItem)
            <tr data-id = "{{$osolItem->id}}" data-div-type = "osolExternal" >
                <td class="row-item table-item cursor-pointer main edit-add-item-mhpv" style="text-transform:uppercase">{{$osolItem->state}}</td>
                <td class="row-item table-item " style="text-transform:uppercase">{{number_format($osolItem->allocation,2)}}</td>
                <td class="row-item table-item " style="text-transform:uppercase">{{number_format($osolItem->addition,2)}}</td>
                <td class="row-item table-item " style="text-transform:uppercase">{{number_format($osolItem->deduct,2)}}</td>
                <td class="row-item table-item " style="text-transform:uppercase">{{number_format($osolItem->total_allocation,2)}}</td>
                <td class="row-item table-item cursor-pointer edit-add-item-adjustment" style="text-transform:uppercase">{{number_format($osolItem->carry_expense,2)}}</td>
                <td class="row-item table-item " style="text-transform:uppercase">{{number_format($osolItem->carry_advance,2)}}</td>
                <td class="row-item table-item " style="text-transform:uppercase">{{number_format($osolItem->carry_total_expense,2)}}</td>
                <td class="row-item table-item " style="text-transform:uppercase">{{number_format($osolItem->balance,2)}}</td>
                <td class="row-item table-item " style="text-transform:uppercase">{{$osolItem->percent_expense}}%</td>
                <td class="row-item table-item " style="text-transform:uppercase">{{$osolItem->percent_advance}}%</td>
                <td class="row-item table-item " style="text-transform:uppercase">{{$osolItem->percent_financial}}%</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="row-item table-item" style="text-transform:uppercase" colspan='12'>Tiada Maklumat</td>
            </tr>
            @endif
            @foreach ($osolSumExternal as $osolItem)
            <tr>
                <td class="row-item table-item footer-table main" style="text-transform:uppercase">JUMLAH</td>
                <td class="row-item table-item footer-table" style="text-transform:uppercase">{{number_format($osolItem->sum_allocation,2)}}</td>
                <td class="row-item table-item footer-table" style="text-transform:uppercase">{{number_format($osolItem->sum_addition,2)}}</td>
                <td class="row-item table-item footer-table" style="text-transform:uppercase">{{number_format($osolItem->sum_deduct,2)}}</td>
                <td class="row-item table-item footer-table" style="text-transform:uppercase">{{number_format($osolItem->sum_total_allocation,2)}}</td>
                <td class="row-item table-item footer-table" style="text-transform:uppercase">{{number_format($osolItem->carry_expense,2)}}</td>
                <td class="row-item table-item footer-table" style="text-transform:uppercase">{{number_format($osolItem->carry_advance,2)}}</td>
                <td class="row-item table-item footer-table" style="text-transform:uppercase">{{number_format($osolItem->carry_total_expense,2)}}</td>
                <td class="row-item table-item footer-table" style="text-transform:uppercase">{{number_format($osolItem->sum_balance,2)}}</td>
                <td class="row-item table-item footer-table" style="text-transform:uppercase">{{$osolItem->sum_percent_expense}}%</td>
                <td class="row-item table-item footer-table" style="text-transform:uppercase">{{$osolItem->sum_percent_advance}}%</td>
                <td class="row-item table-item footer-table" style="text-transform:uppercase">{{$osolItem->sum_percent_financial}}%</td>
                
            </tr>
            @endforeach

        </tbody>
    </table>
</div>