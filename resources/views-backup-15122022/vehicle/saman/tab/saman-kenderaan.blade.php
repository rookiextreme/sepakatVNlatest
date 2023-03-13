<form class="row mt-2" id="frm_vehicle">

    <input type="hidden" name="section" value="vehicle">

    <div class="col-md-6">
        <div class="row mt-2">
            <div class="col-md-12">
                <label for="" class="form-label text-dark">Kenderaan *</label>
                <input type="hidden" id="vehicle_id" name="vehicle_id" readonly class="form-control cursor-pointer"
                    value="@if (!empty($informations['vehicle_id'])) {{ $informations['vehicle_id'] }} @endif">
                <div class="input-group" onclick="getVehicle()" aria-readonly="" data-bs-toggle="modal"
                    data-bs-target="#VehicleSearchModal">

                    @if($is_display)
                        {{ isset($informations['no_pendaftaran']) ? $informations['no_pendaftaran'] : '' }}
                    @else
                    <input type="text" readonly disabled id="vehicle_display" class="form-control cursor-pointer"
                        value="{{ isset($informations['no_pendaftaran']) ? $informations['no_pendaftaran'] : '' }}">
                    <span class="input-group-text"><i class="fa fa-cars"></i></span>
                    @endif
                </div>
            </div>
        </div>
        <div class="row mt-2">

            {{-- <div class="col-md-6">
                    <label for="" class="form-label text-dark">Pemilik Kenderaan</label>
                    <select class="form-select" wire:click.prevent="$emit()" name="owner_id"
                        data-bs-toggle="modal" data-bs-target="#pemilikSearch"
                        {{ $summon !== 'draf' ? 'disabled' : '' }}>
                        @if (!empty($informations['owner_id']))
                            <option value="{{ $informations['owner_id'] }}">{{ $informations['no_identiti'] }}</option>
                        @endif
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="" class="form-label text-dark">Emel Ketua Jabatan Pemilik</label>
                    <input type="text" class="form-control" name="head_email"
                        {{ $summon !== 'draf' ? 'disabled' : '' }} value="{{isset($informations['head_email']) ? $informations['head_email'] : ''}}">
                </div>
                <div class="col-md-6">
                    <label for="" class="form-label text-dark">Alamat Pejabat Pemilik</label>
                    <input type="text" class="form-control" name="owner_address"
                        {{ $summon !== 'draf' ? 'disabled' : '' }} value="{{isset($informations['owner_address']) ? $informations['owner_address'] : ''}}">
                </div> --}}

        </div>

        @if(!$is_display)
            <div class="row mt-2">
                @if (in_array($roleAccessCode, array('01','03')))

                <div class="form-group center">
                    <button class="btn btn-module" type="submit"
                        {{ $summon !== '01' ? 'disabled' : '' }}>Simpan</button>

                        @if(count($informations) > 0)
                        <button 
                        {{ $summon !== '01' ? 'disabled' : '' }}
                        class="btn btn-module" type="button" data-bs-toggle="modal" onclick="promptSubmitForPaymentModal()" data-bs-target="#promptSubmitForPaymentModal">Hantar</button>
                        @endif
                </div>
                @endif
            </div>
        @endif

    </div>
</form>

<script type="text/javascript">
    function submitVehicle(data) {
        $.ajax({
            url: "{{ route('vehicle.saman.register.save') }}",
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(response) {
                console.log(response);
                window.location = response['url']+'?&tab=2';
            },
            error: function(response) {
                console.log(response);
                var errors = response.responseJSON.errors;

                var errorsHtml = '<div class="alert alert-danger mb-0 pb-0">Maklumat Kenderaan <br/><ul>';

                $.each(errors, function(key, value) {
                    if($('[name="'+key+'"]').parent().find('.text-danger').length == 0){
                        $('[name="'+key+'"]').parent().append('<div class="text-danger col-12 fs-6">'+value[0]+'</div>');
                    }
                    errorsHtml += '<li>' + value[0] + '</li>';
                });
                errorsHtml += '</ul></div';

                $('.messages').html(errorsHtml);
            }
        });

    }

    $(document).ready(function() {
        $('#frm_vehicle').on('submit', function(e) {
            e.preventDefault();

            var formData = $(this).serialize();
            formData += "&_token={{ csrf_token() }}";
            submitVehicle(formData);

        });
    })

</script>
