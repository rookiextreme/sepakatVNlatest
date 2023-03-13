<form class="row" id="frm_info">
    @csrf
    <input type="hidden" name="section" value="info">

    <div class="col-md-4">
        <div class="row">
            <div class="col-md-12">
                <label for="" class="form-label text-dark">Kenderaan *</label>
                <input type="hidden" id="vehicle_id" name="vehicle_id" readonly class="form-control cursor-pointer"
                    value="@if (!empty($detail['vehicle_id'])) {{ $detail['vehicle_id'] }} @endif">
                <div class="input-group" onclick="getVehicle()" aria-readonly="" data-bs-toggle="modal"
                    data-bs-target="#VehicleSearchModal">

                    @if($is_display)
                        {{ isset($detail['no_pendaftaran']) ? $detail['no_pendaftaran'] : '' }}
                    @else
                    <input type="text" readonly disabled id="vehicle_display" class="form-control cursor-pointer"
                        value="{{ $detail && $detail->hasVehicle ? $detail->hasVehicle->no_pendaftaran : '' }}">
                    <span class="input-group-text"><i class="fa fa-car"></i></span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="row">
            <div class="col-md-12">
                <label for="" class="form-label text-dark">Pemandu *</label>
                <x-modal-user isDisplay="{{$is_display}}" filterByRole="06" title="Pilih Pemandu" subTitle="Pilih Pemandu daripada rekod Kakitangan yang berdaftar." fieldName="driver_id" fieldValue="{{$detail && $detail['driver_id']}}" dataName="{{ $detail && $detail->hasDriver ? $detail->hasDriver->name : '' }}"></x-modal-user>
            </div>
        </div>
    </div>

    @php
        $allowBtnSave = ['01', '02', '03'];
        $allowBtnSubmit = ['01'];
        $allowBtnVerify = ['02'];
        $allowBtnApproval = ['03'];
    @endphp

    <div class="col-md-12 mt-2 mb-2">
        <div class="form-group center">
            @if(auth()->user()->isAdmin() || !$detail || (in_array($detail->hasBookingStatus->code, $allowBtnSave)))
                <button class="btn btn-module" type="submit">Simpan</button>
            @endif
            @if ($detail)
                @if(in_array($detail->hasBookingStatus->code, $allowBtnSubmit))
                    <button type="button" disabled class="btn btn-module btn-verify" id="btn-verify-info" data-bs-toggle="modal" data-bs-target="#verifyBookingModal">Hantar</button>
                @endif
                @if (auth()->user()->isAdmin() || $TaskFlowAccessLogistic->mod_fleet_approval)
                    @if(in_array($detail->hasBookingStatus->code, $allowBtnApproval))
                        <button class="btn cux-btn bigger" data-bs-toggle="modal" data-bs-target="#rejectBookingModal" type="button" data-toggle="popover" data-trigger="focus" data-placement="top" data-content="Tolak"><i class="fa fa-ban"></i>&nbsp;Tolak</button>
                        @if($detail->hasVehicle && $detail->hasDriver)
                            <button class="btn cux-btn bigger" data-bs-toggle="modal" data-bs-target="#approvalBookingModal" type="button" data-toggle="popover" data-trigger="focus" data-placement="top" data-content="Sah"><i class="fa fa-check"></i>&nbsp;Sah</button>
                        @endif
                    @endif
                @endif
            @endif
        </div>
    </div>

</form>


<script type="text/javascript">

    function submitInfo(data) {
        parent.startLoading();
        $.ajax({
            url: "{{ route('logistic.booking.register.save') }}",
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

                var errorsHtml = '<div class="alert alert-danger mb-0 pb-0"><ul>';

                $.each(errors, function(key, value) {
                    errorsHtml += '<li>' + value[0] + '</li>';
                });
                errorsHtml += '</ul></div';

                $('.messages').html(errorsHtml);
                parent.stopLoading();
            }
        });
    }

    $(document).ready(function(){

        $('#frm_info').on('submit', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            submitInfo(formData);

        });

    })

</script>
