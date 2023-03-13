<script type="text/javascript">

    changeToUpperCase = function(self){
            self.value = self.value.toLocaleUpperCase();
        }

    </script>


    <form class="row mt-2" id="frm_vehicle">
        @csrf
        <input autocomplete="off" type="hidden" name="section" value="vehicle">

        <div class="messages"></div>

        <fieldset>
            <legend>Subjek</legend>
            <div class="row">
                <div class="col-md-2">
                    <label for="" class="form-label text-dark">No Kenderaan *</label>
                    @if (!empty($is_display) && $is_display == 1)
                        <div class="text-capitalize theme-color-text">
                            {{isset($vehicle['no_pendaftaran']) ? $vehicle['no_pendaftaran'] : ""}}
                        </div>
                    @else
                        <div class="input-group">
                            <input type="text" name="reg_no"  id="reg_no" class="form-control cursor-pointer"
                            value="{{isset($vehicle['no_pendaftaran']) ? $vehicle['no_pendaftaran'] : null}}" onkeyup="changeToUpperCase(this)">
                            <span class="input-group-text"><i class="fa fa-car"></i></span>
                        </div>
                    @endif
                </div>
            </div>
        </fieldset>
        <div id="form_isi" >
            <fieldset>
            <legend>Lokasi Penempatan</legend>
            <div class="col-md-12">
                <div class="row">

                    <div class="col-md-2">
                    <label for="" class="form-label text-dark">Negeri</label>
                    @if (!empty($is_display) && $is_display == 1)
                        <div class="text-capitalize theme-color-text">
                            {{isset($detail['state_id']) ? $detail['state_id'] : ""}}
                        </div>
                    @else
                        <div class="input-group">
                            <select class="form-select" name="state_id" id="state_id">
                                <option selected value="">Sila Pilih</option>
                                @foreach ($states as $state)
                                    <option
                                        {{ isset($detail['state_id']) && $detail['state_id'] == $state->id ? 'selected' : '' }} value="{{ $state->id }}">{{ $state->desc }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    </div>

                    <div class="col-md-6">
                        <label for="" class="form-label text-dark">Alamat Lokasi Kenderaan</label>
                        @if (!empty($is_display) && $is_display == 1)
                            <div class="text-capitalize theme-color-text">
                                {{isset($detail['address1']) ? $detail['address1'] : ""}}
                            </div>
                        @else
                            <input type="text" placeholder="Alamat 1" class="form-control" autocomplete="off" id="no_engine" name="alamat1" value="{{isset($detail['address1']) ? $detail['address1']: null}}"/>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-6">
                        @if (!empty($is_display) && $is_display == 1)
                            <div class="text-capitalize theme-color-text">
                                {{isset($detail['alamat2']) ? $detail['alamat2'] : ""}}
                            </div>
                        @else
                            <input type="text" placeholder="Alamat 2" class="form-control" autocomplete="off" id="no_engine" name="alamat2" value="{{isset($detail['alamat2']) ? $detail['alamat2']: null}}"/>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                    </div>
                    @if (!empty($is_display) && $is_display == 1)
                        <div class="text-capitalize theme-color-text">
                            {{isset($detail['postcode']) ? $detail['postcode'] : ""}}
                        </div>
                        <div class="text-capitalize theme-color-text">
                            {{isset($detail['city']) ? $detail['city'] : ""}}
                        </div>
                    @else
                    <div class="col-md-2">
                        <input type="text" placeholder="Poskod" class="form-control" autocomplete="off" id="no_engine" name="poskod" value="{{ isset($detail['postcode']) ? $detail['postcode'] : null }}">
                    </div>
                    <div class="col-md-2">
                        <input type="text" placeholder="Bandar" class="form-control" autocomplete="off" id="no_engine" name="bandar" value="{{ isset($detail['city']) ? $detail['city'] : null }}">
                    </div>
                    @endif
                </div>

            </div>
            </fieldset>


                <fieldset>
                    <legend>Spesifikasi</legend>
                    <div class="row">
                        <div class="col-xl-7 col-lg-8 col-md-8 col-sm-12 col-12">
                                <div class="row">
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <label for="" class="form-label text-dark">Kategori</label>
                                        @if (!empty($is_display) && ($is_display == 1))
                                            <div class="text-capitalize theme-color-text">
                                                {{isset($vehicle['category_id']) ? $vehicle['category_id'] : ""}}
                                            </div>
                                        @else
                                            <div class="input-group">
                                                <select id="category_id" class="form-select" name="category_id" onchange="getSubCategory(this.value)">
                                                    <option value="-1">Sila Pilih</option>
                                                    @foreach ($categoryList as $category )
                                                        <option
                                                        {{ isset($vehicle['category_id']) && $vehicle['category_id'] == $category->id ? 'selected' : '' }} value={{$category->id}}>{{$category->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <label for="" class="form-label text-dark">Sub Kategori</label>
                                        @if (!empty($is_display) && ($is_display == 1))
                                            <div class="text-capitalize theme-color-text">
                                                {{isset($vehicle['sub_category_id']) ? $vehicle['sub_category_id'] : ""}}
                                            </div>
                                        @else
                                            <div class="input-group">
                                                <select class="form-select" name="sub_category_id" id="list_sub_category" onchange="getSubCategoryType(this.value)">
                                                {{-- <select class="form-select" name="sub_category_id" id="list_sub_category" onchange="getSubCategoryType(this.value)"> --}}
                                                    <option
                                                    {{ isset($vehicle['sub_category_id']) && $vehicle['sub_category_id'] == $category->id ? 'selected' : '' }} value="-1">Sila Pilih</option>
                                                </select>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <label for="" class="form-label text-dark">Jenis</label>
                                        @if (!empty($is_display) && ($is_display == 1))
                                            <div class="text-capitalize theme-color-text">
                                                {{isset($vehicle['sub_category_type_id']) ? $vehicle['sub_category_type_id'] : ""}}
                                            </div>
                                        @else
                                            <div class="input-group">
                                                <select class="form-select" name="sub_category_type_id" id="list_sub_category_type">
                                                    <option
                                                    {{ isset($vehicle['sub_category_type_id']) && $vehicle['sub_category_type_id'] == $category->id ? 'selected' : '' }} value="-1">Sila Pilih</option>
                                                </select>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-5 col-lg-5 col-md-6 col-sm-6 col-12">
                                        <label for="" class="form-label text-dark">No Enjin</label>
                                        @if (!empty($is_display) && ($is_display == 1))
                                            <input type="text" value="" name="engine_no" id="engine_no">
                                        @else
                                            <input type="text" name="engine_no" id="engine_no" value="{{ isset($vehicle['no_engine']) ? $vehicle['no_engine'] : null }}">
                                        @endif
                                    </div>
                                    <div class="col-xl-5 col-lg-5 col-md-6 col-sm-6 col-12">
                                        <label for="" class="form-label text-dark">No Chasis</label>
                                        @if (!empty($is_display) && ($is_display == 1))
                                            <div class="text-capitalize theme-color-text">
                                                {{isset($vehicle['no_chasis']) ? $vehicle['no_chasis'] : ""}}
                                            </div>
                                        @else
                                            <input type="text" name="chasis_no" id="chasis_no" value="{{ isset($vehicle['no_chasis']) ? $vehicle['no_chasis'] : null }}">
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-5 col-lg-5 col-md-6 col-sm-6 col-12">
                                        <label for="" class="form-label text-dark">Pembuat</label>
                                        @if (!empty($is_display) && ($is_display == 1))
                                            <div class="text-capitalize theme-color-text">
                                                {{isset($vehicle['brand_id']) ? $vehicle['brand_id'] : ""}}
                                            </div>
                                        @else
                                            <div class="input-group">
                                                <select class="form-select" id="maklumat_pembuat" name="brand" onchange="getVehicleModel(this.value)">
                                                <option value="-1">Sila Pilih</option>
                                                @foreach ($brands as $brand )
                                                    <option
                                                    {{ isset($vehicle['brand_id']) && $vehicle['brand_id'] == $brand->id ? 'selected' : '' }} value="{{$brand->id}}">{{$brand->name}}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-xl-5 col-lg-5 col-md-6 col-sm-6 col-12">
                                        <label for="" class="form-label  text-dark">Model</label>

                                        @if (!empty($is_display) && ($is_display == 1))
                                            <div class="text-capitalize theme-color-text">
                                                {{isset($vehicle['model_id']) ? $vehicle['model_id'] : ""}}
                                            </div>
                                        @else

                                            <select class="form-select" name="model" id="list_vehicle_model">
                                                <option value="-1">Sila Pilih</option>
                                            </select>

                                        @endif
                                    </div>
                                </div>

                        </div>

                    </div>
                </fieldset>

                <div class="col-md-4 mt-2 mb-2">
                    <div class="form-group center">
                            <button class="btn btn-module" type="submit">Simpan</button>

                            <a class="btn btn-module" data-bs-toggle="modal" data-bs-target="#submitForAppointmentNonJKRModal">Hantar</a>
                    </div>
                </div>
        </div>

    </form>

    <script type="text/javascript">

        var stateId = -1;
        var districtId = -1;

        var vehicleLimit = 5;
        var vehicleOffset = 0;
        var vehicleSearch = null;
        var categoryId = -1;

        $(document).ready(function() {

            let notice_date_container = $('#notice_date_input').datepicker();
            notice_date_container.datepicker('setEndDate', new Date());

            let mistake_date_container = $('#mistake_date_input').datepicker();
            mistake_date_container.datepicker('setEndDate', new Date());

            $('.timepicker').datetimepicker({
                format: 'hh:mm A',
                useCurrent: false,
                showTodayButton: true,
                showClear: true,
                toolbarPlacement: 'bottom',
                sideBySide: true,
                icons: {
                    time: "fa fa-clock-o",
                    date: "fa fa-calendar",
                    up: "fa fa-arrow-up",
                    down: "fa fa-arrow-down",
                    previous: "fa fa-chevron-left",
                    next: "fa fa-chevron-right",
                    today: "fa fa-clock",
                    clear: "fa fa-trash"
                }
            });

            if(stateId != -1){
                getDistrict(stateId);
            }

            $('#frm_vehicle').on('submit', function(e) {
                e.preventDefault();

                var formData = $(this).serialize();
                submitVehicle(formData);

            });
            $('#reg_no').on('keyup', function (e) {
                var data= this.value;
                var checkRegex = /^[0-9]*$/;
                var isNumberAlpha = checkRegex.test(data);
                if(!isNumberAlpha){
                    e.preventDefault();
                    data = data.replace(/[^\w\s]/gi, '');
                    $(this).val(data.trim());
                    return false;
                }
            });

            $('#reg_no').on('change', function(e){
                e.preventDefault();
                checkExistRegNumber(this.value);
            });
        })

        function checkExistRegNumber(reg_no){
            $.ajax({
                url: "{{ route('vehicle.checkExistRegNumberPublic') }}",
                type: 'post',
                data: {
                    reg_no: reg_no,
                    '_token': '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(isExist) {
                    console.log(isExist);
                    let errorsHtml = '';
                    if(isExist == 1){
                        errorsHtml = '<div class="alert alert-danger mb-0 pb-0"><li>No Pendaftaran '+reg_no+' Telah Wujud</li><ul>';
                        //$('#reg_no').val('');
                        $('#form_isi').attr('style','display:show');
                    }else{
                        errorsHtml = '<div class="alert alert-info mb-0 pb-0"><li>No Pendaftaran '+reg_no+' Belum Didaftarkan. Sila Isi Maklumat Dibawah Untuk Pendaftaran.</li><ul>';
                            $('#form_isi').attr('style','display:show');
                    }
                    $('.messages').html(errorsHtml);
                },
                error: function(isExist) {

                    console.log(response);
                    var errors = response.responseJSON.errors;
                    var errorsHtml = '<div class="alert alert-danger mb-0 pb-0"><ul>';

                    $.each(errors, function(key, value) {
                        errorsHtml += '<li>' + value[0] + '</li>';
                    });
                    errorsHtml += '</ul></div';

                    $('.messages').html(errorsHtml);
                }
            });
        }

        function getVehicle(content, self){

            if(content == 'next'){
                vehicleOffset = vehicleOffset + 1;
                callAjaxVehicle();
            } else if(content == 'prev'){
                if(vehicleOffset > 0){
                    vehicleOffset = vehicleOffset - 1;
                    callAjaxVehicle();
                }
            }
            else if(content == 'search'){
                console.log(content, self.value);
                if(self.value != ''){
                    $('#enter').show();
                } else {
                    $('#enter').hide();
                }
                vehicleSearch = self.value;
                if(event.key === 'Enter' || self.value == '') {
                    if(vehicleSearch.length > 0){
                        vehicleOffset = 0;
                    }
                    callAjaxVehicle();
                }
            } else {
                callAjaxVehicle();
            }
        }

        function callAjaxVehicle(){

            let searchData = {
                limit: vehicleLimit,
                offset: vehicleOffset
            };

            @if (auth()->user()->isAdmin())
                searchData['search'] = vehicleSearch;
                @else
                searchData['no_pendaftaran'] = vehicleSearch;
            @endif

            console.log('searchData --> ', searchData);

            $.get("{{route('maintenance.job.nonjkr.ajax.getVehicle')}}", searchData , function(data){
                    if(data.length > 0){
                        $('#pagination').show();
                    } else {
                        $('#pagination').hide();
                    }
                    $('#vehicleList').html(data);
                    $('#vehicleList').show();
            });

            $.get("{{route('maintenance.job.nonjkr.ajax.getVehicle.total')}}", searchData, function(vehicle){
                    var totalCurrentPage = (vehicleOffset ? ((vehicleOffset+1)*vehicleLimit): vehicleLimit+1 );
                    if(vehicle.total  < totalCurrentPage){
                        totalCurrentPage = vehicle.total;
                    }

                    var totalFrom = vehicleLimit*vehicleOffset+1;
                    $('#vehicleTotal').text('Rekod '+ (vehicleOffset == 0 ? 1 : (vehicle.total > vehicleLimit ? (totalFrom) : vehicle.total) ) + ' - ' + ( totalCurrentPage ) + ' Daripada ' + vehicle.total);
                    if(vehicle.total == 0){
                        $('#vehicleTotal').html('<label onclick=\"closeAndFreeTextVehicle()\">Tiada Rekod <u>(Sila Daftar Kenderaan Baru)</u></label>');
                    }

                    $('#pagination .next').prop('disabled', false);
                    $('#pagination .prev').prop('disabled', false);

                    if(vehicleOffset == 0){
                        $('#pagination .prev').prop('disabled', true);
                    }

                    if(totalFrom == totalCurrentPage || vehicleOffset > 0 && (totalCurrentPage == vehicle.total)){
                        $('#pagination .next').prop('disabled', true);
                    }

                    if(totalCurrentPage <= vehicleLimit){
                        $('#pagination .next').prop('disabled', true);
                        $('#pagination .prev').prop('disabled', true);
                    }

            });
        }

        function closeAndFreeTextVehicle(){
            $('#VehicleSearchModal').modal('hide');
            setTimeout(function(){
                $('[name="reg_no"]').focus();
            }, 500);
        }

        function submitVehicle(formData) {
            $.ajax({
                url: "{{ route('maintenance.job.nonjkr.register.save') }}",
                type: 'post',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    window.location.href = response['url'];
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

        function getSubCategory(category_id){

            $('#list_sub_category').html('<option value="-1">Sila Pilih</option>');
            $('#list_sub_category_type').html('<option value="-1">Sila Pilih</option>');

            $.get("{{route('vehicle.ajax.getSubCategory')}}", {
                category_id: category_id
            }, function(result){

                var count = result.length;
                var totalInit = 0;
                var same = false;

                result.forEach(element => {
                    $('#list_sub_category').append('<option value='+element.id+'>'+element.name+'</option>');
                    if(subCategoryId == element.id){
                        same = true;
                    }
                    totalInit++;
                });

                if(count == totalInit){
                    if(!same){
                        subCategoryId = -1;
                    }
                    $('#list_sub_category').val(subCategoryId).trigger("change");
                }

            });
        }

        function getSubCategoryType(sub_category_id){

            $('#list_sub_category_type').html('<option value="-1">Sila Pilih</option>');

            $.get("{{route('vehicle.ajax.getSubCategoryType')}}", {
                sub_category_id: sub_category_id
            }, function(result){

                var count = result.length;
                var totalInit = 0;
                var same = false;

                result.forEach(element => {
                    $('#list_sub_category_type').append('<option value='+element.id+'>'+element.name+'</option>');
                    totalInit++;
                    if(subCategoryTypeId == element.id){
                        same = true;
                    }
                });


                if(count == totalInit){
                    if(!same){
                        subCategoryTypeId = -1;
                    }
                    $('#list_sub_category_type').val(subCategoryTypeId).trigger("change");
                }

            });
        }

        function getVehicleModel(brand_id){

            $('#list_vehicle_model').html('<option value="-1">Sila Pilih</option>');

            $.get("{{route('vehicle.ajax.getVehicleModel')}}", {
                brand_id: brand_id
            }, function(result){

                var count = result.length;
                var totalInit = 0;
                var same = false;

                result.forEach(element => {
                    $('#list_vehicle_model').append('<option value='+element.id+'>'+element.name+'</option>');
                    totalInit++;
                    if(vehicleModelId == element.id){
                        same = true;
                    }
                });

                if(count == totalInit){
                    if(!same){
                        vehicleModelId = -1;
                    }
                    $('#list_vehicle_model').val(vehicleModelId).trigger("change");
                }

            });
        }


    </script>
