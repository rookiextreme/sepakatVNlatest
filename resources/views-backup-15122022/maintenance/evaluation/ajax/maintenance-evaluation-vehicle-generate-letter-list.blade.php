@php
    $AccessMaintenanceEvaluation = auth()->user()->vehicle('03', '02');
    $TaskFlowAccessMaintenanceEvaluation = auth()->user()->vehicleWorkFlow('03', '02');
@endphp
{{-- <textarea name="" class="form-control" id="" cols="30" rows="3">@json($TaskFlowAccessAssessmentAccident)</textarea> --}}
<div class="table-responsive">
    {{-- <table id="fleet-ls" class="table display compact stripe hover compact table-bordered"> --}}
        <table id="fleet-ls" class="table-custom stripe no-footer">
        <thead>
            <th style="width: 50px;">
                <input class="form-check-input" name="letter_chkall" id="letter_chkall" type="checkbox">
            </th>
            <th>Bil</th>
            <th>Milik</th>
            <th>No Pendaftaran</th>
            <th class="">Kategori > Sub-Kategori</th>
            <th class="">Jenis</th>
            <th class="" style="width: 50px;">Buatan</th>
            <th class="" style="width: 50px;">Model</th>
            <th class="" style="width: 100px;">Status</th>
            <th class="text-center" style="width: 150px;">
                @if($hasMaintenanceEvaluationDetail->hasStatus->code == '11')
                    Janaan Perihal Kerosakan
                    @else
                    Surat
                @endif
            </th>
        </thead>
        <tbody>

            @foreach ($vehicleList as $vehicle)
                <tr>
                    <td class="lcal-2 text-center">
                        @if($vehicle->hasTemplateLetter)
                            @if(in_array($vehicle->hasTemplateLetter->hasStatus->code, ['04']))
                                @if($vehicle->is_carry_over_maintenance == 0 || $vehicle->is_carry_over_maintenance == null)
                                    <input data-is_carry_over_maintenance="{{$vehicle->is_carry_over_maintenance}}" class="form-check-input" name="letter_chkdel" type="checkbox" value="{{$vehicle->id}}" id="letter_chkdel">
                                @endif
                            @endif
                        @endif
                    </td>
                    <td>{{$loop->index+1}}</td>
                    <td>{{$vehicle->is_gover ? 'Kerajaan' : 'Awam'}}</td>
                    <td>{{$vehicle->plate_no}}</td>
                    <td>{{$vehicle->hasCategory ? $vehicle->hasCategory->name : ''}} > {{$vehicle->hasSubCategory? $vehicle->hasSubCategory->name : ''}}</td>
                    <td>{{$vehicle->hasSubCategoryType ? $vehicle->hasSubCategoryType->name : ''}}</td>
                    <td>{{$vehicle->hasVehicleBrand->name}}</td>
                    <td>{{$vehicle->model_name}}</td>
                    <td>
                        @if($vehicle->is_carry_over_maintenance == 1)
                            Sedang diselengara
                        @endif
                    </td>
                    <td class="text-center">
                        @if($vehicle->hasTemplateLetter)
                            @php
                                $is_myApp = $vehicle && $vehicle->hasMaintenanceDetail->created_by == auth()->user()->id ? true: false;
                            @endphp
                            @if($vehicle->hasTemplateLetter->hasStatus->code == '04' && auth()->user()->isAdmin() || $is_myApp)
                            {{-- <label for="" class="form-label mb-2">
                                {{$vehicle->hasTemplateLetter->hasLetterType->desc}}
                            </label> --}}
                            @endif
                        @endif
                            <div class="btn-group">

                                @if($vehicle->hasTemplateLetter)
                                    
                                    @if($vehicle->hasTemplateLetter->hasStatus->code == '01' && $TaskFlowAccessMaintenanceEvaluation->mod_fleet_verify)
                                        <span class="btn cux-btn small" onclick="generateExamLetter({{$vehicle->id}}, '01')"> Sediakan Janaan Perihal Kerosakan</span>
                                    @elseif($vehicle->hasTemplateLetter->hasStatus->code == '03' && $TaskFlowAccessMaintenanceEvaluation->mod_fleet_approval)
                                        <span class="btn cux-btn small" onclick="generateExamLetter({{$vehicle->id}}, '01')"> Pengesahan Janaan Perihal Kerosakan</span>
                                    @elseif($vehicle->hasTemplateLetter->hasStatus->code == '04' && auth()->user()->isAdmin() ||
                                        $vehicle->hasTemplateLetter->hasStatus->code == '04' && $TaskFlowAccessMaintenanceEvaluation->mod_fleet_approval ||
                                        $vehicle->hasTemplateLetter->hasStatus->code == '04' && $is_myApp
                                    )
                                        @if($vehicle->hasTemplateLetter && $vehicle->hasTemplateLetter->exam_letter ? $vehicle->hasTemplateLetter->exam_letter : '')
                                            <button id="exam_letter_preview" onclick="pdfView(this)" class="btn cux-btn small" type="button" preview-url="/storage/public/dokumen/maintenance/evaluation/exam_letter/{{$vehicle->hasTemplateLetter->exam_letter}}"style="display:block"> Papar Surat Lampiran  </button>
                                        @else
                                        @endif
                                    <span data-url="{{route('jasperReport', ['format' => 'pdf', 'title' => $vehicle->hasTemplateLetter->exam_letter, 'report_name' => 'maintenance_eval_exam_letter', 'table_name' => 'maintenance_evaluation', 'vehicle_id' => $vehicle->id])}}" class="btn cux-btn small" onclick="fancyView(this)"> Papar Janaan Pemeriksaan </span>
                                    {{-- <span class="btn cux-btn small" onclick="view({{$vehicle->id}}, '01')"> Sediakan Janaan Perihal Kerosakan</span> --}}
                                    @else
                                    {{$vehicle->hasTemplateLetter->hasStatus->desc}}
                                    @endif

                                    @else
                                    @if(
                                        (in_array($vehicle->hasMaintenanceVehicleStatus->code, ['04','08']) && $TaskFlowAccessMaintenanceEvaluation->mod_fleet_verify)
                                        )
                                        <span class="btn cux-btn small" onclick="generateExamLetter({{$vehicle->id}}, '01')"> Janaan Perihal Kerosakan</span>
                                    @endif

                                @endif
                            </div>
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
    'targetDivList' =>  '#maintenance_evaluation_vehicle_generate_letter',
    'params' => $params
])}}

<script type="text/javascript">

    let pathUrl = null;
    let embed = null;

    const pdfView = function(self){
         const previewUrl = $(self).attr('preview-url');
         const url = pathUrl;

         const fancybox = new Fancybox([
         {
            src: previewUrl ? previewUrl: url,
            type: "iframe",
         },
         ]);
            fancybox.on("done", (fancybox, slide) => {
         });
      }

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

    const generateLetter = function(vehicle_id, maintenance_type_code){
        parent.startLoading();
        $.post("{{route('maintenance.vehicle-maintenance.generateLetter')}}", {
            maintenance_type_code: maintenance_type_code,
            vehicle_id: vehicle_id,
            tab: 5,
            '_token': '{{ csrf_token() }}'
        },  function(result){
            window.location.href = result.url;
        })
    }

    const generateExamLetter = function(vehicle_id, maintenance_type_code){
        parent.startLoading();
        $.post("{{route('maintenance.vehicle-maintenance.generateExamLetter')}}", {
            // maintenance_type_code: maintenance_type_code,
            vehicle_id: vehicle_id,
            tab: 5,
            '_token': '{{ csrf_token() }}'
        },  function(result){
            window.location.href = result.url;
        })
    }

    $(document).ready(function(){

    });
</script>
