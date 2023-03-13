<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>


	@include('dashboards.headers.metadata')
	<title>JKR SPaKAT : Sistem Aplikasi Pengurusan Kenderaan Atas Talian</title>
	@include('dashboards.headers.styling')

	{{-- based on role --}}
	@include('dashboards.headers.config.theme')

</head>
<body>
<div class="container-xxl">
	<div class="loader centered-loader">
		<img src="{{asset('my-assets/img/loding.gif')}}" width="30px" height="30px"/>
	</div>
{{-- @json(auth()->user()->getRoleNames()) --}}
	<div class="row">
		<div class="col-xxl-2 col-xl-2 col-lg-2 col-md-3 col-sm-12 col-12" style="position: relative;">
			<div class="jkrlogo">
				<img src="{{asset('my-assets/img/logo.png')}}" style="width:100%"/>
			</div>
			<div class="applogo"></div>
			<div class="spakat-small"></div>
			<div class="spakat-full">Sistem Aplikasi<br/>Pengurusan Kenderaan<br/>Atas Talian</div>
			<div class="menu-line"></div>
			<div class="sleft-menu">
				<ul>
					<li>
						<div class="side-by-side"><a href="about" style="padding-bottom:3px"><img src="{{asset('my-assets/img/search.svg')}}" height="18" /></a></div>
						<div class="side-by-side"><a href="about" style="padding-bottom:3px"><img src="{{asset('my-assets/img/home.svg')}}" height="18" /></a></div>
					</li>
					<li style="clear:both"><a href="{{route('dashboard')}}">Dashboard</a></li>
					@hasanyrole('penolong-jurutera-jkr|jurutera-jkr|pentadbir-sistem-spakat')
					<li style="clear:both"><img src="{{asset('my-assets/img/chevron.svg')}}" class="chevron"/> &nbsp;<a href="#" onClick="toggleSubMenu(this);">PENGGUNA</a>
						<ul class="subside" style="display: 
							@if(Route::currentRouteName() == 'user.overview' || 
								Route::currentRouteName() == 'user.approval' ||
								Route::currentRouteName() == 'user.registered' || 
								Route::currentRouteName() == 'user.revoked' || 
								Route::currentRouteName() == 'user.locked'
							) 
								block 
							@endif
							">
							<li><a class="@if(Route::currentRouteName() == 'user.overview')active @endif" href="{{route('user.overview')}}">Overview</a></li>
                            <li><a class="@if(Route::currentRouteName() == 'user.approval')active @endif" href="{{route('user.approval')}}">Pengesahan Pengguna</a></li>
							<li><a class="@if(Route::currentRouteName() == 'user.registered')active @endif" href="{{route('user.registered')}}">Pengguna Berdaftar</a></li>
							<li><a class="@if(Route::currentRouteName() == 'user.revoked')active @endif" href="{{route('user.revoked')}}">Pengguna Dibuang</a></li>
							<li><a class="@if(Route::currentRouteName() == 'user.locked')active @endif" href="{{route('user.locked')}}">Pengguna Dikunci Akses</a></li>
							<li class="pt-3 pb-3"><div class="smallgap"></div></li>
						</ul>
					</li>
					@endhasanyrole
					<li style="clear:both"><img src="{{asset('my-assets/img/chevron.svg')}}" class="chevron"/> &nbsp;<a href="#" onClick="toggleSubMenu(this);">KENDERAAN</a>
						<ul class="subside" style="display: 
						@if(Route::currentRouteName() == 'vehicle.penolong.carta-alir' || 
							Route::currentRouteName() == 'vehicle.list-alternate' ||
							Route::currentRouteName() == 'saman.overview' || 
							Route::currentRouteName() == 'saman.pengguna.overview'
						) 
							block 
						@endif
						">
							@hasanyrole('penolong-jurutera-jkr|jurutera-jkr|pentadbir-sistem-spakat')
								<li><a class="@if(Route::currentRouteName() == 'vehicle.penolong.carta-alir')active @endif" href="{{route('vehicle.penolong.carta-alir')}}">Overview</a></li>
							@endhasanyrole
							<li><a href="{{route('vehicle.register', ['id' => 0, 'is_display' => false])}}">Maklumat Kenderaan</a></li>
							@hasanyrole('penolong-jurutera-jkr|jurutera-jkr|pentadbir-sistem-spakat')
								<li><a class="@if(Route::currentRouteName() == 'vehicle.list-alternate')active @endif" href="{{route('vehicle.list-alternate')}}">Senarai Semakan Kenderaan</a></li>
							@else
								<li><a class="@if(Route::currentRouteName() == 'vehicle.list-alternate')active @endif" href="{{route('vehicle.list-alternate')}}">Senarai Rekod Kenderaan</a></li>
							@endhasanyrole
							{{-- <li><a href="#">Keselamatan dan Prestasi</a></li> --}}
							@hasanyrole('penolong-jurutera-jkr|jurutera-jkr|pentadbir-sistem-spakat')
							<li><a class="@if(Route::currentRouteName() == 'saman.overview')active @endif" href="{{route('saman.overview')}}">Rekod Saman</a></li>
							@endhasanyrole
							@hasanyrole('orang-awam')
							<li><a class="@if(Route::currentRouteName() == 'saman.pengguna.overview')active @endif" href="{{route('saman.pengguna.overview')}}">Rekod Saman Pengguna</a></li>
							@endhasanyrole
							<li><a href="#">Laporan</a></li>
							<li class="pt-3 pb-3"><div class="smallgap"></div></li>
						</ul>
					</li>
					<li><img src="{{asset('my-assets/img/chevron.svg')}}" class="chevron"/> &nbsp;<a href="#" onClick="toggleSubMenu(this);">PENILAIAN</a>
						<ul class="subside">
							<li><a href="javascript:openPgInFrame('com_dsh_map.htm')">Kenderaan Baharu</a></li>
							<li><a href="#">Keselamatan dan Prestasi</a></li>
							<li><a href="#">Nilai Semasa</a></li>
							<li><a href="#">Kemalangan</a></li>
							<li><a href="#">Pinjaman Kerajaan</a></li>
							<li><a href="#">Pelupusan</a></li>
							<li><a href="#">Laporan</a></li>
							<li class="pt-3 pb-3"><div class="smallgap"></div></li>
						</ul>
					</li>
					<li><a href="senggaraan">SENGGARAAN</a></li>
					<li><a href="logistik">LOGISTIK</a></li>
					<li><a href="arkib">ARKIB</a></li>
					<li class="pt-3 pb-3"><div class="smallgap"></div></li>
					<li><a href="{{route('spakat.pengguna.profile', ["id"=> auth()->user()->id] )}}" class="mini">Edit Profil</a></li>
					<li><a href="{{route('change.password.user', ["view"=> "change_password"] )}}" class="mini">Tukar Katalaluan</a></li>
					<li><a href="logout" class="mini">MEJA BANTUAN</a></li>
					<form method="POST" action="{{ route('logout') }}">
						@csrf
						<li><input type="submit" class="btn mini" style="padding-bottom: 10px;padding-right: 0;font-size: 10px;color: #b5b4b4 !important;" value="LOG KELUAR"></li>
					</form>
					{{-- <li><a href="logout" class="mini">LOG KELUAR</a></li> --}}
				</ul>
			</div>
			
		</div>
		<div class="col-xxl-10 col-xl-10 col-lg-10 col-md-9 col-sm-12 col-12" style="position: relative;">
			<div class="back-content">
				@include('dashboards.content')
			</div>
			<div class="row">
				<div class="col-xl-6 col-lg-6 col-sm-6 col-md-6 col-6 foot-box"><small class="signature">&copy; 2021 Jabatan Kerja Raya Malaysia</small></div>
				<div class="col-xl-6 col-lg-6 col-sm-6 col-md-6 col-6" style="position: relative;"><small class="terms">Terms &amp; Conditions</small></div>
			</div>
		</div>
	</div>
</div>
	<div class="burger-box" onClick="togAppsMenu();">
		<div class="hamburger">
			<div class="bars" id="bars-1" style="transform-origin: 0 50%;">&nbsp;</div>
			<div class="bars" id="bars-2">&nbsp;</div>
			<div class="bars" id="bars-3" style="transform-origin: 0 50%;">&nbsp;</div>
		</div>
	</div>
	<div class="top-apps-menu">
		<div class="container">
			Menu
		</div>
	</div>
	<div class="shade-white"></div>
	<div class="btnJumpTop" onclick="scrollToTop()">
		<i class="fal fa-arrow-up fa-lg" style="color:#ffffff !important;"></i>
	</div>
	<div class="mycookies">
		<div class="container">This website uses cookies to improve your experience. We'll assume you're ok with this, but you can opt-out if you wish. <a href="" style="font-size:14px;color:#ffffff">Read more</a><button type="button" class="btn btn-light btn-sm" onClick="acceptCookie();">Accept</button></div>
	</div>

<script type="text/javascript" src="{{asset('/my-assets/jquery/jquery-3.6.0.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/my-assets/bootstrap/js/bootstrap.min.js')}}"></script>
<script>

function startLoad(){
	$('.loader').fadeIn();
}

function stopLoad(){
	$('.loader').fadeOut();
}

jQuery(document).ready(function() {
	// $('.datepicker').datepicker({
	// 	format: 'dd/mm/yyyy',
	// 	startDate: new Date()
	// });

	stopLoad();
	
})
</script>
<!--Begin Comm100 Live Chat Code-->
<div id="comm100-button-96660202-8d9b-4082-bf85-78ea32fc9567"></div>
<script type="text/javascript">
  var Comm100API=Comm100API||{};(function(t){function e(e){var a=document.createElement("script"),c=document.getElementsByTagName("script")[0];a.type="text/javascript",a.async=!0,a.src=e+t.site_id,c.parentNode.insertBefore(a,c)}t.chat_buttons=t.chat_buttons||[],t.chat_buttons.push({code_plan:"96660202-8d9b-4082-bf85-78ea32fc9567",div_id:"comm100-button-96660202-8d9b-4082-bf85-78ea32fc9567"}),t.site_id=40100370,t.main_code_plan="96660202-8d9b-4082-bf85-78ea32fc9567",e("https://vue.comm100.com/livechat.ashx?siteId="),setTimeout(function(){t.loaded||e("https://standby.comm100vue.com/livechat.ashx?siteId=")},5e3)})(Comm100API||{})
</script>
<!--End Comm100 Live Chat Code-->
{{-- <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script> --}}
{{-- @livewire('livewire-ui-modal') --}}
{{-- @livewireUIScripts --}}
@livewireScripts
<script>
	window.livewire.on('closePSMD', () => {
		$('#pemilikSearch').modal('hide').data('bs.modal', null);
	})

	window.livewire.on('userRegisteredMD', () => {
		$("#lockedDt").on('change.datepicker', function(e){
			let date = $(this).data('lockeddt');
			eval(date).set('end_dt', $('#lockedDtInput').val());
		});
	})
</script>
<script type="text/javascript" src="{{asset('my-assets/plugins/datepicker/js/bootstrap-datepicker.js')}}"></script>
<script type="text/javascript" src="{{asset('my-assets/plugins/datepicker/locales/bootstrap-datepicker.ms.min.js')}}"></script>
<script>
	$('.calender').datepicker({
		beforeShowYear: function(date){
			  if (date.getFullYear() == 2007) {
				return false;
			  }
			}
	});
</script>
</body>
</html>