<div>
    <div wire:ignore.self class="modal fade" id="vehicleaanSearch" tabindex="-1" aria-labelledby="vehicleaanSearchLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">

            <div class="modal-body">
              <h3 class="text-dark">Pilih vehicleaan</h3>
              <p class="text-muted">Pilih vehicleaan daripada rekod vehicleaan yang berdaftar.</p><hr>
              <div class="row">
                <div class="col-6 mt-2 mb-2">
                  <input type="text" wire:model="vehicle" class="form-control" placeholder="cari vehicleaan">
                </div>
                <div class="col-12 mt-2">
                  <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>No Pendaftaran</th>
                          <th>Cawangan</th>
                          <th>Hak Milik</th>
                          <th>No Telefon</th>
                          <th>Kategori vehicleaan</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($kenderaan as $vehicle)
                          <tr wire:click.prevent="vehicleaan({{$vehicle->id}})" data-bs-dismiss="modal">
                            <td>{{$vehicle->no_pendaftaran}}</td>
                            <td>{{isset($vehicle->cawangan)? $vehicle->cawangan->cawangan : ''}}</td>
                            <td class="text-dark fw-bold">{{isset($vehicle->user) ? $vehicle->user->name : ''}}</td>
                            <td>{{empty($vehicle->user->detail) ? '-' : $vehicle->user->detail->telbimbit}}</td>
                            <td>
                              @if (!empty($vehicle->maklumat->kategori))
                              {{$vehicle->maklumat->kategori->name}}
                              @endif
                               >
                               @if (!empty($vehicle->maklumat->subKategori))
                               {{$vehicle->maklumat->subKategori->sub_kategori}}
                              @endif
                               </td>
                          </tr>
                        @endforeach
                      </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" id="pemilikSearch" tabindex="-1" aria-labelledby="pemilikSearchLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">

            <div class="modal-body">
                <h3 class="text-dark">Pilih Pemilik vehicleaan</h3>
                <p class="text-muted">Pilih vehicleaan daripada rekod vehicleaan yang berdaftar.</p><hr>
                <div class="row">
                  <div class="col-6">
                    <input type="text" wire:model="owner" class="form-control" placeholder="cari vehicleaan">
                  </div>
                  <div class="col-12 mt-2">
                    <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>No Identiti</th>
                            <th>Kakitangan Kerajaan</th>
                            <th>Nama</th>
                            <th>No Telefon</th>
                            <th>Emel</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($pemiliks as $pemilik)
                              <tr wire:click.prevent="pemilik({{$pemilik->user->id}})">
                                <td>{{$pemilik->identity_no}}</td>
                                <td>{{$pemilik->gov_staff ? 'Ya' : 'Tidak'}}</td>
                                <td class="text-dark fw-bold">{{$pemilik->user->name}}</td>
                                <td>{{$pemilik->telbimbit}}</td>
                                <td>{{$pemilik->user->email}}</td>
                              </tr>
                          @endforeach
                        </tbody>
                    </table>
                  </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
    </div>

</div>
