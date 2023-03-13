@php
    $doc_path = $detail->hasVocDoc() ? $detail->hasVocDoc()->doc_path : '';
    $doc_name = $detail->hasVocDoc() ? $detail->hasVocDoc()->doc_name : '';
    $pathUrl = $doc_path != '' ? '/storage/'.$doc_path.'/'.$doc_name : '';
@endphp

<form class="row" id="frm_info" method="POST" enctype="multipart/form-data">

    <div class="messages"></div>

    @csrf
    <input type="hidden" name="fleet_view" value="{{$fleet_view}}">
    <input type="hidden" name="section" value="info">
    <input type="hidden" name="reg_hak" value="{{$detail->owner_type_id}}">
    <input type="hidden" name="hasNewDocument" id="hasNewDocument" value=0>
    <div class="row">
        <div class="col-xl-7 col-lg-8 col-md-8 col-sm-12 col-12">
            <fieldset>
                <legend>Pengkategorian</legend>
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                        <label for="" class="form-label text-dark">Kategori</label>
                        @if (!empty($is_display) && ($is_display == 1))
                            <div class="text-capitalize theme-color-text">
                                {{$detail->hasCategory() ? $detail->hasCategory()->name:''}}
                            </div>
                        @else
                            <div class="input-group">
                                <select id="category_id" class="form-select" name="category_id" onchange="getSubCategory(this.value)">
                                    <option value="-1">Sila Pilih</option>
                                    @foreach ($categoryList as $category )
                                        <option
                                        {{$detail->hasCategory() && $detail->hasCategory()->id == $category->id ? 'selected': ''}}
                                        value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach

                                </select>
                            </div>
                        @endif
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                        <label for="" class="form-label text-dark">Sub Kategori</label>
                        @if (!empty($is_display) && ($is_display == 1))
                            <div class="text-capitalize theme-color-text">
                            {{$detail->hasSubCategory()? $detail->hasSubCategory()->name:''}}
                            </div>
                        @else
                        <div class="input-group">
                            {{-- todo wired issue --}}
                            <select class="form-select" name="sub_category_id" id="list_sub_category" onchange="getSubCategoryType(this.value)">
                                <option value="-1">Sila Pilih</option>
                            </select>
                        </div>
                        @endif
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                        <label for="" class="form-label text-dark">Jenis</label>
                        @if (!empty($is_display) && ($is_display == 1))
                            <div class="text-capitalize theme-color-text">
                            {{$detail->hasSubCategoryType() ? $detail->hasSubCategoryType()->name:''}}
                            </div>
                        @else
                        <div class="input-group">
                            <select class="form-select" name="sub_category_type_id" id="list_sub_category_type">
                                <option value="-1">Sila Pilih</option>
                            </select>
                        </div>
                        @endif
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <legend>Geran</legend>
                <div class="row">
                    <div class="col-xl-5 col-lg-5 col-md-6 col-sm-6 col-12">
                        <label for="" class="form-label text-dark">No Enjin</label>
                        @if (!empty($is_display) && ($is_display == 1))
                            <div class="text-capitalize theme-color-text">

                            </div>
                        @else
                        <input type="text" xprevalue="{{$detail['no_engine']}}" class="form-control" autocomplete="off" id="no_engine" name="engine" value="{{isset($detail['no_engine'])? $detail['no_engine'] : ''}}">
                        @endif
                    </div>
                    <div class="col-xl-5 col-lg-5 col-md-6 col-sm-6 col-12">
                        <label for="" class="form-label text-dark">No Chasis</label>
                        @if (!empty($is_display) && ($is_display == 1))
                            <div class="text-capitalize theme-color-text">

                            </div>
                        @else
                        <input type="text" xprevalue="{{$detail['no_chasis']}}" class="form-control" autocomplete="off" id="no_chasis" name="chasis" value="{{isset($detail['no_chasis']) ? $detail['no_chasis'] : ''}}">
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-5 col-lg-5 col-md-6 col-sm-6 col-12">
                        <label for="" class="form-label text-dark">Pembuat</label>
                        @if (!empty($is_display) && ($is_display == 1))
                            <div class="text-capitalize theme-color-text">
                                {{$detail->hasBrand() ? $detail->hasBrand()->name:''}}
                            </div>
                        @else
                        <div class="input-group">
                            <select class="form-select" id="maklumat_pembuat" name="pembuat" onchange="getVehicleModel(this.value)">
                            <option value="-1">Sila Pilih</option>
                            @foreach ($brands as $brand )
                                <option
                                {{$detail->hasBrand() && $detail->hasBrand()->id == $brand->id ? 'selected': ''}}
                                value="{{$brand->id}}">{{$brand->name}}</option>
                            @endforeach
                            </select>
                        </div>
                        @endif
                    </div>
                    <div class="col-xl-5 col-lg-5 col-md-6 col-sm-6 col-12">
                        <label for="" class="form-label  text-dark">Model</label>

                        @if (!empty($is_display) && ($is_display == 1))
                            <div class="text-capitalize theme-color-text">
                                {{$detail->hasVehicleModel()? $detail->hasVehicleModel()->name:''}}
                            </div>
                        @else
                        {{-- <select class="form-select" id="maklumat_model" name="model">
                            <option value="-1">Sila Pilih</option>
                            @foreach ($models as $model)
                                <option
                                {{$detail->hasVehicleModel() && $detail->hasVehicleModel()->id == $model->id ? 'selected': ''}}
                                value="{{$model->id}}">{{$model->name}}</option>
                            @endforeach
                        </select> --}}
                        <select class="form-select" name="model" id="list_vehicle_model">
                            <option value="-1">Sila Pilih</option>
                        </select>

                        @endif
                    </div>
                    @if($currentFleetTable == 'department')
                        <div class="row">
                            <div class="col-md-12">
                                <label for="" class="form-label text-dark">VOC Dokumen</label>
                                @php
                                    $format = explode('.',$doc_name);
                                    $format = array_pop($format);
                                    $arrayFormatDownload = ['xlsx','xls','doc','docx'];
                                @endphp

                                @if (!empty($is_display) && ($is_display == 1))
                                    <div class="text-capitalize theme-color-text">
                                        {{$detail->hasVehicleModel()? $detail->hasVehicleModel()->name:''}}
                                    </div>
                                @else
                                <label class="btn cux-btn bigger mb-3" for="doc_voc"><i class="fas fa-cloud-upload"></i> {{$pathUrl == '' ? 'Muat Naik' : 'Tukar Fail'}}</label>
                                <input type="file" accept=".xlsx,.xls,.doc,.docx,.pdf,image/*" class="form-control d-none" name="doc_voc" id="doc_voc">

                                @endif

                                @if($detail->hasVocDoc())
                                    <div class="col-md-4">
                                        @if(in_array($format, $arrayFormatDownload))
                                        <span class="btn cux-btn small" href="#" data-url="{{$pathUrl}}" data-download="true" onclick="fancyView(this)">
                                            <i class="fas fa-file-pdf"></i> Muat Turun</span>
                                        @else
                                        <span class="btn cux-btn small" href="#" data-url="{{$pathUrl}}" onclick="fancyView(this)">
                                            <i class="fas fa-file-pdf"></i> Lihat Dokumen</span>
                                        @endif
                                    </div>
                                @endif
                                {{-- <div id="preview-file" class="form-group mb-2" style="display: none;height: 200px;
                                overflow: auto;">
                                    <embed src="{{$pathUrl}}" id="preview-file-embed" width="100%" type="">
                                </div> --}}
                            </div>
                        </div>
                    @endif
                </div>
            </fieldset>
        </div>
        @if($currentFleetTable == 'department')
            <div class="col-xl-5 col-lg-4 col-md-4 col-sm-12 col-12">
                <fieldset>
                    <legend>Gambar</legend>
                    <div class="col-md-12">
                        <label for="" class="form-label text-dark">Gambar Kenderaan</label>
                        @if (!empty($is_display) && ($is_display == 1))
                        <div id="vehicle-images" class="tanda" style="width: 400px; overflow-x: hidden; padding: 10px;"></div>
                        @else
                            <span class="btn cux-btn bigger mb-2" data-bs-toggle="modal" data-bs-target="#addVehicleImageModal"> <i class="fa fa-plus"></i> Tambah</span>
                            <div id="vehicle-images" style="width: 400px; overflow-x: hidden; padding: 10px;">
                                {{-- @include('vehicle.tab.detail-vehicle-images') --}}
                            </div>
                        @endif
                    </div>
                </fieldset>
            </div>
        @endif
    </div>


    {{-- <div class="col-md-4"></div> --}}

    @if(!empty($detail['vehicle']))
       @if ($detail['vehicle'] == 'lupus')
            <div class="col-md-4">
                    <label for="" class="form-label text-dark">Tarikh Belian</label>
                    <input type="date" class="form-control calender" name="tarikhbelian">
                </div>
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <label for="" class="form-label text-dark">No Resit Rasmi</label>
                    <input type="text" class="form-control" name="noresit">
                </div>
                <div class="col-md-4">
                    <label for="" class="form-label text-dark">Pembeli / Penerima</label>
                    <input type="text" class="form-control" name="penerima">
                </div>
                <div class="col-md-4"></div>
       @endif
    @endif

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
                    @if ((auth()->user()->isAdmin() && $detail) || !$detail || $detail->vAppStatus  && in_array($detail->vAppStatus->code, $allowBtnSave) || $TaskFlowAccessVehicle->mod_fleet_approval)
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

@if($currentFleetTable == 'department')
    <div class="modal fade" id="addVehicleImageModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addVehicleImageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="frmVehicleImage" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="vehicleImage" class="form-label">Muat naik gambar kenderaan <span class="btn cux-btn">&nbsp;<i class="fa fa-upload fa-2x"></i></span></label>
                            <input class="form-control d-none" accept="image/*" name="vehicle_image" type="file" id="vehicleImage" />
                        </div>
                        <div class="form-group">
                            <div id="preview-image" class="text-center" style="display: none;">
                                <img src="" id="preview-image-output" width="100%"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <textarea name="pic_desc" class="form-control" id="pic_desc" cols="30" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="close_modal" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary" xaction="upload_image" >Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

<script type="text/javascript">

    var currentPreviewFile = "{{$pathUrl}}";
    var categoryId = -1;
    var subCategoryId = -1;
    var subCategoryTypeId = -1;
    var vehicleBrandId = -1;
    var vehicleModelId = -1;

    const fancyView = function(self){
        let url = $(self).data('url');
        let is_download = $(self).data('download');

        if(is_download){
            window.location.replace(url);
        } else {
            const fancybox = new Fancybox([
            {
                src: url,
                type: "pdf",
            },
            ]);

            fancybox.on("done", (fancybox, slide) => {
            console.log(`done!`);
            });
        }
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

            var currentSelectedCategoryId = {{$detail->hasCategory() && $detail->hasCategory()->id ? $detail->hasCategory()->id : -1}};

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

            var currentSelectedSubCategoryId = {{$detail->hasSubCategory() && $detail->hasSubCategory()->id ? $detail->hasSubCategory()->id : -1}};

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

            var currentSelectedBrandId = {{$detail->hasBrand() && $detail->hasBrand()->id ? $detail->hasBrand()->id : -1}};

            if(count == totalInit){
                if(!same){
                    vehicleModelId = -1;
                }
                $('#list_vehicle_model').val(vehicleModelId).trigger("change");
            }

        });
    }

    function submitInfo(formData){
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
                console.log(response);
                var errors = response.responseJSON.errors;

                var errorsHtml = '<div class="alert alert-danger mb-0 pb-0"><ul>';

                $.each(errors, function(key, value) {
                    errorsHtml += '<li>' + value[0] + '</li>';
                });
                errorsHtml += '</ul></div';

                $('#frm_info .messages').html(errorsHtml);
                parent.stopLoading();
            }
        });

    }

    function getVehicleImages(){
        $.get('{{route('vehicle.ajax.getVehicleImages')}}', {
            'is_display': '{{$is_display}}',
            'fleet_view': '{{$fleet_view}}'
        }, function(result){
            $('#vehicle-images').html(result)
        });
    }

    function checkExistColumn(column, value){
        $.ajax({
            url: "{{ route('vehicle.checkExistColumnValue') }}",
            type: 'post',
            data: {
                column: column,
                value: value,
                '_token': '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function(isExist) {

                var columnDesc = {
                    'no_engine': 'No Engin',
                    'no_chasis': 'No Chasis'
                }

                let errorsHtml = '';
                if(isExist == 1){
                    errorsHtml = '<div class="alert alert-danger mb-0 pb-0"><li>'+columnDesc[column]+' '+value+' Telah Wujud</li><ul>';
                    let elemt = $('#'+column);
                    elemt.val(elemt.attr('xprevalue'));
                }
                $('#frm_info .messages').html(errorsHtml);
            },
            error: function(response) {
                console.log(response);
                var errors = response.responseJSON.errors;

                var errorsHtml = '<div class="alert alert-danger mb-0 pb-0"><ul>';

                $.each(errors, function(key, value) {
                    errorsHtml += '<li>' + value[0] + '</li>';
                });
                errorsHtml += '</ul></div';

                $('#frm_info .messages').html(errorsHtml);
            }
        });
    }

    $(document).ready(function(){

        @if (!empty($pathUrl))
            $('#preview-file').show();
        @endif

        $('#doc_voc').on('change', function(e){
            e.preventDefault();

            let url = URL.createObjectURL(e.target.files[0]);
            $('#preview-file-embed').attr('src', url);
            $('#preview-file').show();
            currentPreviewFile = url;
            $('#hasNewDocument').val(1);
            console.log('url  file -> ', url);
        })

        @if ($detail->id)
            getVehicleImages();
        @endif

        categoryId = {{$detail->hasCategory() ? $detail->hasCategory()->id : -1}};
        subCategoryId = {{$detail->hasSubCategory() ? $detail->hasSubCategory()->id : -1}};
        subCategoryTypeId = {{$detail->hasSubCategoryType() ? $detail->hasSubCategoryType()->id : -1}};

        vehicleBrandId = {{$detail->hasBrand() ? $detail->hasBrand()->id : -1}};
        vehicleModelId = {{$detail->hasVehicleModel() ? $detail->hasVehicleModel()->id : -1}};

        if(categoryId != -1){
            getSubCategory(categoryId);
        }

        if(vehicleBrandId != -1){
            getVehicleModel(vehicleBrandId);
        }

        $('#no_engine').on('change', function(e){
            e.preventDefault();
            checkExistColumn('no_engine', this.value);
        });

        $('#no_chasis').on('change', function(e){
            e.preventDefault();
            checkExistColumn('no_chasis', this.value);
        });

        $('#frm_info').on('submit', function(e){
            e.preventDefault();

            var formData = new FormData(this);
            submitInfo(formData);

        });

        $('#vehicleImage').on('change', function(e){
            e.preventDefault();

            var output = document.getElementById('preview-image-output');
            output.src = URL.createObjectURL(e.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
                $('#preview-image').show();
                $('#preview-image-output').show();
            }

        });

        $('#frmVehicleImage').on('submit', function(e){
            e.preventDefault();

            var formData = new FormData(this);
            formData.append('fleet_view', "{{$fleet_view}}");

            $.ajax({
                url: "{{route('vehicle.upload.image')}}",
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                async: false,
                data: formData,
                success: function(response) {
                    console.log(response);
                    if(response.status == '200') {
                        getVehicleImages();
                    }
                    $('#addVehicleImageModal').modal('hide');
                    $('#preview-image-output').attr('src', '').hide();
                    $('#frmVehicleImage')[0].reset();
                },
                error: function(response) {
                    var errors = response.responseJSON.errors;
                    $.each(errors, function(key, value) {

                        if($('[name="'+key+'"]').parent().find('.text-danger').length == 0){
                            $('[name="'+key+'"]').parent().append('<div class="text-danger col-12 fs-6">'+value[0]+'</div>');
                        }
                    });

                }
            });
        });

    })

</script>
