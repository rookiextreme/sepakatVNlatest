<div>
    <div wire:ignore.self class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Submit</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if ($messages['status'] == 400)
                    <div class="alert alert-danger">
                        {{$messages['message']}}
                    </div>

                    {{-- <a wire:click.prevent="checkStatus">Semak Semula</a> --}}
                @else
                    <div class="alert alert-success">
                        Anda pasti untuk menghantar ? tekan butang hantar untuk teruskan
                    </div>
                @endif
            </div>
            <div class="modal-footer float-start">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

            @if ($messages['status'] == 400)
                <button type="button" class="btn btn-module" wire:click.prevent="semakSemula">Semak</button>
            @else
                <button type="button" class="btn btn-module" wire:click.prevent="registerSubmit">Hantar</button>
            @endif
            
            </div>
        </div>
        </div>
    </div>
</div>
