<form class="row" id="frm_info" method="POST" enctype="multipart/form-data">
    @csrf

    {{-- <input type="hidden" name="maintenance_id" value="{{$id}}"> --}}
    <input autocomplete="off" type="hidden" name="section" value="info">
    <input type="hidden" name="hasNewDocument" id="hasNewDocument" value=0>
    <div class="row">
        <div class="col-xl-9 col-lg-8 col-md-8 col-sm-12 col-12">

                <div class="row">
                    <fieldset>
                        <legend>Jenis Penilaian</legend>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <label for="" class="form-label text-dark">Jenis Penilaian</label>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_penilaian" id="">
                                <label class="form-check-label" for="flexRadio">
                                    Keselamatan & Prestasi
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_penilaian" id="">
                                <label class="form-check-label" for="flexRadio">
                                    Nilaian Harga Semasa
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_penilaian" id="">
                                <label class="form-check-label" for="flexRadio">
                                    Kemalangan
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_penilaian" id="">
                                <label class="form-check-label" for="flexRadio">
                                    Pinjaman Kerajaan
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_penilaian" id="">
                                <label class="form-check-label" for="flexRadio">
                                    Pelupusan
                                </label>
                            </div>

                            {{-- @foreach ($maintenance_type_list as $maintenance_type)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input"
                                    @if(!empty($detail))
                                        @foreach ($detail->hasManyType() as $selectedType)
                                        {{ $selectedType->id ==  $maintenance_type->id ? 'checked' : ''}}
                                        @endforeach
                                    @endif
                                    type="checkbox" xmaintenance_type_list id="inlineCheckbox-{{$maintenance_type->id}}" value="{{$maintenance_type->id}}">
                                    <label class="cursor-pointer" for="inlineCheckbox-{{$maintenance_type->id}}">{{$maintenance_type->desc}}</label>
                                </div>
                            @endforeach --}}

                        </div>
                    </fieldset>
                </div>
                <div class="row">
                    <fieldset>
                        <legend>Temujanji</legend>

                        <div class="row">
                            <div class="col-md-4">
                                <label for="" class="form-label text-dark">Tarikh Pilihan 1</label>
                                    @if (!empty($is_display) && ($is_display == 1))
                                    <div class="text-capitalize theme-color-text">
                                        {{isset($detail['appointment_dt1']) ? $detail['appointment_dt1'] : ""}}
                                    </div>
                                    @else
                                    <div class="input-group date" id="appointmentDt_1"
                                        data-target-input="nearest">
                                            <input name="appointment_dt1" id="appointmentDt_1Input"
                                            type="text" class="form-control datepicker" placeholder=""
                                            autocomplete="off"
                                            data-provide="datepicker" data-date-autoclose="true"
                                            data-date-format="dd/m/yyyy" data-date-today-highlight="true"
                                            value="{{isset($detail['appointment_dt1']) ? Carbon\Carbon::parse($detail['appointment_dt1'])->format('d/m/Y'): null}}"/>

                                            <div class="input-group-text" for="appointmentDt_1Input">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                    </div>
                                    @endif
                            </div>

                            <div class="col-md-4">
                                <label for="" class="form-label text-dark">Tarikh Pilihan 2</label>
                                    @if (!empty($is_display) && ($is_display == 1))
                                    <div class="text-capitalize theme-color-text">
                                        {{isset($detail['appointment_dt2']) ? $detail['appointment_dt2'] : ""}}
                                    </div>
                                    @else
                                    <div class="input-group date" id="appointmentDt_2"
                                        data-target-input="nearest">
                                            <input name="appointment_dt2" id="appointmentDt_2Input"
                                            type="text" class="form-control datepicker" placeholder=""
                                            autocomplete="off"
                                            data-provide="datepicker" data-date-autoclose="true"
                                            data-date-format="dd/m/yyyy" data-date-today-highlight="true"
                                            value="{{isset($detail['appointment_dt2']) ? Carbon\Carbon::parse($detail['appointment_dt2'])->format('d/m/Y'): null}}"/>

                                            <div class="input-group-text" for="appointmentDt_2Input">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                    </div>
                                    @endif
                            </div>

                            <div class="col-md-4">
                                <label for="" class="form-label text-dark">Tarikh Pilihan 3</label>
                                    @if (!empty($is_display) && ($is_display == 1))
                                    <div class="text-capitalize theme-color-text">
                                        {{isset($detail['appointment_dt3']) ? $detail['appointment_dt3'] : ""}}
                                    </div>
                                    @else
                                    <div class="input-group date" id="appointmentDt_3"
                                        data-target-input="nearest">
                                            <input name="appointment_dt3" id="appointmentDt_3Input"
                                            type="text" class="form-control datepicker" placeholder=""
                                            autocomplete="off"
                                            data-provide="datepicker" data-date-autoclose="true"
                                            data-date-format="dd/m/yyyy" data-date-today-highlight="true"
                                            value="{{isset($detail['appointment_dt3']) ? Carbon\Carbon::parse($detail['appointment_dt3'])->format('d/m/Y'): null}}"/>

                                            <div class="input-group-text" for="appointmentDt_3Input">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                    </div>
                                    @endif
                            </div>
                        </div>

                    </fieldset>

                </div>

                <fieldset>
                    <legend>Individu untuk dihubungi</legend>
                <div class="col-md-12">
                    <div class="row">

                        <div class="col-md-4">
                            <label for="" class="form-label text-dark">Nama</label>
                            @if (!empty($is_display) && ($is_display == 1) && ($detail['person_name'] != null))
                                <input type="text" class="form-control" autocomplete="off" id="name" name="name" value="{{ isset($detail['person_name']) && $detail['person_name'] ? : '' }}">
                            @else
                                <input type="text" class="form-control" autocomplete="off" id="name" name="name" value="{{isset($detail['person_name']) ? $detail['person_name'] : null}}" onkeyup="changeToUpperCase(this)"/>
                            @endif
                        </div>

                        <div class="col-md-4">
                            <label for="" class="form-label text-dark">NO KAD PENGENALAN</label>
                            @if (!empty($is_display) && ($is_display == 1)&& ($detail['person_ic_no'] != null))
                            @else
                                <input type="text" class="form-control" autocomplete="off" maxlength="14" id="ic_no" name="no_ic" value="{{isset($detail['person_ic_no']) ? $detail['person_ic_no'] : null}}" onkeyup="updateFormat('no_ic', this)"/>
                            @endif
                        </div>

                        <div class="col-md-4"></div>

                        <div class="col-md-4">
                            <label for="" class="form-label text-dark">NO TELEFON BIMBIT</label>
                            @if (!empty($is_display) && ($is_display == 1)&& ($detail['person_phone_no'] != null))
                            @else
                                <input type="text" class="form-control" autocomplete="off" id="no_phone" name="no_phone" value="{{isset($detail['person_phone_no']) ? $detail['person_phone_no'] : null}}" />
                            @endif
                        </div>

                        <div class="col-md-4">
                            <label for="" class="form-label text-dark">EMAIL</label>
                            @if (!empty($is_display) && ($is_display == 1)&& ($detail['person_email'] != null))
                            @else
                                <input type="text" class="form-control" autocomplete="off" id="email" name="email" value="{{isset($detail['person_email']) ? $detail['person_email'] : null}}"/>
                            @endif
                        </div>

                    </div>
                </fieldset>

                <fieldset>
                <div class="row">
                    <div class="col-md-12">
                        {{-- <label for="" class="form-label text-dark">Dokumen Sebut Harga (Sekiranya ada)</label>

                        @if (!empty($is_display) && ($is_display == 1))

                        @else

                        @endif --}}
                        @if (!empty($is_display) && ($is_display == 1))
                            <div class="text-capitalize theme-color-text">

                            </div>
                        @else
                            <label for="" class="form-label text-dark">Sebut Harga (Jika Ada)</label>
                            <label class="btn cux-btn bigger mb-3" for="quotation_doc">
                                <i class="fas fa-cloud-upload"></i> {{$detail && $detail->hasQuotationDoc ? 'Tukar Fail' : 'Muat Naik'}}
                            </label>
                            <input type="file" onchange="changeDocument(this)" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,application/pdf,image/*" class="form-control d-none" name="quotation_doc" id="quotation_doc">
                        @endif
                        <div id="preview-file-quotation_doc" class="form-group mb-2" style="display: {{$detail && $detail->hasQuotationDoc ? 'block' : 'none'}};height: 200px;
                            overflow: auto;">
                            @php
                                $doc_path = $detail && $detail->hasQuotationDoc ? $detail->hasQuotationDoc->doc_path : null;
                                $doc_name = $detail && $detail->hasQuotationDoc ? $detail->hasQuotationDoc->doc_name : null;
                                $pathUrl = $doc_path != '' ? '/storage/'.$doc_path.'/'.$doc_name : '';
                            @endphp
                                <embed src="{{$pathUrl}}" id="preview-file-quotation_doc-embed" width="100%" type="">
                            </div>


                    </div>
                </div>
                </fieldset>


        </div>

    </div>

    <div class="col-md-4 mt-2 mb-2">
        <div class="form-group center">
                <button class="btn btn-module" type="submit">Simpan</button>
                <a class="btn btn-module" data-bs-toggle="modal" data-bs-target="#submitForAppointmentNonJKRModal">Hantar</a>
        </div>
    </div>
</form>

<script type="text/javascript">

    let currentAppDt1;
    let currentAppDt2;
    let currentAppDt3;
    let excludeDateApp = [];

    function removeKey(arr, value){
        for (var i = 0; i < arr.length; i++) {
            if (arr[i] === value) {
                arr = arr.splice(i, 1);
            }
        }
        return arr;
    }

    function reinitializeDatepicker(target){

        $(target).datepicker("destroy").datepicker(
            {
                startDate: new Date(),
                beforeShowDay: function(_date) {
                    let day = moment(_date);
                    let res = !~$.inArray(day.format('YYYY-MM-DD'), excludeDateApp) && (_date.getDay() != 0);
                    return res;
                }
            }
        );
    }

    function submitInfo(formData) {

        let maintenance_type_list_selected = [];
        $('[xmaintenance_type_list]:checked').map(function () {
            maintenance_type_list_selected.push(this.value);
        });
        formData.append('maintenance_type_list_selected', maintenance_type_list_selected);
        $.ajax({
            url: "{{ route('maintenance.job.nonjkr.register.save') }}",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            success: function(response) {
                parent.openPgInFrame(response['url']);
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

    function changeDocument(self){
        event.preventDefault();
        let docType = self.id;
        let url = URL.createObjectURL(event.target.files[0]);
            $('#preview-file-'+docType+'-embed').attr('src', url);
            $('#preview-file-'+docType).show();
    }

    function updateFormat(model, self){
        var key = event.keyCode || event.charCode;
        console.log('key' , key);
        if(model == 'no_ic'){
            let x = $('#ic_no').val();

            if(key == 8){
                $('#ic_no').val(x);
            } else {
                if(x.length !== 7 || x.length !== 9){
                    x = x.replace(/[^\w\s]/gi, "");
                }

                if(x.length >= 6 && key !== 8){
                    x = x.substring(0, 6) + "-" + x.substring(6, x.length);
                }

                if(x.length >= 9 && key !== 8){
                    x = x.substring(0, 9) + "-" + x.substring(9, x.length);
                }
                $('#ic_no').val(x);
            }

        }
    }

    $(document).ready(function(){

        let app_dt_1_container = $('#appointmentDt_1Input').datepicker(
            {
                startDate: new Date()
            }
        );

        let app_dt_2_container = $('#appointmentDt_2Input');
        let app_dt_3_container = $('#appointmentDt_3Input');


        app_dt_1_container.on('click', function(e){
            let val = $(this).datepicker('getDate');
            if(val){
                currentAppDt1 = new moment(val).format('YYYY-MM-DD');
            }
        });

        app_dt_2_container.on('click', function(e){
            let val = $(this).datepicker('getDate');
            if(val){
                currentAppDt2 = new moment(val).format('YYYY-MM-DD');
            }
        });

        app_dt_3_container.on('click', function(e){
            let val = $(this).datepicker('getDate');
            if(val){
                currentAppDt3 = new moment(val).format('YYYY-MM-DD');
            }
        });


        app_dt_1_container.on('changeDate', function(ev){
            removeKey(excludeDateApp, currentAppDt1);
            let date = new moment(ev.date).format('YYYY-MM-DD');
            console.log('prev Array ', excludeDateApp);
            if($.inArray(date, excludeDateApp) === -1){
                excludeDateApp.push(date);
                console.log('latest Key Array ', excludeDateApp);
            }

            reinitializeDatepicker('#appointmentDt_1Input');
            reinitializeDatepicker('#appointmentDt_2Input');
            reinitializeDatepicker('#appointmentDt_3Input');

        });

        app_dt_2_container.on('changeDate', function(ev){

            removeKey(excludeDateApp, currentAppDt2);
            let date = new moment(ev.date).format('YYYY-MM-DD');
            console.log('prev Array ', excludeDateApp);
            if($.inArray(date, excludeDateApp) === -1){
                excludeDateApp.push(date);
                console.log('latest Key Array ', excludeDateApp);
            }

            reinitializeDatepicker('#appointmentDt_1Input');
            reinitializeDatepicker('#appointmentDt_2Input');
            reinitializeDatepicker('#appointmentDt_3Input');

        });

        app_dt_3_container.on('changeDate', function(ev){

            removeKey(excludeDateApp, currentAppDt3);
            let date = new moment(ev.date).format('YYYY-MM-DD');
            console.log('prev Array ', excludeDateApp);
            if($.inArray(date, excludeDateApp) === -1){
                excludeDateApp.push(date);
                console.log('latest Key Array ', excludeDateApp);
            }

            reinitializeDatepicker('#appointmentDt_1Input');
            reinitializeDatepicker('#appointmentDt_2Input');
            reinitializeDatepicker('#appointmentDt_3Input');

        });

        $('#frm_info').on('submit', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            submitInfo(formData);

        });

    })

</script>
