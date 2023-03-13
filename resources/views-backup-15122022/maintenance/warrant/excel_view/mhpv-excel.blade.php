<div class="detailing" style='overflow-x: scroll;'>
    <table><tr><td  colspan='12' > <div class="small-title" style='margin-bottom:15px'>OSOL 26000 - PENYATA KEMAJUAN PERBELANJAAN BULAN {{strtoupper($monthDesc[$selectedMonth])}} {{$selectedYear}}</div></td></tr></table>
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

            @if(count($osol26)> 0)
            @foreach ($osol26 as $osolItem)
            <tr data-id = "{{$osolItem->id}}" data-div-type = "osol26" >
                <td  class="row-item table-item cursor-pointer  main edit-add-item-mhpv" style="text-transform:uppercase">{{$osolItem->state}}</td>
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

            @foreach ($osolSum26 as $osolItem)
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
    <div class="pagebreak"></div>
    <table><tr><td  colspan='12' > <div class="small-title" style='margin-bottom:15px'>OSOL 28000 - PENYATA KEMAJUAN PERBELANJAAN BULAN {{strtoupper($monthDesc[$selectedMonth])}} {{$selectedYear}}</div></td></tr></table>
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
            @if(count($osol28)> 0)
            @foreach ($osol28 as $osolItem)
            <tr data-id = "{{$osolItem->id}}" data-div-type = "osol28">
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
            @foreach ($osolSum28 as $osolItem)
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
    <div class="pagebreak"></div>
    <table><tr><td  colspan='12' ><div class="small-title" style='margin-bottom:15px'>PENYATA KEMAJUAN MHPV BULAN {{strtoupper($monthDesc[$selectedMonth])}} {{$selectedYear}}</div></td></tr></table>
    <table>
        <tr>
            <td class="col-mth header-depreciation left">OSOL</td>
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

            @if(count($osolTotal)> 0)
            @foreach ($osolTotal['list_total'] as $osolItem)
            <tr>
                <td class="row-item table-item main" style="text-transform:uppercase">{{$osolItem->osol_value}}</td>
                <td class="row-item table-item" style="text-transform:uppercase">{{number_format($osolItem->sum_allocation,2)}}</td>
                <td class="row-item table-item" style="text-transform:uppercase">{{number_format($osolItem->sum_addition,2)}}</td>
                <td class="row-item table-item" style="text-transform:uppercase">{{number_format($osolItem->sum_deduct,2)}}</td>
                <td class="row-item table-item" style="text-transform:uppercase">{{number_format($osolItem->sum_total_allocation,2)}}</td>
                <td class="row-item table-item" style="text-transform:uppercase">{{number_format($osolItem->carry_sum_expense,2)}}</td>
                <td class="row-item table-item" style="text-transform:uppercase">{{number_format($osolItem->carry_sum_advance,2)}}</td>
                <td class="row-item table-item" style="text-transform:uppercase">{{number_format($osolItem->carry_sum_total_expense,2)}}</td>
                <td class="row-item table-item" style="text-transform:uppercase">{{number_format($osolItem->sum_balance,2)}}</td>
                <td class="row-item table-item" style="text-transform:uppercase">{{$osolItem->sum_percent_expense}}%</td>
                <td class="row-item table-item" style="text-transform:uppercase">{{$osolItem->sum_percent_advance}}%</td>
                <td class="row-item table-item" style="text-transform:uppercase">{{$osolItem->sum_percent_financial}}%</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="row-item table-item" style="text-transform:uppercase" colspan='12'>Tiada Maklumat</td>
            </tr>
            @endif

            <tr>
                <td class="row-item table-item footer-table main" style="text-transform:uppercase">JUMLAH</td>
                @if(count($osolTotal)> 0)
                    @if(array_key_exists(0,$osolTotal['list_total']) && array_key_exists(1,$osolTotal['list_total']))
                    
                    <td class="row-item table-item footer-table edit-add-item" style="text-transform:uppercase">{{ number_format((array_sum(array_column($osolTotal['list_total'], 'sum_allocation'))),2)}}</td>
                    <td class="row-item table-item footer-table edit-add-item" style="text-transform:uppercase">{{ number_format((array_sum(array_column($osolTotal['list_total'], 'sum_addition'))),2)}}</td>
                    <td class="row-item table-item footer-table edit-add-item" style="text-transform:uppercase">{{ number_format((array_sum(array_column($osolTotal['list_total'], 'sum_deduct'))),2)}}</td>
                    <td class="row-item table-item footer-table edit-add-item" style="text-transform:uppercase">{{ number_format((array_sum(array_column($osolTotal['list_total'], 'sum_total_allocation'))),2)}}</td>
                    <td class="row-item table-item footer-table edit-add-item" style="text-transform:uppercase">{{ number_format((array_sum(array_column($osolTotal['list_total'], 'carry_sum_expense'))),2)}}</td>
                    <td class="row-item table-item footer-table edit-add-item" style="text-transform:uppercase">{{ number_format((array_sum(array_column($osolTotal['list_total'], 'carry_sum_advance'))),2)}}</td>
                    <td class="row-item table-item footer-table edit-add-item" style="text-transform:uppercase">{{ number_format((array_sum(array_column($osolTotal['list_total'], 'carry_sum_total_expense'))),2)}}</td>
                    <td class="row-item table-item footer-table edit-add-item" style="text-transform:uppercase">{{ number_format((array_sum(array_column($osolTotal['list_total'], 'sum_balance'))),2)}}</td>

                    @else 
                    <td class="row-item table-item footer-table edit-add-item" style="text-transform:uppercase">0</td>
                    <td class="row-item table-item footer-table edit-add-item" style="text-transform:uppercase">0</td>
                    <td class="row-item table-item footer-table edit-add-item" style="text-transform:uppercase">0</td>
                    <td class="row-item table-item footer-table edit-add-item" style="text-transform:uppercase">0</td>
                    <td class="row-item table-item footer-table edit-add-item" style="text-transform:uppercase">0</td>
                    <td class="row-item table-item footer-table edit-add-item" style="text-transform:uppercase">0</td>
                    <td class="row-item table-item footer-table edit-add-item" style="text-transform:uppercase">0</td>
                    <td class="row-item table-item footer-table edit-add-item" style="text-transform:uppercase">0</td>
                    @endif

                    <td class="row-item table-item footer-table edit-add-item" style="text-transform:uppercase">{{$osolTotal['sum_percent_expense']}}%</td>
                    <td class="row-item table-item footer-table edit-add-item" style="text-transform:uppercase">{{$osolTotal['sum_percent_advance']}}%</td>
                    <td class="row-item table-item footer-table edit-add-item" style="text-transform:uppercase">{{$osolTotal['sum_percent_financial']}}%</td>

                @else
                    <td class="row-item table-item footer-table edit-add-item" style="text-transform:uppercase">0</td>
                    <td class="row-item table-item footer-table edit-add-item" style="text-transform:uppercase">0</td>
                    <td class="row-item table-item footer-table edit-add-item" style="text-transform:uppercase">0</td>
                    <td class="row-item table-item footer-table edit-add-item" style="text-transform:uppercase">0</td>
                    <td class="row-item table-item footer-table edit-add-item" style="text-transform:uppercase">0</td>
                    <td class="row-item table-item footer-table edit-add-item" style="text-transform:uppercase">0</td>
                    <td class="row-item table-item footer-table edit-add-item" style="text-transform:uppercase">0</td>
                    <td class="row-item table-item footer-table edit-add-item" style="text-transform:uppercase">0</td>
                    <td class="row-item table-item footer-table edit-add-item" style="text-transform:uppercase">0</td>
                    <td class="row-item table-item footer-table edit-add-item" style="text-transform:uppercase">0</td>
                    <td class="row-item table-item footer-table edit-add-item" style="text-transform:uppercase">0</td>
                @endif

            </tr>
        </tbody>
    </table>
</div>