@php

@endphp

        <div class="messages"></div>

        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <legend>MAKLUMAT BAYARAN SAMAN</legend>
                </div>
            </div>
        </div>

        <form id="frmPayment" enctype="multipart/form-data">
            @csrf
            <div class="col-md-6">
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="" class="form-label text-dark">Nombor Resit <strong class="text-danger">*</strong> </label>
                        <input type="text" id="receipt_no" autocomplete="off" name="receipt_no" value="">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="" class="form-label text-dark">Jumlah Bayaran <strong class="text-danger">*</strong> </label>
                        <input type="text" id="total_payment" autocomplete="off" name="total_payment" value="">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-4">
                        <label for="" class="form-label text-dark">Tarikh Bayaran <strong class="text-danger">*</strong> </label>
                        <div class="input-group date" id="payment_date">
                            <input autocomplete="off" name="payment_date" id="payment_date_input"
                                        type="text" class="form-control datepicker" placeholder=""
                                        autocomplete="off"
                                        data-provide="datepicker" data-date-autoclose="true"
                                        data-date-format="dd/m/yyyy" data-date-today-highlight="true"
                                        value=""/>
                            <div class="input-group-text" for="payment_date">
                                <i class="fa fa-calendar"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="" class="form-label text-dark">Kaedah Bayaran <strong class="text-danger">*</strong> </label>
                        <input type="text" id="payment_method" autocomplete="off" name="payment_method" value="">
                    </div>
                </div>
                <div class="row mt-2">
                    {{-- <div class="col-md-8">
                        <label for="" class="form-label text-dark">Dokumen Pembayaran <strong class="text-danger">*</strong> </label>
                        <div class="input-group mb-3">
                            <input type="file" accept="application/pdf,image/*" class="form-control" name="dokumen" id="inputGroupFile02">
                            <label class="input-group-text" for="inputGroupFile02">Muat Naik</label>
                        </div>
                    </div> --}}
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-5 col-12">
                        <label for="" class="form-label text-dark">Dokumen Pembayaran<strong class="text-danger">*</strong> </label>
                        <label class="btn cux-btn small" for="doc_payment">{{$pathUrl == '' ? 'Muat Naik' : 'Tukar Fail'}}</label>
                        <input type="file" class="form-control d-none" accept="application/pdf,image/*" name="dokumen_kemaskini" id="doc_payment">
                        <div id="preview-file" class="form-group mb-2" style="display: none;height: 200px;
                        overflow: auto;">
                        {{$pathUrl ? : ''}}
                            <embed src="{{$pathUrl}}" id="preview-file-embed" width="100%" type="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-3 mt-4">
                    <button class="btn btn-module text-white" type="submit">Hantar</button>
                </div>
            </div>
        </form>


        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ $message }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <img width="150px" src="/../{{ Session::get('dokumen') }}">
        @endif

        <div class="messages"></div>

        <form id="frmPayment">
            @csrf
            <div class="col-md-6">
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="" class="form-label text-dark">Nombor Resit <strong class="text-danger">*</strong> </label>
                        <input type="text" id="receipt_no" autocomplete="off" name="receipt_no" value="">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="" class="form-label text-dark">Jumlah Bayaran <strong class="text-danger">*</strong> </label>
                        <input type="text" id="total_payment" autocomplete="off" name="total_payment" value="">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-4">
                        <label for="" class="form-label text-dark">Tarikh Bayaran <strong class="text-danger">*</strong> </label>
                        <div class="input-group date" id="payment_date">
                            <input autocomplete="off" name="payment_date" id="payment_date_input"
                                        type="text" class="form-control datepicker" placeholder=""
                                        autocomplete="off"
                                        data-provide="datepicker" data-date-autoclose="true"
                                        data-date-format="dd/m/yyyy" data-date-today-highlight="true"
                                        value=""/>
                            <div class="input-group-text" for="payment_date">
                                <i class="fa fa-calendar"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="" class="form-label text-dark">Kaedah Bayaran <strong class="text-danger">*</strong> </label>
                        <input type="text" id="payment_method" autocomplete="off" name="payment_method" value="">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-8">
                        <label for="" class="form-label text-dark">Dokumen Pembayaran <strong class="text-danger">*</strong> </label>
                        <div class="input-group mb-3">
                            <input type="file" accept="application/pdf,image/*" class="form-control" name="dokumen" id="inputGroupFile02">
                            <label class="input-group-text" for="inputGroupFile02">Muat Naik</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-3 mt-4">
                    <button class="btn btn-module text-white" type="submit">Hantar</button>
                </div>
            </div>
        </form>

        <script>
            function backToList() {
            window.location = "{{ route('vehicle.list-alternate') }}";
        }

        function getVehicle(content, self) {

            if (content == 'next') {
                vehicleOffset = vehicleOffset + 1;
                callAjaxVehicle();
            } else if (content == 'prev') {
                if (vehicleOffset > 0) {
                    vehicleOffset = vehicleOffset - 1;
                    callAjaxVehicle();
                }
            } else if (content == 'search') {
                console.log(content, self.value);
                if (self.value != '') {
                    $('#enter').show();
                } else {
                    $('#enter').hide();
                }
                vehicleSearch = self.value;
                if (event.key === 'Enter' || self.value == '') {
                    callAjaxVehicle();
                }
            } else {
                callAjaxVehicle();
            }
        }

        function callAjaxVehicle() {
            $.get("{{ route('vehicle.saman.ajax.getVehicle') }}", {
                limit: vehicleLimit,
                offset: vehicleOffset,
                search: vehicleSearch
            }, function(data) {
                if (data.length > vehicleLimit) {
                    $('#pagination').show();
                } else {
                    $('#pagination').hide();
                }
                $('#vehicleList').html(data);
            });

            $.get("{{ route('vehicle.saman.ajax.getVehicle.total') }}", {
                limit: vehicleLimit,
                offset: vehicleOffset,
                search: vehicleSearch
            }, function(vehicle) {
                var totalCurrentPage = (vehicleOffset ? ((vehicleOffset + 1) * vehicleLimit) : vehicleLimit +
                1);
                if (vehicle.total < totalCurrentPage) {
                    totalCurrentPage = vehicle.total;
                }

                var totalFrom = vehicleLimit * vehicleOffset + 1;
                $('#vehicleTotal').text('Rekod ' + (vehicleOffset == 0 ? 1 : (vehicle.total > vehicleLimit ? (
                        totalFrom) : vehicle.total)) + ' - ' + (totalCurrentPage) + ' Daripada ' + vehicle
                    .total);
                if (vehicle.total == 0) {
                    $('#vehicleTotal').text('Tiada Rekod');
                }

                $('#pagination .next').prop('disabled', false);
                $('#pagination .prev').prop('disabled', false);

                if (totalCurrentPage < vehicleLimit) {
                    $('#pagination .next').prop('disabled', true);
                    $('#pagination .prev').prop('disabled', true);
                }

                if (totalFrom == totalCurrentPage) {
                    $('#pagination .next').prop('disabled', true);
                }

                if (vehicleOffset == 0) {
                    $('#pagination .prev').prop('disabled', true);
                }

            });
        }

        function selectVehicle(vehicle_id, vehicle_no) {
            let targetVehicleInput = $('#vehicle_id');
            let targetVehicleDisplay = $('#vehicle_display');
            targetVehicleInput.val(vehicle_id);
            targetVehicleDisplay.val(vehicle_no);
            $('#VehicleSearchModal').modal('hide');
        }

        function submitPayment(formData){
            parent.startLoading();
            $.ajax({
                url: "{{ route('vehicle.saman.receipt.upload.post') }}",
                data: formData,
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

        $(document).ready(function() {
            initTab();

            var hash = window.location.hash;
            var tab = parseInt(hash.split('tab=')[1]);

            switch (tab) {
                case 2:
                    $('#tab2').click();
                    break;
                case 3:
                    $('#tab3').click();
                    break;

                default:
                    break;
            }
            $('select').select2({
                width: '100%',
                theme: "classic"
            });

            $('#frmPayment').on('submit', function(e){
                e.preventDefault();
                let formData = new FormData(this);
                submitPayment(formData);
            });

        });
        </script>
