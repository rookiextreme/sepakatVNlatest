<style>

.divider {

    margin-top: 100px;
}
.vl0 
{
    border-top: 1px dotted #a2a29e;
    width:  250px;
}

.vl1
{
    border-top: 1px dotted #a2a29e;
    width: 300px;
}

.vl2
{
    border-top: 1px dotted #a2a29e;
    width: 300px;
}

.vl3
{
    border-top: 1px dotted #a2a29e;
    width: 300px;
}

.hl0
{
    border-left: 1px dotted #a2a29e;
    height: 350px;
}

.kon {
    width: 10px;
    height: 10px;
    float: right;
    position: relative;
    top: -5px;
    right: -20px;
    border-right: 10px solid;
}

.diamond {
    width: 0;
    height: 0;
    border: 10px solid transparent;
    border-bottom-color: #a2a29e;
    position: relative;
    top: -20px;
}
.diamond:after {
    content: '';
    position: absolute;
    left: -10px;
    top: 10px;
    width: 0;
    height: 0;
    border: 10px solid transparent;
    border-top-color: #a2a29e;
}

.card:hover{
    border-radius: 25px 25px 0px 0px;
    transform: scale(1.05);
    box-shadow: 0 10px 20px rgba(0,0,0,.12), 0 4px 8px rgba(0,0,0,.06);
}

</style>

<div  class="row">
    <div class="divider"></div>
    <div class="vl0 me-2 mt-5 ms-2">
        <div class="kon diamond"></div>
        <div class="col-12">
            <a class="text-decoration-none" href="{{route('user.approval')}}">
                <div class="card" style="width: 200px;top:-145px;border:none;left: -12px;">
                    <img src="{{asset("img/carta-alir/user/approval.png")}}" alt="" class="card-img-top">
                    <div class="card-body border">
                        <h6 class="card-title text-success fw-bold">Menunggu Pengesahan</h6>
                        <div class="mt-4">
                            <div class="display-5 text-dark fw-bold">
                                {{$totalApproval}}
                            </div>
                            <p class="fw-bold text-dark">Pengguna</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="vl1 me-2 mt-5">
        <div class="kon diamond"></div>
        <div class="col-12">
            <a class="text-decoration-none" href="{{route('user.registered')}}">
                <div class="card" style="width: 200px;top:-145px;border:none;left: 30px;">
                    <img src="{{asset("img/carta-alir/user/registered.png")}}" alt="" class="card-img-top">
                    <div class="card-body border">
                        <h6 class="card-title text-primary fw-bold">Pengguna Berdaftar</h6>
                        <div class="mt-4">
                            <div class="display-5 text-dark fw-bold">
                                {{$totalRegistered}}
                            </div>
                            <p class="fw-bold text-dark">Pengguna</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="vl2 me-2 mt-5" style="height: 600px;">
        <div class="kon" style="border:none;float: left;right: -74px;top: -27px;">
            <img src="{{asset("img/icon-delete.png")}}" height="50px"/>
        </div>
        <div class="col-12">
            <a class="text-decoration-none" href="{{route('user.revoked')}}">
                <div class="card" style="width: 200px;top:-145px;border:none;left: 200px;">
                    <img src="{{asset("img/carta-alir/user/revoked.png")}}" alt="" class="card-img-top">
                    <div class="card-body border">
                        <h6 class="card-title text-primary fw-bold">Rekod Terbuang</h6>
                        <div class="mt-4">
                            <div class="display-5 text-dark fw-bold">
                                {{$totalRevoked}}
                            </div>
                            <p class="fw-bold text-dark">Pengguna</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="hl0" style="position: absolute;margin-left: -22px;top: 265px;">
            <div class="vl3 me-2" style="margin-top: 350px;">
                <div class="kon" style="border:none;float: left;right: -100px;top: -27px;">
                    <img src="{{asset("img/icon-lock.png")}}" height="50px"/>
                </div>
                <div class="col-12">
                    <a class="text-decoration-none" href="{{route('user.locked')}}">
                        <div class="card" style="width: 200px;top: -170px;border:none;left: 230px;">
                            <img src="{{asset("img/carta-alir/user/locked.png")}}" alt="" class="card-img-top">
                            <div class="card-body border">
                                <h6 class="card-title text-primary fw-bold">Rekod Terkunci</h6>
                                <div class="mt-4">
                                    <div class="display-5 text-dark fw-bold">
                                        {{$totalLocked}}
                                    </div>
                                    <p class="fw-bold text-dark">Pengguna</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
