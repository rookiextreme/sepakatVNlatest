<div class="container">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="position: relative;">
            <div class="spectitle">Dashboard Penyenggaraan : <span>{{auth()->user()->name}}</span></div>
            <div class="row">
                <div class="col-md-6">
                    <div class="my-date">{{date("d M Y")}}</div>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="search" onkeyup="searching(this)" class="form-control search" placeholder="Carian Plat No" value="">
                        <span class="input-group-text" style="border-width:1px;"><i class="fa fa-search"></i></span>
                    </div>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 top-shelf">
                    <div class="top-shelf-wrap">
                        <div style="width: 100%;display: flex;overflow-x: scroll;height: 123px;padding-left: 10px;">
                            @foreach ($maintenance_evaluation_vehicle_active_list as $maintenance_evaluation_vehicle_active)
                                <div class="active-box">
                                    <small style="font-size: 7px;">Penyelenggaraan Pemeriksaan Kerosakan</small>
                                    @php
                                        $mjevalcode = "01";
                                        if($maintenance_evaluation_vehicle_active->hasCategory && $maintenance_evaluation_vehicle_active->hasCategory->code == "02"){
                                            $mjevalcode = "03";
                                        }
                                    @endphp
                                    <div class="inside" onclick="generateFormExamination({{$maintenance_evaluation_vehicle_active->id}}, '{{$mjevalcode}}')">
                                        {{$maintenance_evaluation_vehicle_active->plate_no}}
                                    </div>
                                </div>
                            @endforeach
                            @foreach ($maintenance_job_vehicle_active_list as $maintenance_job_vehicle_active)
                                @php
                                    $repair_method_id = null;
                                    $showBtn = false;

                                    if($maintenance_job_vehicle_active->hasExamform->hasFormRepair->count() == 0 && $maintenance_job_vehicle_active->hasExamform &&
                                        //klo xda  research market
                                        $maintenance_job_vehicle_active->hasExamform->hasFormRepairInternal->first() &&
                                        in_array($maintenance_job_vehicle_active->hasExamform->hasFormRepairInternal->first()->code, ['07']) &&
                                        $maintenance_job_vehicle_active->hasExamform->hasFormRepairInternal->first()->hasRepairMethod && 
                                        $maintenance_job_vehicle_active->hasExamform->hasFormRepairInternal->first()->hasRepairMethod->code == '01'
                                        ){
                                        $repair_method_id = $maintenance_job_vehicle_active->hasExamform->hasFormRepairInternal->first()->id;
                                        $showBtn = true;
                                    } elseif($maintenance_job_vehicle_active->hasExamform->hasFormRepair->count() > 0 && $maintenance_job_vehicle_active->hasExamform &&
                                        //klo ada research market
                                        $maintenance_job_vehicle_active->hasExamform->hasFormRepairInternal->first() &&
                                        $maintenance_job_vehicle_active->hasExamform->hasFormRepairInternal->first()->hasInternalRepairStatus &&
                                        in_array($maintenance_job_vehicle_active->hasExamform->hasFormRepairInternal->first()->hasInternalRepairStatus->code, ['07']) &&
                                        $maintenance_job_vehicle_active->hasExamform->hasFormRepairInternal->first()->hasRepairMethod &&
                                        $maintenance_job_vehicle_active->hasExamform->hasFormRepairInternal->first()->hasRepairMethod->code == '01'
                                        ){
                                        $repair_method_id = $maintenance_job_vehicle_active->hasExamform->hasFormRepairInternal->first()->hasRepairMethod->id;
                                        $showBtn = true;
                                    } else if($maintenance_job_vehicle_active->hasExamform->hasFormRepair->count() == 0 && $maintenance_job_vehicle_active->hasExamform &&
                                            //klo x ada research market 
                                        $maintenance_job_vehicle_active->hasExamform->hasFormRepairExternal->first() &&
                                        in_array($maintenance_job_vehicle_active->hasExamform->hasFormRepairExternal->first()->code, ['08']) &&
                                        $maintenance_job_vehicle_active->hasExamform->hasFormRepairExternal->first()->hasRepairMethod &&
                                        $maintenance_job_vehicle_active->hasExamform->hasFormRepairExternal->first()->hasRepairMethod->code == '02'
                                        ){
                                        $repair_method_id = $maintenance_job_vehicle_active->hasExamform->hasFormRepairExternal->first()->id;
                                        $showBtn = true;
                                    } else if(
                                        $maintenance_job_vehicle_active->hasExamform->hasFormRepair->count() > 0 && $maintenance_job_vehicle_active->hasExamform &&
                                        //klo ada research market
                                        $maintenance_job_vehicle_active->hasExamform->hasFormRepairExternal->first() &&
                                        $maintenance_job_vehicle_active->hasExamform->hasFormRepairExternal->first()->hasExternalRepairStatus && 
                                        in_array($maintenance_job_vehicle_active->hasExamform->hasFormRepairExternal->first()->hasExternalRepairStatus->code, ['08']) &&
                                        $maintenance_job_vehicle_active->hasExamform->hasFormRepairExternal->first()->hasRepairMethod &&
                                        $maintenance_job_vehicle_active->hasExamform->hasFormRepairExternal->first()->hasRepairMethod->code == '02'
                                        ){
                                            if(!$maintenance_job_vehicle_active->hasExamform->hasInternalRepairStatus || $maintenance_job_vehicle_active->hasExamform->hasInternalRepairStatus->code == '03'){
                                                $repair_method_id = $maintenance_job_vehicle_active->hasExamform->hasFormRepairExternal->first()->hasRepairMethod->id;
                                            }
                                        $showBtn = true;
                                    } elseif($maintenance_job_vehicle_active->hasExamform->hasMaintenanceJobVehicleStatus->code == '02'){
                                        $showBtn = true;
                                    }
                                @endphp
                                @if($showBtn)
                                    <div class="active-box">
                                        <small style="font-size: 7px;">Penyelenggaraan Servis Dan Pembaikan</small>
                                        <div class="inside" data-repair_method_id="{{$repair_method_id}}" onclick="generateFormExamination({{$maintenance_job_vehicle_active->id}}, '02', this)">
                                            {{$maintenance_job_vehicle_active->plate_no}}
                                        </div>
                                    </div>

                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="curve" style="background-image: url({{asset('my-assets/img/curve.png')}});">Sedang Berjalan<br/><i class="fal fa-arrow-right mt-2"></i></div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 shelf">
                    <div class="jobtype nav-link collapsed" data-bs-toggle="collapse" href="#maintenance_evaluation">Penyelenggaraan Pemeriksaan Kerosakan 
                        <span id="maintenance_evaluation_total">{{count($maintenance_evaluation_vehicle_list)}}</span>
                    </div>
                    <div style="width: 100%;" id="maintenance_evaluation" class="collapse">
                        <div>
                            @foreach ($maintenance_evaluation_vehicle_list as $maintenance_evaluation_vehicle)
                                <div class="job-box" onclick="promptFormExamination({{$maintenance_evaluation_vehicle->id}}, '{{$maintenance_evaluation_vehicle->plate_no}}', '01'); $('#modal_title').text('Mulakan Penyelenggaraan Pemeriksaan Kerosakan')">
                                    <table style="width: 250px; height: 70px; white-space: initial;">
                                        <tr>
                                            <td style="width: 100px;vertical-align: bottom; {{strlen($maintenance_evaluation_vehicle->plate_no) > 10 ? 'font-size:16px;' :''}}" class="plate-no text-start text-white">{{$maintenance_evaluation_vehicle->plate_no}}</td>
                                            <td style="{{strlen($maintenance_evaluation_vehicle->hasMaintenanceDetail->department_name) > 30 ? 'font-size:10px;' :''}}" class="department-name text-white text-start ps-2" style="vertical-align: middle;" colspan="2" rowspan="2">
                                                {{$maintenance_evaluation_vehicle->hasMaintenanceDetail->department_name}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 100px;vertical-align: top;" class="department-dt text-start text-white">{{\Carbon\Carbon::parse($maintenance_evaluation_vehicle->hasMaintenanceDetail->appointment_dt)->format('d/m/Y')}}</td>
                                        </tr>
                                    </table>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 shelf">
                    <div class="jobtype nav-link collapsed" data-bs-toggle="collapse" href="#maintenance_job">Penyelenggaraan Servis Dan Pembaikan 
                        <span id="maintenance_job_total">{{count($maintenance_job_vehicle_list)}}</span>
                    </div>
                    <div style="width: 100%;" id="maintenance_job" class="collapse">
                        <div>
                            @foreach ($maintenance_job_vehicle_list as $maintenance_job_vehicle)

                            @php
                                $repair_method_id = null;
                                
                                if($maintenance_job_vehicle->hasExamform->hasFormRepair->count() == 0 && $maintenance_job_vehicle->hasExamform &&
                                    //klo xda research market (tiada form repair)
                                    $maintenance_job_vehicle->hasExamform->hasFormRepairInternal->first() &&
                                    in_array($maintenance_job_vehicle->hasExamform->hasFormRepairInternal->first()->code, ['01']) &&
                                    $maintenance_job_vehicle->hasExamform->hasFormRepairInternal->first()->hasRepairMethod && 
                                    $maintenance_job_vehicle->hasExamform->hasFormRepairInternal->first()->hasRepairMethod->code == '01' &&
                                    $maintenance_job_vehicle->hasExamform->hasFormRepairInternal->first()->is_research_market == 0
                                    ){
                                    // echo "1";
                                    $repair_method_id = $maintenance_job_vehicle->hasExamform->hasFormRepairInternal->first()->id;
                                } elseif($maintenance_job_vehicle->hasExamform->hasFormRepair->count() > 0 && $maintenance_job_vehicle->hasExamform &&
                                    //klo ada research market internal
                                    $maintenance_job_vehicle->hasExamform->hasFormRepairInternal->first() &&
                                    $maintenance_job_vehicle->hasExamform->hasFormRepairInternal->first()->hasInternalRepairStatus &&
                                    in_array($maintenance_job_vehicle->hasExamform->hasFormRepairInternal->first()->hasInternalRepairStatus->code, ['01']) &&
                                    $maintenance_job_vehicle->hasExamform->hasFormRepairInternal->first()->hasRepairMethod->code == '01' &&                                    
                                    $maintenance_job_vehicle->hasExamform->hasFormRepairInternal->first()->hasRepairMethod &&
                                    $maintenance_job_vehicle->hasExamform->hasFormRepairInternal->first()->is_research_market == 1 
                                    ){
                                    // echo "2";
                                    $repair_method_id = $maintenance_job_vehicle->hasExamform->hasFormRepairInternal->first()->hasRepairMethod->id;
                                } 
                                else if($maintenance_job_vehicle->hasExamform->hasFormRepair->count() > 0 && $maintenance_job_vehicle->hasExamform &&
                                    //klo x ada research market internal tidak perlu 
                                    $maintenance_job_vehicle->hasExamform->hasFormRepairInternal->first() &&
                                    $maintenance_job_vehicle->hasExamform->hasFormRepairInternal->first()->hasInternalRepairStatus && 
                                    in_array($maintenance_job_vehicle->hasExamform->hasFormRepairInternal->first()->hasInternalRepairStatus->code, ['01']) &&
                                    $maintenance_job_vehicle->hasExamform->hasFormRepairInternal->first()->hasRepairMethod &&
                                    $maintenance_job_vehicle->hasExamform->hasFormRepairInternal->first()->hasRepairMethod->code == '01' &&
                                    $maintenance_job_vehicle->hasExamform->hasFormRepairInternal->first()->is_research_market == 0
                                    ){
                                    // echo "3";
                                    $repair_method_id = $maintenance_job_vehicle->hasExamform->hasFormRepairInternal->first()->hasRepairMethod->id;
                                }
                                else if($maintenance_job_vehicle->hasExamform->hasFormRepair->count() > 0 && $maintenance_job_vehicle->hasExamform &&
                                    //klo x ada research market internal sebut harga
                                    $maintenance_job_vehicle->hasExamform->hasFormRepairInternal->first() &&
                                    $maintenance_job_vehicle->hasExamform->hasFormRepairInternal->first()->hasInternalRepairStatus && 
                                    in_array($maintenance_job_vehicle->hasExamform->hasFormRepairInternal->first()->hasInternalRepairStatus->code, ['01']) &&
                                    $maintenance_job_vehicle->hasExamform->hasFormRepairInternal->first()->hasRepairMethod &&
                                    $maintenance_job_vehicle->hasExamform->hasFormRepairInternal->first()->hasRepairMethod->code == '01' &&
                                    $maintenance_job_vehicle->hasExamform->hasFormRepairInternal->first()->is_research_market == 2
                                    ){
                                    // echo "4";
                                    $repair_method_id = $maintenance_job_vehicle->hasExamform->hasFormRepairInternal->first()->hasRepairMethod->id;
                                }
                                else if($maintenance_job_vehicle->hasExamform->hasFormRepair->count() == 0 && $maintenance_job_vehicle->hasExamform &&
                                    //klo x ada research market external (tiada form repair)
                                    $maintenance_job_vehicle->hasExamform->hasFormRepairExternal->first() &&
                                    in_array($maintenance_job_vehicle->hasExamform->hasFormRepairExternal->first()->code, ['04']) &&
                                    $maintenance_job_vehicle->hasExamform->hasFormRepairExternal->first()->hasRepairMethod &&
                                    $maintenance_job_vehicle->hasExamform->hasFormRepairExternal->first()->hasRepairMethod->code == '02'
                                    ){
                                    // echo "5";
                                    $repair_method_id = $maintenance_job_vehicle->hasExamform->hasFormRepairExternal->first()->id;
                                } else if($maintenance_job_vehicle->hasExamform->hasFormRepair->count() > 0 && $maintenance_job_vehicle->hasExamform &&
                                    //klo ada research market external
                                    $maintenance_job_vehicle->hasExamform->hasFormRepairExternal->first() &&
                                    $maintenance_job_vehicle->hasExamform->hasFormRepairExternal->first()->hasExternalRepairStatus && 
                                    in_array($maintenance_job_vehicle->hasExamform->hasFormRepairExternal->first()->hasExternalRepairStatus->code, ['04']) &&
                                    $maintenance_job_vehicle->hasExamform->hasFormRepairExternal->first()->hasRepairMethod &&
                                    $maintenance_job_vehicle->hasExamform->hasFormRepairExternal->first()->hasRepairMethod->code == '02' &&
                                    $maintenance_job_vehicle->hasExamform->hasFormRepairExternal->first()->is_research_market == 1 
                                    ){
                                    // echo "6";
                                    $repair_method_id = $maintenance_job_vehicle->hasExamform->hasFormRepairExternal->first()->hasRepairMethod->id;
                                }
                                else if($maintenance_job_vehicle->hasExamform->hasFormRepair->count() > 0 && $maintenance_job_vehicle->hasExamform &&
                                    //klo x ada research market external tidak perlu
                                    $maintenance_job_vehicle->hasExamform->hasFormRepairExternal->first() &&
                                    $maintenance_job_vehicle->hasExamform->hasFormRepairExternal->first()->hasExternalRepairStatus && 
                                    in_array($maintenance_job_vehicle->hasExamform->hasFormRepairExternal->first()->hasExternalRepairStatus->code, ['04']) &&
                                    $maintenance_job_vehicle->hasExamform->hasFormRepairExternal->first()->hasRepairMethod &&
                                    $maintenance_job_vehicle->hasExamform->hasFormRepairExternal->first()->hasRepairMethod->code == '02' &&
                                    $maintenance_job_vehicle->hasExamform->hasFormRepairExternal->first()->is_research_market == 0
                                    ){
                                    // echo "7";
                                    $repair_method_id = $maintenance_job_vehicle->hasExamform->hasFormRepairExternal->first()->hasRepairMethod->id;
                                }
                                else if($maintenance_job_vehicle->hasExamform->hasFormRepair->count() > 0 && $maintenance_job_vehicle->hasExamform &&
                                    //klo x ada research market external sebut harga
                                    $maintenance_job_vehicle->hasExamform->hasFormRepairExternal->first() &&
                                    $maintenance_job_vehicle->hasExamform->hasFormRepairExternal->first()->hasExternalRepairStatus && 
                                    in_array($maintenance_job_vehicle->hasExamform->hasFormRepairExternal->first()->hasExternalRepairStatus->code, ['04']) &&
                                    $maintenance_job_vehicle->hasExamform->hasFormRepairExternal->first()->hasRepairMethod &&
                                    $maintenance_job_vehicle->hasExamform->hasFormRepairExternal->first()->hasRepairMethod->code == '02' &&
                                    $maintenance_job_vehicle->hasExamform->hasFormRepairExternal->first()->is_research_market == 2
                                    ){
                                    // echo "8";
                                    $repair_method_id = $maintenance_job_vehicle->hasExamform->hasFormRepairExternal->first()->hasRepairMethod->id;
                                }
 
                            @endphp
                            

                            <div class="job-box" data-repair_method_id="{{$repair_method_id}}" onclick="promptFormExamination({{$maintenance_job_vehicle->id}}, '{{$maintenance_job_vehicle->plate_no}}', '02', this); $('#modal_title').text('Mulakan Penyelenggaraan Servis Dan Pembaikan')">
                                <table style="width: 250px; height: 70px; white-space: initial;">
                                    <tr>
                                        <td style="width: 100px;vertical-align: bottom; {{strlen($maintenance_job_vehicle->plate_no) > 10 ? 'font-size:16px;' :''}}" class="plate-no text-start text-white">{{$maintenance_job_vehicle->plate_no}}</td>
                                        <td style="{{strlen($maintenance_job_vehicle->hasMaintenanceDetail->department_name) > 30 ? 'font-size:10px;' :''}}" class="department-name text-white text-start ps-2" style="vertical-align: middle;" colspan="2" rowspan="2">
                                            {{$maintenance_job_vehicle->hasMaintenanceDetail->department_name}}
                                            @if(env('APP_ENV') == 'local')
                                                <ul class="list-group">
                                                    @foreach ($maintenance_job_vehicle->hasManyPurposeType()->get() as $purposeType)
                                                        <li class="list-group-item ">{{$purposeType->desc}}</li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 100px;vertical-align: top;" class="department-dt text-start text-white">{{\Carbon\Carbon::parse($maintenance_job_vehicle->hasMaintenanceDetail->appointment_dt)->format('d/m/Y')}}</td>
                                    </tr>
                                </table>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 shelf"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="maintenanceConfirmationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="maintenanceConfirmationModalLabel" aria-hidden="true" style="background-color: #f4f5f2;">
    <div class="modal-dialog">
    <div class="modal-content">
        <form id="gotoFormExamination">
            @csrf
            <div class="modal-header">
            </div>
            <div class="modal-body">
                <span id="modal_title"></span> bagi no kenderaan: <label for="" class="form-label fs-5" id="selected_plate_no"></label>
                <input type="hidden" class="vehicle_id" name="vehicle_id">
                <input type="hidden" class="maintenance_evaluation_id" name="maintenance_evaluation_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <span type="button" class="btn btn-primary" onclick="generateFormExamination()" >Ya</button>
            </div>
        </form>
    </div>
    </div>
</div>

<script>

    let selected_vehicle_id = null;
    let maintenance_type_code = null;
    let selected_repair_method_id = null;

    searching = function(self, mode){
        let value = self.value;
        if(mode == 'clear'){
            value = '';
        }
        $('.job-box, .active-box').each(function(){
        if($(this).text().toUpperCase().indexOf(value.toUpperCase()) != -1){
            $(this).show();
        } else {$(this).hide()}
        });

        updateTotal();
    }

    updateTotal = function(self){

        let maintenance_evaluation_total = $('#maintenance_evaluation_total');
        maintenance_evaluation_total.text(maintenance_evaluation_total.parent().parent().find('.job-box:visible').length);

        let maintenance_job_total = $('#maintenance_job_total');
        maintenance_job_total.text(maintenance_job_total.parent().parent().find('.job-box:visible').length);

    }

    promptFormExamination = function(vehicle_id, plate_no, maintenance_type_code_selected, self){
        maintenance_type_code = maintenance_type_code_selected;
        selected_vehicle_id = vehicle_id;
        selected_repair_method_id = $(self).data('repair_method_id')
        $('#selected_plate_no').text(plate_no);
        $('#maintenanceConfirmationModal').modal('show');
    }

    generateFormExamination = function(vehicle_id, maintenance_type_code_selected, self){
        if(vehicle_id){
            selected_vehicle_id = vehicle_id;
        }
        if(maintenance_type_code_selected){
            maintenance_type_code = maintenance_type_code_selected;
        }

        if($(self).data('repair_method_id')){
            selected_repair_method_id = $(self).data('repair_method_id');
        }
        

        parent.startLoading();
        $.post("{{route('maintenance.vehicle-maintenance.generateForm')}}", {
            maintenance_type_code: maintenance_type_code,
            vehicle_id: selected_vehicle_id,
            repair_method_id: selected_repair_method_id,
            '_token': '{{ csrf_token() }}'
        },  function(result){
            window.location.href = result.url;

        })
    }

    jQuery(document).ready(function() {
        $('input[type=search]').on('search', function () {
            searching(this, 'clear');
        });
    })
</script>