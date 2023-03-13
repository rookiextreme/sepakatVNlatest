@php
    $form = $detail->hasJVEForm;
    $hasInternalQuot = null;
    $hasExternalQuot = null;

    if($detail->hasJVEForm){
        if($detail->hasJVEForm->hasInternalQuot){
            $hasInternalQuot = $detail->hasJVEForm->hasInternalQuot;
        }
        if($detail->hasJVEForm->hasExternalQuot){
            $hasExternalQuot = $detail->hasJVEForm->hasExternalQuot;
        }
    }

@endphp
<form class="row" id="frm_detail" enctype="multipart/form-data">

    @csrf

    @if($detail && ($detail->is_research_market == 1 || $detail->is_research_market == 2))
        <div class="fixed-submit">
            @if ($detail && !$detail->completedBy)
                <button class="btn btn-link" type="button" xaction="draf"><i class="fa fa-save"></i> Simpan</button>
                <button class="btn btn-module" type="button" data-bs-toggle="modal" data-bs-target="#prompApprovalModal">Selesai</button>
            @endif
        </div>
    @endif

    <div class="messages"></div>

    <input type="hidden" name="section" value="detail">
    <fieldset>
        <legend>Maklumat Rekod Penyenggaraan</legend>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="" class="form-label">No. Pendaftaran</label>
                    <div>{{$hasVehicle->plate_no}}</div>
                </div>
            </div>
            <div class="col-md-6"></div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="" class="form-label">Kategori</label>
                    <div>{{$hasVehicle->hasCategory ? $hasVehicle->hasCategory->name : ''}}</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="" class="form-label">Jenis</label>
                    <div>{{
                    $hasVehicle->hasSubCategory ?
                    $hasVehicle->hasSubCategory->name .($hasVehicle->hasSubCategoryType ? ' > '.$hasVehicle->hasSubCategoryType->name : '')
                    : ''
                    }}</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="" class="form-label">Model</label>
                    <div>{{$hasVehicle->model_name ? $hasVehicle->model_name : ''}}</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="" class="form-label">Nama Syarikat / Jabatan yang menyenggara</label>
                    <div>{{$hasMaintenanceDetail->hasWorkshop->desc}}</div>
                </div>
            </div>
        </div>
        <hr/>
        @if($detail && ($detail->is_research_market == 1 || $detail->is_research_market == 2))
        <div class="row">
            <div class="col-md-4">
                <div class="form-group col-md-6">
                    <label for="" class="form-label">Tarikh</label>
                    <div>{{\Carbon\Carbon::now()->format('d F Y')}}</div>
                </div>
                <div class="form-group col-md-12">
                    <label for="" class="form-label">No. Baucer <span class="text-danger">*</span></label>
                    @if($detail && $detail->expense == 0)
                    <input class="form-control" maxlength="100" type="text" name="lo_no" id="lo_no" value="{{$detail ? $detail->lo_no : ''}}">
                    @else
                    {{$detail ? $detail->lo_no : ''}}
                    @endif
                </div>
                <div class="form-group col-md-5">
                    <label for="" class="form-label">Tarikh Bayaran <span class="text-danger">*</span></label>
                    @if($detail && $detail->expense == 0)
                    <div class="input-group date" id="completed_dt"
                        data-target-input="nearest">
                            <input name="completed_dt" id="completed_dtInput"
                            type="text" class="form-control datepicker" placeholder=""
                            autocomplete="off"
                            data-provide="datepicker" data-date-autoclose="true"
                            data-date-format="dd/mm/yyyy" data-date-today-highlight="true"
                            value="{{$detail && $detail->completed_dt ? Carbon\Carbon::parse($detail->completed_dt)->format('d/m/Y') : ''}}"/>

                            <div class="input-group-text" for="completed_dtInput">
                                <i class="fa fa-calendar"></i>
                            </div>
                    </div>
                    @else
                    {{$detail && $detail->completed_dt ? Carbon\Carbon::parse($detail->completed_dt)->format('d/m/Y') : ''}}
                    @endif
                </div>
            </div>
            @if (
                Auth::user()->isAdmin() ||
                Auth::user()->isSeniorEngineerMaintenance() ||
                Auth::user()->isEngineerMaintenance() ||
                Auth::user()->isAssistEngineerMaintenance()
            )
                @if($detail && $detail->is_research_market == 1)
                    <div class="col-md-8">
                        <fieldset>
                            <legend>Senarai Perihal Kerja</legend>
                            <div class="table-responsive">
                                <table class="sripe table-custom">
                                    <thead>
                                        <th class="text-center" style="width: 50px;">Bil.</th>
                                        <th>Jenis Penyenggaraan</th>
                                        <th>Perihal Kerja</th>
                                        <th class="text-right" style="width: 130px;">Harga (RM)</th>
                                        <th>{{$detail->hasSelectedSupplierComp ? $detail->hasSelectedSupplierComp->company_name : ''}}</th>
                                    </thead>
                                    <tbody>

                                        @if(count($detail->hasManyMVComponentList) == 0)
                                            <tr class="no-record">
                                                <td colspan="5" class="no-record"><i class="fas fa-info-circle"></i> Tiada rekod dijumpai</td>
                                            </tr>
                                        @endif

                                        {{-- @json($detail->hasSelectedSupplierComp->hasManyProcurement) --}}
                                        @foreach ($detail->hasManyMVComponentList as $component)
                                        <tr>
                                            <td>{{$loop->index+1}}.</td>
                                            <td>PEMBAIKAN {{$detail->hasRepairMethod->desc}}</td>
                                            {{-- <td>KERJA-KERJA MEMBUKA, MEROMBAK RAWAT, MENGENALPASTI DAN MEMASANG ALAT GANTI BARU BAGI {{$component->hasRefComponentLvl1?$component->hasRefComponentLvl1->component:''}} SEHINGGA SEMPURNA --}}
                                                <td> {{strtoupper($component->detail)}}
                                                @if($component->hasManyResearchMarketComponent->count()>0)
                                                    <ul class="sub-component mt-2" style="list-style-type: upper-roman;">
                                                        @foreach ($component->hasManyResearchMarketComponent as $componentSub)
                                                            <li class="mb-1">
                                                                <label for="" class="form-label d-inline" style="line-height: 20px">
                                                                    @switch($componentSub->lvl)
                                                                        @case(2)
                                                                            {{$componentSub->hasCompLvl2->component}}
                                                                            @break
                                                                        @case(3)
                                                                        {{$componentSub->hasCompLvl3->component}}
                                                                            @break
                                                                        @default

                                                                    @endswitch
                                                                </label>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </td>
                                            <td>{{number_format($component->total_price, 2)}}</td>
                                            <td>
                                                @if($detail->hasSelectedSupplierComp)
                                                {{-- {{$detail->hasSelectedSupplierComp}} --}}
                                                @php
                                                    $selectedComp = $detail->hasSelectedSupplierComp->hasManyProcurement->where('mjob_exam_form_component_id', $component->id)->first();
                                                @endphp
                                                {{number_format($selectedComp ? $selectedComp->price : 0 , 2)}}
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>
                                        <th class="text-center" style="width: 50px;">Bil.</th>
                                        <th>Jenis Penyenggaraan</th>
                                        <th>Perihal Kerja</th>
                                        <th class="text-right" style="width: 130px;">Harga (RM)</th>
                                        <th>{{number_format($detail->pro_budget_price, 2)}}</th>
                                    </thead>
                                    </tfoot>
                                </table>
                            </div>
                        </fieldset>
                    </div>
                    @elseif($detail && $detail->is_research_market == 2)
                    @if ($detail->repair_method_id == 1)
                        <div class="col-md-8">
                            <fieldset>
                                <legend>Sebut Harga</legend>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="" class="form-label">Pilihan Waran</label>
                                            {{$hasInternalQuot && $hasInternalQuot->hasWarantType ? $hasInternalQuot->hasWarantType->desc : ''}}
                                        </div>
                                    </div>
                                    @if($hasInternalQuot && $hasInternalQuot->hasWarantType->code == '01')
                                        <div class="col-md-6" id="osol_type_container">
                                            <div class="form-group">
                                                <label for="" class="form-label">Jenis Osol</label>
                                                {{$hasInternalQuot->hasOsolType ? $hasInternalQuot->hasOsolType->desc : ''}}
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="" class="form-label">No sebutharga</label>
                                            @if ($hasInternalQuot)
                                                {{$hasInternalQuot->quotation_no ? $hasInternalQuot->quotation_no : ''}}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="" class="form-label">Nama syarikat pembekal</label>
                                            {{-- @foreach ($detail->hasQuotation as $quotation)
                                                {{$quotation ? $quotation->company_name : ''}}
                                            @endforeach --}}
                                            @if ($hasInternalQuot)
                                                {{$hasInternalQuot->company_name ? $hasInternalQuot->company_name : ''}}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="" class="form-label">Tarikh Sebut Harga</label>
                                            {{-- @foreach ($detail->hasQuotation as $quotation)
                                                {{$quotation ? \Carbon\Carbon::parse($quotation->quotation_dt)->format('d/m/Y') : ''}}
                                            @endforeach --}}
                                            @if ($hasInternalQuot)
                                                {{$hasInternalQuot ? \Carbon\Carbon::parse($hasInternalQuot->quotation_dt)->format('d/m/Y') : ''}}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="" class="form-label">Tarikh SST</label>
                                            {{-- @foreach ($detail->hasQuotation as $quotation)
                                                {{$quotation ? \Carbon\Carbon::parse($quotation->sst_dt)->format('d/m/Y') : ''}}
                                            @endforeach --}}
                                            @if ($hasInternalQuot)
                                                {{$hasInternalQuot ? \Carbon\Carbon::parse($hasInternalQuot->sst_dt)->format('d/m/Y') : ''}}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="" class="form-label">Jumlah harga (RM)</label>
                                            {{-- {{$detail->hasQuotation ? number_format($detail->hasQuotation->total_price, 2) : ''}} --}}
                                            {{-- @foreach ($detail->hasQuotation as $quotation)
                                                {{$quotation ? number_format($quotation->total_price, 2) : ''}}
                                            @endforeach --}}
                                            @if ($hasInternalQuot)
                                                {{$hasInternalQuot ? number_format($hasInternalQuot->total_price, 2) : ''}}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="" class="form-label">Tarikh Siap</label>
                                            {{-- {{$detail->hasQuotation ? \Carbon\Carbon::parse($detail->hasQuotation->end_dt)->format('d/m/Y') : ''}} --}}
                                            {{-- @foreach ($detail->hasQuotation as $quotation)
                                                {{$quotation ? \Carbon\Carbon::parse($quotation->end_dt)->format('d/m/Y') : ''}}
                                            @endforeach --}}
                                            @if ($hasInternalQuot)
                                                {{$hasInternalQuot ? \Carbon\Carbon::parse($hasInternalQuot->end_dt)->format('d/m/Y') : ''}}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>

                    @elseif ($detail->repair_method_id == 2)
                        <div class="col-md-8">
                            <fieldset>
                                <legend>Sebut Harga</legend>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="" class="form-label">Pilihan Waran</label>
                                            {{$hasExternalQuot && $hasExternalQuot->hasWarantType ? $hasExternalQuot->hasWarantType->desc : ''}}
                                        </div>
                                    </div>
                                    @if($hasExternalQuot && $hasExternalQuot->hasWarantType->code == '01')
                                        <div class="col-md-6" id="osol_type_container">
                                            <div class="form-group">
                                                <label for="" class="form-label">Jenis Osol</label>
                                                {{$hasExternalQuot->hasOsolType ? $hasExternalQuot->hasOsolType->desc : ''}}
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="" class="form-label">No sebutharga</label>
                                            @if ($hasExternalQuot)
                                                {{$hasExternalQuot->quotation_no ? $hasExternalQuot->quotation_no : ''}}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="" class="form-label">Nama syarikat pembekal</label>
                                            @if ($hasExternalQuot)
                                                {{$hasExternalQuot->company_name ? $hasExternalQuot->company_name : ''}}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="" class="form-label">Tarikh Sebut Harga</label>
                                            @if ($hasExternalQuot)
                                                {{$hasExternalQuot ? \Carbon\Carbon::parse($hasExternalQuot->quotation_dt)->format('d/m/Y') : ''}}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="" class="form-label">Tarikh SST</label>
                                            @if ($hasExternalQuot)
                                                {{$hasExternalQuot ? \Carbon\Carbon::parse($hasExternalQuot->sst_dt)->format('d/m/Y') : ''}}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="" class="form-label">Jumlah harga (RM)</label>
                                            @if ($hasExternalQuot)
                                                {{$hasExternalQuot ? number_format($hasExternalQuot->total_price, 2) : ''}}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="" class="form-label">Tarikh Siap</label>
                                            @if ($hasExternalQuot)
                                                {{$hasExternalQuot ? \Carbon\Carbon::parse($hasExternalQuot->end_dt)->format('d/m/Y') : ''}}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    @endif
                @endif
            @endif
        </div>
        @endif

    </fieldset>
</form>

<div class="modal fade" id="prompApprovalModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="prompApprovalModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="margin-top:22vh;-webkit-border-radius: 12px;-moz-border-radius: 12px;border-radius: 12px;">
        <div class="modal-content awas" style="background-image: url({{asset('my-assets/img/awas.png')}});">
            <div class="modal-header" style="height:70px;">
                Pengesahan
                <button type="button" class="btn close" data-dismiss="modal" aria-label="Close" xaction="no" data-bs-dismiss="modal">
                <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body" id="prompt-container">
                <div class="txt-memo">
                    Adakah anda ingin meneruskan proses selesai?
                </div>
            </div>
            <div class="modal-footer float-start">
                <span class="btn btn-module" data-bs-dismiss="modal" xaction="advance_complete">Ya</span>
                <span class="btn btn-reset" data-bs-dismiss="modal">Tutup</span>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    const submitDetail = function(data){
        parent.startLoading();
        $.ajax({
            url: "{{ route('maintenance.job.vehicle.monitoring.done.form.complete') }}",
            type: 'post',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            success: function(response) {
                console.log(response);
                window.location = response['url'];
            },
            error: function(response) {
                console.log(response);
                var errors = response.responseJSON.errors;

                $.each(errors, function(key, value) {
                });

                parent.stopLoading();
            }
        });
    }

    $(document).ready(function(){

        let completed_dtInput = $('#completed_dtInput').datepicker();

        $('[xaction]').on('click', function(e){
            e.preventDefault();

            let form = $('#frm_detail');
            let formData = new FormData(form[0]);
            let save_as = $(this).attr('xaction');
            formData.append('save_as', save_as);
            formData.append('vehicle_id', {{$vehicle_id}})
            formData.append('jve_form_repair_id', {{$jve_form_repair_id}});
            submitDetail(formData)

        })

    });

</script>
