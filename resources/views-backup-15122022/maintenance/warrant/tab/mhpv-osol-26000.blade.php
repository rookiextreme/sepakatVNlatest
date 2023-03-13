<div class="small-title" style='margin-bottom:15px'>OSOL 26000 - PENYATA KEMAJUAN PERBELANJAAN BULAN {{strtoupper($monthDesc[$selectedMonth])}} {{$selectedYear}}</div>

    <div class="row" id="osol260-parent">
        <div class="col-6 col-md-3 pe-0" id="container-osol-260-state">
            <table class="" style="width: 100%">
                <tbody>

                    <tr>
                        <td class="col-mth header-depreciation left label_state" colspan="2" style="height: 55px;">NEGERI
                            <div class="btn-group float-end d-none d-md-inline-flex btn-scoller">
                                <button type="button" class="btn cux-btn small" onclick="scrollToLeft('container-osol-260')"><i class="fa fa-arrow-left"></i></button>
                                <button type="button" class="btn cux-btn small" onclick="scrollToRight('container-osol-260')"><i class="fa fa-arrow-right"></i></button>
                            </div>
                        </td>
                    </tr>

                    @if(count($osol26)> 0)
                    @foreach ($osol26 as $osolItem)
                    <tr data-id = "{{$osolItem->id}}" data-div-type = "osol26">
                        <td  class="row-item table-item cursor-pointer  main edit-add-item-mhpv" style="text-transform:uppercase">{{$osolItem->state}}</td>
                        @if($is_preview == 1)

                        @else
                        <td class="table-item cursor-pointer  main edit-add-item-mhpv" ><i class="fa fa-pencil-alt"></i></td>
                        @endif
                    </tr>
                    @endforeach
                    @endif
                    @foreach ($osolSum26 as $osolItem)
                    <tr>
                        <td class="row-item table-item footer-table main" style="text-transform:uppercase" colspan='2' >JUMLAH</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-6 col-md-9 ps-0 overflow-auto" id="container-osol-260">
            <table class="" style="width: 100%">
                <tr>
                    {{-- <td class="col-mth header-depreciation left" rowspan='2' colspan='2'>NEGERI</td> --}}
                    <td class="col-mth header-depreciation" colspan='4'>PERUNTUKAN (RM)</td>
                    <td class="col-mth header-depreciation" colspan='5'>PERBELANJAAN (RM)</td>
                    <td class="col-mth header-depreciation" rowspan='2'>BAKI (RM)</td>
                    <td class="col-mth header-depreciation" colspan='3'>PERATUS (%)</td>
                </tr>
                <tr>

                    <td class="col-mth header-depreciation">PERUNTUKAN</td>
                    <td class="col-mth header-depreciation" >TAMBAHAN</td>
                    <td class="col-mth header-depreciation" >TARIK BALIK</td>
                    <td class="col-mth header-depreciation" >JUMLAH</td>
                    <td class="col-mth header-depreciation" colspan='2'>PERBELANJAAN</td>
                    <td class="col-mth header-depreciation" colspan='2'>TANGGUNGAN</td>
                    <td class="col-mth header-depreciation" >JUMLAH</td>
                    <td class="col-mth header-depreciation" >PERBELANJAAN</td>
                    <td class="col-mth header-depreciation" >TANGGUNGAN</td>
                    <td class="col-mth header-depreciation" >KEWANGAN</td>
                </tr>
                <tbody>

                    @if(count($osol26)> 0)
                    @foreach ($osol26 as $osolItem)
                    <tr data-id = "{{$osolItem->id}}" data-div-type = "osol26" >
                        {{-- <td  class="row-item table-item cursor-pointer  main edit-add-item-mhpv" style="text-transform:uppercase">{{$osolItem->state}}</td> --}}
                        {{-- <td class="table-item cursor-pointer  main edit-add-item-mhpv" ><i class="fa fa-pencil-alt"></i></td> --}}
                        <td class="row-item table-item " style="text-transform:uppercase">{{number_format($osolItem->allocation,2)}}</td>
                        <td class="row-item table-item " style="text-transform:uppercase">{{number_format($osolItem->addition,2)}}</td>
                        <td class="row-item table-item " style="text-transform:uppercase">{{number_format($osolItem->deduct,2)}}</td>
                        <td class="row-item table-item " style="text-transform:uppercase">{{number_format($osolItem->total_allocation,2)}}</td>
                        <td class="row-item table-item " @if($is_preview == 1) colspan="2" @endif style="text-transform:uppercase">{{number_format($osolItem->carry_expense,2)}}</td>
                        @if($is_preview == 1)
                        @else
                        <td class="table-item cursor-pointer" style="padding: 8px;" data-id="{{$osolItem->id}}" data-curr_val="{{$osolItem->carry_expense}}" data-expense="{{$osolItem->expense}}" data-adjust="expense">
                            <div class="btn-group">
                                <button type="button" data-mode="add" class="btn cux-btn edit-add-item-adjustment">
                                    <i class="fa fa-plus"></i>
                                </button>
                                <button type="button" data-mode="update" class="btn cux-btn edit-add-item-adjustment">
                                    <i class="fa fa-pencil-alt"></i>
                                </button>
                            </div>
                        </td>
                        @endif
                        <td class="row-item table-item " style="text-transform:uppercase">{{number_format($osolItem->carry_advance,2)}}</td>
                        @if($is_preview == 1)
                        @else
                        <td class="table-item cursor-pointer" style="padding: 8px;" data-id="{{$osolItem->id}}" data-curr_val="{{$osolItem->carry_advance}}" data-advance="{{$osolItem->advance}}" data-adjust="advance" >
                            <div class="btn-group">
                                <button type="button" data-mode="add" class="btn cux-btn edit-add-item-adjustment">
                                    <i class="fa fa-plus"></i>
                                </button>
                                <button type="button" data-mode="update" class="btn cux-btn edit-add-item-adjustment">
                                    <i class="fa fa-pencil-alt"></i>
                                </button>
                            </div>
                        </td>
                        @endif
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
                        {{-- <td class="row-item table-item footer-table main" style="text-transform:uppercase" colspan='2' >JUMLAH</td> --}}
                        <td class="row-item table-item footer-table" style="text-transform:uppercase">{{number_format($osolItem->sum_allocation,2)}}</td>
                        <td class="row-item table-item footer-table" style="text-transform:uppercase">{{number_format($osolItem->sum_addition,2)}}</td>
                        <td class="row-item table-item footer-table" style="text-transform:uppercase">{{number_format($osolItem->sum_deduct,2)}}</td>
                        <td class="row-item table-item footer-table" style="text-transform:uppercase">{{number_format($osolItem->sum_total_allocation,2)}}</td>
                        <td class="row-item table-item footer-table" style="text-transform:uppercase" colspan='2'>{{number_format($osolItem->carry_expense,2)}}</td>
                        <td class="row-item table-item footer-table" style="text-transform:uppercase" colspan='2'>{{number_format($osolItem->carry_advance,2)}}</td>
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
    </div>

