

<div class="detailing" style='overflow-x: scroll;'>

    @include('maintenance.warrant.tab.mhpv-osol-26000')
    <div class="pagebreak"></div>
    @include('maintenance.warrant.tab.mhpv-osol-28000')
    <div class="pagebreak"></div>
    <div class="small-title" style='margin-bottom:15px'>PENYATA KEMAJUAN MHPV BULAN {{strtoupper($monthDesc[$selectedMonth])}} {{$selectedYear}}</div>

    <div class="row" id="osolTotal0-parent">
        <div class="col-6 col-md-3 pe-0" id="container-osol-mhpv-state">
            <table class="" style="width: 100%">
                <tbody>

                    <tr>
                        <td class="col-mth header-depreciation left label_state" rowspan="1" colspan="2" style="height: 54px;">OSOL
                            <div class="btn-group float-end d-none d-md-inline-flex btn-scoller">
                                <button type="button" class="btn cux-btn small" onclick="scrollToLeft('container-osol-mhpv')"><i class="fa fa-arrow-left"></i></button>
                                <button type="button" class="btn cux-btn small" onclick="scrollToRight('container-osol-mhpv')"><i class="fa fa-arrow-right"></i></button>
                            </div>
                        </td>
                    </tr>

                    @if(count($osolTotal)> 0)
                    @foreach ($osolTotal['list_total'] as $osolItem)
                    <tr>
                        <td  class="row-item table-item cursor-pointer  main edit-add-item-mhpv" style="text-transform:uppercase">{{$osolItem->osol_value}}</td>
                    </tr>
                    @endforeach
                    @endif
                    <tr>
                        <td class="row-item table-item footer-table main" style="text-transform:uppercase" colspan='2' >JUMLAH</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-6 col-md-9 ps-0 overflow-auto" id="container-osol-mhpv">
            <table class="" style="width: 100%">
                <tr>
                    {{-- <td class="col-mth header-depreciation left" rowspan='2'>OSOL</td> --}}
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
                        {{-- <td class="row-item table-item main" style="text-transform:uppercase">{{$osolItem->osol_value}}</td> --}}
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
                        {{-- <td class="row-item table-item footer-table main" style="text-transform:uppercase">JUMLAH</td> --}}
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
</div>
