<div class="">
    <div class="mt-2">
        
        <ul class="nav nav-tabs mb-2" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link {{$tab == 'pendaftaran' ? 'active' : ''}}" wire:click="$set('tab', 'pendaftaran')">Maklumat Pembyaran</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link {{$tab == 'maklumat' ? 'active' : ''}}" wire:click="$set('tab', 'maklumat')">Muat Naik</button>
            </li>
           
        </ul>
        <div class="tab-content" id="myTabContent">
            <form wire:submit.prevent="store">
                @if ($tab == 'pendaftaran')
                    <div class="row">
                        <div class="col-6">
                            <div class="row">
                                <div class="col-6 mt-4">
                                    <label for="" class="form-label">No Resit</label>
                                    <input type="text" wire:model="bayar.resit" class="form-control">
                                </div>
                                <div class="col-6 mt-4">
                                    <label for="" class="form-label">Jumlah Bayaran</label>
                                    <input type="text" wire:model="bayar.jumlah" class="form-control">
                                </div>
                                <div class="col-6 mt-4">
                                    <label for="" class="form-label">Tarikh Bayaran</label>
                                    <input type="date" wire:model="bayar.tarikh" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif($tab == 'maklumat')
                    <div class="row">
                        <div class="col-6">
                            <div class="row">
                                <div class="col">
                                    <label for="" class="form-label text-dark">Resit Pembayaran</label>
                                    <div class="input-group mb-3">
                                        <input type="file" wire:model="dokumen" class="form-control" id="inputGroupFile02">
                                        <label class="input-group-text" for="inputGroupFile02">Upload</label>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h4 class="fw-bold text-dark">Dokumen</h4><hr>
                            <a href="{{empty($bayar['url']) ? '' : $bayar['url']}}"></a>
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-3 mt-4">
                        <button class="btn btn-success text-white" type="submit">Hantar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
</div>