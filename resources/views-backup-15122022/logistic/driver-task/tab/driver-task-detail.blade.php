<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="" class="form-label">Nama Pemohon</label>
            <div class="text-uppercase">{{ $detail->booking_person_name }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="" class="form-label">Nombor Telefon</label>
            <div class="text-uppercase">{{ $detail->tel_no }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="" class="form-label">Destinasi</label>
            <div class="text-uppercase">{{ $detail->destination }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="" class="form-label">Destinasi</label>
            <div class="text-uppercase">{{ $detail->destination }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="" class="form-label">Tujuan</label>
            <div class="text-uppercase">{{ $detail->reason }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="" class="form-label">Tarikh Tempahan</label>
            <div class="text-uppercase">{{ \Carbon\Carbon::parse($detail->created_at)->format('d/m/Y') }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="" class="form-label">Tarikh & Masa Pergi</label>
            <div class="text-uppercase">{{ \Carbon\Carbon::parse($detail->start_datetime)->format('d/m/Y h:m:s A') }}
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="" class="form-label">Tarikh & Masa Balik</label>
            <div class="text-uppercase">{{ \Carbon\Carbon::parse($detail->end_datetime)->format('d/m/Y h:m:s A') }}
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="" class="form-label">Mod</label>
            <div class="text-uppercase">{{$detail->hasStayStatus ? $detail->hasStayStatus->desc : '-'}}
            </div>
        </div>
    </div>
</div>

<div class="row mt-2">
    <div class="col-md-12">
        @foreach ($detail->hasManyAssignedVehicleWithDriver as $vehicle)
        <div class="divider-line mt-2"></div>
        <div class="row">
            <div class="col-md-8">
                <fieldset>
                    <legend>Maklumat Kenderaan</legend>
                    <div class="row box-info">
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">No Pendaftaran</div>
                        <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{$vehicle->hasAssignedVehicle->no_pendaftaran}}</div>
                    </div>
                    <div class="row box-info">
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Hak Milik</div>
                        <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{ $vehicle->hasAssignedVehicle && $vehicle->hasAssignedVehicle->hasOwnerType ? $vehicle->hasAssignedVehicle->hasOwnerType->desc_bm : '-' }}</div>
                    </div>
                    <div class="row box-info">
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Lokasi Penempatan</div>
                        <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{ $vehicle->hasAssignedVehicle && $vehicle->hasAssignedVehicle->hasPlacement() ? $vehicle->hasAssignedVehicle->hasPlacement()->desc : '-' }}</div>
                    </div>
                    <div class="row box-info">
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Negeri</div>
                        <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{ isset($vehicle->hasAssignedVehicle->hasState->desc) ? $vehicle->hasAssignedVehicle->hasState->desc : '-' }}</div>
                    </div>
                
                    <div class="row box-info">
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Cawangan / Bahagian</div>
                        <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{ isset($vehicle->hasAssignedVehicle->cawangan->name) ? $vehicle->hasAssignedVehicle->cawangan->name : '-' }}</div>
                    </div>
                    <div class="row box-info">
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">No JKR</div>
                        <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{ isset($vehicle->hasAssignedVehicle['no_jkr']) ? $vehicle->hasAssignedVehicle['no_jkr'] : '-' }}</div>
                    </div>
                    <div class="row box-info">
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Status</div>
                        <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{$vehicle->hasAssignedVehicle && $vehicle->hasAssignedVehicle->hasVehicleStatus ? $vehicle->hasAssignedVehicle->hasVehicleStatus->desc:''}}</div>
                    </div>
                    <div class="row box-info">
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Kategori</div>
                        <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{$vehicle->hasAssignedVehicle->hasCategory() ? $vehicle->hasAssignedVehicle->hasCategory()->name:''}} > {{$vehicle->hasAssignedVehicle->hasSubCategory()? $vehicle->hasAssignedVehicle->hasSubCategory()->name:''}}</div>
                    </div>
                    <div class="row box-info">
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Jenis</div>
                        <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{$vehicle->hasAssignedVehicle->hasSubCategoryType() ? $vehicle->hasAssignedVehicle->hasSubCategoryType()->name:''}}</div>
                    </div>
                    <div class="row box-info">
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">No Loji</div>
                        <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{isset($vehicle->hasAssignedVehicle['no_loji']) ? $vehicle->hasAssignedVehicle['no_loji'] : "-"}}</div>
                    </div>
                    <div class="row box-info">
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Tarikh Cukai Jalan</div>
                        <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{isset($vehicle->hasAssignedVehicle['tarikh_cukai_jalan']) ? $vehicle->hasAssignedVehicle['tarikh_cukai_jalan'] : "-"}}</div>
                    </div>
                    <div class="row box-info">
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Harga Perolehan</div>
                        <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{isset($vehicle->hasAssignedVehicle['harga_perolehan']) ? $vehicle->hasAssignedVehicle['harga_perolehan'] : "-"}}</div>
                    </div>
                    <div class="row box-info">
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Tarikh Pembelian</div>
                        <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{isset($vehicle->hasAssignedVehicle['acqDt']) ? \Carbon\Carbon::parse($vehicle->hasAssignedVehicle['acqDt'])->format('d M Y') : "-"}}</div>
                    </div>
                    <div class="row box-info">
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Pemeriksaan Keselamatan</div>
                        <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{isset($vehicle->hasAssignedVehicle['tarikh_pemeriksaan_keselamatan']) ? $vehicle->hasAssignedVehicle['tarikh_pemeriksaan_keselamatan'] : "-"}}</div>
                    </div>
                    <div class="row box-info">
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Pegawai Bertanggungjawab</div>
                        <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{ $vehicle->hasAssignedVehicle && $vehicle->hasAssignedVehicle->hasPersonIncharge ? $vehicle->hasAssignedVehicle->hasPersonIncharge->name : '-' }}</div>
                    </div>
                    @IF ($vehicle->hasDriver)
                    <div class="row box-info">
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Pemandu</div>
                        <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{ $vehicle->hasDriver ? $vehicle->hasDriver->name : '-' }}</div>
                    </div>
                    @endif
                </fieldset>
            </div>
            <div class="col-md-4">
                <fieldset>
                    <legend>Penumpang</legend>
                    <ul class="ps-0" style="list-style-type:decimal">
                        @foreach ($vehicle->hasManyPassenger as $passenger)
                            <li class="mb-2 form-label">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="" class="form-label" class="form-label">Nama</label>
                                        <div>{{$passenger->name}}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="" class="form-label" class="form-label">Telefon</label>
                                        <div>{{$passenger->phone_no}}</div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </fieldset>
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- <div class="table-responsive">
    <table class="table-custom stripe no-footer">
        <thead>
            <th>Bil</th>
            <th>No Pendaftaran</th>
            <th>Pemandu</th>
            <th>Penumpang</th>
        </thead>
        <tbody>
            
            @foreach ($detail->hasManyAssignedVehicleWithDriver as $task)
                <tr>
                    <td>{{$loop->index+1}}</td>
                    <td>{{$task->hasAssignedVehicle->no_pendaftaran}}</td>
                    <td>{{$task->hasDriver->name}}</td>
                    <td>
                        <ul>
                            @foreach ($task->hasManyPassenger as $passenger)
                                <li>{{$passenger->name}} - {{$passenger->phone_no}}</li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
            @endforeach
            
        </tbody>
    </table>
</div> --}}

<script type="text/javascript">
    $(document).ready(function() {

    })
</script>
