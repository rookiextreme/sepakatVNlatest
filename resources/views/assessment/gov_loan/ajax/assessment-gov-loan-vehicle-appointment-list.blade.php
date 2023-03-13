@php
    $TaskFlowAccessAssessmentGovLoan = auth()->user()->vehicleWorkFlow('02', '01');
    // $totalPrice = 0;
    // $count = 0;
    // foreach ($vehicleList as $vehicle){
    //     $totalPrice += $vehicle->vehicle_price;
    // }
@endphp
{{-- <textarea name="" class="form-control" id="" cols="30" rows="3">@json($TaskFlowAccessAssessmentGovLoan)</textarea> --}}
<div class="table-responsive pt-0">
    <table id="fleet-ls" class="table-custom no-footer stripe">
        <thead>
            <th class="col-del">
                <input class="form-check-input" name="chkall" id="chkall" type="checkbox">
            </th>
            <th class="col-del">Bil</th>
            <th>No Pendaftaran</th>
            <th class="lcal-4">Jenis</th>
            <th class="lcal-3">Buatan</th>
            <th class="lcal-3">Model</th>
            <th>Pembantu Kemahiran</th>
            <th style="text-align:right;width:100px;padding-bottom:7px">Harga<br/><small>RM</small></th>
        </thead>
        <tbody>
            @foreach ($vehicleList as $index => $vehicle)
                <tr>
                    <td class="pb-0">
                        <input class="form-check-input" name="chkdel" type="checkbox" value="{{$vehicle->id}}" id="chkdel">
                    </td>
                    <td class="pb-0"><div style="font-size: 14px">{{$vehicleList->firstItem() + $index}}</div><input type="hidden" name="vehicle_id[{{$loop->index}}]" value="{{$vehicle->id}}"></td>
                    <td>{{$vehicle->plate_no}}<input type="hidden" class="form-control" name="vehicle_id[{{$loop->index}}]" value="{{$vehicle->id}}"></td>
                    <td class="caps">{{$vehicle->hasSubCategoryType ? $vehicle->hasSubCategoryType->name : '-'}}</td>
                    <td>{{$vehicle->hasVehicleBrand ? $vehicle->hasVehicleBrand->name : '-'}}</td>
                    <td>{{$vehicle->model_name}}</td>
                    <td class="pb-0" style="padding-top:3px;padding-left:4px;padding-right:4px;padding-bottom:0px;width:270px">
                        @if($hasAssessmentGovLoanDetail->hasStatus->code == '02')
                        <select data-vehicle-id="{{$vehicle->id}}" name="foremen_id" class="foremen" id="foremen_id_{{$vehicle}}">
                            <option value="open">TUGASAN TERBUKA</option>
                            <optgroup label="Spesifik :">
                             @foreach ($foremenList as $foremen)
                             <option {{$vehicle->foremen_by == $foremen->id ? 'selected': ''}} value="{{$foremen->id}}">{{mb_strimwidth(strtoupper($foremen->name), 0, 26, "...")}}</option>
                             @endforeach
                             </optgroup>
                         </select>
                        @else
                            {{$vehicle->foremenBy ? $vehicle->foremenBy->name : '-'}}
                        @endif
                    </td>
                    <td class="pb-0" style="padding-top:3px;padding-left:4px;padding-right:4px;padding-bottom:0px;">
                        <input type="text" class="form-control currency" name="vehicle_price[{{$loop->index}}]" id="vehicle_price{{$loop->index}}" value="{{ number_format((float)$vehicle->vehicle_price, 2, '.', '')}}" data-vehicle-id="{{$vehicle->id}}" onchange="countGrandTotal(); updatePrice(this);">
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <th colspan="7" class="text-end pt-3">Jumlah <small>RM</small></th>
            <th style="text-align:right;width:100px"><span id="grandtotal" style="color:#000000">{{ number_format((float)$totalPrice, 2, '.', '')}}</span></th>
        </tfoot>
    </table>
</div>

<!-- Modal -->
    <div class="modal fade" id="borangBPKModal" tabindex="-1" aria-labelledby="borangBPKModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <!--<div class="modal-header">
            </div>-->
            <div class="modal-body">
                <div class="letter-a4">
                    <div class="bpk">BPK 1/94</div>
                    <div class="letter-title">Borang Pesanan Kerja</div>
                    <div class="inv-date">Tarikh : <span >{{Carbon\Carbon::now()->format("d/m/Y")}}</span></div>
                    <div class="row">
                        <div class="col inv-term">Daripada</div>
                        <div class="col inv-dot">:</div>
                        <div class="col inv-item">Seksyen Penilaian</div>
                    </div>
                    <div class="row">
                        <div class="col inv-term">Kepada</div>
                        <div class="col inv-dot">:</div>
                        <div class="col inv-item" id="nama_pemohon"></div>
                    </div>
                    <div class="row">
                        <div class="col inv-term">Perkara</div>
                        <div class="col inv-dot">:</div>
                        <div class="col inv-item">Permohonan Nombor Kerja Berpenggal
                            <div class="btn-group">
                                <button class="btn cux-btn">A</button>
                                <button class="btn cux-btn">B</button>
                                <button class="btn cux-btn">S</button>
                                <button class="btn cux-btn">O</button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col inv-term">Pelanggan</div>
                        <div class="col inv-dot">:</div>
                        <div class="col inv-item" id="nama_syarikat"></div>
                    </div>
                    <div class="row">
                        <div class="col inv-term">No. PTJ</div>
                        <div class="col inv-dot">:</div>
                        <div class="col inv-item">Generate No PTJ JKR</div>
                    </div>
                    <div class="row">
                        <div class="col inv-term">Model</div>
                        <div class="col inv-dot">:</div>
                        <div class="col inv-item" id="nama_model"></div>
                    </div>
                    <div class="row">
                        <div class="col inv-term">Jenis</div>
                        <div class="col inv-dot">:</div>
                        <div class="col inv-item" id="subcategory_type"></div>
                    </div>
                    <div class="row">
                        <div class="col inv-term">Jenis Kerja</div>
                        <div class="col inv-dot">:</div>
                        <div class="col inv-item">Memeriksa dan Menguji </div>
                    </div>
                    <!--
                        PENILAIAN KENDERAAN BAHARU - Memeriksa dan Menguji Kenderaan Baharu
                        PENILAIAN HARGA SEMASA - Pemeriksaan dan Penilaian Harga Semasa Kenderaan
                        PENILAIAN PINJAMAN KERAJAAN - Pemeriksaan dan Penilaian Terpakai untuk Skim Pinjaman Kenderaan
                    -->
                    <div class="row">
                        <div class="col inv-term">No JKR</div>
                        <div class="col inv-dot">:</div>
                        <div class="col inv-item">Generate No JKR</div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col inv-term">No JPJ</div>
                        <div class="col inv-dot">:</div>
                        <div class="col inv-item" id="no_jpj"></div>
                    </div>
                    <div class="row">
                        <div class="col inv-term"></div>
                        <div class="col inv-invoice" id="harga-malay">ENAM PULUH RINGGIT MALAYSIA SAHAJA<br/>(1 Bil) X RM 60.00 = RM 60.00</div>
                    </div>
                    <div class="row">
                        <div class="col inv-term2">Anggaran</div>
                        <div class="col inv-dot">:</div>
                        <div class="col inv-butir" id="anggaran">RM 60</div>
                    </div>
                    <div class="row">
                        <div class="col inv-term2">No. L.O. / Waran / DLL (Nyatakan)</div>
                        <div class="col inv-dot">:</div>
                        <div class="col inv-butir"></div>
                    </div>
                    <div class="row">
                        <div class="col inv-term2">T/Tangan Penguasa Bahagian</div>
                        <div class="col inv-dot">:</div>
                        <div class="col inv-butir"></div>
                    </div>
                    <br/>
                    <div class="line-cross">
                        <div class="potong">* Sila potong mana yang tidak berkenaan</div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col inv-term2">Kegunaan Bahagian Perancang</div>
                        <div class="col inv-dot">:</div>
                        <div class="col inv-butir"></div>
                    </div>
                    <div class="row">
                        <div class="col inv-term2">No. Kerja</div>
                        <div class="col inv-dot">:</div>
                        <div class="col inv-butir" id="demo-nokerja">4123888</div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col inv-term2">Tanda tangan</div>
                        <div class="col inv-dot">:</div>
                        <div class="col inv-butir"></div>
                    </div>
                    <div class="row">
                        <div class="col inv-term2">Tarikh</div>
                        <div class="col inv-dot">:</div>
                        <div class="col inv-butir"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer float-start">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
            </div>
        </div>
    </div>
@php
$params = [
    // 'form_id' => 1
    'assessment_gov_loan_id' => $assessment_gov_loan_id
];
@endphp
{{$vehicleList->links('pagination.ajax-default', [
   'targetDivList' =>  '#assessment_gov_loan_vehicle_appointment',
   'params' => $params
])}}

<script type="text/javascript">

    var ids = [];

    function getCurrentChecked(){
        ids = [];
        $('#chkdel:checked').map(function() {
            ids.push(parseInt(this.value));
        });

        return ids;
    }
    function tempohBerekonomi() {
        var tempoh = 0;
        var maxYears = 15;
        var tahunAsal = 2015;
        var tahunSkrg = 2021;
        var diff = parseInt(tahunSkrg) - parseInt(tahunAsal);
        if(parseInt(diff) > 15) {
            tempoh = 0;
        }else{
            if(parseInt(diff) > 8) {
                tempoh = parseInt(maxYears) - parseInt(diff);
            }else{
                tempoh = parseInt(maxYears) - parseInt(diff);
            }
        }
        return tempoh;
    }
    function countGrandTotal() {
        var total = 0.0;
        var sum = 0.00;
        $('.currency').each(function(){
            var thisval = $(this).val();
            if(thisval == '')thisval = '0.0';
            $(this).val(parseFloat(thisval).toFixed(2));
            sum += +$(this).val();
        });
        $('#grandtotal').text(parseFloat(sum).toFixed(2));
    }

    updatePrice = function(self){
        let crf = "{{ csrf_token() }}";
        let vehicle_id = $(self).data('vehicle-id');
        let price = self.value;
        $.post('{{route('assessment.gov_loan.vehicle-appointment-updatePrice')}}', {
            '_token': crf,
            'vehicle_id': vehicle_id,
            'price': price
        });
    }

    generateFormExamination = function(vehicle_id){
        parent.startLoading();
        $.post("{{route('assessment.vehicle-assessment.generateForm')}}", {
            vehicle_id: vehicle_id,
            '_token': '{{ csrf_token() }}'
        },  function(result){
            window.location.href = result.url;
        })
    }

    assignToFormen = function(vehicle_id, formen_id){
        $.post("{{route('assessment.gov_loan.vehicle-appointment-assign')}}", {
            vehicle_id: vehicle_id,
            user_id: formen_id,
            assign_to: 'formen',
            '_token': '{{ csrf_token() }}'
        },  function(result){

        })
    }

    viewBorangBPK = function(vehicle_id){

        let borangBPKModal = $('#borangBPKModal');
        $.ajax({
        url: '{{Route("assessment.gov_loan.vehicle.getVehicleForm")}}',
        type: 'get',
        data: {
            "vehicleId": vehicle_id
        },
        dataType: 'json',
            success: function(data) {
                console.log(data);
                $('#nama_pemohon').html(data.applicant_name);
                $('#nama_model').html(data.model_name);
                $('#subcategory_type').html(data.subcategory_type);
                $('#no_jpj').html(data.plate_no);
                $('#nama_syarikat').html(data.company_name);

                $('#demo-nokerja').text($('#work_no').val());

                var grandTotal = $('#totalprice').text();

                var harga = "ENAM PULUH RINGGIT MALAYSIA SAHAJA<br/>(1 Bil) X RM " + grandTotal + " = RM " + grandTotal;
                $('#anggaran').html("RM " + grandTotal);
                $('#harga-malay').html(harga);

                parent.stopLoading();
            }
        });
        borangBPKModal.modal('show');
    }

    $(document).ready(function(){

    $('.foremen').select2({
        'width': "100%",
        'theme': "classic"
    }).on('change', function(e){
        e.preventDefault();

        let vehicle_id = $(this).attr('data-vehicle-id');
        let forment_id = this.value;
        assignToFormen(vehicle_id, forment_id);
    });

    $('[name="chkall"]').change(function() {

        $('[name="chkdel"]').prop('checked', $(this).is(':checked'));
            $('#delete_all').prop('disabled', true);

            getCurrentChecked();
            if(ids.length > 0){
                $('#delete_all').prop('disabled', false);
            }

        });

        $('[name="chkdel"]').change(function() {

            $('#delete_all').prop('disabled', true);

            getCurrentChecked();
            if(ids.length == $('[name="chkdel"]').length){
                $('#chkall').prop('checked', true);
            } else {
                $('#chkall').prop('checked', false);
            }

            if(ids.length > 0){
                $('#delete_all').prop('disabled', false);
            }
        });

        $('[name="chkall"]').change(function() {

            $('[name="chkdel"]').prop('checked', $(this).is(':checked'));
            $('#delete_all').prop('disabled', true);

            getCurrentChecked();
            if(ids.length > 0){
                $('#delete_all').prop('disabled', false);
            }

        });

        $('[name="chkdel"]').change(function() {

            $('#delete_all').prop('disabled', true);

            getCurrentChecked();
            if(ids.length == $('[name="chkdel"]').length){
                $('#chkall').prop('checked', true);
            } else {
                $('#chkall').prop('checked', false);
            }

            if(ids.length > 0){
                $('#delete_all').prop('disabled', false);
            }
        });

    });
</script>
