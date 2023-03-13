@php
    $TaskFlowAccessAssessmentcurrvalue = auth()->user()->vehicleWorkFlow('02', '01');
@endphp
{{-- <textarea name="" class="form-control" id="" cols="30" rows="3">@json($TaskFlowAccessAssessmentcurrvalue)</textarea> --}}
<style type="text/css">
    .lcal-2 {
        width: 40px;
        text-align: center;
        padding-right:0px;
        padding-left:10px;
        padding-top:0px;
    }
    .lcal-2 .form-check-input {
        margin-left:4px;
        margin-top:2px;
    }
    .table-custom-local {
        border-spacing: 0;
        border-collapse: separate !important;
        border-color:#d7d7de;
        border-width: 2px;
    }
    .table-custom-local thead th:first-of-type {
        border-color:#d7d7de;
        border-left-width: 0px;
        border-top-width: 0px;
        border-bottom-width: 2px;
        border-right-width: 0px;
        text-align: center;
    }

    .table-custom-local thead th {
        border-color:#d7d7de;
        border-left-width: 0px;
        border-right-width: 0px;

        border-top-width: 0px;
        border-bottom-width: 2px;
        text-align: center;
        font-family:avenir-bold !important;
        font-size: 12px !important;
        color:#393728 !important;
        text-align: left;
        line-height: 12px;
        font-weight:200;
        text-transform: uppercase;
        vertical-align: bottom;
    }
    .table-custom-local thead th:last-of-type {
        border-radius: 0px 8px 0px 0px;
        -moz-border-radius: 0px 8px 0px 0px;
        -webkit-border-radius: 0px 8px 0px 0px;
        border-color:#d7d7de;
        border-left-width: 0px;
        border-bottom-width: 2px;
        border-right-width: 0px;
    }
    .table-custom-local thead th.special {
        background-color:#ffffff;
        border-radius: 8px 8px 0px 0px;
        -moz-border-radius: 8px 8px 0px 0px;
        -webkit-border-radius: 8px 8px 0px 0px;
    }
    .table-custom-local tbody tr {
        border-top-style: none;
        border-top-color: none;
        border-top-width: 0px;
    }
    .table-custom-local tbody tr td {
        border-right-color:#d7d7de;
        border-right-width: 0px;
        border-right-style: solid;
        border-left-color:#d7d7de;
        border-left-width: 0px;
        border-left-style: solid;
        border-top-style: none !important;
        border-top-color: none !important;
        font-family: mark;
        font-size:14px;
        height:18px;
        vertical-align: top !important;
        line-height:16px;
        border-bottom-style: none;
        border-bottom-color: #d7d7de;
        border-bottom-width: 1px;
    }
    .table-custom-local tbody tr td.special {
        background-color:#ffffff;
    }
    .table-custom-local tbody tr td:last-of-type {
        border-right-style: none;
        border-right-color:#d7d7de;
        border-right-width: 0px;
    }
    .table-custom-local tbody tr td a {
        font-family: mark-bold;
        text-decoration: none;
        font-size:14px;
        height:18px;
        color:#393728;
        vertical-align: top !important;
        line-height:16px;
        cursor: pointer;
    }
    .table-custom-local tbody tr td a:hover {
        color:orange;
    }
    .table-custom-local tfoot td {
        height:10px;
        line-height:10px;
        border-left-width: 0px;
        border-right-width: 0px;
        background-color:transparent !important;
    }
    .table-custom-local tfoot td.special {
        background-color:#ffffff !important;
        border-radius: 0px 0px 8px 8px;
        -moz-border-radius: 0px 0px 8px 8px;
        -webkit-border-radius: 0px 0px 8px 8px;
    }
    .edit-btn {
        padding-left:4px;
        padding-right:4px;
        padding-top:5px;
        padding-bottom:5px;
        text-align: center;
        border-color:#dcdcd8;
        font-family: mark;
        font-size: 12px;
        width:30px;
        border-color:#dcdcd8;
        border-width:2px;
        border-style:solid;
        margin-top:0px;
        cursor: pointer;
        margin:0px;
    }
    .edit-btn:hover {
        background-color:orange;
    }
    .lcal-btn {
        padding:0px;
        text-align:center;
        cursor: pointer;
        width:40px;
        padding-left:7px;
    }
    .lcal-btn:hover {
        text-align:center;
        background-color:#dce0d9;
        border-radius: 8px 8px 8px 8px;
        -moz-border-radius: 8px 8px 8px 8px;
        -webkit-border-radius: 8px 8px 8px 8px;
    }
</style>
@if(count($vehicleList) > 0)
<div class="table-responsive">
    <table class="table-custom no-footer stripe">
        <thead>
            @if($hasAssessmentCurrvalueDetail->hasStatus->code == '01')
                {{-- <th class="col-del">
                    <input class="form-check-input" name="chkall" id="chkall" type="checkbox">
                </th> --}}
                <th class="col-del"></th>
                <th class="col-del"></th>
            @endif
            <th>Bil</th>
            <th class="special">No Pendaftaran</th>
            <th>Tahun<br/>Dibuat</th>
            <th>Tarikh<br/>Didaftarkan</th>
            <th>Kategori <i class="fal fa-chevron-right"></i> Sub-Kategori</th>
            <th>Jenis</th>
            <th>Buatan</th>
            <th>Model</th>
            @if($hasAssessmentCurrvalueDetail->hasStatus->code == '08')
            <th>Senarai Semak</th>
            @endif
        </thead>
        <tbody>
            @foreach ($vehicleList as $index => $vehicle)
                <tr class="vehicle">
                    @if($hasAssessmentCurrvalueDetail->hasStatus->code == '01')
                        {{-- <td class="lcal-2 text-center">
                            <input class="form-check-input" name="chkdel" type="checkbox" value="{{$vehicle->id}}" id="chkdel">
                        </td> --}}
                        <td class="col-edit" data-current-page = "{{Request('page') ? Request('page') : 1}}" onclick="editAssessmentVehicle({{$vehicle->id}}, 'edit', this)">
                            <button type="button" class="btn" onClick="editAssessmentVehicle({{$vehicle->id}}, 'edit')"><i class="fa fa-pencil-alt"></i></button>
                        </td>
                        <td class="col-edit" onclick="editAssessmentVehicle({{$vehicle->id}}, 'duplicate')">
                            <button type="button" class="btn" onClick="editAssessmentVehicle({{$vehicle->id}}, 'duplicate')" title="Klon maklumat"><i class="fa fa-clone"></i></button>
                        </td>
                    @endif
                    <td>{{$vehicleList->firstItem() + $index}}</td>
                    {{-- <td>{{$loop->index+1}}</td> --}}
                    @if($hasAssessmentCurrvalueDetail->hasStatus->code == '01')
                        <td class="caps special" ><a data-current-page = "{{Request('page') ? Request('page') : 1}}" onclick="editAssessmentVehicle({{$vehicle->id}}, 'edit', this)" href="#" >{{$vehicle->plate_no}}</a></td>
                    @else
                        <td class="caps special"><a href="javascript:viewVehicle({{$vehicle->id}})">{{$vehicle->plate_no}}</a></td>
                    @endif
                    <td>{{$vehicle->manufacture_year}}</td>
                    <td class="caps">{{ Carbon\Carbon::parse($vehicle->registration_vehicle_dt)->format("d M Y")}}</td>
                    <td class="caps">{{$vehicle->hasCategory->name}} > {{$vehicle->hasSubCategory? $vehicle->hasSubCategory->name : ''}}</td>
                    <td>{{$vehicle->hasSubCategoryType ? $vehicle->hasSubCategoryType->name : ''}}</td>
                    <td>{{$vehicle->hasVehicleBrand->name}}</td>
                    <td>{{$vehicle->model_name}}</td>
                    @if($hasAssessmentCurrvalueDetail->hasStatus->code == '08')
                    <td>
                        <a
                            style="height: unset;"
                            class="btn cux-btn small"
                            title="Lihat Sijil"
                            data-fancybox data-type="iframe"
                            href="{{route('jasperReport', ['format' => 'pdf', 'title' => 'Senarai Semak', 'report_name' => 'assessment_currvalue_checklist', 'vehicle_id' => $vehicle->id])}}"
                            >
                            <i class="fas fa-file"></i> Senarai Semak
                        </a>
                    </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
@php
$params = [
    // 'form_id' => 1
    'assessment_currvalue_id' => $assessment_currvalue_id
];
@endphp
{{$vehicleList->links('pagination.ajax-default', [
   'targetDivList' =>  '#assessment_currvalue_vehicle',
   'params' => $params
])}}

<script type="text/javascript">

    function getCurrentChecked(){
        ids = [];
        $('#chkdel:checked').map(function() {
            ids.push(parseInt(this.value));
        });

        return ids;
    }

    $(document).ready(function(){

        let edit_purchaseDt = $('#edit_purchaseDt').datetimepicker({
            language:  'ms',
            todayBtn:  1,
            todayHighlight: 1,
            autoclose: 1,
            minView: 2,
            endDate: moment().format('YYYY-MM-DD'),
            pickerPosition: "top-right"
        }).on('changeDate', function(e){
            let formatedValue = moment(e.date).format('YYYY-MM-DD');
            $('#edit_purchase_dt').val(formatedValue);
            console.log(formatedValue);
        });

        let edit_registrationVehicleDt = $('#edit_registrationVehicleDt').datetimepicker({
            language:  'ms',
            todayBtn:  1,
            todayHighlight: 1,
            autoclose: 1,
            minView: 2,
            endDate: moment().format('YYYY-MM-DD'),
            pickerPosition: "top-right"
        }).on('changeDate', function(e){
            let formatedValue = moment(e.date).format('YYYY-MM-DD');
            $('#edit_registration_vehicle_dt').val(formatedValue);
            console.log(formatedValue);
        });

        let edit_manufactureYear = $('#edit_manufactureYear').datepicker({
            language:  'ms',
            keyboardNavigation: false,
            viewMode: "years",
            minViewMode: "years",
            todayBtn:  1,
            todayHighlight: 1,
            autoclose: 1,
            minView: 2,
            endDate: moment().format('YYYY'),
            pickerPosition: "top-right"
        }).on('changeDate', function(e){
            let formatedValue = moment(e.date).format('YYYY');
            $('#edit_manufacture_year').val(formatedValue);
            console.log(formatedValue);
        });

    });
</script>
