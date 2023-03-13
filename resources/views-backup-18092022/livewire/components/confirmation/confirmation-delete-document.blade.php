<div>
    <div wire:ignore.self class="modal fade" id="confirmationDeleteModal" tabindex="-1" aria-labelledby="confirmationDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            
            <div class="modal-body">
                @if (empty($success))
                    <h5 class="modal-title mt-3 mb-3 text-dark" id="exampleModalLabel">Adakah anda ingin menghapuskan fail ini ?</h5>
                @else
                    <div class="alert alert-warning text-center">{{$success}}</div>
                @endif
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                @empty($success)
                <a  class="btn btn-primary text-white" wire:click.prevent="deleteDocument({{$this->doc_id}})">Pasti</a>
                @endempty
            </div>
          </div>
        </div>
    </div>
</div>