
<form class="row" id="frm_detail" enctype="multipart/form-data">

    @csrf

    {{-- <div class="fixed-submit">
        <button class="btn btn-link" type="submit" xaction="draf"><i class="fa fa-save"></i> Simpan Sebagai Draf</button>
    </div> --}}

    <div class="messages"></div>

    <input type="hidden" name="section" value="detail">
    <div class="row">
        <div class="col-md-12 printme">
            <h3 class="text-center">Jabatan Kerja Raya</h3>
            <h4 class="text-center">Laporan Pemeriksaan Dan Pengujian Kenderaan</h4>
        </div>
        <div class="col-md-6">
            <fieldset>
                <legend>Data Kenderaan</legend>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div for="" class="form-label-custom d-inline fs-6 text-left col-md-6">No. Pendaftaran</div>
                            <div class="d-inline fs-6 text-right col-md-6">{{$detail->plate_no}}</div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div for="" class="form-label-custom d-inline fs-6 text-left col-md-6">Kategori</div>
                            <div class="d-inline fs-6 text-right col-md-6">{{$detail->hasCategory ? $detail->hasCategory->name : '-'}}</div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div for="" class="form-label-custom d-inline fs-6 text-left col-md-6">Jenis</div>
                            <div class="d-inline fs-6 text-right col-md-6">{{
                                $detail->hasSubCategory ? 
                                $detail->hasSubCategory->name .($detail->hasSubCategoryType ? ' > '.$detail->hasSubCategoryType->name : '')
                                : '-'
                                }}</div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div for="" class="form-label-custom d-inline fs-6 text-left col-md-6">Pembuat</div>
                            <div class="d-inline fs-6 text-right col-md-6">{{$detail->hasBrand ? $detail->hasBrand->name : '-'}}</div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div for="" class="form-label-custom d-inline fs-6 text-left col-md-6">Model</div>
                            <div class="d-inline fs-6 text-right col-md-6">{{$detail->model_name ? $detail->model_name : '-'}}</div>
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset>
                <legend>Data Pelanggan</legend>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div for="" class="form-label-custom d-inline fs-6 text-left col-md-6">Kementerian</div>
                            <div class="d-inline fs-6 text-right col-md-6">{{$detail->hasMaintenanceDetail->hasAgency->desc}}</div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div for="" class="form-label-custom d-inline fs-6 text-left col-md-6">Jabatan</div>
                            <div class="d-inline fs-6 text-right col-md-6">{{$detail->hasMaintenanceDetail->department_name}}</div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div for="" class="form-label-custom d-inline fs-6 text-left col-md-6">No Rujukan Sistem</div>
                            <div class="d-inline fs-6 text-right col-md-6">{{$detail->hasMaintenanceDetail->ref_number}}</div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div for="" class="form-label-custom d-inline fs-6 text-left col-md-6">Tarikh Masuk</div>
                            <div class="d-inline fs-6 text-right col-md-6">{{\Carbon\Carbon::parse($detail->hasMaintenanceDetail->created_dt)->format('d F Y')}}</div>
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>
        <div class="col-md-12">
            <fieldset>
                <legend>Data Pemeriksaan</legend>
                <div class="row">
                    <div class="col-md-12">
                        @php
                            $index = 0;
                        @endphp
                        <table class="table-custom stripe no-footer">
                            <thead>
                                <th>Bil</th>
                                <th>Sistem</th>
                                <th>Perkara</th>
                                <th>Catatan</th>
                            </thead>
                            <tbody>
                                @foreach ($detail->hasCheckListLvl2WithNote as $lvl2)
                                @php
                                    $index++;
                                @endphp
                                    <tr>
                                        <td>{{$index}}</td>
                                        <td>{{$lvl2->hasComponentLvl2->hashComponentCheckListLvl1->component}}</td>
                                        <td>{{$lvl2->hasComponentLvl2->component}}</td>
                                        <td>{{$lvl2->note}}</td>
                                    </tr>
                                @endforeach
                                @foreach ($detail->hasCheckListLvl3WithNote as $lvl3)
                                    @php
                                        $index++;
                                    @endphp
                                    <tr>
                                        <td>{{$index}}</td>
                                        <td>{{$lvl3->hasComponentLvl3->hashComponentCheckListLvl2->hashComponentCheckListLvl1->component}}</td>
                                        <td>{{$lvl3->hasComponentLvl3->component}}</td>
                                        <td>{{$lvl3->note}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset>
                <legend>Pemeriksa</legend>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div for="" class="form-label-custom d-inline fs-6 text-left col-md-6">Diperiksa Oleh</div>
                                    <div class="d-inline fs-6 text-right col-md-6">{{$detail->assessmentedBy ? $detail->assessmentedBy->name : ''}}</div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div for="" class="form-label-custom d-inline fs-6 text-left col-md-6">Tarikh Periksa</div>
                                    <div class="d-inline fs-6 text-right col-md-6">{{\Carbon\Carbon::parse($detail->assessment_dt)->format('d F Y')}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset>
                <legend>Penyemak</legend>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div for="" class="form-label-custom d-inline fs-6 text-left col-md-6">Disemak Oleh</div>
                                    <div class="d-inline fs-6 text-right col-md-6">{{$detail->verifiedBy ? $detail->verifiedBy->name : ''}}</div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div for="" class="form-label-custom d-inline fs-6 text-left col-md-6">Tarikh Semak</div>
                                    <div class="d-inline fs-6 text-right col-md-6">{{\Carbon\Carbon::parse($detail->verify_dt)->format('d F Y')}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
</form>

<script type="text/javascript">

$(document).ready(function(){

let monitoring_done_dtInput = $('#monitoring_done_dtInput').datepicker();

});

</script>
