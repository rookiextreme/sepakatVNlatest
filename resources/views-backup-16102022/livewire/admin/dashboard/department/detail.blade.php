<div class="col-md-12">
    {{-- <nav class="nav mb-3">
        <a class="nav-link pb-0 pt-0 ps-0 pe-1" href="{{ url('/base/control') }}">Dashboard</a>
        /
        <a class="nav-link pb-0 pt-0 ps-1" href="{{ url('/base/control/department') }}">Senarai Jabatan</a>
    
        <a class="nav-link pb-0 pt-0 ps-1 active" href="#">Maklumat Jabatan</a>
    </nav> --}}
    <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" class="text-dark" href="#">MAKLUMAT JABATAN</a>
        </li>
    </ul>
    <div class="mt-3">
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </div>
     <form wire:submit.prevent="save" class="row mt-3">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="" class="form-label">Kementerian</label>
                        <div>{{$ministryName}}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="" class="form-label">Nama</label>
                        <input type="text" wire:model="departmentName" class="form-control">
                        @error('departmentName') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-4 float-end">
            <button class="btn btn-primary text-white float-end" type="submit">Kemaskini</button>
        </div>
     </form>
</div>
