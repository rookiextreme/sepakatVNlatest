<div  class="row">
    {{-- Stop trying to control. --}}
    <div class="col-md-3">
        <a href="{{route('vehicle.penolong.semakan')}}">
            <div class="card">
                <img src="{{asset("img/carta-alir/jumlah-kenderaan.png")}}" alt="" class="card-img-top">
                <div class="card-body">
                    <h6 class="card-title text-success fw-bold">Pendaftaran Baru</h6>
                    <div class="mt-4">
                        <div class="display-5 text-dark fw-bold">
                            {{$totalNew}}
                        </div>
                        <p class="fw-bold text-dark">Kenderaan</p>
                    </div>
                </div>
            </div>
        </a>
        
        
    </div>
    <div class="col-md-3">
        <div class="card">
            <img src="{{asset("img/bg-carta-alir.png")}}" alt="" class="card-img-top">
            <div class="card-body">
                <h6 class="card-title text-danger fw-bold">Menunngu Pengesahan</h6>
                <div class="mt-4">
                    <div class="display-5 text-dark fw-bold">
                        {{$totalWaiting}}

                    </div>
                    <p class="fw-bold text-dark">Kenderaan</p>
                </div>
            </div>
        </div>
        
    </div>
    <div class="col-md-3">
        <div class="card">
            <img src="{{asset("img/carta-alir/jumlah-kenderaan.png")}}" alt="" class="card-img-top">
            <div class="card-body">
                <h6 class="card-title text-primary fw-bold">Senarai Kenderaan</h6>
                <div class="mt-4">
                    <div class="display-5 text-dark fw-bold">
                        {{$totalVehicle}}

                    </div>
                    <p class="fw-bold text-dark">Kenderaan</p>
                </div>
            </div>
        </div>
        
    </div>
    <div class="col-md-3"></div>
    <div class="col-md-3 mt-4 ">
        <div class="card">
            <img src="{{asset("img/carta-alir/jumlah-kenderaan.png")}}" alt="" class="card-img-top">
            <div class="card-body">
                <h6 class="card-title text-primary fw-bold">Menunggu Pembetulan</h6>
                <div class="mt-4">
                    <div class="display-5 text-dark fw-bold">
                        {{$totalCorrection}}

                    </div>
                    <p class="fw-bold text-dark">Kenderaan</p>
                </div>
            </div>
        </div>
        
    </div>
    <div class="col-md-3 offset-md-3 mt-4">
        <div class="card">
            <img src="{{asset("img/carta-alir/jumlah-kenderaan.png")}}" alt="" class="card-img-top">
            <div class="card-body">
                <h6 class="card-title text-primary fw-bold">Rekod Terbuang</h6>
                <div class="mt-4">
                    <div class="display-5 text-dark fw-bold">
                        {{$totalDelete}}

                    </div>
                    <p class="fw-bold text-dark">Kenderaan</p>
                </div>
            </div>
        </div>
        
    </div>
</div>
