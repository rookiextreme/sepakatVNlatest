
@php
$TaskFlowAccessAssessmentcurrvalue = auth()->user()->vehicleWorkFlow('02', '01');
$assessment_id = Request('id');
use App\Models\Assessment\AssessmentCurrvalueVehicle;
$vehicleDetails = AssessmentCurrvalueVehicle::where('assessment_currvalue_id', $assessment_id)
                                            ->whereHas('hasAssessmentVehicleStatus', function($q){
                                                $q->where('code', '03');
                                            })->get();
$total_price = 0.00;
foreach ($detail->hasVehicleMany as $vehicle) {
    $total_price += $vehicle->vehicle_price;
}

$prev_page = Request('prev_page') ? Request('prev_page') : 1;
$status_code = Request('status_code') ? Request('status_code') : 'all_inprogress';

@endphp

<style>

    .img-del {
                position: absolute;
                right:8px;
                top:-8px;width:30px;height:30px;background-color:red;border-radius:17px;text-align:center;padding-top:4px;
                cursor:pointer;
            }
    .img-del:hover {
        background-color:orange;
    }
</style>

<form class="row" id="frm_approval" enctype="multipart/form-data">

    @csrf

    <input type="hidden" name="section" value="approval">
    <fieldset>
        <legend>Maklumat Pembayaran</legend>
        <div class="row">
            <div class="col-xl-9 col-lg-10 col-md-12 col-sm-12 col-12 pt-2">
                <div class="row">
                    <div class="col-xl-2 col-lg-2 col-md-3 col-sm-3 col-12">
                        <div class="form-group">
                            <label for="" class="form-label text-dark">Jumlah Bayaran </label>
                            <div class="txt-data ass_gov mt-2"><small>RM</small> {{number_format($total_price, 2, '.', ',')}}</div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-3 col-sm-3 col-12">
                        <div class="form-group">
                            <label for="" class="form-label text-dark">No Kerja</label>
                            {{-- <input type="text" class="form-control" name="receipt_no" id="receipt_no" value="{{$AssessmentNewVehicle->hasAssessmentDetail->hasBpkNo->code}}" style="max-width:130px" maxlength="10"> --}}
                            <div class="txt-data ass_gov mt-2">{{$detail->hasBpkNo->code}}</div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-3 col-12">
                        <label for="" class="form-label text-dark">No Resit</label>
                        {{-- @if(empty($detail->no_receipt)) --}}
                            <input type="text" class="form-control"  data-id="{{$detail->id}}" onchange="this.value = this.value.toUpperCase(); saveReceipt(this);" name="receipt_no" id="receipt_no" value="{{$detail->no_receipt}}" maxlength="30">
                        {{-- @else
                            <div class="txt-data ass_gov mt-2">{{$detail->no_receipt}}</div>
                        @endif --}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-5 col-sm-5 col-12">
                        <div class="form-group">
                            <label for="" class="form-label  text-dark">Resit Bayaran <span class="text-danger">{{$detail->total_price > 0 ? "*" : " "}}</span></label>
                            <div class="col-md-9"><label for="receipt_doc" class="btn cux-btn bigger"><i class="fas fa-image"></i> Muat Naik Gambar</label></div>
                            <input onchange="uploadFileReceipt(this)" data-id="{{$detail->id}}" data-lvl="receipt_doc" class="form-control d-none" accept="image/*" type="file" id="receipt_doc" />
                            </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-5 col-sm-5 col-12" id="reload_receipt">
                        @if ($detail->hasReceiptDoc)
                            @php
                                $path = '';
                                $docName = '';
                                if($detail->hasReceiptDoc){
                                    $path = $detail->hasReceiptDoc->doc_path;
                                    $docName = $detail->hasReceiptDoc->doc_name;
                                }
                            @endphp
                            <input type="hidden" name="receipt_file" id="receipt_file" value="{{$docName}}">
                            <div style="position:relative; width:150px;">
                                <div class="img-del" onclick="deleteRelatedDoc({{$detail->id}}, 'receipt_doc', {{$detail->receipt_doc}})"><i class="fa fa-times icon-white"></i></div>
                                <img id="preview_receipt" onclick="openEnlargeModal(this)" src="/storage/{{$path.'/'.$docName}}" alt="" width="100px" class="cursor-pointer" style="display: {{$detail->hasReceiptDoc ? 'block' :'none'}}">
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
    <fieldset>
        <legend>Maklumat Penilaian</legend>
        <!--<div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                <div class="workflow-box">
                    <div class="form-group">
                        <label for="" class="form-label">Penilaian</label>
                        <div class="txt-data ass_gov">MOHD AMIN BIN DOLLAH<br/><small>14 Sep 2021 2:00 pm</small></div>
                    </div>
                </div>
                <div class="workflow-box">
                    <div class="form-group">
                        <label for="" class="form-label">Semakan</label>
                        <div class="txt-data ass_gov">MOHD RAMADY BIN MOHD ZAINUL<br/><small>14 Sep 2021 2:00 pm</small></div>
                    </div>
                </div>
                <div class="workflow-box">
                    <div class="form-group">
                        <label for="" class="form-label">Pengesahan</label>
                        <div class="txt-data ass_gov">MOHD RAMADY BIN MOHD ZAINUL<br/><small>14 Sep 2021 2:00 pm</small></div>
                    </div>
                </div>
            </div>
        </div>-->
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-12" id="assessment_currvalue_vehicle_evaluation">

            </div>
        </div>
    </fieldset>
    @if($detail->hasStatus->code == '04')
        <div class="col-md-12 form-group">
            <div class="row">
                <div class="col-md-12 mt-2 mb-2">
                    <div class="form-group center">
                        {{-- <span class="btn btn-module" onclick="prompAssessmentcurrvalueEvaluateModal()">Hantar</span> --}}
                        {{-- <span class="btn btn-danger" onclick="prompAssessmentcurrvalueRevokeModal()">Tolak</a> --}}
                    </div>
                </div>
            </div>
        </div>
    @endif

</form>

<!--<div class="modal fade" id="assessmentcurrvalueEvaluationModal" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="assessmentcurrvalueEvaluationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h3 class="title"></h3>
                <p class="sub-title">
                    Adakah anda ingin meneruskan untuk pengesahan?
                </p>
            </div>
            <div class="modal-footer float-start">
                <button type="button" id="close" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-secondary text-white" onclick="assessmentVehicleEvaluate(this)">Ya</button>
            </div>
        </div>
    </div>
</div>-->

<div class="modal fade modal-asking" id="assessmentcurrvalueEvaluationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="assessmentcurrvalueEvaluationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="row" id="frm_examination">
            @csrf
            <div class="modal-content awas" style="height:250px;background-image: url({{asset('my-assets/img/awas.png')}});">
                <div class="modal-body pt-5">
                    <div class="asking">
                        Hantar hasil penilaian<br/>kepada Jurutera untuk kelulusan?
                    </div>
                    <input type="hidden" name="section" value="examination">
                </div>
                <div class="modal-footer justify-content-start">
                    <button class="btn btn-module" type="button" onclick="assessmentVehicleEvaluate(this)">Ya</button>
                    <button type="button" class="btn btn-link" id="close" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">

    prompAssessmentcurrvalueEvaluateModal = function(){
        $('#assessmentcurrvalueEvaluationModal').modal('show');
    }

    loadAssessmentcurrvalueVehicleEvaluation = function() {
        let data = {
            'status_code': '{{$status_code}}'
        };
        $.get("{{ route('assessment.currvalue.vehicle-evaluation.list', ['page' => $prev_page]) }}", data, function(result){
            $('#assessment_currvalue_vehicle_evaluation').html(result);
        });
    }

    assessmentVehicleEvaluate = function(self){
        $(self).parent().find('#close').hide();
        $(self).text('Sila tunggu...').prop('disabled', true);
        $.post('{{route('assessment.currvalue.approval')}}', {
            '_token': '{{ csrf_token() }}'
        }, function(response){
            window.location.href = response.url;
        })
    }

    // assessmentVehicleReject = function(){
    //     $.post('{{route('assessment.currvalue.reject')}}', {
    //         '_token': '{{ csrf_token() }}'
    //     }, function(response){
    //         window.location.href = response.url;
    //     })
    // }
    saveReceipt = function(self){
        let crf = "{{ csrf_token() }}";
        let id = $(self).data('id');
        let receipt_no = self.value;
        $.post('{{route('assessment.currvalue.vehicle-evaluation.save-receipt')}}', {
            '_token': crf,
            'id': id,
            'receipt_no': receipt_no
        });
    }

        uploadFileReceipt = function(self){

            let url = URL.createObjectURL($(self)[0].files[0]);
            if(url){
                $(self).parent().find('.form-label').text('Tukar Fail')
                $(self).parent().find('#preview_receipt').attr('src', url).show();
            }

            let formData = new FormData();

            formData.append('_token', "{{ csrf_token() }}");
            formData.append('id', $(self).attr('data-id'));
            formData.append('lvl', $(self).attr('data-lvl'));
            formData.append('vehicle_id', "{{Request('vehicle_id')}}");
            formData.append('assessment_type_id', "{{Request('assessment_type_id')}}");
            formData.append('check_lvl_id', "{{Request('check_lvl_id')}}");
            formData.append('file', $(self)[0].files[0]);
            $.ajax({
                url: "{{ route('assessment.currvalue.vehicle-assessment.form-file.save') }}",
                type: 'post',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                success: function(response) {
                    // console.log(response);
                    $('#response').html('<span class="text-success">'+response.message+'</span>').fadeIn(500).fadeOut(5000);
                    $('#reload_receipt').load(document.URL + ' #reload_receipt');

                },
                error: function(response) {
                    let errors = response.responseJSON.errors;
                    $.each(errors, function(key, value) {

                    });

                }

            });
        }

        deleteRelatedDoc = function(vehicle_id, section, image_id){
            $.post("{{route('assessment.currvalue.deleteRelatedDoc')}}", {
                vehicle_id: vehicle_id,
                image_id: image_id,
                section: section,
                '_token': '{{ csrf_token() }}'
            },  function(result){
                if(section=='veh_img_doc'){
                    $('#reload_veh').load(document.URL + ' #reload_veh');
                    $('#own_image').load(document.URL + ' #own_image');
                }else if(section=='receipt_doc'){
                    $('#reload_receipt').load(document.URL + ' #reload_receipt');
                }else{
                    $('#reload_vtl').load(document.URL + ' #reload_vtl');
                }
            })
        }

    $(document).ready(function(){
        loadAssessmentcurrvalueVehicleEvaluation();
    })

</script>
