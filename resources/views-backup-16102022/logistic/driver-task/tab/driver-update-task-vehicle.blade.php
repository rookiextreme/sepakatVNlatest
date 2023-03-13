<form class="row" id="frm_update_task">
    @csrf
    <input type="hidden" name="category" value="{{request('category')}}">
    <input type="hidden" name="section" value="update_task">

    <div class="col-md-12">
        <div class="row">
            <div class="col-md-4">
                <label for="" class="form-label  text-dark">Nama Pemandu</label>
                @if($is_display == 1)
                <div>{{$vehicle ? $vehicle->spare_driver_name : '-'}}</div>
                @else
                <input type="text" name="spare_driver_name" class="form-control" autocomplete="off"
                value="{{$vehicle ? $vehicle->spare_driver_name : ''}}" >
                @endif
            </div>
            <div class="col-md-12"></div>
            <div class="col-md-4">
                <label for="" class="form-label  text-dark">Odometer Sebelum</label>
                @if($is_display == 1)
                <div>{{$vehicle ? $vehicle->before_odometer : '-'}}</div>
                @else
                <input type="text" name="before_odometer" class="form-control" autocomplete="off"
                value="{{$vehicle ? $vehicle->before_odometer : ''}}" >
                @endif
            </div>
    
            <div class="col-md-4">
                <label for="" class="form-label text-dark">Odometer Selepas</label>
                @if($is_display == 1)
                <div>{{$vehicle ? $vehicle->next_odometer : '-'}}</div>
                @else
                <input type="text" name="next_odometer" class="form-control" autocomplete="off"
                value="{{$vehicle ? $vehicle->next_odometer : ''}}" >
                @endif
            </div>
    
            <div class="col-md-4"></div>
        
            <div class="col-md-4">
                <label for="" class="form-label  text-dark">Tarikh Dan Masa Tugasan (Pergi)</label>
                @if($is_display == 1)
                    <div>{{\Carbon\Carbon::parse($vehicle->task_datetime)->format('d/m/Y h:m:s A')}}</div>
                @else
                <div class="input-group date form_datetime" id="task_datetime_container" data-date="{{$vehicle && $vehicle->task_datetime ? $vehicle->task_datetime : ''}}" data-date-format="dd MM yyyy - HH:ii p" data-link-field="task_datetime">
                    <input class="form-control" size="16" type="text" value="" readonly>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                </div>
                <input type="hidden" name="task_datetime" id="task_datetime" value="{{$vehicle && $vehicle->task_datetime ? $vehicle->task_datetime : ''}}" />
                @endif
            </div>
    
            <div class="col-md-4">
                <label for="" class="form-label  text-dark">Tarikh Dan Masa Tugasan (Balik)</label>
                @if($is_display == 1)
                    <div>{{\Carbon\Carbon::parse($vehicle->task_datetime)->format('d/m/Y h:m:s A')}}</div>
                @else
                <div class="input-group date form_datetime" id="task_end_datetime_container" data-date="{{$vehicle && $vehicle->task_end_datetime ? $vehicle->task_end_datetime : ''}}" data-date-format="dd MM yyyy - HH:ii p" data-link-field="task_end_datetime">
                    <input class="form-control" size="16" type="text" value="" readonly>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                </div>
                <input type="hidden" name="task_end_datetime" id="task_end_datetime" value="{{$vehicle && $vehicle->task_end_datetime ? $vehicle->task_end_datetime : ''}}" />
                @endif
            </div>
    
            <div class="col-md-4"></div>
        
            <div class="col-md-4">
                <label for="" class="form-label  text-dark">Jumlah Touch N GO Digunakan (RM)</label>
                @if($is_display == 1)
                <div>{{$vehicle ? $vehicle->total_price_tng_used : ''}}</div>
                @else
                <input type="text" name="total_price_tng_used" class="form-control" autocomplete="off"
                value="{{$vehicle ? $vehicle->total_price_tng_used : ''}}" >
                @endif
            </div>
        
            <div class="col-md-4">
                <label for="" class="form-label  text-dark">Minyak Digunakan (Liter)</label>
                @if($is_display == 1)
                <div>{{$vehicle ? $vehicle->oil_used : ''}}</div>
                @else
                <input type="text" name="oil_used" class="form-control" autocomplete="off"
                value="{{$vehicle ? $vehicle->oil_used : ''}}" >
                @endif
            </div>
    
            <div class="col-md-4"></div>
    
            <div class="col-md-4" id="fuel_receipt_container">
    
                @php
                    $doc_path = $vehicle && $vehicle->hasFuelReceipt ? $vehicle->hasFuelReceipt->doc_path : '';
                    $doc_name = $vehicle && $vehicle->hasFuelReceipt ? $vehicle->hasFuelReceipt->doc_name : '';
                    $pathUrl = $vehicle && $vehicle->hasFuelReceipt ? '/storage/'.$doc_path.$doc_name : '';
                @endphp

                @if($is_display == 1)
                <label for="" class="form-label">Resit Minyak</label>
                <a class="btn cux-btn bigger mb-1" onclick="downloadFile('{{$pathUrl}}', 'Resit Minyak {{\Carbon\Carbon::now()->format('d-m-Y')}}')">Muat Turun</a>
                @else
    
                    <label for="" class="form-label">Resit Minyak <span class="text-danger">*</span></label>
                    <input type="file" class="d-none" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,application/pdf" name="fuel_receipt" id="fuel_receipt" value="{{$pathUrl}}">
                    @if($vehicle && $vehicle->hasFuelReceipt)
                        <div class="mb-1 mt-1">
                            <a class="btn cux-btn bigger" onclick="downloadFile('{{$pathUrl}}', 'Resit Minyak {{\Carbon\Carbon::now()->format('d-m-Y')}}')">Muat Turun</a>
                            <label class="btn cux-btn small" for="fuel_receipt">Ganti</label>
                        </div>
                    @else
                    <label for="fuel_receipt" type="button" class="btn cux-btn bigger">
                        <i class="fa fa-upload"></i> Muat Naik</label>
                    @endif
                    
                @endif
                <div id="preview-file" class="form-group" style="display: {{$vehicle && $vehicle->hasFuelReceipt ? 'block': 'none'}};">
                    <embed src="{{$pathUrl}}" id="preview-file-embed" width="100%" height="200px" type="">
                </div>
                
            </div>
        </div>
    </div>

    @php
        $allowBtnSave = ['01','02','03'];
        $allowBtnTaskDone = ['01','02','03'];
    @endphp

    <div class="col-md-12 mt-2 mb-2">
        <div class="form-group center">
            @if(!$vehicle || (in_array($vehicle->hasStatus->code, $allowBtnSave)))
                <button class="btn btn-module" type="submit">Simpan</button>
            @endif
            @if ($vehicle && $vehicle->before_odometer)
                @if(in_array($vehicle->hasStatus->code, $allowBtnTaskDone))
                    <a class="btn btn-module" data-bs-toggle="modal" data-bs-target="#driverTaskDoneModal">Tugasan Selesai</a>
                @endif
            @endif
        </div>
    </div>

</form>

<script type="text/javascript">

    let fuel_receiptCurrentPreviewFile = null;
    
    function submitUpdateTask(data) {
        parent.startLoading();
        $.ajax({
            url: "{{ route('logistic.driver.task.vehicle.update') }}",
            type: 'post',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            success: function(response) {
                console.log(response);
                window.location = response['url'];
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
                parent.stopLoading();
            }
        });
    }

    $(document).ready(function(){

        let task_datetime_container = $('#task_datetime_container').datetimepicker({
            language:  'ms',
            weekStart: 1,
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            forceParse: 0,
            showMeridian: 1
        });

        let task_end_datetime_container = $('#task_end_datetime_container').datetimepicker({
            language:  'ms',
            weekStart: 1,
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            forceParse: 0,
            showMeridian: 1
        });

        @if ($vehicle && $vehicle->task_datetime)
            task_datetime_container.datetimepicker('setDate', new Date("{{$vehicle->task_datetime}}"));
        @endif

        @if ($vehicle && $vehicle->task_end_datetime)
            task_end_datetime_container.datetimepicker('setDate', new Date("{{$vehicle->task_end_datetime}}"));
        @endif

        $('#fuel_receipt').on('change', function(e){
            e.preventDefault();

            let url = URL.createObjectURL(e.target.files[0]);
            $('#fuel_receipt_container #preview-file-embed').attr('src', url);
            $('#fuel_receipt_container #preview-file').show();
            fuel_receiptCurrentPreviewFile = url;
        })

        $('#frm_update_task').on('submit', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            submitUpdateTask(formData);

        });

    })

</script>
