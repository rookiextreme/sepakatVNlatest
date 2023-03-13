<div>
    <div wire:ignore.self class="modal fade"  id="setRoleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="setRoleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
              @if (empty($success))
                <div class="col-md-6">
                    <label for="" class="form-label text-dark">Tetapan Peranan</label>
                    <div class="input-group mb-3">
                      <select class="form-select" wire:model="user_role" >
                          <option selected>Pilih Peranan</option>
                          @foreach ($roles as $role )
                            <option value="{{$role->detail->name}}">{{$role->desc_bm}}</option> 
                          @endforeach
                      </select>
                      @error('user_role') <span class="error text-danger">{{ $message }}</span> @enderror
                  </div>
                </div>
              @else
                  <div class="alert alert-warning text-center">{{$success}}</div>
              @endif
              
          </div>
          <div class="modal-footer d-flex justify-content-between">
            <button wire:click.prevent="close" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            @empty($success)
                <a  class="btn btn-primary text-white" wire:click.prevent="setRole({{$this->user_id}})" data-bs-dismiss="modal">Pasti</a>
            @endempty
          </div>
        </div>
      </div>
    </div>
    <div wire:ignore.self class="modal fade" id="approvalModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="approvalModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
              @if (empty($success))
                  <h5 class="modal-title mt-3 mb-3 text-dark">Maklumat pengguna ini telah disemak dan didapati <span class="fw-bold text-primary">MENEPATI</span> kriteria yang ditetapkan.</h5>
                  <p>
                    Adakah anda pasti untuk mengesahkan rekod pengguna ini?
                  </p>
              @else
                  <div class="alert alert-warning text-center">{{$success}}</div>
              @endif
              
          </div>
          <div class="modal-footer d-flex justify-content-between">
            <button onclick="@if($isUpdate) window.location = '{{route('user.approval')}}'; @else 'asass' @endif" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            @if(empty($success) && !$is_confirm)
            <div wire:loading.remove>
              <a  class="btn btn-primary text-white" wire:loading.attr="disabled" @if(!$is_confirm) wire:click.prevent="approve({{$this->user_id}}) @endif">
      
                Pasti
              </a>
            </div>
              <div wire:loading wire:target="approve">
                <span class="text-primary">Sila Tunggu...</span>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
    <div wire:ignore.self class="modal fade"  id="rejectModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
              @if (empty($success))
                  <h5 class="modal-title mt-3 mb-3 text-dark">Adakah anda ingin membatal pengguna ini?</h5>
                  <label class="label-control">Nyatakan Sebab</label>
                  <textarea style="resize: none;" class="form-control" wire:model="commentStatus" rows="5"></textarea>
                  @error('commentStatus') <span class="error text-danger">{{ $message }}</span> @enderror
              @else
                  <div class="alert alert-warning text-center">{{$success}}</div>
              @endif
              
          </div>
          <div class="modal-footer d-flex justify-content-between">
            <button wire:click.prevent="close" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            @empty($success)
                <a  class="btn btn-primary text-white" wire:click.prevent="reject({{$this->user_id}})">Pasti</a>
            @endempty
          </div>
        </div>
      </div>
    </div>
</div>