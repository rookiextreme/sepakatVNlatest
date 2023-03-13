<link rel="stylesheet" href="{{ asset('my-assets/plugins/fancybox/css/fancybox.css') }}">
<script src="{{ asset('my-assets/plugins/fancybox/js/fancybox.umd.js') }}"></script>

<style type="text/css">

</style>
@php
    $TaskFlowAccessAssessmentDisposal = auth()->user()->vehicleWorkFlow('02', '01');
@endphp
{{-- <textarea name="" class="form-control" id="" cols="30" rows="3">@json($TaskFlowAccessAssessmentDisposal)</textarea> --}}
<div class="table-responsive">
    <table id="fleet-ls" class="table-custom no-footer mt-0 stripe">
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
                    <td>{{$vehicle->hasCategory ? $vehicle->hasCategory->name : '-'}} > {{$vehicle->hasSubCategory ? $vehicle->hasSubCategory->name : '-'}}</td>
                    <td>{{$vehicle->hasSubCategoryType ? $vehicle->hasSubCategoryType->name : '-'}}</td>
                    <td>{{$vehicle->hasVehicleBrand ? $vehicle->hasVehicleBrand->name : '-'}}</td>
                    <td>{{$vehicle->model_name}}</td>
                    <td>{{$vehicle->hasAssessmentVehicleStatus ? $vehicle->hasAssessmentVehicleStatus->desc : '-'}}</td>
                    <td class="text-center">
                        @if($vehicle->hasAssessmentVehicleStatus->code == '06')
                            <div class="btn-group">
                                {{-- <a
                                style="height: unset;"
                                class="btn cux-btn small"
                                title="Cetak Surat Pelupusan"
                                data-url="{{route('assessment.disposal.disposal-letter', ['assessment_id' => 'Penilaian Kenderaan Baharu'])}}"
                                onclick="editCertificate({{$vehicle->id}}, {{$hasAssessmentDisposalDetail->id}})"
                                >
                                <i class="fas fa-file-alt"></i>
                                </a> --}}
                                <a
                                style="height: unset;"
                                class="btn cux-btn small"
                                data-fancybox data-type="iframe"
                                title="Cetak KEW.PA-19"
                                href="{{route('jasperReport', ['format' => 'pdf', 'title' => 'KEW.PA-19', 'report_name' => 'disposal_certificate', 'assessment_disposal_vehicle_id' => $vehicle->id])}}"
                                >
                                <i class="fas fa-file-certificate"></i>
                                </a>
                            </div>
                            {{-- <a
                            style="height: unset;"
                            class="btn cux-btn small"
                            data-fancybox data-type="iframe"
                            href="{{route('jasperReport', ['format' => 'pdf', 'title' => 'KEW.PA-19', 'report_name' => 'disposal_certificate', 'assessment_disposal_vehicle_id' => $vehicle->id])}}"
                            >
                            Lihat KEW.PA-19
                            </a> --}}
                        @endif
                        {{-- <span onclick="parent.openPgInFrame('{{route('assessment.accident.vehicle-assessment.viewCertificate', ['vehicle_id' => $vehicle->id])}}')" class="btn cux-btn small">Lihat Sijil</span> --}}
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
</div>
@php
$params = [
    // 'form_id' => 1
    'assessment_disposal_id' => $assessment_disposal_id
];
@endphp
{{$vehicleList->links('pagination.ajax-default', [
   'targetDivList' =>  '#assessment_disposal_vehicle_certificate',
   'params' => $params
])}}

<script type="text/javascript">
    $(document).ready(function(){


    });
</script>
