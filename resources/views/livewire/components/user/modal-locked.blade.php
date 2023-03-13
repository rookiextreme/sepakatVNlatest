<div>
    <div wire:ignore.self class="modal fade" id="giveAccessModal" tabindex="-1" aria-labelledby="giveAccessModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
              @if (empty($success))
                  <h5 class="modal-title mt-3 mb-3 text-dark">Adakah anda ingin memberikan akses semua kepada pengguna ini?</h5>
              @else
                  <div class="alert alert-warning text-center">{{$success}}</div>
              @endif
              
          </div>
          <div class="modal-footer float-start">
            <button wire:click.prevent="close" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            @empty($success)
                <a  class="btn btn-primary text-white" wire:click.prevent="giveAccess({{$this->user_id}})">Pasti</a>
            @endempty
          </div>
        </div>
      </div>
    </div>
</div>