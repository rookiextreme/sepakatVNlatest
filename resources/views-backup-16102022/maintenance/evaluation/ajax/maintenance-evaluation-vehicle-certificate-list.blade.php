<link rel="stylesheet" href="{{ asset('my-assets/plugins/fancybox/css/fancybox.css') }}">
<script src="{{ asset('my-assets/plugins/fancybox/js/fancybox.umd.js') }}"></script>

<style type="text/css">

</style>
@php
    $TaskFlowAccessMaintenanceEvaluation = auth()->user()->vehicleWorkFlow('02', '01');
@endphp
{{-- <textarea name="" class="form-control" id="" cols="30" rows="3">@json($TaskFlowAccessMaintenanceEvaluation)</textarea> --}}
<div class="table-responsive">
    <table id="fleet-ls" class="table-custom stripe no-footer">
        <thead>
            <th>Bil</th>
            <th>Milik</th>
            <th>No Pendaftaran</th>
            <th class="">Kategori > Sub-Kategori</th>
            <th class="">Jenis</th>
            <th class="" style="width: 50px;">Buatan</th>
            <th class="" style="width: 50px;">Model</th>
            <th class="">Status</th>
            <th class="text-center" style="width: 120px;"></th>
        </thead>
        <tbody>

            @foreach ($vehicleList as $vehicle)
                <tr>
                    <td>{{$loop->index+1}}</td>
                    <td>{{$vehicle->is_gover ? 'Kerajaan' : 'Awam'}}</td>
                    <td>{{$vehicle->plate_no}}</td>
                    <td>{{$vehicle->hasCategory->name}} > {{$vehicle->hasSubCategory? $vehicle->hasSubCategory->name : ''}}</td>
                    <td>{{$vehicle->hasSubCategoryType ? $vehicle->hasSubCategoryType->name : ''}}</td>
                    <td>{{$vehicle->hasVehicleBrand->name}}</td>
                    <td>{{$vehicle->model_name}}</td>
                    <td>{{$vehicle->hasMaintenanceVehicleStatus->desc}}</td>
                    <td class="text-center">
                        @if($vehicle->hasMaintenanceVehicleStatus->code == '04')
                            <a
                            style="height: unset;"
                            class="btn cux-btn small"
                            data-fancybox data-type="iframe"
                            href="{{route('jasperReport', ['format' => 'pdf', 'title' => 'Sijil Kenderaan', 'report_name' => 'assessment_vehicle_certificate', 'table_name' => 'assessment_accident', 'vehicle_id' => $vehicle->id])}}"
                            >
                            Lihat Sijil
                            </a>
                        @endif
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
</div>
@php
    $params = [
        // 'form_id' => 1
    ];
@endphp
{{$vehicleList->links('pagination.ajax-default', [
    'targetDivList' =>  '#maintenance_evaluation_vehicle_appointment',
    'params' => $params
])}}

<script type="text/javascript">
    $(document).ready(function(){


    });
</script>
