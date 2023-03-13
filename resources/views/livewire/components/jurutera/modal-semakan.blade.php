<div>
    <div class="modal fade" id="verifiedModal" tabindex="-1" aria-labelledby="verifiedModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            
            <div class="modal-body">
                @if (empty($success))
                    <h5 class="modal-title mt-3 mb-3 text-dark" id="exampleModalLabel">Maklumat kenderaan ini telah disemak dan didapati <span class="text-primary">MENEPATI</span>   kriteria yang ditetapkan.</h5>
                    <textarea class="form-control" wire:model="comment" rows="10"></textarea>
                @else
                    <div class="alert alert-warning text-center">{{$success}}</div>
                @endif
                
            </div>
            <div class="modal-footer float-start">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
              @empty($success)
                 <button type="button" class="btn btn-primary text-white" wire:click.prevent="pasti">Pasti</button>
              @endempty
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="gagalModal" tabindex="-1" aria-labelledby="gagalModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            
            <div class="modal-body">
                @if (empty($success))
                    <h5 class="modal-title mt-3 mb-3 text-dark" id="exampleModalLabel">Maklumat kenderaan ini telah disemak dan didapati <span class="text-danger">TIDAK MENEPATI</span> kriteria yang ditetapkan.</h5>
                    <p class="text-muted">
                        Adakah anda pasti untuk menyerahkan rekod ini untuk proses pengesahan.
                    </p>
                    <textarea class="form-control" wire:model="comment" rows="10"></textarea>
                @else
                     <div class="alert alert-warning text-center">{{$success}}</div>
                @endif
            </div>
            <div class="modal-footer float-start">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
              @empty($success)
                 <button class="btn btn-danger text-white" wire:click="batalRekod">Batal Rekod</button>
                <button type="button" class="btn btn-primary text-white" wire:click.prevent="semakanSemula">Semakan Semula</button>
              @endempty
            </div>
          </div>
        </div>
      </div>
</div>
