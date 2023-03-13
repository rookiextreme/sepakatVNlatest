<div class="detailing" style='overflow-x: scroll;'>
    <div class="small-title" style='margin-bottom:15px'>KKR- PENYATA KEMAJUAN PERBELANJAAN BULAN {{strtoupper($monthDesc[$selectedMonth])}} {{$selectedYear}}</div>

    <div class="row" id="kkr-parent">
        <div class="col-6 col-md-3 pe-0" id="container-kkr-state">
            <table class="" style="width: 100%">
                <tbody>
                    <tr>
                        <td class="col-mth header-depreciation left label_state" rowspan="1" colspan="2" style="height: 54px;">
                            @if($is_preview == 1)
                            @else
                            <button onclick="$('#addStateForKKRModal').modal('show')" type="button" class="btn cux-btn small no-printme"><i class="fa fa-plus"></i></button>
                            @endif
                        NEGERI
                        {{-- <td class="col-mth header-depreciation left" rowspan='2' colspan="2">NEGERI</td> --}}
                        <div class="btn-group float-end d-none d-md-inline-flex no-printme">
                            <button type="button" class="btn cux-btn small" onclick="scrollToLeft('container-kkr')"><i class="fa fa-arrow-left"></i></button>
                            <button type="button" class="btn cux-btn small" onclick="scrollToRight('container-kkr')"><i class="fa fa-arrow-right"></i></button>
                        </div>
                        </td>
                    </tr>
                    @if(count($osolKKR)> 0)
                        @foreach ($osolKKR as $osolItem)
                        <tr data-id = "{{$osolItem->id}}" data-div-type = "osolKKR">
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
        <div class="col-6 col-md-9 ps-0 overflow-auto" id="container-kkr">
            <table>
                <tr>
                    <td class="col-mth header-depreciation" rowspan="2">Tarikh</td>
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
                    <td class="col-mth header-depreciation" colspan='2' >PERBELANJAAN</td>
                    <td class="col-mth header-depreciation" colspan='2'>TANGGUNGAN</td>
                    <td class="col-mth header-depreciation" >JUMLAH</td>
                    <td class="col-mth header-depreciation" >PERBELANJAAN</td>
                    <td class="col-mth header-depreciation" >TANGGUNGAN</td>
                    <td class="col-mth header-depreciation" >KEWANGAN</td>
                </tr>
                <tbody>

                    @if(count($osolKKR)> 0)
                    @foreach ($osolKKR as $osolItem)
                    <tr data-id = "{{$osolItem->id}}" data-div-type = "osolKKR" >
                        {{-- <td class="row-item table-item cursor-pointer main edit-add-item-mhpv" style="text-transform:uppercase">{{$osolItem->state}}</td> --}}
                        {{-- <td class="table-item cursor-pointer  main edit-add-item-mhpv" ><i class="fa fa-pencil-alt"></i></td> --}}
                        <td class="row-item table-item " style="text-transform:uppercase">{{\Carbon\Carbon::parse($osolItem->warrant_received_dt)->format('d/m/Y')}}</td>
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

                    @foreach ($osolSumKKR as $osolItem)
                    <tr>
                        <td class="row-item table-item footer-table" style="text-transform:uppercase" rowspan="2"></td>
                        {{-- <td class="row-item table-item footer-table main" style="text-transform:uppercase" colspan="2">JUMLAH</td> --}}
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

    <div class="modal fade" id="addStateForKKRModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addStateForKKRLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form id="frm_addStateKKR">
                    <div class="modal-header">
                        Tambah Waran
                    </div>
                    <div class="modal-body" id="unlisted_state_kkr">
                        <div class="row">
                            <div class="col-md-12">
                                @if(count($unlistedKKRState) > 0)
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="" class="form-label">Negeri</label>
                                            <select name="workshop_id" id="workshop_id">
                                                @foreach($unlistedKKRState as $index => $workshop)
                                                <option value="{{$workshop->workshop_id}}">{{$workshop->state_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
    
                                        <div class="col-md-12">
                                            <label for="" class="form-label">Tarikh Waran</label>
                                            <div class="input-group date" id="warrant_received_dt">
                                                <input name="warrant_received_dt" id="warrantDtInput"
                                                type="text" class="form-control datepicker" placeholder=""
                                                autocomplete="off"
                                                data-provide="datepicker" data-date-autoclose="true"
                                                data-date-format="dd/mm/yyyy" data-date-today-highlight="true"
                                                value=""/>
    
                                                <div class="input-group-text" for="warrantDtInput">
                                                    <i class="fal fa-calendar fa-lg"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @else semua negeri telah ada.
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        @if(count($unlistedKKRState) > 0)
                        <button type="submit" class="btn btn-module">Simpan</button>
                        @endif
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript">

    submitKKRAddState = function(formData){
        $.post('{{route('maintenance.warrant.add.warrant.state.kkr')}}', {
            '_token': '{{ csrf_token() }}',
            'workshop_id' : formData.get('workshop_id'),
            'warrant_received_dt' : formData.get('warrant_received_dt'),
            'year' : '{{$selectedYear}}'
        }, function(res){
            console.log(res);
            if(res.code == 200){
                // $('#addStateForKKRModal').modal('hide');
                // $('#response').html('<span class="text-success">'+res.message+'</span>').fadeIn(500).fadeOut(5000);
                window.location.reload();
            }
        });
    }

    $(document).ready(function(){
        $('#workshop_id').select2({
            width: '100%',
            theme: "classic",
            dropdownParent: $('#addStateForKKRModal')
        });

        $('#frm_addStateKKR').on('submit', function(e){
            e.preventDefault();
            let form = new FormData(this);
            console.log('form => ', form.get('workshop_id'));
            submitKKRAddState(form);
        })
    })
</script>
