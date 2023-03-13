<form class="" id="frm_addon">
    @csrf
    <input type="hidden" name="fleet_view" value="{{$fleet_view}}">
    <input type="hidden" name="section" value="addon">
    <input type="hidden" name="reg_hak" value="{{$detail->owner_type_id}}">
    <fieldset>
        <legend>Perolehan</legend>
        <div class="row">
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
                <label for="" class="form-label text-dark">No Loji</label>
                    @if (!empty($is_display) && ($is_display == 1))
                        <div class="text-capitalize theme-color-text">
                            {{isset($detail['no_loji']) ? $detail['no_loji'] : ""}}
                        </div>
                    @else
                    <input type="text" class="form-control" autocomplete="off" name="noLoji" value="{{isset($detail['no_loji']) ? $detail['no_loji'] : ""}}">
                    @endif
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
                <label for="" class="form-label text-dark">Harga Perolehan</label>
                @if (!empty($is_display) && ($is_display == 1))
                    <div class="text-capitalize theme-color-text">
                        {{isset($detail['harga_perolehan']) ? number_format($detail['harga_perolehan'], 2) : ""}}
                    </div>
                @else
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">RM</span>
                    <input type="text" class="form-control" onkeypress="return isNumber(this)" autocomplete="off" name="hargaPerolehan" value="{{isset($detail['harga_perolehan']) ? number_format($detail['harga_perolehan'], 2) : ""}}">
                </div>
                @endif
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
                <label for="" class="form-label text-dark">Tarikh Beli</label>
                    @if (!empty($is_display) && ($is_display == 1))
                    <div class="text-capitalize theme-color-text">
                        {{isset($detail['acqDt']) ? $detail['acqDt'] : ""}}
                    </div>
                    @else
                    <div class="input-group date" id="acqDt"
                        data-target-input="nearest">
                            <input name="acqDt" id="acqDtInput"
                            type="text" class="form-control datepicker" placeholder=""
                            autocomplete="off"
                            data-provide="datepicker" data-date-autoclose="true"
                            data-date-format="dd/mm/yyyy" data-date-today-highlight="true"
                            value="{{isset($detail['acqDt']) ? Carbon\Carbon::parse($detail['acqDt'])->format('d/m/Y'): null}}"/>

                            <div class="input-group-text" for="acqDtInput">
                                <i class="fa fa-calendar"></i>
                            </div>
                    </div>
                    @endif
            </div>
        </div>
    </fieldset>
    <fieldset>
        <legend>Peringatan</legend>
        <div class="row">
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
                <label class="form-label text-dark">Cukai Jalan</label>
                    @if (!empty($is_display) && ($is_display == 1))
                        <div class="text-capitalize theme-color-text">
                            {{isset($detail['tarikh_cukai_jalan']) ? $detail['tarikh_cukai_jalan'] : ""}}
                        </div>
                    @else
                        <div class="form-group">
                            <div class="input-group date" id="roadTaxDt">
                                <input name="roadTaxDt" id="roadTaxDtInput"
                                type="text" class="form-control datepicker" placeholder=""
                                autocomplete="off"
                                data-provide="datepicker" data-date-autoclose="true"
                                data-date-format="dd/mm/yyyy" data-date-today-highlight="true"
                                value="{{isset($detail['tarikh_cukai_jalan']) ? Carbon\Carbon::parse($detail['tarikh_cukai_jalan'])->format('d/m/Y'): null}}"/>

                                <div class="input-group-text" for="roadTaxDtInput">
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div>
                        </div>
                    @error('tambahan.cukaiJalan') <span class="error text-danger">{{ $message }}</span> @enderror
                    @endif
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
                <label for="" class="form-label text-dark">Pemeriksaan Keselamatan</label>
                @if (!empty($is_display) && ($is_display == 1))
                <div class="text-capitalize theme-color-text">
                    {{isset($detail['tarikh_pemeriksaan_keselamatan']) ? $detail['tarikh_pemeriksaan_keselamatan'] : ""}}
                </div>
                @else
                <div wire:ignore class="input-group date" id="pemeriksaanKeselamatan">
                        <input name="pemeriksaanKeselamatan" id="pemeriksaanKeselamatanInput"
                        type="text" class="form-control datepicker" placeholder=""
                        autocomplete="off"
                        data-provide="datepicker" data-date-autoclose="true"
                        data-date-format="dd/m/yyyy" data-date-today-highlight="true"
                        value="{{isset($detail['tarikh_pemeriksaan_keselamatan']) ? Carbon\Carbon::parse($detail['tarikh_pemeriksaan_keselamatan'])->format('d/m/Y'): null}}"/>

                        <div class="input-group-text" for="pemeriksaanKeselamatanInput">
                            <i class="fa fa-calendar"></i>
                        </div>
                </div>
                @endif
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
                <label for="" class="form-label text-dark">Tahun Dibuat</label>
                @if (!empty($is_display) && ($is_display == 1))
                <div class="text-capitalize theme-color-text">
                    {{isset($detail['manufacture_year']) ? $detail['manufacture_year'] : ""}}
                </div>
                @else
                <div wire:ignore class="input-group date" id="manufactureDate">
                        <input name="manufactureDate" id="manufactureDateInput"
                        type="text" class="form-control datepicker" placeholder=""
                        autocomplete="off"
                        data-provide="datepicker" data-date-autoclose="true"
                        data-date-format="yyyy" data-date-today-highlight="true"
                        value="{{isset($detail['manufacture_year']) ? $detail['manufacture_year'] : null}}"/>

                        <div class="input-group-text" for="manufactureDateInput">
                            <i class="fa fa-calendar"></i>
                        </div>
                </div>
                @endif
            </div>
        </div>
    </fieldset>
    <div class="row">
        <div class="col-md-8">
            <div class="row g-3">
                {{-- <div class="col-md-6">
                    <label for="" class="form-label text-dark">No Lo (Pesanan Tempatan)</label>
                    @if (!empty($is_display) && ($is_display == 1))
                    <div class="text-capitalize theme-color-text">
                        {{isset($detail['no_lo']) ? $detail['no_lo'] : ""}}
                    </div>
                    @else
                    <input type="text" class="form-control" autocomplete="off" name="noLo" value="{{isset($detail['no_lo']) ? $detail['no_lo'] : ""}}">
                    @endif
                </div> --}}
                {{-- <div class="col-md-6">
                    <label for="" class="form-label text-dark">Tarikh Pembelian Kenderaan</label>
                    @if (!empty($is_display) && ($is_display == 1))
                    <div class="text-capitalize theme-color-text">
                        {{isset($detail['tarikh_pembelian_kenderaan']) ? $detail['tarikh_pembelian_kenderaan'] : ""}}
                    </div>
                    @else
                    <div class="input-group date" id="tarikhPembelian"
                        data-target-input="nearest">
                            <input name="tarikhPembelian" id="tarikhPembelianInput"
                            type="text" class="form-control datepicker" placeholder=""
                            autocomplete="off"
                            data-provide="datepicker" data-date-autoclose="true"
                            data-date-format="dd/m/yyyy" data-date-today-highlight="true"
                            value="{{isset($detail['tarikh_pembelian_kenderaan']) ? Carbon\Carbon::parse($detail['tarikh_pembelian_kenderaan'])->format('d/m/Y'): null}}"/>

                            <div class="input-group-text" for="tarikhPembelianInput">
                                <i class="fa fa-calendar"></i>
                            </div>
                    </div>
                    @endif
                </div> --}}
                {{-- <div class="col-md-6">
                    <label for="" class="form-label text-dark">Tarikh Pemeriksaan Fizikal</label>
                    @if (!empty($is_display) && ($is_display == 1))
                    <div class="text-capitalize theme-color-text">
                        {{isset($detail['tarikh_pemeriksaan_fizikal']) ? $detail['tarikh_pemeriksaan_fizikal'] : ""}}
                    </div>
                    @else
                    <div wire:ignore class="input-group date" id="pemeriksaanFizikal">
                            <input name="pemeriksaanFizikal" id="pemeriksaanFizikalInput"
                            type="text" class="form-control datepicker" placeholder=""
                            autocomplete="off"
                            data-provide="datepicker" data-date-autoclose="true"
                            data-date-format="dd/m/yyyy" data-date-today-highlight="true"
                            value="{{isset($detail['tarikh_pemeriksaan_fizikal']) ? Carbon\Carbon::parse($detail['tarikh_pemeriksaan_fizikal'])->format('d/m/Y'): null}}"/>

                            <div class="input-group-text" for="pemeriksaanFizikalInput">
                                <i class="fa fa-calendar"></i>
                            </div>
                    </div>
                    @endif
                </div> --}}
                <div class="col-md-6">

                </div>
            </div>
        </div>
    </div>
    @if (empty($is_display) && $is_display == 0)
        <div class="row">
            <br><br>

            @php
                $allowBtnSave = array('01','02');
                $allowBtnVerification = array('01');
                $allowBtnVerify = array('02');
                $allowBtnApproval = array('03');
            @endphp

            <div class="col-md-4 mt-2 mb-2">
                <div class="form-group center">
                    @if ((auth()->user()->isAdmin() && $detail) || !$detail || $detail->vAppStatus  && in_array($detail->vAppStatus->code, $allowBtnSave) || $TaskFlowAccessVehicle->mod_fleet_approval || $TaskFlowAccessVehicle->mod_fleet_can_edit_after_approve)
                        <button class="btn btn-module" type="submit" >Simpan</button>
                    @endif
                    @if ($detail)
                        @if(in_array($detail->vAppStatus->code, $allowBtnVerification))
                            <a class="btn btn-module" data-bs-toggle="modal" data-bs-target="#submitVerificationModal">Hantar</a>
                        @endif

                        @if ($TaskFlowAccessVehicle->mod_fleet_verify)
                            @if(in_array($detail->vAppStatus->code, $allowBtnVerify))
                                <button class="btn cux-btn bigger" data-bs-toggle="modal" data-bs-target="#verifyVehicleModal" type="button" data-toggle="popover" data-trigger="focus" data-placement="top" data-content="Semak"><i class="fa fa-check"></i>&nbsp;Semak</button>
                            @endif
                        @endif

                        @if ($TaskFlowAccessVehicle->mod_fleet_approval)
                            @if(in_array($detail->vAppStatus->code, $allowBtnApproval))
                                <button class="btn cux-btn bigger" data-bs-toggle="modal" data-bs-target="#approvalVehicleModal" type="button" data-toggle="popover" data-trigger="focus" data-placement="top" data-content="Sah"><i class="fa fa-check"></i>&nbsp;Sah</button>
                            @endif
                        @endif

                    @endif
                </div>
            </div>
        </div>
    @endif
</form>


<script type="text/javascript">

    function isNumber(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }

    function submitAddon(formData){
        // var manufacture_year = document.getElementById("manufactureDateInput").value;

        parent.startLoading();

        $.ajax({
            url: "{{route('vehicle.register.save')}}",
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            async: false,
            data: formData,
            success: function(response) {
                window.location = response['url'];
            },
            error: function(response) {

            }
        });

    }

    $(document).ready(function(){

        let acq_dt_container = $('#acqDtInput').datepicker();
        acq_dt_container.datepicker('setEndDate', new Date());

        let roadtax_dt_container = $('#roadTaxDtInput').datepicker();

        let vexam_dt_container = $('#pemeriksaanKeselamatanInput').datepicker();
        vexam_dt_container.datepicker('setEndDate', new Date());

        let md_dt_container = $('#manufactureDateInput').datepicker(
            {
                format: "yyyy",
                weekStart: 1,
                orientation: "bottom",
                keyboardNavigation: false,
                viewMode: "years",
                minViewMode: "years"
            }
        );

        md_dt_container.datepicker('setEndDate', new Date());

        $('#frm_addon').on('submit', function(e){
            e.preventDefault();

            var formData = new FormData(this);
            submitAddon(formData);

        });

        // $(".yearpick").ejDatePicker({value: new Date(),dateFormat: "yyyy" });
    })

</script>
