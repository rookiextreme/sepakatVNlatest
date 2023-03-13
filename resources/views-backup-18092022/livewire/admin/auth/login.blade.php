<div>
    <div class="offset-md-3 offset-lg-4 offset-xl-4 col-12 col-md-6 col-lg-4 col-xl-4 mt-3">
        <div class="card card-top-border shadow">
            <div class="card-body">
                @if ($err)
                    <div  class="alert alert-danger">
                        {{$response}}
                    </div>
                @endif
                <form method="post" wire:submit.prevent="signin">
                    <div class="form-group">
                        <label for="" class="form-label">Email</label>
                        <input type="text" wire:model="email" class="form-control">
                        @error('email')
                            <span class="error text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group mt-3">
                        <label for="" class="form-label">Password</label>
                        <input type="password" wire:model="password" class="form-control">
                        @error('password')
                            <span class="error text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-12 text-end">

                            <input type="submit" class="btn btn-warning shadow-sm" value='Sign In'>

                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
