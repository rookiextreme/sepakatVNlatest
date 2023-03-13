<div>
    <div class="col-md-6 offset-md-3 mt-3">
        <div class="card card-top-border shadow">
            <div class="card-body">
                @if ($err)
                    <div  class="alert alert-danger">
                        {{$response}}
                    </div>
                @endif
                <form wire:submit.prevent="signin">
                    <div class="form-group">
                        <label for="" class="form-label">Email</label>
                        <input type="text" wire:model="username" class="form-control">
                        @error('username')
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
                        <div class="col-md-6">
                            <a href="{{route('spakat.register')}}" class="btn-link">Daftar</a><br>
                            <a href="{{route('password.request')}}" class="text-muted">Lupa kata laluan</a>
                        </div>
                        <div class="col-md-6 text-end">

                            <input type="submit" class="btn btn-warning shadow-sm" value='Sign In'>

                        </div>

                    </div>
                </form>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <form wire:submit.prevent="clickLogin">
                    <div class="form-group">
                        <label for="" class="form-label">Login (Staging Only)</label>
                        <select name="" id="" wire:model="easylogin" class="form-control">
                            <option value="orang@awam.com">Orang Awam</option>
                            <option value="penolong.juru@tera.com">Penolong Jurutera</option>
                            <option value="juru@tera.com">Jurutera</option>
                        </select>

                    </div>
                    <button class="btn btn-danger mt-2 text-white" type="submit">
                        Sign In
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
