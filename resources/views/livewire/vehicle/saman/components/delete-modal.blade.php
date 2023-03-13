<div>
    {{-- The Master doesn't talk, he acts. --}}
    <div wire:ignore.self class="modal fade" id="{{'deleteModal-'.$saman_id}}" tabindex="-1" aria-labelledby="{{'deleteModal-'.$saman_id}}" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
           
            <div class="modal-body">
                <h3 class="{{'text-'.$message['style']}}">{{$message['header']}}</h3>
                <p class="{{'text-'.$message['style'].' alert alert-'.$message['style']}}">{{$message['message']}}</p>
                {{-- {{$saman_id}} --}}
            </div>
            <div class="modal-footer float-start">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary text-white" wire:click="delete">Buang</button>
            </div>
          </div>
        </div>
    </div>
</div>
