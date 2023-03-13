<div id="userDetailIndicators">

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Nama</label>
                <div>{{$user->name?: '-' }}</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Nama Pengguna</label>
                <div>{{$user->username?: '-' }}</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Emel</label>
                <div>{{$user->email?: '-' }}</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Identity No.</label>
                <div>{{$user->detail->identity_no?: '-' }}</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Tel Bimbit</label>
                <div>{{$user->detail->telbimbit?: '-' }}</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Tel Pejabat</label>
                <div>{{$user->detail->telpejabat?: '-' }}</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Nama Syarikat</label>
                <div>{{$user->detail->company_name?: '-' }}</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Tarikh Daftar</label>
                <div>{{Carbon\Carbon::parse($user->detail->created_at)->format("d/m/Y , g:i A")?: '-' }}</div>
            </div>
        </div>
    </div>

</div>