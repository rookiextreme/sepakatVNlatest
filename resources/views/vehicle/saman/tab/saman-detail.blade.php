<form class="row mt-2" id="frm_detail">
    @csrf
    <input type="hidden" name="vehicle_id" value="{{$vehicleDetail->id}}"/>
    @php

        function convertSQLDateToDisplayDate($dateVal, $format){
            return \Carbon\carbon::createFromFormat('Y-m-d', $dateVal)->format($format);
        }

        function convertSQLTimeToDisplayTime($timeVal, $format){
            \Log::info($timeVal);
            return \Carbon\carbon::createFromFormat('H:i:s', $timeVal)->format($format);
        }

        $detailSummon_agency = isset($summonDetail['summon_agency']) ? $summonDetail['summon_agency'] : '';
        $detailSummon_type = isset($summonDetail['summon_type']) ? $summonDetail['summon_type'] : '';
        $summon_notice_no = isset($summonDetail['summon_notice_no']) ? $summonDetail['summon_notice_no'] : '';

        $notice_date = isset($summonDetail['notice_date']) ? convertSQLDateToDisplayDate($summonDetail['notice_date'], 'd/m/Y') : '';
        $receive_notice_date = isset($summonDetail['receive_notice_date']) ? convertSQLDateToDisplayDate($summonDetail['receive_notice_date'], 'd/m/Y') : '';
        $mistake_date = isset($summonDetail['mistake_date']) ? convertSQLDateToDisplayDate($summonDetail['mistake_date'], 'd/m/Y') : '';
        $mistake_time = isset($summonDetail['mistake_time']) ? convertSQLTimeToDisplayTime($summonDetail['mistake_time'], 'h:i A') : '';

        $stateId = isset($summonDetail['state_id']) ? $summonDetail['state_id'] : -1;
        $stateName = isset($summonDetail['state_name']) ? $summonDetail['state_name'] : '';
        $districtId = isset($summonDetail['district_id']) ? $summonDetail['district_id'] : -1;
        $districtName = isset($summonDetail['district_name']) ? $summonDetail['district_name'] : '';

        $mistake_location = isset($summonDetail['mistake_location']) ? $summonDetail['mistake_location'] : '';
        $driver_name = isset($summonDetail['driver_name']) ? $summonDetail['driver_name'] : '';
        $driver_staffno = isset($summonDetail['driver_staffno']) ? $summonDetail['driver_staffno'] : '';
        $total_compound = isset($summonDetail['total_compound']) ? (float)$summonDetail['total_compound'] : '';
        $compound_reason = isset($summonDetail['compound_reason']) ? $summonDetail['compound_reason'] : '';

        $hasSummonNoticeDoc = isset($summonDetail['hasSummonNoticeDoc']) ? $summonDetail['hasSummonNoticeDoc'] : null;

    @endphp
    <input autocomplete="off" type="hidden" name="section" value="detail">
    <fieldset>
        <legend>Pengeluaran Notis</legend>
        <div class="row">
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-5 col-12">
                <label for="" class="form-label text-dark">Pengeluar Saman <em class="text-danger">*</em> </label>
                @if($is_display)
                        <div class="text-uppercase">{{ $detailSummon_agency->desc }}</div>
                    @else
                    <select class="form-select" name="summon_agency_id">
                        <option value="">Pilih</option>
                        @foreach ($summon_agencies as $summon_agency)
                            <option @if($detailSummon_agency && $detailSummon_agency->id == $summon_agency->id) selected @else @endif value="{{$summon_agency->id}}" class="text-uppercase">{{$summon_agency->desc}}</option>
                        @endforeach
                    </select>
                    <div class="hasErr" id="summon_summon_agency_id"></div>
                @endif
            </div>
            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-5 col-12">
                <label for="" class="form-label text-dark">Jenis Saman <em class="text-danger">*</em> </label>
                @if($is_display)
                        <div class="text-uppercase">{{ $detailSummon_type->desc }}</div>
                    @else
                    @foreach ($summon_types as $summon_type)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="summon_type_id" id="inlineRadio-{{$summon_type->id}}" value="{{$summon_type->id}}"
                            @if($detailSummon_type && $detailSummon_type->id == $summon_type->id) checked @else @endif
                            >
                            <label class="form-check-label cursor-pointer" for="inlineRadio-{{$summon_type->id}}">{{$summon_type->desc}} </label>
                        </div>
                    @endforeach
                    <div class="hasErr" id="summon_summon_type_id"></div>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-5 col-12">
                <label for="" class="form-label text-dark">Nombor Notis Saman <em class="text-danger">*</em> </label>
                @if($is_display)
                        <div class="text-uppercase">{{$summon_notice_no}}</div>
                    @else
                <input autocomplete="off" onchange="checkSummonNo(this)" type="text" class="form-control" name="summon_notice_no" value="{{$summon_notice_no}}">
                <div class="hasErr" id="summon_summon_notice_no"></div>
                @endif
            </div>
            <div class="col-xl-2 col-lg-2 col-md-3 col-sm-3 col-12">
                <label for="" class="form-label text-dark">Tarikh Notis <em class="text-danger">*</em> </label>
                    @if($is_display)
                            <div class="text-uppercase">{{ $notice_date }}</div>
                    @else
                        <div class="input-group date" id="notice_date">
                            <input autocomplete="off" name="notice_date" id="notice_date_input"
                                        type="text" class="form-control datepicker" placeholder=""
                                        autocomplete="off"
                                        data-provide="datepicker" data-date-autoclose="true"
                                        data-date-format="dd/m/yyyy" data-date-today-highlight="true"
                                        value="{{$notice_date}}"/>
                            <div class="input-group-text" for="notice_date">
                                <i class="fa fa-calendar"></i>
                            </div>
                        </div>
                        <div class="hasErr" id="summon_notice_date"></div>
                    @endif
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                <label for="" class="form-label text-dark">Tarikh Terima Saman (CDPK)<em class="text-danger">*</em> </label>
                    @if($is_display)
                            <div class="text-uppercase">{{ $notice_date }}</div>
                    @else
                        <div class="input-group date" id="receive_notice_date">
                            <input autocomplete="off" name="receive_notice_date" id="receive_notice_date_input"
                                        type="text" class="form-control datepicker" placeholder=""
                                        autocomplete="off"
                                        data-provide="datepicker" data-date-autoclose="true"
                                        data-date-format="dd/m/yyyy" data-date-today-highlight="true"
                                        value="{{$receive_notice_date}}"/>
                            <div class="input-group-text" for="receive_notice_date">
                                <i class="fa fa-calendar"></i>
                            </div>
                        </div>
                        <div class="hasErr" id="summon_receive_notice_date"></div>
                    @endif
            </div>
        </div>
    </fieldset>
    <fieldset>
        <legend>Maklumat Kesalahan</legend>
        <div class="row">
            <div class="col-xl-2 col-lg-2 col-md-3 col-sm-3 col-12">
                <label for="" class="form-label text-dark">Tarikh Kesalahan <em class="text-danger">*</em> </label>
                @if($is_display)
                        <div class="text-uppercase">{{  $mistake_date}}</div>
                    @else
                <div class="input-group date" id="mistake_date">
                    <input autocomplete="off" name="mistake_date" id="mistake_date_input"
                                type="text" class="form-control datepicker" placeholder=""
                                autocomplete="off"
                                data-provide="datepicker" data-date-autoclose="true"
                                data-date-format="dd/m/yyyy" data-date-today-highlight="true"
                                value="{{$mistake_date}}"/>
                    <div class="input-group-text" for="mistake_date">
                        <i class="fa fa-calendar"></i>
                    </div>
                </div>
                <div class="hasErr" id="summon_mistake_date"></div>
                @endif
            </div>
            <div class="col-xl-2 col-lg-2 col-md-3 col-sm-3 col-12">
                <label for="" class="form-label text-dark">Masa Kesalahan</label>
                @if($is_display)
                        <div class="text-uppercase">{{ $mistake_time}}</div>
                    @else
                    <div style="position: relative" for="mistake_time">
                        <input autocomplete="off" type="text" id="mistake_time" class="form-control timepicker" name="mistake_time" value="{{$mistake_time}}">
                    </div>
                    {{-- <div class="hasErr" id="summon_mistake_time"></div> --}}
                @endif
            </div>
        </div>
        <div class="row">
            {{-- <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                <label for="" class="form-label text-dark">Lokasi Kesalahan <em class="text-danger">*</em> </label>
                @if($is_display)
                    <div class="text-uppercase">
                        {{$stateName}}
                    </div>
                @else
                <select class="form-select" name="state_id" onchange="getDistrict(this.value)" aria-placeholder="[Sila pilih]" placeholder="[Sila pilih]">
                     <option value=""> Sila Pilih </option>
                    @foreach ($states as $state)
                        <option {{$stateId == $state->id ? 'selected': ''}} value="{{ $state->id }}">{{ $state->negeri }}</option>
                    @endforeach
                </select>
                <div class="hasErr" id="summon_state_id"></div>
                @endif
            </div> --}}
            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                <label for="" class="form-label text-dark">Tempat Kesalahan <em class="text-danger">*</em> </label>
                    @if($is_display)
                        <div class="text-uppercase">
                            {{$mistake_location}}
                        </div>
                    @else
                        <input autocomplete="off" type="text" class="form-control" name="mistake_location" value="{{$mistake_location}}">
                        <div class="hasErr" id="summon_mistake_location"></div>
                    @endif
                {{-- <div class="col-md-4">
                    <label for="" class="form-label text-dark">Pemandu (ketika kesalahan dilakukan)  </label>
                    <x-modal-user isDisplay="{{$is_display}}" filterByRole="06" title="Pemandu" subTitle="Sila pilih atau buat carian" fieldName="driver_id" fieldValue="{{$summonDetail && $summonDetail['hasDriver']->name}}" dataName="{{ $summonDetail && $summonDetail['hasDriver'] ? $summonDetail['hasDriver']->name : '' }}"></x-modal-user>
                </div> --}}
            </div>
        </div>
        <div class="row">
            <div class="col-xl-2 col-lg-3 col-md-3 col-sm-4 col-12">
                <label for="" class="form-label text-dark">Jumlah Kompaun (RM) <em class="text-danger">*</em> </label>
                @if($is_display)
                        <div class="text-uppercase">
                            {{number_format((float)$total_compound, 2)}}
                        </div>
                    @else
                <input autocomplete="off" type="text" class="form-control" onkeypress="return isNumber(this)" name="total_compound" value="{{number_format((float)$total_compound, 2)}}">
                <div class="hasErr" id="summon_total_compound"></div>
                @endif
            </div>
            <div class="col-xl-4 col-lg-5 col-md-5 col-sm-8 col-12">
                <label for="" class="form-label text-dark">Nyatakan Sebab Kesalahan <em class="text-danger">*</em> </label>
                @if($is_display)
                        <div class="text-uppercase">
                            {{$compound_reason}}
                        </div>
                    @else
                <input autocomplete="off" type="text" class="form-control" name="compound_reason" value="{{$compound_reason}}">
                <div class="hasErr" id="summon_compound_reason"></div>
                @endif
            </div>
        </fieldset>
        <fieldset>
            <legend>INDIVIDU BERTANGGUNGJAWAB</legend>
            <div class="row">
                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-12">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="" class="form-label text-dark" >Nama Individu 1</label>
                            <input type="text" id="pic_name1" name="pic_name1" class="form-control" autocomplete="off"
                            value="{{isset($summonDetail['pic_name1']) ? $summonDetail['pic_name1'] : null}}" onkeyup="changeToUpperCase(this)">
                        </div>
                    </div>
                </div>
                    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="" class="form-label text-dark">Email</label>
                                <input type="text" id="pic_email1" name="pic_email1" class="form-control" autocomplete="off"
                                value="{{isset($summonDetail['pic_email1']) ? $summonDetail['pic_email1'] : null}}" onkeyup="changeToUpperCase(this)">
                                <div class="hasErr" id="summon_pic_email1"></div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="row">
                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-12">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="" class="form-label text-dark" >Nama Individu 2</label>
                            <input type="text" id="pic_name2" name="pic_name2" class="form-control" autocomplete="off"
                            value="{{isset($summonDetail['pic_name2']) ? $summonDetail['pic_name2'] : null}}" onkeyup="changeToUpperCase(this)">
                        </div>
                    </div>
                </div>
                    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="" class="form-label text-dark">Email</label>
                                <input type="text" id="pic_email2" name="pic_email2" class="form-control" autocomplete="off"
                                value="{{isset($summonDetail['pic_email2']) ? $summonDetail['pic_email2'] : null}}" onkeyup="changeToUpperCase(this)">
                                <div class="hasErr" id="summon_pic_email2"></div>
                            </div>
                        </div>
                    </div>
            </div>
        </fieldset>
        <fieldset>
            <legend>Dokumen</legend>
            <div class="col-md-4">
                <label for="" class="form-label text-dark">Notis Saman (PDF/Gambar) <em class="text-danger">*</em> </label>

                @if(!$is_display)

                <label class="btn cux-btn bigger mb-3" for="summon_notice_doc"><i class="fas fa-cloud-upload"></i> {{$hasSummonNoticeDoc ? 'Tukar Fail' : 'Muat Naik'}} </label>
                <input type="file" onchange="changeDocument(this)" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,application/pdf,image/*" class="form-control d-none" name="summon_notice_doc" id="summon_notice_doc">
                <input type="hidden" name="has_summon_notice_doc" value="{{$hasSummonNoticeDoc ?  1:0 }}">

                @endif
                @php
                    $doc_path = $hasSummonNoticeDoc ? $hasSummonNoticeDoc->doc_path : null;
                    $doc_name = $hasSummonNoticeDoc ? $hasSummonNoticeDoc->doc_name : null;
                    $pathUrl = $doc_path != '' ? '/storage/'.$doc_path.'/'.$doc_name : '';
                @endphp
                <div id="preview-file-summon_notice_doc" class="form-group mb-2" style="display: {{$hasSummonNoticeDoc ? 'block' : 'none'}};height: 200px;overflow: auto;">

                <div class="btn-group mb-2">
                    @if($pathUrl != '')
                        <button onclick="fancyView('{{$pathUrl}}')" class="btn cux-btn small" type="button"> <i class="fa fa-eye"></i> Lihat Fail</button>
                    @endif
                </div>
                    <embed src="{{$pathUrl}}" id="preview-file-summon_notice_doc-embed" width="100%" type="">
                </div>
            </div>
            <div class="hasErr" id="summon_summon_notice_doc"></div>
        </fieldset>

        @if(!$is_display)
        <div class="row g-3 mt-2">
            <div class="form-group center">
                @if (in_array($roleAccessCode, array('01','03')))
                <button {{ $summon !== '01' ? ( auth()->user()->isAdmin() ?  '' : 'disabled' ) : '' }}
                class="btn btn-module" type="submit">Simpan</button>
                @endif

                @if(count($informations) > 0)
                    @if($summon == '01')
                    <button
                    {{-- {{ $summon == '02' && $summon == '02' ? ( auth()->user()->isAdmin() ?  '' : 'disabled' ) : '' }} --}}
                    class="btn btn-module" type="button" data-bs-toggle="modal" onclick="promptSubmitForPaymentModal()" data-bs-target="#promptSubmitForPaymentModal">Hantar</button>
                    @endif
                @endif
            </div>
        </div>
        @endif
</form>

<script type="text/javascript">

    var stateId = {{$stateId}};
    var districtId = {{$districtId}};

    checkSummonNo = function(self){
        let value = self.value;
        $.post('{{route('vehicle.saman.check.summon-no')}}', {
            '_token':'{{ csrf_token() }}',
            'summon_notice_no' : value
        }, function(is_existed) {
            if(is_existed == '1'){
                $('.hasErr#summon_summon_notice_no').html('Nombor notis saman telah wujud.');
                $('#frm_detail [type="submit"]').prop('disabled', true);
            } else {
                $('.hasErr#summon_summon_notice_no').html('');
                $('#frm_detail [type="submit"]').prop('disabled', false);
            }
        });
    }

    function changeDocument(self){
        event.preventDefault();
        let docType = self.id;
        let url = URL.createObjectURL(event.target.files[0]);
            $('#preview-file-'+docType+'-embed').attr('src', url);
            $('#preview-file-'+docType).show();
    }

    function submitDetail(formData) {

        $('.hasErr').html('');

        $.ajax({
            url: "{{ route('vehicle.saman.register.save') }}",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            success: function(response) {
                window.location.href = response['url'];
            },
            error: function(response) {
                //console.log(response.responseJSON.exception);
                $('#promptSubmitForPaymentModal').modal('hide');

                var errors = response.responseJSON.errors;
                $.each(errors, function(key, value) {
                    $('.hasErr#summon_'+key).html(value[0]);
                });

                $('#tab1').click();
                //$('.messages').html(errorsHtml);
            }
        });

    }

    function getDistrict(state_id){

        $('#list_district').html('<option value="-1">Sila Pilih</option>');

        $.get("{{route('vehicle.ajax.getDistrict')}}", {
            state_id: state_id
        }, function(result){

            var count = result.length;
            var totalInit = 0;
            var same = false;

            result.forEach(element => {
                $('#list_district').append('<option value='+element.id+'>'+element.name+'</option>');
                totalInit++;
                if(districtId == element.id){
                    same = true;
                }
            });

            var currentSelectedStateId = {{$stateId}};

            if(count == totalInit){
                if(!same){
                    districtId = -1;
                }
                $('#list_district').val(districtId).trigger("change");
            }

        });
    }

    function isNumber(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }

    $(document).ready(function() {

        let notice_date_container = $('#notice_date_input').datepicker();
        notice_date_container.datepicker('setEndDate', new Date());

        let mistake_date_container = $('#mistake_date_input').datepicker();
        mistake_date_container.datepicker('setEndDate', new Date());

        $('.timepicker').datetimepicker({
            format: 'hh:mm A',
            useCurrent: false,
            showTodayButton: true,
            showClear: true,
            toolbarPlacement: 'bottom',
            sideBySide: true,
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down",
                previous: "fa fa-chevron-left",
                next: "fa fa-chevron-right",
                today: "fa fa-clock",
                clear: "fa fa-trash"
            }
        });

        if(stateId != -1){
            getDistrict(stateId);
        }

        $('#frm_detail').on('submit', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            submitDetail(formData);

        });
    })

</script>
