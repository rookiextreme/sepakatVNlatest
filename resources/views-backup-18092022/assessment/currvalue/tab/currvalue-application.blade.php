
<form class="row" id="frm_application" enctype="multipart/form-data">

    @csrf

    <div class="messages"></div>

    <input type="hidden" name="section" value="detail">
    <fieldset>
        <legend>Pemohon Pinjaman</legend>
        <div class="row">
            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-5">
                <label for="" class="form-label text-dark">Nama Pemohon <span class="text-danger">*</span></label>

                @if(!$detail || $is_myApp && in_array($detail->hasStatus->code, ['01']) || auth()->user()->isAdmin())
                    <input type="text" name="applicant_name" id="applicant_name" class="form-control" autocomplete="off"
                    onchange="this.value = this.value.toUpperCase()"
                    value="{{$detail ? $detail->applicant_name : strtoupper(auth()->user()->name)}}">
                @else
                    <div class="txt-data ass_gov">{{$detail ? $detail->applicant_name : strtoupper(auth()->user()->name)}}</div>
                @endif
            </div>
            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-3">
                <label for="" class="form-label  text-dark">No Telefon<span class="text-danger">*</span></label>

                @if(!$detail ||$is_myApp && in_array($detail->hasStatus->code, ['01']) || auth()->user()->isAdmin())
                    <input type="text" name="phone_no" id="phone_no" class="form-control" autocomplete="off"
                    value="{{$detail ? $detail->phone_no : auth()->user()->detail->telbimbit}}"
                    onkeyup="this.value = !isNaN(this.value) ? this.value : ''; ">
                @else
                    <div class="txt-data ass_gov">{{$detail ? $detail->phone_no : auth()->user()->detail->telbimbit}}</div>
                @endif
            </div>
            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-sm-4">
                <label for="" class="form-label  text-dark">Emel <span class="text-danger">*</span></label>

                @if(!$detail ||$is_myApp && in_array($detail->hasStatus->code, ['01']) || auth()->user()->isAdmin())
                    <input type="text" name="email" id="email" class="form-control" autocomplete="off"
                    value="{{$detail ? $detail->email : auth()->user()->email}}">
                @else
                    <div class="txt-data-small ass_gov">{{$detail ? $detail->email : auth()->user()->email}}</div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-xl-4 col-lg-4 col-md-5 col-sm-6">
                <label for="" class="form-label text-dark">Kementerian  <span class="text-danger">*</span></label>
                @if(!$detail ||$is_myApp && in_array($detail->hasStatus->code, ['01']) || auth()->user()->isAdmin())
                    <div class="input-group">
                        <select class="form-control form-select" id="agency_id" name="agency_id" >
                            <option></option>
                            @foreach ($agency_list as $agency)
                                <option {{($detail && $detail->hasAgency && $detail->hasAgency->id == $agency->id) || (auth()->user()->detail->hasAgency && auth()->user()->detail->hasAgency->id == $agency->id) ? 'selected'  : ''}} value="{{$agency->id}}">{{strtoupper($agency->desc)}}</option>
                            @endforeach
                        </select>
                    </div>
                @else
                    <div class="txt-data ass_gov">{{$detail && $detail->hasAgency ? $detail->hasAgency->desc : null}}</div>
                @endif
            </div>
            <div class="col-xl-3 col-lg-4 col-md-5 col-sm-6">
                <label for="" class="form-label text-dark">Jabatan / Agensi <span class="text-danger">*</span></label>

                @if(!$detail ||$is_myApp && in_array($detail->hasStatus->code, ['01']) || auth()->user()->isAdmin())
                    <div class="input-group">
                        <input type="text" class="form-control" id="department_name" name="department_name" value="{{$detail ? $detail->department_name : auth()->user()->detail->department_name}}" onchange="this.value = this.value.toUpperCase()">
                    </div>
                @else
                    <div class="txt-data ass_gov">{{$detail ? $detail->department_name : null}}</div>
                @endif
            </div>
            <div class="col-xl-3 col-lg-4 col-md-5 col-sm-6">
                <label for="" class="form-label text-dark">Ketua Jabatan (Gelaran) <span class="text-danger">*</span></label>

                @if(!$detail ||$is_myApp && in_array($detail->hasStatus->code, ['01']) || auth()->user()->isAdmin())
                    <div class="input-group">
                        <input type="text" class="form-control" id="hod_title" name="hod_title" placeholder="KETUA PENGARAH" onchange="this.value = this.value.toUpperCase()" value="{{$detail ? $detail->hod_title : auth()->user()->detail->hod_title}}">
                    </div>
                @else
                    <div class="txt-data ass_new">{{$detail ? $detail->hod_title : null}}</div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                <label for="" class="form-label text-dark">Alamat  <span class="text-danger">*</span></label>

                @if(!$detail ||$is_myApp && in_array($detail->hasStatus->code, ['01']) || auth()->user()->isAdmin())
                    <textarea class="form-control" name="address" id="address" onchange="this.value = this.value.toUpperCase()" cols="30" rows="3">{{$detail ? $detail->address : auth()->user()->detail->address}}</textarea>
                @else
                    <div class="txt-data ass_gov">{{$detail ? $detail->address : null}}</div>
                @endif
            </div>
            <div class="col-xl-6 col-lg-6 col-md-7 col-sm-6">
                <div class="row">
                    <div class="col-xl-2 col-lg-3 col-md-3 col-sm-6">
                        <label for="" class="form-label text-dark">Poskod <span class="text-danger">*</span></label>

                        @if(!$detail ||$is_myApp && in_array($detail->hasStatus->code, ['01']) || auth()->user()->isAdmin())
                            <div class="input-group">
                                <input type="text" class="form-control" id="postcode" onkeyup="this.value = !isNaN(this.value) ? this.value : ''; " name="postcode" value="{{$detail ? $detail->postcode : auth()->user()->detail->postcode}}">
                            </div>
                        @else
                            <div class="txt-data ass_gov">{{$detail ? $detail->postcode : null}}</div>
                        @endif
                    </div>
                    <div class="col-xl-5 col-lg-7 col-md-6 col-sm-12">
                        <label for="" class="form-label text-dark">Negeri <span class="text-danger">*</span></label>

                        @if(!$detail ||$is_myApp && in_array($detail->hasStatus->code, ['01']) || auth()->user()->isAdmin())
                            <div class="input-group">
                                <select class="form-control form-select" id="state_id" name="state_id" >
                                    <option></option>
                                    @foreach ($state_list as $state)
                                        <option {{($detail && $detail->state_id  == $state->id) || (auth()->user()->detail->hasState && auth()->user()->detail->hasState->id == $state->id) ? 'selected'  : ''}} value="{{$state->id}}">{{strtoupper($state->desc)}}</option>
                                    @endforeach
                                </select>
                                {{-- <input type="text" class="form-control" name="state_id" id="state_id" value="{{$detail ? $detail->state_id : null}}"> --}}
                            </div>
                        @else
                            <div class="txt-data ass_gov">
                                @foreach ($state_list as $state)
                                    {{$detail && $detail->state_id  == $state->id ? $state->desc  : null}}
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
    <fieldset>
        <legend>Penilaian</legend>
        <div class="row">

            <div class="col-xl-3 col-lg-4 col-md-5 col-sm-6">
                @if($detail)
                <label for="" class="form-label text-dark">No Rujukan <span class=""></span></label>
                    <div class="txt-data ass_gov thin-underline" style="height:52px">
                        {{$detail->ref_number ? : null}}
                    </div>
                @endif
                <label for="" class="form-label text-dark">Woksyop Pilihan <span class="text-danger">*</span></label>

                @if(!$detail ||$is_myApp && in_array($detail->hasStatus->code, ['01']) || auth()->user()->isAdmin())
                    <div class="input-group">
                        <select class="form-control form-select" id="" name="workshop_id">
                            <option></option>
                            @foreach ($workshop_list as $workshop)
                                <option {{($detail && $detail->hasWorkShop && $detail->hasWorkShop->id == $workshop->id)|| (auth()->user()->detail->hasWorkshop && auth()->user()->detail->hasWorkshop->id == $workshop->id) ? 'selected'  : ''}} value="{{$workshop->id}}">{{$workshop->desc}}</option>
                            @endforeach
                        </select>
                    </div>
                @else
                    <div class="txt-data ass_gov">{{$detail && $detail->hasWorkShop ? $detail->hasWorkShop->desc : null}}</div>
                @endif
            </div>
            <div class="col-xl-3 col-lg-4 col-md-5 col-sm-6">
                <label class="form-label text-dark">Cadangan Tarikh & Masa Temujanji <i class="fa fa-info-circle spakat-tip" data-bs-toggle="tooltip" data-bs-placement="right" title="Anda boleh pilih beberapa tarikh dan masa yang sesuai untuk anda, dan kami cuba untuk memilih mana-mana tarikh yang kosong mengikut pilihan anda. Namun, sekiranya tiada slot yang kosong, kami akan berikan slot mengikut kekosongan."></i> <span class="text-danger">*</span></label>
                <div class="row">
                    <div class="col-12">
                        <label class="sub-label text-dark">Pilihan Pertama</label>
                    </div>
                    @if(!$detail ||$is_myApp && in_array($detail->hasStatus->code, ['01']) || auth()->user()->isAdmin())
                    <div class="col-xl-7 col-7">
                        <div class="input-group date form_datetime" id="date1Container" data-date="{{$detail && $detail->appointment_dt1 ? $detail->appointment_dt1 : ''}}" data-date-format="dd M yyyy">
                            <input class="form-control appointment_date" size="16" id="input_date_1" type="text"
                            value="{{$detail && $detail->appointment_dt1 ? Carbon\Carbon::parse($detail->appointment_dt1 )->format('d M Y') : ''}}" placeholder="Tarikh 1" onkeypress="return false;" required>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                            <label class="input-group-addon input-group-text" for="input_date_1">
                                <i class="fal fa-calendar-alt"></i>
                            </label>
                        </div>
                        <input type="hidden" name="appointment_date_1" id="appointment_date_1" value="{{$detail && $detail->appointment_dt1 ? Carbon\Carbon::parse($detail->appointment_dt1 )->format('d M Y G:i:s') : ''}}" />
                    </div>
                    <div class="col-xl-5 col-5 ps-0">
                        <select class="form-control form-select appointment_time" id="time_1" name="time_1">
                            <option></option>
                        @php
                            $mytime = '';
                            if($detail && $detail->appointment_dt1) {
                                $mytime = sprintf('%02d', strval(Carbon\Carbon::parse($detail->appointment_dt1 )->format('g'))).strval(Carbon\Carbon::parse($detail->appointment_dt1 )->format(':i A'));
                            }
                            $arrBlock = array('12:45 PM','01:00 PM','01:15 PM','01:30 PM','01:45 PM','04:15 PM','04:30 PM','04:45 PM');
                            $arrMin = array('00','15','30','45');

                            for ($time = 9; $time <= 16; $time++) {
                                $ampm = $time < 12 ? 'AM' : 'PM';
                                $timedisplay = $time > 12 ? ($time - 12) : $time;
                                $showtime = sprintf('%02d', $timedisplay);

                                foreach ($arrMin as $value) {
                                    $fulltime = $showtime.":".$value." ".$ampm;
                                    if (in_array($fulltime, $arrBlock, TRUE)){

                                    }else{
                                        $selected = '';
                                        if($mytime == $fulltime){
                                            $selected = "selected";
                                        }else{
                                            $selected = "";
                                        }
                                        // echo $fulltime;
                                        echo "<option value='{$fulltime}' {$selected}>{$fulltime}</option>";
                                    }
                                    $selected = "";
                                }
                            }
                        @endphp
                        </select>
                    </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-12">
                        <label class="sub-label text-dark">Pilihan Kedua</label>
                    </div>
                    @if(!$detail ||$is_myApp && in_array($detail->hasStatus->code, ['01']) || auth()->user()->isAdmin())
                    <div class="col-xl-7 col-7">
                        <div class="input-group date form_datetime" id="date2Container" data-date="{{$detail && $detail->appointment_dt2 ? $detail->appointment_dt2 : ''}}" data-date-format="dd M yyyy">
                            <input class="form-control appointment_date" size="16" id="input_date_2" type="text"
                            value="{{$detail && $detail->appointment_dt2 ? Carbon\Carbon::parse($detail->appointment_dt2 )->format('d M Y') : ''}}" placeholder="Tarikh 2" onkeypress="return false;" >
                            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                            <label class="input-group-addon input-group-text" for="input_date_2">
                                <i class="fal fa-calendar-alt"></i>
                            </label>
                        </div>
                        <input type="hidden" name="appointment_date_2" id="appointment_date_2" value="{{$detail && $detail->appointment_dt2 ? Carbon\Carbon::parse($detail->appointment_dt2)->format('d M Y G:i:s') : ''}}" />
                    </div>
                    <div class="col-xl-5 col-5 ps-0">
                        <select class="form-control form-select appointment_time" id="time_2" name="time_2">
                            <option></option>
                        @php
                            $mytime = '';
                            if($detail && $detail->appointment_dt2) {
                                $mytime = sprintf('%02d', strval(Carbon\Carbon::parse($detail->appointment_dt2 )->format('g'))).strval(Carbon\Carbon::parse($detail->appointment_dt2 )->format(':i A'));
                            }
                            $arrBlock = array('12:45 PM','01:00 PM','01:15 PM','01:30 PM','01:45 PM','04:15 PM','04:30 PM','04:45 PM');
                            $arrMin = array('00','15','30','45');

                            for ($time = 9; $time <= 16; $time++) {
                                $ampm = $time < 12 ? 'AM' : 'PM';
                                $timedisplay = $time > 12 ? ($time - 12) : $time;
                                $showtime = sprintf('%02d', $timedisplay);

                                foreach ($arrMin as $value) {
                                    $fulltime = $showtime.":".$value." ".$ampm;
                                    if (in_array($fulltime, $arrBlock, TRUE)){

                                    }else{
                                        $selected = '';
                                        if($mytime == $fulltime){
                                            $selected = "selected";
                                        }else{
                                            $selected = "";
                                        }
                                        // echo $fulltime;
                                        echo "<option value='{$fulltime}' {$selected}>{$fulltime}</option>";
                                    }
                                    $selected = "";
                                }
                            }
                        @endphp
                        </select>
                    </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-12">
                        <label class="sub-label text-dark">Pilihan Ketiga</label>
                    </div>
                    @if(!$detail ||$is_myApp && in_array($detail->hasStatus->code, ['01']) || auth()->user()->isAdmin())
                    <div class="col-xl-7 col-7">
                        <div class="input-group date form_datetime" id="date3Container" data-date="{{$detail && $detail->appointment_dt3 ? $detail->appointment_dt3 : ''}}" data-date-format="dd M yyyy">
                            <input class="form-control appointment_date" size="16" id="input_date_3" type="text"
                            value="{{$detail && $detail->appointment_dt3 ? Carbon\Carbon::parse($detail->appointment_dt3 )->format('d M Y') : ''}}" placeholder="Tarikh 3" onkeypress="return false;" >
                            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                            <label class="input-group-addon input-group-text" for="input_date_3">
                                <i class="fal fa-calendar-alt"></i>
                            </label>
                        </div>
                        <input type="hidden" name="appointment_date_3" id="appointment_date_3" value="{{$detail && $detail->appointment_dt3 ? Carbon\Carbon::parse($detail->appointment_dt3)->format('d M Y G:i:s') : ''}}" />
                    </div>
                    <div class="col-xl-5 col-5 ps-0">
                        <select class="form-control form-select appointment_time" id="time_3" name="time_3">
                            <option></option>
                        @php
                            $mytime = '';
                            if($detail && $detail->appointment_dt3) {
                                $mytime = sprintf('%02d', strval(Carbon\Carbon::parse($detail->appointment_dt3 )->format('g'))).strval(Carbon\Carbon::parse($detail->appointment_dt3 )->format(':i A'));
                            }
                            $arrBlock = array('12:45 PM','01:00 PM','01:15 PM','01:30 PM','01:45 PM','04:15 PM','04:30 PM','04:45 PM');
                            $arrMin = array('00','15','30','45');

                            for ($time = 9; $time <= 16; $time++) {
                                $ampm = $time < 12 ? 'AM' : 'PM';
                                $timedisplay = $time > 12 ? ($time - 12) : $time;
                                $showtime = sprintf('%02d', $timedisplay);

                                foreach ($arrMin as $value) {
                                    $fulltime = $showtime.":".$value." ".$ampm;
                                    if (in_array($fulltime, $arrBlock, TRUE)){

                                    }else{
                                        $selected = '';
                                        if($mytime == $fulltime){
                                            $selected = "selected";
                                        }else{
                                            $selected = "";
                                        }
                                        // echo $fulltime;
                                        echo "<option value='{$fulltime}' {$selected}>{$fulltime}</option>";
                                    }
                                    $selected = "";
                                }
                            }
                        @endphp
                        </select>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </fieldset>
    <hr/>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            @if($detail)
                @if($is_myApp)
                    @if($detail->hasStatus->code == '01')
                    <button {{$detail && $detail->hasVehicle && $detail->hasVehicle->count()>0 ? '':'disabled'}} class="btn btn-module verify" data-id="{{$detail ? $detail->id : null}}"><i class="fal fa-paper-plane icon-white"></i>&nbsp;&nbsp;Hantar</button>
                    @endif
                    {{-- @if(in_array($detail->hasStatus->code, ['01']) || auth()->user()->isAdmin()) --}}
                    @if($detail->hasStatus->code == '01')
                        <button class="btn btn-link" type="submit"><i class="fal fa-save"></i>&nbsp;&nbsp;Simpan</button>
                    @endif
                @endif
            @else
                <button class="btn btn-link" type="submit">Seterusnya <i class="fal fa-arrow-right"></i> </button>
            @endif
        </div>
    </div>
    <p>&nbsp;</p>
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


        //console.log(target);
        //console.log(excludeDateApp);

       setTimeout(() => {
            $(target).datetimepicker('remove').datetimepicker(
                {
                    autoclose: 1,
                    todayHighlight: 1,
                    startDate: new Date(),
                    datesDisabled: excludeDateApp
                }
            );
       }, 500);


    }

    function submitApplication(data) {

        $('#frm_application .hasErr').html('');

        $('[name="app_dates"]').html('');
        let app_dt_1 = moment($("#app_dt_1")).format('YYYY-MM-DD HH:mm');
        console.log(app_dt_1);

            parent.startLoading();
            $.ajax({
                url: "{{ route('assessment.currvalue.register.save') }}",
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

                        if(key == 'app_dates'){
                            if($('[name="'+key+'"]').find('.hasErr').length == 0){
                                console.log(value[0]);
                                $('[name="'+key+'"]').html('<div class="hasErr text-danger col-12 fs-6">'+value[0]+'</div>');
                            }
                        }
                        else if($('[name="'+key+'"]').attr('type') == 'radio' || $('[name="'+key+'"]').attr('type') == 'checkbox'){
                            if($('[name="'+key+'"]').parent().parent().find('.hasErr').length == 0){
                                $('[name="'+key+'"]').parent().parent().append('<div class="hasErr text-danger col-12 fs-6">'+value[0]+'</div>');
                            }
                        } else {
                            if($('[name="'+key+'"]').parent().find('.hasErr').length == 0){
                                $('[name="'+key+'"]').parent().append('<div class="hasErr text-danger col-12 fs-6">'+value[0]+'</div>');
                            }
                        }
                    });

                    parent.stopLoading();
                }
            });
        }


        $(document).ready(function(){
        /*@if($detail && $detail->appointment_dt1)
            excludeDateApp.push('{{Carbon\Carbon::parse($detail->appointment_dt1)->format("Y-m-d")}}');

        @endif

        @if($detail && $detail->appointment_dt2)
            excludeDateApp.push('{{Carbon\Carbon::parse($detail->appointment_dt2)->format("Y-m-d")}}');

        @endif

        @if($detail && $detail->appointment_dt3)
            excludeDateApp.push('{{Carbon\Carbon::parse($detail->appointment_dt3)->format("Y-m-d")}}');

        @endif

            reinitializeDatepicker('#date1Container');
            reinitializeDatepicker('#date2Container');
            reinitializeDatepicker('#date3Container');*/


        $('#frm_application').on('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            formData.append('app_dates', excludeDateApp);
            submitApplication(formData);

        });

        let date1Container = $('#date_1_input').datepicker();
        date1Container.datepicker('setEndDate', new Date());

        let app_dt_1_container = $('#date1Container').datepicker(
            {
                autoclose: 1,
                todayHighlight: 1,
                startDate: new Date()
            }
        );

        let date2Container = $('#date_2_input').datepicker();
        date2Container.datepicker('setEndDate', new Date());

        let app_dt_2_container = $('#date2Container').datepicker(
            {
                autoclose: 1,
                todayHighlight: 1,
                startDate: new Date()
            }
        );

        let date3Container = $('#date_3_input').datepicker();
        date3Container.datepicker('setEndDate', new Date());

        let app_dt_3_container = $('#date3Container').datepicker(
            {
                autoclose: 1,
                todayHighlight: 1,
                startDate: new Date()
            }
        );

        //appointment_date
        $('.appointment_time').add(".appointment_date").change(function(){
            //combine both date & time
            var mynum = this.id.slice(-1);
            var ddate = $('#input_date_' + mynum).val();
            var dtime = $('#time_' + mynum).val();
            if(dtime != ''){
                both = convertDateToDB(ddate) + " " + dtime;
            }else{
                both = convertDateToDB(ddate);
            }
            $('#appointment_date_' + mynum).val(both);
        });

        app_dt_1_container.on('changeDate', function(ev){

            let formatedValue = moment(ev.date).format('YYYY-MM-DD HH:mm');
            $('[name="date_1"]').val(formatedValue);

            removeKey(excludeDateApp, currentAppDt1);
            let date = new moment(ev.date).format('YYYY-MM-DD');
            console.log('prev Array ', excludeDateApp);
            if($.inArray(date, excludeDateApp) === -1){
                excludeDateApp.push(date);
                console.log('latest Key Array ', excludeDateApp);
            }

            //reinitializeDatepicker('#date1Container');
            //reinitializeDatepicker('#date2Container');
            //reinitializeDatepicker('#date3Container');

        });

        app_dt_2_container.on('changeDate', function(ev){

            let formatedValue2 = moment(ev.date).format('YYYY-MM-DD HH:mm');
            $('[name="date_2"]').val(formatedValue2);

            removeKey(excludeDateApp, currentAppDt2);
            let date = new moment(ev.date).format('YYYY-MM-DD');
            console.log('prev Array ', excludeDateApp);
            if($.inArray(date, excludeDateApp) === -1){
                excludeDateApp.push(date);
                console.log('latest Key Array ', excludeDateApp);
            }

            //reinitializeDatepicker('#date1Container');
            reinitializeDatepicker('#date2Container');
            reinitializeDatepicker('#date3Container');

        });

        app_dt_3_container.on('changeDate', function(ev){

            let formatedValue3 = moment(ev.date).format('YYYY-MM-DD HH:mm');
            $('[name="date_3"]').val(formatedValue3);

            removeKey(excludeDateApp, currentAppDt3);
            let date = new moment(ev.date).format('YYYY-MM-DD');
            console.log('prev Array ', excludeDateApp);
            if($.inArray(date, excludeDateApp) === -1){
                excludeDateApp.push(date);
                console.log('latest Key Array ', excludeDateApp);
            }

            reinitializeDatepicker('#date1Container');
            reinitializeDatepicker('#date2Container');
            reinitializeDatepicker('#date3Container');
        });

    })
</script>
