<link rel="stylesheet" href="{{ asset('my-assets/plugins/fancybox/css/fancybox.css') }}">
<script src="{{ asset('my-assets/plugins/fancybox/js/fancybox.umd.js') }}"></script>

<style type="text/css">

</style>
@php
    $TaskFlowAccessAssessmentcurrvalue = auth()->user()->vehicleWorkFlow('02', '01');
@endphp
{{-- <textarea name="" class="form-control" id="" cols="30" rows="3">@json($TaskFlowAccessAssessmentcurrvalue)</textarea> --}}
<div class="table-responsive">
    <table id="fleet-ls" class="table-custom no-footer stripe">
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

            @foreach ($vehicleList as $index => $vehicle)
                <tr>
                    <td>{{$vehicleList->firstItem() + $index}}</td>
                    <td>{{$vehicle->is_gover ? 'Kerajaan' : 'Awam'}}</td>
                    <td>{{$vehicle->plate_no}}</td>
                    <td>{{$vehicle->hasCategory->name}} > {{$vehicle->hasSubCategory? $vehicle->hasSubCategory->name : ''}}</td>
                    <td>{{$vehicle->hasSubCategoryType ? $vehicle->hasSubCategoryType->name : ''}}</td>
                    <td>{{$vehicle->hasVehicleBrand->name}}</td>
                    <td>{{$vehicle->model_name}}</td>
                    <td>{{$vehicle->hasAssessmentVehicleStatus->desc}}</td>
                    <td class="text-center">
                        @if($vehicle->hasAssessmentVehicleStatus->code == '06')
                            <div class="btn-group">
                                @if (auth()->user()->isAssistEngineerAssessment() || auth()->user()->isEngineerAssessment() || auth()->user()->isEngineer() || auth()->user()->isAssistEngineer() || auth()->user()->isAdmin())
                                    <a
                                    style="height: unset;"
                                    class="btn cux-btn small"
                                    title="Edit Sijil"
                                    onclick="editCertificate({{$vehicle->id}}, {{$hasAssessmentCurrvalueDetail->id}})"
                                    >
                                    <i class="fas fa-pencil-alt"></i>
                                    </a>
                                @endif
                                <a
                                style="height: unset;"
                                class="btn cux-btn small"
                                title="Lihat Sijil"
                                data-fancybox data-type="iframe"
                                href="{{route('jasperReport', ['format' => 'pdf', 'title' => 'Sijil Harga Semasa', 'report_name' => 'assessment_certificate_currvalue', 'vehicle_id' => $vehicle->id])}}"
                                >
                                <i class="fas fa-file-certificate"></i>
                                </a>

                            </div>
                        @endif
                        {{-- @if($vehicle->hasAssessmentVehicleStatus->code == '06')
                            <a
                            style="height: unset;"
                            class="btn cux-btn small"
                            data-fancybox data-type="iframe"
                            href="{{route('jasperReport', ['format' => 'pdf', 'title' => 'Sijil Harga Semasa', 'report_name' => 'assessment_certificate_currvalue', 'vehicle_id' => $vehicle->id])}}"
                            >
                            Lihat Sijil
                            </a>
                        @endif --}}
                        {{-- <span onclick="parent.openPgInFrame('{{route('assessment.currvalue.vehicle-assessment.viewCertificate', ['vehicle_id' => $vehicle->id])}}')" class="btn cux-btn small">Lihat Sijil</span> --}}
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
</div>
@php
$params = [
    // 'form_id' => 1
    'assessment_currvalue_id' => $assessment_currvalue_id
];
@endphp
{{$vehicleList->links('pagination.ajax-default', [
   'targetDivList' =>  '#assessment_currvalue_vehicle_certificate',
   'params' => $params
])}}

<script type="text/javascript">
    $(document).ready(function(){


    });
</script>
