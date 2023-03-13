@php
    $TaskFlowAccessMaintenanceEvaluation = auth()->user()->vehicleWorkFlow('02', '01');
@endphp
<div class="table-responsive">
    <table class="table table-bordered no-footer" style="width: 100%">
        <thead>
            <th class="align-top" style="width: 50px;">Bil</th>
            {{-- @if($is_preview == 0) --}}
                <td class="align-top" style="width: 50px;"></td>
            {{-- @endif --}}
            <th class="align-top">Perincian Kerja</th>
            <th class="align-top">Simptom/Kerosakan</th>
            <th class="align-top">Keperluan Penukaran Alat Ganti</th>
            <th class="align-top">Anggaran</th>
        </thead>
        <tbody>
            @if ($letterCheckList->count() == 0)
                <tr>
                    <td class="text-center" colspan="5">Tiada Rekod</td>
                </tr>
            @endif
            @foreach ($letterCheckList as $letterCheck)
                <tr>
                    {{-- <td>2.{{$loop->index+1}}</td> --}}
                    <td>{{$loop->index+1}}</td>
                    {{-- @if($is_preview == 0) --}}
                        <td>
                            <div class="btn-group">
                                <span class="btn cux-btn small" data-id="{{$letterCheck->id}}" data-job-detail="{{$letterCheck->job_detail}}" data-syntom="{{$letterCheck->syntom}}" data-accessories="{{$letterCheck->accessories}}" data-budget="{{$letterCheck->budget}}" onclick="editLetterCheck(this)">
                                    <i class="fa fal fa-pen-nib"></i>
                                </span>
                                <span class="btn cux-btn small" data-id="{{$letterCheck->id}}" onclick="delLetterCheck(this)">
                                    <i class="fa fal fa-trash-alt"></i>
                                </span>
                            </div>
                        </td>
                    {{-- @endif --}}
                    <td>
                        {{$letterCheck->job_detail}}
                    </td>
                    <td>
                        {{$letterCheck->accessories}}
                    </td>
                    <td>
                        {{$letterCheck->syntom}}
                    </td>
                    <td>
                        RM {{number_format($letterCheck->budget, 2)}}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{-- {{$letterCheckList->links('pagination.ajax-maintenance-eval-template-letter')}} --}}

<script type="text/javascript">

    $(document).ready(function(){

    });
</script>
