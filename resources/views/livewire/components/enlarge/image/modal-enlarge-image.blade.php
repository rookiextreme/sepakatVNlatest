<div>
    <div wire:ignore.self class="modal fade" id="enlargeImageModal" tabindex="-1" aria-labelledby="enlargeImageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            
            <div class="modal-body">
                @if (empty($success))
                    <h5 class="modal-title mt-3 mb-3 text-dark" id="exampleModalLabel">{{$img_title}}</h5>
                    <img src="{{$img_url}}" width="100%">
                @else
                    <div class="alert alert-warning text-center">{{$success}}</div>
                @endif
                
            </div>
            <div class="modal-footer float-start">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
          </div>
        </div>
    </div>
</div>