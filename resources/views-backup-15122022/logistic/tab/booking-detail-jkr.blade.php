<fieldset>
    <legend>Maklumat Kenderaan</legend>
    <div class="row">
        <div class="col-12 pt-2">
            @if(!$detail ||
                    in_array($detail->hasBookingStatus->code, $allowBtnSave) ||
                    ($TaskFlowAccessLogistic->mod_fleet_approval && in_array($detail->hasBookingStatus->code, $allowBtnApproval))
                    )
                <div class="btn-group">
                <button type="button" class="btn cux-btn bigger" aria-readonly="type" data-bs-toggle="modal" data-bs-target="#addVehicleTypeModal">
                    <i class="fal fa-plus"></i> Jenis Kenderaan
                </button>
                {{-- <button type="button" class="btn cux-btn bigger" data-category="concession" aria-readonly="" data-bs-toggle="modal" data-bs-target="#addVehicleTypeModal">
                    <i class="fal fa-plus"></i> Kenderaan Konsesi
                </button> --}}
                <button onclick="prompDeleteBookingVehicle()" class="btn cux-btn bigger" type="button" id="delete_all" disabled><i class="fal fa-trash-alt"></i> Hapus</button>
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-12" id="table_vehicle_type"></div>
    </div>
</fieldset>