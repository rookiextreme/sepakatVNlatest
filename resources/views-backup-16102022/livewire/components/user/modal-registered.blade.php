<div>
    <div wire:ignore.self class="modal fade" id="revokeModal" tabindex="-1" aria-labelledby="revokeModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
              @if (empty($success))
                  <h5 class="modal-title mt-3 mb-3 text-dark">Adakah anda ingin membuang pengguna ini?</h5>
                  <label class="label-control">Nyatakan Sebab</label>
                  <textarea style="resize: none;" class="form-control" wire:model="commentStatus" rows="5"></textarea>
                  @error('commentStatus') <span class="error text-danger">{{ $message }}</span> @enderror
              @else
                  <div class="alert alert-warning text-center">{{$success}}</div>
              @endif
              
          </div>
          <div class="modal-footer">
            <button wire:click.prevent="close" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            @empty($success)
                <a  class="btn btn-primary text-white" wire:click.prevent="revoke({{$this->user_id}})">Pasti</a>
            @endempty
          </div>
        </div>
      </div>
    </div>
    <div wire:ignore.self class="modal fade" id="lockModal" tabindex="-1" aria-labelledby="lockModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form wire:submit.prevent="lock({{$this->user_id}})">
          <div class="modal-body">
              @if (empty($success))
                  <h5 class="modal-title mt-3 mb-3 text-dark">Adakah anda ingin mengunci pengguna ini?</h5>
                  <div class="form-group">
                    <label class="label-control">Dikunci sehingga:</label>

                  <div wire:ignore class="input-group date" id="lockedDt"
                      data-target-input="nearest" data-lockeddt="@this">
                          <input wire:model="end_dt" data-target="#lockedDt" id="lockedDtInput"
                          type="text" class="form-control datepicker" placeholder="" 
                          autocomplete="off"
                          data-provide="datepicker" data-date-autoclose="true" 
                          data-date-format="yyyy-mm-dd" data-date-today-highlight="true" />

                          <div class="input-group-text" for="lockedDtInput">
                              <i class="fa fa-calendar"></i>
                          </div>
                  </div>
                    @error('end_dt') <span class="error text-danger">{{ $message }}</span> @enderror
                  </div>
                  <div class="form-group">
                    <label class="label-control">Nyatakan Sebab</label>
                    <textarea style="resize: none;" class="form-control" wire:model.lazy="commentStatus" rows="5"></textarea>
                    @error('commentStatus') <span class="error text-danger">{{ $message }}</span> @enderror
                  </div>
              @else
                  <div class="alert alert-warning text-center">{{$success}}</div>
              @endif
              
          </div>
          <div class="modal-footer">
            <button wire:click.prevent="close" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            @empty($success)
                <button  class="btn btn-primary text-white" type="submit" >Pasti</a>
            @endempty
          </div>
          </form>
        </div>
      </div>
    </div>
</div>