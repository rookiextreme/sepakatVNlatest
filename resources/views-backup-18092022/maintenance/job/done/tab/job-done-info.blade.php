
<form class="row" id="frm_info" enctype="multipart/form-data">

    @csrf

    <div class="messages"></div>

    <input type="hidden" name="section" value="info">
    <fieldset>
        <legend>Senarai Borang Dan Penilaian</legend>
        <div class="row">
            <div class="col-md-12" id="frm_info_list">
                <div class="table-responsive">
                    <table class="sripe table-custom">
                        <thead>
                            <th class="text-center" style="width: 50px;">Bil.</th>
                            <th>Perihal Kerja</th>
                            <th class="text-center" style="width: 130px;">Dokumen</th>
                        </thead>
                        <tbody>
                            {{-- <tr class="no-record">
                                <td colspan="3" class="no-record"><i class="fas fa-info-circle"></i> Tiada rekod dijumpai</td>
                            </tr> --}}
                            @if($detail->is_research_market == 1)

                            @php

                            $index = 0;
                                
                                $list = [
                                    [
                                        'name' => 'BORANG JUSTIFIKASI PELAKSANAAN PEMERIKSAAN CKM.J.01',
                                        'id' => 4,
                                        'text' => 'Lihat',
                                    ],
                                    [
                                        'name' => 'SURAT PERINCIAN KAJIAN PASARAN',
                                        'id' => 1,
                                        'text' => 'Lihat',
                                    ],
                                    [
                                        'name' => 'JADUAL HARGA',
                                        'id' => 5,
                                        'text' => 'Lihat',
                                    ],
                                    [
                                        'name' => 'SURAT PEMERIKSAAN KERJA LUAR CKM.J.03',
                                        'id' => 2,
                                        'text' => 'Lihat',
                                    ],
                                    [
                                        'name' => 'BORANG JUSTIFIKASI PELAKSANAAN PENGUJIAN CKM.J.02',
                                        'id' => 7,
                                        'text' => 'Lihat',
                                    ],
                                    [
                                        'name' => 'REKOD PENYENGGARAAN',
                                        'id' => 3,
                                        'text' => 'Lihat',
                                    ]
                                ]

                            @endphp

                            @foreach ($list as $key)

                                @if ($key['id'] == 2 && $detail->hasRepairMethod->code == '01')
                                    @else
                                    @php
                                        $index = $index + 1;
                                    @endphp
                                    <tr>
                                        <td>{{$index}}.</td>
                                        <td>{{$key['name']}}</td>
                                        <td class="text-center">
                                            <span class="btn cux-btn small" onclick="openNewTab({{$key['id']}})">{{$key['text']}}</span>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            @else
                            <tr>
                                <td>1.</td>
                                <td>BORANG JUSTIFIKASI PELAKSANAAN PEMERIKSAAN CKM.J.01</td>
                                <td class="text-center">
                                    <span class="btn cux-btn small" onclick="openNewTab(4)">Lihat</span>
                                </td>
                            </tr>
                            <tr>
                                <td>2.</td>
                                <td>SURAT PEMERIKSAAN KERJA LUAR CKM.J.03</td>
                                <td class="text-center">
                                    <span class="btn cux-btn small" onclick="openNewTab(2)">Lihat</span>
                                </td>
                            </tr>
                            <tr>
                                <td>3.</td>
                                <td>BORANG JUSTIFIKASI PELAKSANAAN PENGUJIAN CKM.J.02</td>
                                <td class="text-center">
                                    <span class="btn cux-btn small" onclick="openNewTab(7)">Lihat</span>
                                </td>
                            </tr>
                            <tr>
                                <td>4.</td>
                                <td>BORANG SEBUT HARGA</td>
                                <td class="text-center">
                                    <span class="btn cux-btn small" onclick="openNewTab(6)">Lihat</span>
                                </td>
                            </tr>
                            <tr>
                                <td>5.</td>
                                <td>REKOD PENYENGGARAAN</td>
                                <td class="text-center">
                                    <span class="btn cux-btn small" onclick="openNewTab(3)">Lihat</span>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                        <tfoot>
                            <th class="text-center" style="width: 50px;">Bil.</th>
                            <th>Perihal Kerja</th>
                            <th class="text-center">Dokumen</th>
                        </thead>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </fieldset>
</form>

<div class="modal fade" id="prompApprovalModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="prompApprovalModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="margin-top:22vh;-webkit-border-radius: 12px;-moz-border-radius: 12px;border-radius: 12px;">
        <div class="modal-content awas" style="background-image: url({{asset('my-assets/img/awas.png')}});">
            <div class="modal-header" style="height:70px;">
                Pengesahan
                <button type="button" class="btn close" data-dismiss="modal" aria-label="Close" xaction="no" data-bs-dismiss="modal">
                <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body" id="prompt-container">
                <div class="txt-memo">
                    Adakah anda ingin meneruskan proses selesai?
                </div>
            </div>
            <div class="modal-footer">
                <span class="btn btn-module" data-bs-dismiss="modal" onclick="goTabMaintenance()">Ya</span>
                <span class="btn btn-reset" data-bs-dismiss="modal">Tutup</span>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    const fancyView = function(url){

        @if ($jve_form_repair_id)
        url = url+"&jve_form_repair_id={{$jve_form_repair_id}}";
        @endif
        const fancybox = new Fancybox([
        {
            src: url,
            type: "iframe",
        },
        ]);

        fancybox.on("done", (fancybox, slide) => {
        console.log(`done!`);
        });
    }

    function openNewTab(id){


         if(id==1){

            var url = '{{route('maintenance.job.vehicle.market-research')}}?id={{$detail->id}}';
            //alert(url);
            fancyView(url);
            //window.open(url,"PERINCIAN KAJIAN PASARAN");


        }else if(id==2){

            var url = '{{route('maintenance.job.vehicle.external')}}?id={{$detail->id}}';
            //alert(url);
            fancyView(url);
            //window.open(url,"PEMERIKSSAN KERJA LUAR");

        }else if(id==3){

            var url = '{{route('maintenance.job.vehicle.maintenance-record')}}?id={{$detail->id}}';
            //alert(url);
            fancyView(url);
            // window.open(url,"PEMERIKSSAN KERJA LUAR");
        }else if(id==4){

            var url = '{{route('maintenance.job.vehicle.justification-part-1')}}?id={{$detail->id}}';
            //alert(url);
            fancyView(url);
            // window.open(url,"PEMERIKSSAN KERJA LUAR");

        }else if(id==5){

            var url = '{{route('maintenance.job.vehicle.price-list')}}?id={{$detail->id}}';
            //alert(url);
            fancyView(url);
            // window.open(url,"PEMERIKSSAN KERJA LUAR");
            }
        else if(id==6){

            var url = '{{route('maintenance.job.vehicle.quotation')}}?id={{$detail->id}}';
            //alert(url);
            fancyView(url);
            // window.open(url,"MAKLUMAT SEBUT HARGA KENDERAAN / JENTERA");
        }else if(id==7){

            var url = '{{route('maintenance.job.vehicle.justification-part-2')}}?id={{$detail->id}}';
            //alert(url);
            fancyView(url);
            // window.open(url,"PEMERIKSSAN KERJA LUAR");

        }

    }

</script>
