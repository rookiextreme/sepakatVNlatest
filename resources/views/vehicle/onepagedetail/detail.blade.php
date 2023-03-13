@php
    use App\Models\FleetDisposal;
    use App\Models\Fleet\FleetEventHistory;

    $disposalRecord = FleetDisposal::where('no_pendaftaran', $detail['no_pendaftaran'])->first();
    $eventHistory = FleetEventHistory::where('vehicle_id', $detail['id'])->get();

@endphp
<form class="row" id="frm_detail">
    <div class="messages"></div>
    @php
        $srcPage = Request('src');
        $publicPath = "";
        if($detail && $detail->hashVehicleImagePrimary() && $detail->hashVehicleImagePrimary()->doc_path_thumbnail){
            $publicPath = '/'.$detail->hashVehicleImagePrimary()->doc_path_thumbnail.'/'.$detail->hashVehicleImagePrimary()->doc_name;
        }

        $doc_path = $detail->hasVocDoc() ? $detail->hasVocDoc()->doc_path : '';
        $doc_name = $detail->hasVocDoc() ? $detail->hasVocDoc()->doc_name : '';
        $pathUrl = $doc_path != '' ? '/storage/'.$doc_path.'/'.$doc_name : '';
    @endphp
    <input type="hidden" name="section" value="detail">
    <input type="hidden" name="current_fleet_table" value="{{$currentFleetTable}}">
    <div id="printMe" class="printme" style="width:900px">
            <div class="row mb-2" id="vehicle_photo">
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 line-r">
                    <div class="polaroid">
                        {{--<div class="box-left" data-bs-toggle="modal"  data-bs-target="#vehicleImagesModal" onclick="loadVehicleImages({{$detail->id}})" style="background-image: url({{!empty($publicPath) ? $publicPath : asset('my-assets/fleet-img/no-image-min.png') }});">&nbsp;</div>
                        <div class="plet-no">{{ isset($detail['no_pendaftaran']) ? $detail['no_pendaftaran'] : '-' }}</div>--}}
                        <div class="box-left" data-bs-toggle="modal"  data-bs-target="#vehicleImagesModal" onclick="loadVehicleImages({{$detail->id}})"><img src="{{!empty($publicPath) ? $publicPath : asset('my-assets/fleet-img/no-image-min.png') }}" width="100%"/></div>

                        <div class="plet-no">{{ isset($detail['no_pendaftaran']) ? $detail['no_pendaftaran'] : '-' }}</div>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-4 no-printme">
                    <div class="float-end">
                        <div class="btn-group">
                            <span class="btn cux-btn small" onClick="javascript:openPgInFrame('{{ route('vehicle.register',  ['id' => $detail->id, 'fleet_view' => $fleet_view ]) }}')"> <i class="fal fa-edit"></i> Kemaskini</span>
                            <span class="btn cux-btn small" onClick="window.print()"> <i class="fal fa-print"></i> Cetak</span>
                        </div>
                    </div>
                </div>
                    <fieldset>
                        <legend>Maklumat Kenderaan</legend>
                        <div class="row box-info">
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">No Pendaftaran</div>
                            <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{ isset($detail['no_pendaftaran']) ? $detail['no_pendaftaran'] : '-' }}</div>
                        </div>
                        <div class="row box-info">
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Hak Milik</div>
                            <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{ $detail && $detail->hasOwnerType ? $detail->hasOwnerType->desc_bm : '-' }}</div>
                        </div>
                        <div class="row box-info">
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Lokasi Penempatan</div>
                            <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{ $detail && $detail->hasPlacement() ? $detail->hasPlacement()->desc : '-' }}</div>
                        </div>
                        <div class="row box-info">
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Negeri</div>
                            <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{ isset($detail->hasState->desc) ? $detail->hasState->desc : '-' }}</div>
                        </div>

                        <div class="row box-info">
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Cawangan / Bahagian</div>
                            <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{ isset($detail->cawangan->name) ? $detail->cawangan->name : '-' }}</div>
                        </div>
                        <div class="row box-info">
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">No JKR</div>
                            <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{ isset($detail['no_jkr']) ? $detail['no_jkr'] : '-' }}</div>
                        </div>
                        <div class="row box-info">
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Status</div>
                            <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{$detail && $detail->hasVehicleStatus ? $detail->hasVehicleStatus->desc:''}}</div>
                        </div>
                        <div class="row box-info">
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Kategori</div>
                            <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{$detail->hasCategory() ? $detail->hasCategory()->name:''}} > {{$detail->hasSubCategory()? $detail->hasSubCategory()->name:''}}</div>
                        </div>
                        <div class="row box-info">
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Jenis</div>
                            <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{$detail->hasSubCategoryType() ? $detail->hasSubCategoryType()->name:''}}</div>
                        </div>
                        <div class="row box-info">
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">No Loji</div>
                            <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{isset($detail['no_loji']) ? $detail['no_loji'] : "-"}}</div>
                        </div>
                        <div class="row box-info">
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Tarikh Cukai Jalan</div>
                            <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{isset($detail['tarikh_cukai_jalan']) ? $detail['tarikh_cukai_jalan'] : "-"}}</div>
                        </div>
                        <div class="row box-info">
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Harga Perolehan</div>
                            <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{isset($detail['harga_perolehan']) ? $detail['harga_perolehan'] : "-"}}</div>
                        </div>
                        <div class="row box-info">
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Tarikh Pembelian</div>
                            <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{isset($detail['acqDt']) ? \Carbon\Carbon::parse($detail['acqDt'])->format('d M Y') : "-"}}</div>
                        </div>
                        <div class="row box-info">
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Pemeriksaan Keselamatan</div>
                            <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{isset($detail['tarikh_pemeriksaan_keselamatan']) ? $detail['tarikh_pemeriksaan_keselamatan'] : "-"}}</div>
                        </div>
                        <div class="row box-info">
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Pegawai Bertanggungjawab</div>
                            <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{ $detail && $detail->hasPersonIncharge ? $detail->hasPersonIncharge->name : '-' }}</div>
                        </div>
                        @IF ($detail && $detail->hasMainDriver)
                        <div class="row box-info">
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Pemandu</div>
                            <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{ $detail && $detail->hasMainDriver ? $detail->hasMainDriver->name : '-' }}</div>
                        </div>
                        @endif
                    </fieldset>
                    <p>&nbsp;</p>
                    <fieldset>
                        <legend>Geran / VOC</legend>
                        <div class="row box-info">
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">No Enjin</div>
                            <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{isset($detail['no_engine'])? $detail['no_engine'] : ''}}</div>
                        </div>
                        <div class="row box-info">
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">No Chasis</div>
                            <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{isset($detail['no_chasis']) ? $detail['no_chasis'] : ''}}</div>
                        </div>
                        <div class="row box-info">
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Pembuat</div>
                            <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{$detail->hasBrand() ? $detail->hasBrand()->name:''}}</div>
                        </div>
                        <div class="row box-info">
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Model</div>
                            <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{$detail->hasVehicleModel()? $detail->hasVehicleModel()->name:''}}</div>
                        </div>
                        <div class="row box-info">
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Tahun Dibuat</div>
                            <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{isset($detail['manufacture_year']) ? $detail['manufacture_year'] : "-"}}</div>
                        </div>
                        <div class="row box-underline">
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Muat Turun Dokumen</div>
                            @if($detail->hasVocDoc())
                                @php
                                    $format = explode('.',$doc_name);
                                    $format = array_pop($format);
                                    $arrayFormatDownload = ['xlsx','xls','doc','docx'];
                                @endphp
                            @endif
                            <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">
                                @if($detail->hasVocDoc())
                                <button type="button" class="btn cux-btn small btn-file" @if($detail->hasVocDoc()) data-url="{{$pathUrl}}" data-download="{{in_array($format, $arrayFormatDownload)?'true': ''}}" onclick="fancyView(this)" @endif style="margin-left:-2px;margin-top:-4px"><i class="fas fa-file-pdf"></i> Muat Turun Geran / VOC</button>
                                @else
                                Tiada Dokumen
                                @endif
                            </div>
                        </div>
                    </fieldset>
                    <p>&nbsp;</p>
                    <fieldset>
                        <legend>Rekod Pelupusan</legend>
                        <div class="row box-info">
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Tarikh </div>
                            <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{isset($disposalRecord['dispose_dt']) ? \Carbon\Carbon::parse($disposalRecord['dispose_dt'])->format('d M Y') : "-"}}</div>
                        </div>
                    </fieldset>
                    <p>&nbsp;</p>
                    <fieldset>
                        <legend>Sejarah</legend>
                        @if($detail['no_pendaftaran'] == 'WU7')
                            <div class="row">
                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2 rlabel" style="position: relative"><div class="bulat"></div> <div class="peristiwa">12 Feb 2021</div></div>
                                <div class="col-xl-10 col-lg-10 col-md-9 col-sm-9 col-9">
                                    <div class="revent">Penilaian Pelupusan</div>
                                </div>
                            </div>
                            <div class="row gap-row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"><div class="gap-line"></div></div>
                                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9 col-9"></div>
                            </div>
                            <div class="row">
                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2 rlabel"style="position: relative"><div class="bulat"></div> <div class="peristiwa">4 Apr 2021</div></div>
                                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9 col-9">
                                    <div class="revent">Pembaikan</div>
                                </div>
                            </div>
                        @elseif ($detail['no_pendaftaran'] == 'WWB9334')
                            <div class="row">
                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2 rlabel" style="position: relative"><div class="bulat"></div> <div class="peristiwa">30 Jun 2020</div></div>
                                <div class="col-xl-10 col-lg-10 col-md-9 col-sm-9 col-9">
                                    <div class="revent">Penilaian Kenderaan Baharu</div>
                                </div>
                            </div>
                            <div class="row gap-row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"><div class="gap-line"></div></div>
                                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9 col-9"></div>
                            </div>
                            <div class="row">
                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2 rlabel"style="position: relative"><div class="bulat"></div> <div class="peristiwa">25 Apr 2019</div></div>
                                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9 col-9">
                                    <div class="revent">Pemeriksaan</div>
                                </div>
                            </div>
                        @elseif ($detail['no_pendaftaran'] == 'WWE3648')
                            <div class="row">
                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2 rlabel" style="position: relative"><div class="bulat"></div> <div class="peristiwa">3 Julai 2020</div></div>
                                <div class="col-xl-10 col-lg-10 col-md-9 col-sm-9 col-9">
                                    <div class="revent">Penilaian Keselamatan & Prestasi</div>
                                </div>
                            </div>
                            <div class="row gap-row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"><div class="gap-line"></div></div>
                                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9 col-9"></div>
                            </div>
                            <div class="row">
                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2 rlabel"style="position: relative"><div class="bulat"></div> <div class="peristiwa">16 Ogos 2020</div></div>
                                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9 col-9">
                                    <div class="revent">Logistik</div>
                                </div>
                            </div>
                        @elseif ($detail['no_pendaftaran'] == 'WXP3225')
                            <div class="row">
                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2 rlabel" style="position: relative"><div class="bulat"></div> <div class="peristiwa">19 September 2021</div></div>
                                <div class="col-xl-10 col-lg-10 col-md-9 col-sm-9 col-9">
                                    <div class="revent">Siap Siaga Bencana</div>
                                </div>
                            </div>
                            <div class="row gap-row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"><div class="gap-line"></div></div>
                                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9 col-9"></div>
                            </div>
                            <div class="row">
                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2 rlabel"style="position: relative"><div class="bulat"></div> <div class="peristiwa">17 Julai 2021</div></div>
                                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9 col-9">
                                    <div class="revent">Penilaian Pelupusan</div>
                                </div>
                            </div>
                        @else
                            @if(count($eventHistory))
                                @foreach ($eventHistory as $eventList)
                                    <div class="row">
                                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2 rlabel" style="position: relative"><div class="bulat"></div> <div class="peristiwa">{{Carbon\Carbon::parse($eventList['event_dt'])->format('d M Y')}}</div></div>
                                        <div class="col-xl-10 col-lg-10 col-md-9 col-sm-9 col-9">
                                            <div class="revent">{{$eventList->hasEvent()->desc}}</div>
                                        </div>
                                    </div>
                                    <div class="row gap-row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"><div class="gap-line"></div></div>
                                        <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9 col-9"></div>
                                    </div>
                                @endforeach
                            @else
                                <div class="row">
                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2 rlabel" style="position: relative"><div class="bulat"></div> <div class="peristiwa"></div></div>
                                    <div class="col-xl-10 col-lg-10 col-md-9 col-sm-9 col-9">
                                        <div class="revent">Tiada Rekod Sejarah</div>
                                    </div>
                                </div>
                            @endif
                        @endif

                    </fieldset>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
            </div>
    </div>
    @if (empty($is_display) && $is_display == 0)
        <div class="row">
            @php
                $allowBtnSave = ['01', '02'];
                $allowBtnVerification = ['01'];
                $allowBtnVerify = ['02'];
                $allowBtnApproval = ['03'];
            @endphp

            <div class="col-12 mt-2 mb-2">
                <hr/>
                <div class="form-group center">
                    @if ((auth()->user()->isAdmin() && $detail) || !$detail || $detail->vAppStatus  && in_array($detail->vAppStatus->code, $allowBtnSave) || $TaskFlowAccessVehicle->mod_fleet_approval)
                        <button class="btn btn-module" type="submit">Simpan</button>
                    @endif
                    @if ($detail && $detail->vAppStatus())
                        @if (in_array($detail->vAppStatus->code, $allowBtnVerification))
                            <a class="btn btn-module" data-bs-toggle="modal"
                                data-bs-target="#submitVerificationModal">Hantar</a>
                        @endif

                        @if ($TaskFlowAccessVehicle->mod_fleet_verify)
                            @if (in_array($detail->vAppStatus->code, $allowBtnVerify))
                                <button class="btn cux-btn bigger" data-bs-toggle="modal"
                                    data-bs-target="#verifyVehicleModal" type="button" data-toggle="popover"
                                    data-trigger="focus" data-placement="top" data-content="Semak"><i
                                        class="fa fa-check"></i>&nbsp;Semak</button>
                            @endif
                        @endif

                        @if ($TaskFlowAccessVehicle->mod_fleet_approval)
                            @if (in_array($detail->vAppStatus->code, $allowBtnApproval))
                                <button class="btn cux-btn bigger" data-bs-toggle="modal"
                                    data-bs-target="#approvalVehicleModal" type="button" data-toggle="popover"
                                    data-trigger="focus" data-placement="top" data-content="Sah"><i
                                        class="fa fa-check"></i>&nbsp;Sah</button>
                            @endif
                        @endif

                    @endif
                </div>
            </div>
        </div>
    @endif
</form>
<div class="modal fade modal-dialog-scrollable" id="vehicleImagesModal" tabindex="-1" aria-labelledby="vehicleImagesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="height: auto">
        <div class="modal-content" style="position: relative;width:100%;">
            <div class="modal-header">Imej Kenderaan
                <button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close" style="position:absolute;right:15px;top:15px;z-index:10"></button>
            </div>
            <div class="modal-body" style="min-height:600px">
                <div id="vehicle-images" style="width:100%"></div>
            </div>
        </div>
    </div>
</div>
<div>
    <!-- Bootstrap -->
    <!-- Modal Popup -->
    <div id="MyPopup" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        &times;</button>
                    <h4 class="modal-title">
                    </h4>
                </div>22
                <a href="#" class="btnShowPopup">
                    <img src="http://static.flickr.com/66/199481236_dc98b5abb3_s.jpg" style="width: 150px;
                        height: 100px;"/>
                </a><a href="#" class="btnShowPopup">
                    <img src="http://static.flickr.com/75/199481072_b4a0d09597_s.jpg" style="width: 100px;
                        height: 100px;"/>
                </a><a href="#" class="btnShowPopup">
                    <img src="http://static.flickr.com/57/199481087_33ae73a8de_s.jpg" style="width: 150px;
                        height: 100px;"/>
                </a><a href="#" class="btnShowPopup">
                    <img src="http://static.flickr.com/77/199481108_4359e6b971_s.jpg" style="width: 150px;
                        height: 100px;"/>
                </a><a href="#" class="btnShowPopup">
                    <img src="http://static.flickr.com/58/199481143_3c148d9dd3_s.jpg" style="width: 150px;
                        height: 100px;"/>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="enlargeImageModal" tabindex="-1" aria-labelledby="enlargeImageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

        <div class="modal-body">
          <h5 class="modal-title mt-3 mb-3 text-dark" id="exampleModalLabel"></h5>
          <div class="text-center" style="overflow: auto; height: 500px">
            <img id="enlarge_img" src="{{!empty($publicPath) ? $publicPath : asset('my-assets/fleet-img/no-image-min.png') }}" class="preview-image">
          </div>
        </div>
        <div class="modal-footer float-start">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

  {{-- <input type="button" id="openModalBtn" value="Open Modal"> --}}

        <div id="openModal1" class="modalDialog" data-modalorder=1>
            <div>
                <a href="#close" title="Close" class="close">X</a>
                <img id="enlarge_img" src="{{!empty($publicPath) ? $publicPath : asset('my-assets/fleet-img/no-image-min.png') }}" class="preview-image">
                <div class="text-center">
                    <input class="getAssignment2" type="button" value="Previous">
                    <input class="getAssignment" type="button" value="Next">
                </div>
            </div>

        </div>

        <div id="openModal2" class="modalDialog" data-modalorder=2>
            <div>
                <a href="#close" title="Close" class="close">X</a>
                <img id="enlarge_img" src="{{!empty($publicPath) ? $publicPath : asset('my-assets/fleet-img/no-image-min.png') }}" class="preview-image">
                <input class="getAssignment2" type="button" value="Previous">
                <input class="getAssignment" type="button" value="Next">
            </div>
        </div>

        <div id="openModal3" class="modalDialog" data-modalorder=3>
            <div>
                <a href="#close" title="Close" class="close">X</a>
                <img id="enlarge_img" src="{{!empty($publicPath) ? $publicPath : asset('my-assets/fleet-img/no-image-min.png') }}" class="preview-image">
                <input class="getAssignment2" type="button" value="Previous">
                <input class="getAssignment" type="button" value="Next">
            </div>
        </div>
<script type="text/javascript">

    var sectorId = -1;
    var branchId = -1;
    // var subCategoryTypeId = -1;
    var divisionId = -1;
    var placementDivisionId = -1;

    @if ($detail && $detail->cawangan)
        branchId = '{{$detail->cawangan->id}}';
    @endif

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

    function openEnlargeModal(){
            $('#enlargeImageModal').modal('show');
        }

    // function print(target) {
    //     let prevWidth = $('#vehicle_photo').innerWidth();
    //     $('.rlabel').append('<label class="dott">:</label>');
    //     $('.rlabel,.mytext').css({'display':'inline'});
    //     $('#vehicle_photo').css({
    //         'width':'500px',
    //         'margin-left': 'auto',
    //         'margin-right': 'auto'
    //     });
    //     let prevImgWidth = 200;
    //     let prevImgHeight = $('#vehicle_photo .polaroid .box-left').innerHeight();
    //     $('#vehicle_photo .polaroid .box-left').css({
    //         'width': '200px',
    //         'height':'100px',
    //         'background-repeat': 'no-repeat',
    //         'background-size': 'contain'
    //     });
    //     $('.btn').hide();
    //     let res = Popup($('<div/>').append($('#'+target).clone()).html());
    //     res.document.close();
    //     console.log(res);
    //     $('.rlabel .dott').remove();
    //     $('.rlabel,.mytext').css({'display':'inherit'});
    //     $('.btn').show();
    //     $('#vehicle_photo').css({
    //         'width':prevWidth,
    //         'margin-left': '-12px',
    //         'margin-right': '-12px'
    //     });
    //     $('#vehicle_photo .polaroid .box-left').css({
    //         'width': 'unset',
    //         'height':prevImgHeight
    //     });

    // }

    // function Popup(data)
    // {
    //     var a = window.open('data', 'mydiv','height=400,width=600,scrollbars=yes','');
    //     a.document.write(data);
    //     a.print();
    //     return a;
    // }


    function checkExistRegNumber(reg_no){
        $.ajax({
            url: "{{ route('vehicle.checkExistRegNumber') }}",
            type: 'post',
            data: {
                reg_no: reg_no,
                '_token': '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function(isExist) {

                let errorsHtml = '';
                if(isExist == 1){
                    errorsHtml = '<div class="alert alert-danger mb-0 pb-0"><li>No Pendaftaran '+reg_no+' Telah Wujud</li><ul>';
                    //$('#reg_no').val('');
                }
                $('.messages').html(errorsHtml);
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

    function getPlacement(reg_negeri){

        $('#list_lokasi').html('<option value="-1">Sila Pilih</option>');

        $.get("{{route('vehicle.ajax.getPlacement')}}", {
            reg_negeri: reg_negeri
        }, function(result){

            var count = result.length;
            var totalInit = 0;
            var same = false;

            result.forEach(element => {

                $('#list_lokasi').append('<option value='+element.id+'>'+element.desc+'</option>');
                    if(divisionId == element.id){
                        same = true;
                    }
                    totalInit++;
                });

                if(count == totalInit){
                    if(!same){
                        divisionId = -1;
                    }
                    $('#list_lokasi').val(divisionId).trigger("change");
                }

        });
    }



    function getBranchOwner(owner_type_id){

        $('#list_cawangan').html('<option value="-1" selected>Sila Pilih</option>');

        $.get("{{route('vehicle.ajax.getBranchOwner')}}", {
            owner_type_id: owner_type_id
        }, function(result){

            var count = result.length;
            var totalInit = 0;
            var same = false;

            result.forEach(element => {

                $('#list_cawangan').append('<option value='+element.id+'>'+element.name+'</option>');
                    if(branchId == element.id){
                        same = true;
                    }
                    totalInit++;
                });

                if(count == totalInit){
                    if(!same){
                        branchId = -1;
                    }
                    $('#list_cawangan').val(branchId).trigger("change");
                }

        });
    }

    function submitDetail(data) {

        parent.startLoading();
        $.ajax({
            url: "{{ route('vehicle.register.save') }}",
            type: 'post',
            data: data,
            dataType: 'json',
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

    function loadVehicleImages(vehicle_id){ /////
        $.get("{{route('vehicle.ajax.getModalVehicleImages')}}", {
            'vehicle_id': vehicle_id,
            'fleet_view': '{{$fleet_view}}'
        }, function(res){
            $('#vehicle-images').html(res);
            $('#vehicleImagesIndicators').carousel({
                interval: 3000,
                cycle: true
            });
        });
    }

    $(document).ready(function() {

        var data=[];
            currentModal = 0;

            $('.modalDialog').each(function(){
                data.push({
                id: $(this).attr('id'),
                order: $(this).data('modalorder')
                });
            })

                $('#openModalBtn').click(function(){
                currentModal = 0;
                window.location.href = "#" + data[currentModal].id;
                $('#'+data[currentModal].id).find('.getAssignment2').prop('disabled', true);
            })

            //prev
            $('.getAssignment2').click(function(){
                if (currentModal>0) {
                    currentModal--;
                window.location.href = "#" + data[currentModal].id;
                } else {

                    window.location.href = '#'
                }
            })

            //next
            $('.getAssignment').click(function(){
                if (currentModal<data.length - 1) {
                    currentModal++;
                if (currentModal===data.length - 1) $('#'+data[currentModal].id).find('.getAssignment').prop('disabled', true);
                window.location.href = "#" + data[currentModal].id;
                } else {
                    window.location.href = '#'
                }
            })

        $(function () {
            $("#btnShowPopup").click(function () {
                $("#MyPopup").modal("show");
            });
        });

        @if ($detail && $detail->hasOwnerType)
        getBranchOwner('{{$detail->hasOwnerType->id}}');
        @endif

        $('#reg_no').on('keyup', function (e) {
            var data= this.value;
            var checkRegex = /^[0-9]*$/;
            var isNumberAlpha = checkRegex.test(data);
            if(!isNumberAlpha){
                e.preventDefault();
                data = data.replace(/[^\w\s]/gi, '');
                $(this).val(data.trim());
                return false;
            }
        });

        $('#reg_no').on('change', function(e){
            e.preventDefault();
            checkExistRegNumber(this.value);
        });

        $('#reg_hak').on('change', function(e){
            e.preventDefault();
            const id =  this.value;
            const xcode =  $('option:selected', this).attr('xcode');
            let branch_container = $('#branch_container');
            let project_name_container = $('#project-name-container');
            let detail_project_container = $('#detail-project-container');
            console.log('xcode --> ', xcode);
            if(xcode == '01' || xcode == '02'){
                getBranchOwner(id);
                branch_container.show();
                project_name_container.hide();
                detail_project_container.hide();
            } else {
                detail_project_container.show();
                project_name_container.show();
                branch_container.hide();
            }
        });

        $('#frm_detail').on('submit', function(e) {
            e.preventDefault();

            var formData = $(this).serialize();
            formData += "&_token={{ csrf_token() }}";
            formData += "&fleet_view={{$fleet_view}}";
            submitDetail(formData);

        });
    })

    changeToUpperCase = function(self){
        self.value = self.value.toLocaleUpperCase();
    }
</script>
