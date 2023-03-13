@php
    $doc_path = isset($summonDetail['payment']) ? $summonDetail['payment']->dokumenPembayaran->path_dokumen : '';
    $doc_name = isset($summonDetail['payment']) ? $summonDetail['payment']->dokumenPembayaran->name_dokumen : '';
    $pathUrl = $doc_path != '' ? '/storage/'.$doc_path.'/'.$doc_name : '';

    $is_changeOwnerShip = isset($summonDetail['change_summon_owner']) && $summonDetail['hasSummonStatus']->code == '04' && $summonDetail['change_summon_owner'] ? true: false;
@endphp

{{-- @if(isset($summonDetail['hasSummonStatus']) && $summonDetail['hasSummonStatus']->code == '04')
    <div class="form-group">
        <label for="">Maklumat Penting</label>
        <div>Saman telah ditukar milik. Pemilik saman akan membuat pembanyaran diluar kawalan sistem ini.</div>
    </div>
    <div class="form-group">
        <label for="">Nota</label>
        <div>{{$summonDetail['change_summon_owner_note']}}</div>
    </div>
@else --}}
<form class="row" id="frm_payment" enctype="multipart/form-data">

    @csrf
    <input type="hidden" name="hasNewDocument" id="hasNewDocument" value="{{$pathUrl == '' ? 1: 0}}">
    <input type="hidden" name="hasNewDocument1" id="hasNewDocument1" value="{{$pathUrl == '' ? 1: 0}}">
    <fieldset>
        <legend>Tindakan</legend>
        <div class="col-xl-3 col-lg-4 col-md-8 col-sm-8 col-12">
            <div class="form-group">
                <label for="" class="form-label text-dark">Kemaskini Maklumat Saman</label>
                <div class="input-group">
                    <select id="saman_info" class="form-select">
                        <option {{$summonDetail['hasSummonStatus']->code == '05' ? 'selected': ''}} value="3" >Proses Rayuan Pengurangan Saman</option>
                        <option {{!$is_changeOwnerShip && $summonDetail['hasSummonStatus']->code != '05' ?  'selected': ''}} value="1">Kemaskini Pembayaran Saman</option>
                        <option {{$is_changeOwnerShip ?  'selected': ''}} value="2" >Tukar Milik Saman</option>
                    </select>
                </div>
            </div>
        </div>
    </fieldset>

    <div id="kemaskini" class="form-row container row" style="display:{{!$is_changeOwnerShip ? 'block': 'none'}};">
    <fieldset>
        <legend>Pembayaran</legend>
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-5 col-12">
                <div class="form-group">
                    <label for="" class="form-label text-dark">Nombor Resit <strong class="text-danger">*</strong> </label>
                    <input type="text" id="receipt_no" autocomplete="off" name="receipt_no" value="{{isset($summonDetail['payment']) ? $summonDetail['payment']->receipt_no : ''}}">
                </div>
                <div class="hasErr" id="s_payment_receipt_no"></div>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-3 col-sm-4 col-12">
                <div class="form-group">
                    <label for="" class="form-label text-dark">Jumlah Bayaran <strong class="text-danger">*</strong> </label>
                    <input type="text" id="total_payment" autocomplete="off" name="total_payment" value="{{isset($summonDetail['payment']) ? $summonDetail['payment']->total_payment : ''}}">
                </div>
                <div class="hasErr" id="s_payment_total_payment"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-2 col-lg-2 col-md-3 col-sm-4 col-12">
                <div class="form-group">
                    <label for="" class="form-label text-dark">Tarikh Bayaran <strong class="text-danger">*</strong> </label>
                    <div class="input-group date" id="payment_date">
                        <input autocomplete="off" name="payment_date" id="payment_date_input"
                                    type="text" class="form-control datepicker" placeholder=""
                                    autocomplete="off"
                                    data-provide="datepicker" data-date-autoclose="true"
                                    data-date-format="dd/m/yyyy" data-date-today-highlight="true"
                                    value="{{isset($summonDetail['payment']) ? \Carbon\Carbon::parse($summonDetail['payment']->payment_date)->format('d/m/Y') : ''}}"/>
                        <div class="input-group-text" for="payment_date">
                            <i class="fal fa-calendar"></i>
                        </div>
                    </div>
                </div>
                <div class="hasErr" id="s_payment_payment_date"></div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-5 col-12">
                <label for="" class="form-label text-dark">Kaedah Bayaran <strong class="text-danger">*</strong> </label>
                <div class="form-group">
                    <input type="text" id="payment_method" autocomplete="off" name="payment_method" value="{{isset($summonDetail['payment']) ? $summonDetail['payment']->payment_method : ''}}">
                </div>
                <div class="hasErr" id="s_payment_payment_method"></div>
            </div>
        </div>
    </fieldset>
    <fieldset>
        <legend>Bukti</legend>
        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-5 col-12">
            <label for="" class="form-label text-dark">Dokumen Pembayaran<strong class="text-danger">*</strong> </label>
            
            <div class="btn-group mb-2">
                <label class="btn cux-btn small" for="doc_payment">{{$pathUrl == '' ? 'Muat Naik' : 'Tukar Fail'}}</label>
                @if($pathUrl != '')
                    <button onclick="fancyView('{{$pathUrl}}')" class="btn cux-btn small" type="button"> <i class="fa fa-eye"></i> Lihat Fail</button>
                @endif
            </div>
            <input type="file" class="form-control d-none" accept="application/pdf,image/*" name="dokumen_kemaskini" id="doc_payment">
            <div id="preview-file" class="form-group mb-2" style="display: none;height: 200px;
            overflow: auto;">

                <embed src="{{$pathUrl}}" id="preview-file-embed" width="100%" type="">
            </div>
            <div class="hasErr" id="s_payment_dokumen_kemaskini"></div>
        </div>
    </fieldset>
    </div>

    <div id="tukar" class="form-row container row" style="display:{{$is_changeOwnerShip ? 'block': 'none'}};">
        <div class="col-md-4" >
            <label for="" class="form-label text-dark">Nama Pemandu <strong class="text-danger">*</strong> </label>
            <input type="text" id="nama_pemandu" autocomplete="off" name="nama_pemandu" value="{{isset($summonDetail['nama_pemandu']) ? $summonDetail['nama_pemandu'] : ''}}">
        </div>
        <div class="col-md-8">
            <div class="col-md-12">
                <label for="" class="form-label text-dark">Dokumen Sokongan (PDF/Gambar)</label>
                    <span class="btn cux-btn bigger mb-2" data-bs-toggle="modal" data-bs-target="#addMoreSupportDocModal"> <i class="fa fa-plus"></i> Tambah</span>
                    <div id="support-docs" style="width: 400px; overflow-x: hidden; padding: 10px;">
                        {{-- @include('vehicle.tab.detail-support-docs') --}}
                    </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="col-3 mt-4">
            <div class="form-group center">
                @if(in_array($summonDetail['hasStatus']->code, ['01','02']) || auth()->user()->isAdmin())
                    <button class="btn btn-module text-white" type="submit" xaction="submitPrompt">Simpan</button>
                @endif
                
                <button 
                    @if(!$is_changeOwnerShip && $summonDetail['hasSummonStatus']->code != '05')
                    disabled
                    @elseif($summonDetail['hasStatus']->code == '02') 
                @else disabled 
                @endif class="btn btn-module" xaction="hantarPrompt" type="button" data-bs-toggle="modal" onclick="submitPaymentModal()" data-bs-target="#submitPaymentModal">Hantar</button>
            </div>
        </div>
    </div>

</form>

{{-- changeSummonOwnerModal --}}
@if(isset($summonDetail['change_summon_owner']) && !$summonDetail['change_summon_owner'])

<div class="modal fade" id="changeSummonOwnerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="changeSummonOwnerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="frmChangeSummonOwner" action="" method="post">
                @csrf
                <div class="modal-header">
                </div>
                <div class="modal-body">
                    <div>
                        Adakah anda ingin menukar pemilik saman ini ?
                    </div>
                    <div class="form-group">
                        <label for="note">Nota</label>
                        <textarea class="form-control" name="note" id="note" cols="30" rows="5"></textarea>
                    </div>

                </div>
                <div class="modal-footer float-start">
                    <span class="btn btn-module" xaction="close" style="display: none" data-bs-dismiss="modal">Tutup</span>
                    <span class="btn btn-module" xaction="no" data-bs-dismiss="modal">Tidak</span>
                    <button class="btn btn-danger" xaction="change_summon_owner" type="submit" >Ya</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endif

<div class="modal fade" id="addMoreSupportDocModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addMoreSupportDocModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="frmSupportDoc" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="supportDoc" class="form-label">Muat naik dokument sokongan <span class="btn cux-btn">&nbsp;<i class="fa fa-upload fa-2x"></i></span></label>
                        <input class="form-control d-none" accept="image/*,.pdf" name="support_doc" type="file" id="supportDoc" />
                    </div>
                    <div class="form-group">
                        <div id="preview-image" class="text-center" style="display: none;">
                            <embed src="" id="preview-image-output" width="100%"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <textarea name="pic_desc" class="form-control" id="pic_desc" cols="30" rows="5"></textarea>
                    </div>
                </div>
                <div class="modal-footer float-start">
                    <button type="button" class="btn btn-secondary" id="close_modal" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-module" xaction="upload_image" >Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">

    let is_existSupportDocs = false;

    var currentPreviewFile = "{{$pathUrl}}";
    var currentPreviewFile2 = "{{$pathUrl}}";


    function getSupportDocs(){
        checkExistSupportDocs();
        $.get('{{route('vehicle.saman.ajax.getSupportDocs')}}', {
            'is_display': '{{$is_display}}'
        }, function(result){
            $('#support-docs').html(result);
        });
    }

    function checkExistSupportDocs(){
        $.get('{{route('vehicle.saman.ajax.checkExistSupportDocs')}}', function(result){
            is_existSupportDocs = result.is_existed;
            let targetBtnHantar = $('#frm_payment').find('[xaction="hantarPrompt"]');
            if(is_existSupportDocs){
                @if($is_changeOwnerShip && $summonDetail['hasSummonStatus']->code == '04')
                    targetBtnHantar.prop('disabled', true);
                    @else
                    targetBtnHantar.prop('disabled', false);
                @endif
            } else {
                targetBtnHantar.prop('disabled', true);
            }
        });
    }

    function checkExistPaymentDocs(){
        $.get('{{route('vehicle.saman.ajax.checkExistPaymentDocs')}}', function(result){
            is_existSupportDocs = result.is_existed;
            let targetBtnHantar = $('#frm_payment').find('[xaction="hantarPrompt"]');
            if(is_existSupportDocs){
                @if($is_changeOwnerShip && $summonDetail['hasSummonStatus']->code == '04')
                    targetBtnHantar.prop('disabled', true);
                    @else
                    targetBtnHantar.prop('disabled', false);
                @endif
            } else {
                targetBtnHantar.prop('disabled', true);
            }
        });
    }

    function changeSummonOwner(formData){

        let totalSupportDoc = $('.hasSupportDoc').length;

        console.log("totalSupportDoc", totalSupportDoc);

        if(totalSupportDoc > 0){
            formData.append('totalSupportDoc', totalSupportDoc);
        }

        $.ajax({
            url: "{{ route('vehicle.saman.changeSummonOwner') }}",
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            method: 'POST',
            success: function(response) {
                window.location.reload();
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
            }
        });
    }

    function submitPayment(data){

        $('.hasErr').html('');

        parent.startLoading();
        $.ajax({
            url: "{{ route('vehicle.saman.receipt.upload.post') }}",
            type: 'post',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            success: function(response) {
                console.log(response);
                window.location = response['url'];
                checkExistPaymentDocs();
            },
            error: function(response) {
                console.log(response);
                var errors = response.responseJSON.errors;

                // var errorsHtml = '<div class="alert alert-danger mb-0 pb-0"><ul>';

                // $.each(errors, function(key, value) {
                //     errorsHtml += '<li>' + value[0] + '</li>';
                // });
                // errorsHtml += '</ul></div';

                // $('.messages').html(errorsHtml);

                $.each(errors, function(key, value) {
                    $('.hasErr#s_payment_'+key).html(value[0]);
                });

                parent.stopLoading();
            }
        });
    }

    $(document).ready(function() {

        checkExistSupportDocs();

        checkExistPaymentDocs();

        @if ($is_changeOwnerShip)
        getSupportDocs();
        @endif

        @if (!empty($pathUrl))
            $('#preview-file').show();
            $('#preview-file1').show();
        @endif

        $('#doc_payment').on('change', function(e){
            e.preventDefault();

            let url = URL.createObjectURL(e.target.files[0]);
            $('#preview-file-embed').attr('src', url);
            $('#preview-file').show();
            currentPreviewFile = url;
            $('#hasNewDocument').val(1);
            let btnSubmit = $('#frm_payment').find('[xaction="submitPrompt"]');
            let btnSend = $('#frm_payment').find('[xaction="hantarPrompt"]');
            if(currentPreviewFile)
            {
                btnSubmit.show();
                btnSend.prop('disabled', false);
                $('#preview-file').css('height', 300).show();
            }
            else
            {
                btnSubmit.hide();
                btnSend.prop('disabled', true);
            }

        });

        $('#doc_paymenttukar').on('change', function(e){
            e.preventDefault();

            let url2 = URL.createObjectURL(e.target.files[0]);
            $('#preview-file-embed1').attr('src', url2);
            $('#preview-file1').show();
            currentPreviewFile2 = url2;
            $('#hasNewDocument1').val(1);
            console.log('url 2 file -> ', url2);
        });

        $('#frm_payment').on('submit', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            var saman_info = $("#saman_info").val();
            formData.append('saman_info', saman_info);
            console.log('saman_info', saman_info);
            if(saman_info == 2){
                changeSummonOwner(formData);
            } else {
                submitPayment(formData);
            }

        });

        //support-docs"

        $('#supportDoc').on('change', function(e){
            e.preventDefault();

            var output = document.getElementById('preview-image-output');
            output.src = URL.createObjectURL(e.target.files[0]);
            $('#preview-image').show();
            $('#preview-image-output').show();
            URL.revokeObjectURL(output.src) // free memory

        });

        $('#frmSupportDoc').on('submit', function(e){
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                url: "{{route('vehicle.saman.upload.support_doc')}}",
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                async: false,
                data: formData,
                success: function(response) {
                    console.log(response);
                    if(response.status == '200') {
                        getsupportDocs();
                    }
                    $('#addMoreSupportDocModal').modal('hide');
                    $('#preview-image-output').attr('src', '').hide();
                    $('#frmSupportDoc')[0].reset();
                    getSupportDocs();
                    checkExistSupportDocs();
                },
                error: function(response) {
                    var errors = response.responseJSON.errors;
                    $.each(errors, function(key, value) {

                        if($('[name="'+key+'"]').parent().find('.text-danger').length == 0){
                            $('[name="'+key+'"]').parent().append('<div class="text-danger col-12 fs-6">'+value[0]+'</div>');
                        }
                    });

                }
            });
        });

        $('#frmChangeSummonOwner').on('submit', function(e){
            e.preventDefault();
            let formData = new FormData(this);
            changeSummonOwner(formData);
        });

        $('#tab2').on('click', function(){
            if(currentPreviewFile){
                $('#preview-file-embed').attr('src', currentPreviewFile);
            }
            if(currentPreviewFile2){
                $('#preview-file-embed1').attr('src', currentPreviewFile2);
            }
        });

        $('#saman_info').on('change', function() {

            var saman_info = $("#saman_info").val();
            $('[xaction="hantarPrompt"]').prop('disabled', true);
            $('#doc_payment').val(null);

            if (saman_info == 1 || saman_info == 3){

                $('[xaction="hantarPrompt"]').prop('disabled', false);
                $('#kemaskini').attr('style','display:block');
                $('#tukar').attr('style','display:none');

                if($('#doc_payment').val()){
                    $('[xaction="hantarPrompt"]').prop('disabled', false);
                } else {
                    $('#preview-file').css('height', 0).hide();
                    $('[xaction="hantarPrompt"]').prop('disabled', true);
                }

            }
            else if (saman_info == 2){
                console.log(saman_info);
                $('#kemaskini').attr('style','display:none');
                $('#tukar').attr('style','display:block');
                $('[xaction="hantarPrompt"]').prop('disabled', true);
                getSupportDocs();

            }
            else {
            }
        });

    })

</script>
