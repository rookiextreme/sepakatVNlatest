<div>
    <div class="top-apps-menu">
        <img src="my-assets/img/spakat-small-min.png" id="menu-logo"/>
        <div class="full">Sistem Aplikasi<br/>Pengurusan Kenderaan<br/>Atas Talian</div>
        <ul class="bunch-menu">
            <li class="row-menu"><i class="fal fa-home"></i> <a href="index.htm">Laman Utama</a></li>
            <li class="row-menu"><i class="fal fa-sign-in"></i> <a href="login.htm">Log Masuk</a></li>
        </ul>
    </div>
    <div class="whole">
        <div class="cloud-top">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-xs-6 col-6" style="position: relative;">
                        <div class="spakat-header">
                            <img src="my-assets/img/spakat-small-min.png" class="d-inline d-sm-inline-flex"/>
                        </div>
                        <div class="jkr-float"><img src="my-assets/img/logo.png"/></div>
                        <div class="triangle-float"><img src="my-assets/img/triangle-min.png" class="img-fluid"/></div>
                        <div class="spakat-fullname">Sistem Aplikasi Pengurusan Kenderaan Atas Talian</div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-xs-6 col-6 d-none d-sm-block home-menu">
                        <a class="btn btn-blank" href="{{route('dashboard')}}"><img src="my-assets/img/home-grey.svg"/></a>
                        <a class="btn btn-login" href="{{route('login')}}">
                            @if(auth())
                            Halaman Utama
                            @else
                            Log Masuk
                            @endif
                        </a>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
		<div class="col-xl-12 col-lg-12 col-xs-12 col-12" style="position: relative;">
			<div class="back-content p-0">
				<div class="container pt-3">
                    <div class="col-md-6">
                        <div class="text-center"></div>
                            @if ($linkExpired)
                            <form wire:submit.prevent="save">
                                <div class="top-title pb-5">Pautan aktif telah tamat tempoh. Sila hubungi pentadbir sistem untuk aktifkan kembali.</div>
                            </form>
                            @else
                                @if ($displayForm)
                                @if ($is_create)
                                <form wire:submit.prevent="save">
                                    <div class="top-title">Cipta ID & Kata Laluan</div>
                                    <div class="top-info">Sila masukkan ID pilihan dan kata laluan</div>
                                    <hr/>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <label class="form-label">Nama Penuh <em>*</em></label>
                                        <div>{{$fullname}}</div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-md-8 col-sm-6 col-12">
                                        <label class="form-label">ID Pilihan <em>*</em></label>
                                        <input wire.ignore.self  onchange="trimValue(this)" wire:model.prevent="username" type="text" class="form-control" id="username" name="username" placeholder="">        
                                        @error('username') <span class="error text-danger">{{ $message }}</span>
                                        @else
                                        <span class="error text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-md-8 col-sm-6 col-12">
                                        <label class="form-label">Kata Laluan <em>*</em></label>
                                        <input wire.ignore.self type="password" wire:model.prevent="password" class="form-control" id="password" name="password" placeholder="">
                                        @error('password') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-auto">
                                        <span id="passwordHelpInline" class="form-text">
                                        Mestilah sepanjang 8-20 karakter.
                                        </span>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-md-8 col-sm-6 col-12">
                                        <label class="form-label">Sahkan Kata Laluan <em>*</em></label>
                                        <input wire.ignore.self type="password" wire:model.prevent="repassword" class="form-control" id="password2" name="password2" placeholder="">
                                        @error('repassword') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    
                                    <div class="form-group center">
                                        <button type="submit" class="btn btn-module">Hantar</button>
                                    </div>
                                    <p>&nbsp;</p>
                                </form>

                                @elseif($is_forgot_pass | $is_change_password)
                                <form wire:submit.prevent="save">
                                    <div class="top-title">Cipta Kata Laluan baru</div>
                                    <div class="top-info">Sila masukkan kata laluan baru</div>
                                    <hr/>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <label class="form-label">Nama Penuh</label>
                                        <div>{{$fullname}}</div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-md-8 col-sm-6 col-12">
                                        <label class="form-label">ID Pilihan </label>
                                        <div>{{$username}}</div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-md-8 col-sm-6 col-12">
                                        <label class="form-label">Kata Laluan <em>*</em></label>
                                        <input wire.ignore.self type="password" wire:model.prevent="password" class="form-control" id="password" name="password" placeholder="">
                                        @error('password') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-auto">
                                        <span id="passwordHelpInline" class="form-text">
                                        Must be 8-20 characters long.
                                        </span>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-md-8 col-sm-6 col-12">
                                        <label class="form-label">Sahkan Kata Laluan <em>*</em></label>
                                        <input wire.ignore.self type="password" wire:model.prevent="repassword" class="form-control" id="password2" name="password2" placeholder="">
                                        @error('repassword') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    
                                    <div class="form-group center">
                                        <button type="submit" class="btn btn-module">Hantar</button>
                                    </div>
                                    <p>&nbsp;</p>
                                </form>
                                @endif
                                @else
                                    <form wire:submit.prevent="save">
                                        <div class="top-title pb-5">Pautan tidak wujud</div>
                                    </form>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid sfooter">
		<div class="container">
			<div class="row">
				<div class="col-xl-7 col-lg-7 col-md-7 col-sm-7 col-12 pt-5 pb-4 pl-0" style="font-size: 14px;line-height: 18px;">
					<div style="font-family: mark-thin;color:#afa68f;font-size:14px;">Urusetia</div><div class="urusetia"><img src="my-assets/img/spakat-small-min.png"></div>
					<span style="display: inline-block;font-family: avenir-bold;line-height: 22px;">Cawangan Kejuruteraan Mekanikal,&nbsp;</span><span style="display: inline-block;font-family:avenir-bold;line-height: 22px;">JKR Woksyop Persekutuan</span><br/>
					No 2, Jalan Arowana, 55300 Kuala Lumpur,
					<span style="display: inline-block;">Wilayah Persekutuan Kuala Lumpur</span><br/>
					<div class="combo-btn">
						<div class="title"><i class="fal fa-envelope fa-lg"></i></div>
						<div class="subject">spakat@jkr.gov.my</div>
					</div>
					
				</div>
				<div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-12"></div>
			</div>
			<div class="row" id="signature-bix">
				<div class="col-xl-6 col-lg-6 col-sm-6 col-md-6 col-6 foot-box"><small class="signature">&copy; 2021 Jabatan Kerja Raya Malaysia</small></div>
				<div class="col-xl-6 col-lg-6 col-sm-6 col-md-6 col-6" style="position: relative;"><small class="terms">Terma &amp; Syarat</small></div>
			</div>
		</div>
</div>

<script type="text/javascript">

    function trimValue(self){
        self.value = self.value.replace(/ /g,'');
    }

</script>

