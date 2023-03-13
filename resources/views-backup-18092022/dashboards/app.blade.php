@php
	$bgcolor = "#49575c";
	$applogo = asset('my-assets/img/spakat-admin-min.png');
	$landingPage = "";
	$roleAccessCode = Auth()->user()->roleAccess() ? Auth()->user()->roleAccess()->code: null;

@endphp

{{-- Admin --}}
@if($roleAccessCode == '01')
	@php
		$bgcolor = "#49575c";
		$applogo = asset('my-assets/img/spakat-admin-min.png');
		$landingPage = route('access.admin.dashboard');
		$totalVehicle = DB::table('kenderaans.pendaftarans')
                        ->join('kenderaans.status_semakans', 'kenderaans.status_semakans.pendaftaran_id', '=', 'kenderaans.pendaftarans.id')
                        ->join('identifiers.vapp_status', 'identifiers.vapp_status.id', '=', 'kenderaans.status_semakans.vapp_status_id')
                        ->where('identifiers.vapp_status.code','!=', '00')
                        ->count();
		$totalNotYetApprovedUser = DB::table('users.details')
						->join('ref_status AS a', 'a.id', '=', 'ref_status_id')
						->where('a.code','=','03')->count();

		// Start Module Logistic
		$totalLogisticBooking = DB::table('logistic.logistic_booking')
						->join('logistic.logistic_booking_status AS a', 'a.id', '=', 'status_id')
						->where('a.code','!=','00')->count();
		// End Module Logistic
	@endphp
@endif

{{-- Top Management --}}
@if($roleAccessCode == '02')
	@php
		$bgcolor = "#3e7879";
		$applogo = asset('my-assets/img/spakat-business-min.png');
		$landingPage = route('access.management.dashboard');
		$totalVehicle = DB::table('kenderaans.pendaftarans')
                        ->join('kenderaans.status_semakans', 'kenderaans.status_semakans.pendaftaran_id', '=', 'kenderaans.pendaftarans.id')
						->join('identifiers.vapp_status', 'identifiers.vapp_status.id', '=', 'kenderaans.status_semakans.vapp_status_id')
                        ->where('identifiers.vapp_status.code','!=', '00')
                        ->count();
		// Start Module Logistic
		$totalLogisticBooking = DB::table('logistic.logistic_booking')
						->join('logistic.logistic_booking_status AS a', 'a.id', '=', 'status_id')
						->where('a.code','!=','00')->count();
		// End Module Logistic
	@endphp
@endif

{{-- Engineer and Asistant Engineer --}}
@if (in_array($roleAccessCode, array('03')))
	@php
		$bgcolor = "#345864";
		$applogo = asset('my-assets/img/spakat-ops-min.png');
		$landingPage = route('access.operation.dashboard');
		$totalVehicle = DB::table('kenderaans.pendaftarans')
                        ->join('kenderaans.status_semakans', 'kenderaans.status_semakans.pendaftaran_id', '=', 'kenderaans.pendaftarans.id')
                        ->join('identifiers.vapp_status', 'identifiers.vapp_status.id', '=', 'kenderaans.status_semakans.vapp_status_id')
                        ->where('identifiers.vapp_status.code','!=', '00')
                        ->count();
		// Start Module Logistic
		$totalLogisticBooking = DB::table('logistic.logistic_booking')
						->join('logistic.logistic_booking_status AS a', 'a.id', '=', 'status_id')
						->where('a.code','!=','00')->count();
		// End Module Logistic
	@endphp
@endif

{{-- Public --}}
@if($roleAccessCode == '04')
	@php
		$bgcolor = "#49999c";
		$applogo = asset('my-assets/img/spakat-admin-min.png');
		$landingPage = route('access.public.dashboard');
		$totalVehicle = DB::table('kenderaans.pendaftarans')
                        ->join('kenderaans.status_semakans', 'kenderaans.status_semakans.pendaftaran_id', '=', 'kenderaans.pendaftarans.id')
                        ->join('identifiers.vapp_status', 'identifiers.vapp_status.id', '=', 'kenderaans.status_semakans.vapp_status_id')
                        ->where('identifiers.vapp_status.code','!=', '00')
						->where('kenderaans.pendaftarans.user_id','=', Auth()->user()->id);
		Log::info($totalVehicle->toSql());
		$totalVehicle = $totalVehicle->count();
		// Start Module Logistic
		$totalLogisticBooking = DB::table('logistic.logistic_booking AS a')
						->join('logistic.logistic_booking_status AS b', 'b.id', '=', 'a.status_id')
						->where('a.created_by', Auth()->user()->id);

		$totalLogisticBooking->where('b.code','!=','00');
		$totalLogisticBooking = $totalLogisticBooking->count();
		// End Module Logistic
	@endphp
@endif


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charscreatePwordet=UTF-8">
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link href="https://www.cubixi.com/" rel="alternate" hreflang="x-default">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<meta name="description" content="Pick and choose of what you need from our wide range of business solutions that maximize your people potential and organisation growth. Feel free to try our Free Plan!"><link rel="canonical" href="https://www.cubixi.com/">
	<meta property="og:site_name" content="Cubixi">
	<meta property="og:type" content="website">
	<meta property="og:url" content="https://www.cubixi.com">
	<meta property="og:title" content="JKR SPaKAT : Sistem Aplikasi Pengurusan Kenderaan Atas Talian">
	<meta property="og:description" content="Pick and choose of what you need from our wide range of business solutions that maximize your people potential and organisation growth. Feel free to try our Free Plan!">
	<meta property="og:image" content="//spakat.cubixi.com/img/mod-spakat.jpg">
	<title>JKR SPaKAT : Sistem Aplikasi Pengurusan Kenderaan Atas Talian</title>
	<link rel="shortcut icon" href="{{asset('my-assets/favicon/favicon.png')}}">

	<!--Universal Cubixi styling including Admin, ESS, Mobile and Public.-->
	<link href="{{asset('my-assets/css/cubixi.css')}}" rel="stylesheet" type="text/css">

	<!--importing bootstrap-->
	<link href="{{asset('my-assets/bootstrap/css/bootstrap.css')}}" rel="stylesheet" type="text/css" />

	<link href="{{asset('my-assets/css/public.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('my-assets/css/admin-menu.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('my-assets/css/footer.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('my-assets/fontawesome-pro/css/light.min.css')}}" rel="stylesheet">
	<script src="{{asset('my-assets/fontawesome-pro/js/all.js')}}"></script>
	<!--Importing Icons-->
	<script src="{{asset('my-assets/spakat/spakat.js')}}" type="text/javascript"></script>
	<script type="text/javascript">
		function scrollToTop() {
			//scroll to the highest
			$('body').animate({ scrollTop: 0 }, 'fast');
			$('.parallax').animate({ scrollTop: 0 }, 'slow');
		}
		function createCookie(name,value,days) {
			//create cookie
			var expires = "";
			if (days) {
				var date = new Date();
				date.setTime(date.getTime() + (days*24*60*60*1000));
				expires = "; expires=" + date.toUTCString();
			}
			document.cookie = name + "=" + value + expires + "; path=/";
		}
		function acceptCookie() {
			createCookie('cooAccept', '1', 100);
			$('.mycookies').fadeOut('slow');
		}
		function readCookie(name) {
			//read cookie
			var nameEQ = name + "=";
			var ca = document.cookie.split(';');
			for(var i=0;i < ca.length;i++) {
				var c = ca[i];
				while (c.charAt(0)==' ') c = c.substring(1,c.length);
				if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
			}
			return null;
		}
		function eraseCookie(name) {
			//delete cookie
			createCookie(name,"",-1);
		}
		function closeCookies() {
			$('.cookies-layer').fadeOut();
		}
		function minAll() {
			$('.subside').slideUp('fast');
			$('.chevron').removeClass('buka');
		}
		function maxAll() {
			$('.subside').slideDown('fast');
			$('.chevron').addClass('buka');
		}
		function toggleSubMenu(obj) {
			if($(obj).parent().children('ul').is(":visible")){
				$(obj).parent().children('ul').slideUp('fast');
				$(obj).parent().children('img').removeClass('buka');
			}else{
				$(obj).parent().children('ul').slideDown('fast');
				$(obj).parent().children('img').addClass('buka');
			}
		}
        function toggleSubMenuSpecial(obj, clink) {
            //alert(clink);
            //var fil = document.getElementById('pg-apps').src;
            //alert(fil);
            //var filename = fil.substring(fil.lastIndexOf('/')+1);
            //alert(filename);
			if($(obj).parent().children('ul').is(":visible")){
                //window.open(clink, "pg-apps");
				$(obj).parent().children('ul').slideUp('fast');
				$(obj).parent().children('img').removeClass('buka');
			}else{
                window.open(clink, "pg-apps");
				$(obj).parent().children('ul').slideDown('fast');
				$(obj).parent().children('img').addClass('buka');
			}
		}

		function checkIframeLoaded() {
			// Get a handle to the iframe element
			var iframe = document.getElementById('pg-apps');
			var iframeDoc = iframe.contentDocument || iframe.contentWindow.document;

			// Check if loading is complete
			if (  iframeDoc.readyState  == 'complete' ) {
				//iframe.contentWindow.alert("Hello");
				iframe.contentWindow.onload = function(){
					alert("I am loaded");
				};

				// The loading is complete, call the function we want executed once the iframe is loaded
				afterLoading();
				return;
			}

			// If we are here, it is not loaded. Set things up so we check   the status again in 100 milliseconds
			window.setTimeout(checkIframeLoaded, 100);
		}

		function afterLoading(){
			stopLoading();
		}
	</script>

	<style type="text/css">
		body {
			background-color: {{$bgcolor}};
		}
		.flymenu {
			display: none;
		}
        .btn-icom-menu {
            cursor:pointer;
            filter: brightness(200%) contrast(198%) saturate(45%) grayscale(99%);
        }
        .btn-icom-menu:hover {
            filter: invert(64%) sepia(84%) saturate(549%) hue-rotate(355deg) brightness(100%) contrast(104%);
        }
		.access-by {
			float: left;
			width: 300px;
			height: 55px;
			padding-top: 8px;
			padding-right: 0px;
			color: #ffae00;
		}
		.user{
			float: right;
			width: auto;
			height: 55px;
			padding-top: 8px;
			color: #ffae00;
		}
        @media (max-width: 1800px) {
            .jkrlogo {
                display: none;
            }
            .applogo {
                width:200px;
            }
        }
		@media (max-width: 1399.98px) {
			/*X-Large devices (large desktops, less than 1400px)*/
			/*X-Large*/
			.flymenu {
				display: block;
				position: absolute;
				left:-400px;
				top:0px;
				width:400px;
				height:100%;
				z-index: 100;
				padding-left:20px;
				padding-top:20px;
				background: rgb(13,13,13);
	background: linear-gradient(90deg, rgba(13,13,13,1) 0%, rgba(25,28,29,1) 73%, rgba(45,53,56,0.4682247899159664) 88%, rgba(13,13,13,0) 100%);
			}
		}
        @media (max-width: 1199.98px) {

        }

		@media (max-width: 1199.98px) {
			/*Large devices (desktops, less than 1200px)*/
			/*Large*/

		}
		@media (max-width: 991.98px) {
			/* Medium devices (tablets, less than 992px)*/
			/*medium*/
			.flymenu {
				background: rgb(13,13,13);
	background: linear-gradient(90deg, rgba(13,13,13,1) 0%, rgba(25,28,29,1) 73%, rgba(45,53,56,0.4682247899159664) 88%, rgba(13,13,13,0) 100%);
			}

		}
		@media (max-width: 767.98px) {
			/* Small devices (landscape phones, less than 768px)
			/*small*/
		}
		@media (max-width: 575.98px) {
			/*X-Small devices (portrait phones, less than 576px)*/
			/*x-small*/
			.flymenu {
				left:-100vw;
				width:100vw;
				background: rgb(13,13,13);
	background: linear-gradient(90deg, rgba(13,13,13,1) 0%, rgba(25,28,29,1) 10%, rgba(45,53,56,1) 80%, rgba(73,87,92,0.4051995798319328) 100%);
			}
            #pg-apps {
                padding-left:0px;
                padding-right:0px;
                margin-left:0px;
                margin-right:0px;
            }
		}
		#loading{
			width: 100%;
			height: 100%;
			background-color: #000000a6;
			position: fixed;
			z-index: 999;
		}
	</style>
</head>
<body onload="checkIframeLoaded();">
	@php
		$session_prev_id = session()->get('session_switch_admin_id');
	@endphp
<script type="text/javascript">
	function startLoading(){
		$('#loading').show();
	}
	function stopLoading(){
		$('#loading').hide();
	}
	@if ($session_prev_id)
		const switchBacktoAdmin = function(self){
			$.post('{{route('switch.user.post')}}', {
				"_token": "{{ csrf_token() }}"
			}, function(res){
				window.parent.location.href = res;
			});
		}
	@endif
	
</script>
<div id="loading">
	<div class="d-flex justify-content-center align-items-center" style="height: 100%;">
		<img src="{{asset('my-assets/img/loding.gif')}}" width="30px" height="30px">
	</div>
</div>
<div class="flymenu">
	<div class="collapser">
		<div class="btn-group">
			<button class="btn btn-sm" type="button" onClick="maxAll();"><i class="fal fa-plus fa-lg"></i></button>
			<button class="btn btn-sm" type="button" onClick="minAll();"><i class="fal fa-minus fa-lg"></i></button>
            <button class="btn btn-sm" type="button" onClick="openPgInFrame('{{$landingPage}}');"><i class="fal fa-home fa-lg"></i></button>
		</div>
	</div>
	<div class="sleft-menu mobile">
		@include('dashboards.menu-content')
		<div class="signature-mini">&copy; 2021 Jabatan Kerja Raya Malaysia</div>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
	</div>
</div>

<div class="switch-to-admin d-flex justify-content-center" style="position: fixed; z-index: 1;">
	@if($session_prev_id)
		<button type="button" class="btn btn-primary text-white" onclick="switchBacktoAdmin()"><i class="fa fa-backward"></i> kembali ke pentadbir</button>
	@endif
</div>

<div class="master-container">
    <div class="user-tag">
		<i
		data-bs-container="body"
                data-bs-toggle="popover"
                data-bs-trigger="hover focus"
                data-bs-placement="top"
                title="{{auth()->user()->roleAccess()->desc_bm}}"
				data-bs-html="true"
                data-bs-content="
				<ul>
				@foreach(auth()->user()->roles as $role)
				<li>{{auth()->user()->getRoleDesc($role->name)->desc_bm}}</li>
				@endforeach
				</ul>
				"
		class="fal fa-user white-filter"></i>&nbsp;&nbsp;{{auth()->user()->name}}{{--({{auth()->user()->roleAccess()->desc_bm}})--}}
	</div>
	<div class="row">
		<div class="col-xl-2 d-none d-xl-block" style="position: relative;" id="flmenu">
			<div class="jkrlogo"><img src="{{asset('my-assets/img/logo.png')}}" class="img-fluid"/></div>
			<div class="applogo"><img src="{{$applogo}}" class="img-fluid"/></div>
			<div class="spakatlogo"><img src="{{asset('my-assets/img/spakat-small-min.png')}}" class="img-fluid"/></div>
			<div class="spakat-full">Sistem Aplikasi<br/>Pengurusan Kenderaan<br/><!--<span id="lebar"></span>-->Atas Talian</div>
			<div class="collapser">
				<div class="btn-group">
					<a class="btn btn-sm btn-icom-menu" onClick="maxAll();"><i class="fal fa-plus white-filter"></i></a>
					<a class="btn btn-sm btn-icom-menu" onClick="minAll();"><i class="fal fa-minus" style="filter: brightness(200%) contrast(198%) saturate(45%) grayscale(99%);"></i></a>
                    <a class="btn btn-sm btn-icom-menu" onClick="openPgInFrame('{{$landingPage}}');"><i class="fal fa-home fa-lg"  style="filter: brightness(200%) contrast(198%) saturate(45%) grayscale(99%);"></i></a>
                    <a class="btn btn-sm btn-icom-menu" onClick="logout()"><i class="fal fa-sign-out fa-lg"></i></a>
				</div>
			</div>
			<div class="sleft-menu">
				@include('dashboards.menu-content')
			</div>
		</div>
		<div class="col-xl-10 col-lg-12 col-12 center-stage" style="position: relative;">
			<div class="headline">
				<div class="spakat-brand">
					<img src="{{asset('my-assets/img/logo.png')}}" class="d-inline" id="jkr-logo"/>
					<img src="{{asset('my-assets/img/spakat-header-min.png')}}" class="d-inline d-sm-inline-flex" id="spakat-logo" style="z-index: 10"/>
					<div class="epi-full">Sistem Aplikasi Pengurusan Kenderaan Atas Talian<!--<span id="lebar2"></span>--></div>
				</div>
				{{-- <div class="access-by">
					Akses sebagai : {{auth()->user()->roleAccess()->desc_bm}}
				</div> --}}
				{{--<div class="side-by-side" style="padding-right:10px;">
					<a href="#" data-bs-toggle="modal" data-bs-target="#globalSearchModal"><img src="{{asset('my-assets/img/search.svg')}}" style="margin-top:1px;"/></a>

					<a href="#" onClick="openPgInFrame('{{$landingPage}}');"><img src="{{asset('my-assets/img/home.svg')}}" /></a>
				</div>
				<div class="user">{{auth()->user()->name}} ({{auth()->user()->roleAccess()->desc_bm}})</div>--}}
			</div>
			<div class="admin-content">{{--.box--}}
				@php
					$sessionRedirectTo = session()->get('session_redirectTo');
				@endphp
				@if(Request('redirectTo'))
					@php
						$landingPage = Request('redirectTo');
					@endphp
				@endif
				@if($sessionRedirectTo)
					@php
						$landingPage = $sessionRedirectTo;
					@endphp
				@endif
				<iframe src="{{$landingPage}}" name="pg-apps" id="pg-apps" frameborder="0" style="width:100%;height:100%;"></iframe>
				@php
					session()->put('session_redirectTo', null);
				@endphp
			</div>
			<div class="row footwhole">
				<div class="col-12 footleft">&copy; 2021 Jabatan Kerja Raya Malaysia</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="globalSearchModal" tabindex="-1" aria-labelledby="globalSearchModalLabel" aria-hidden="true">
		<div class="modal-dialog">
		  <div class="modal-content" style='border-radius: 10px; margin-top: 50%; border: 2px solid #6c757d96; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);'>
			<div class="modal-body">
				<form action="{{route('.redirect')}}">
					<input type="hidden" name="redirectTo" value="{{route('global.search')}}" />
					<input autocomplete="off" style='width: 100%;  text-align: center;  border: none; font-family: avenir; padding:10px; outline: none;' placeholder='carian keseluruhan' name="search" value="">
				</form>
			</div>
		</div>
	</div>
</div>
<div class="burger-box">
	<div class="hamburger" onClick="togAdminMenu();">
		<div class="bars" id="bars-1" style="transform-origin: 0 50%;">&nbsp;</div>
		<div class="bars" id="bars-2">&nbsp;</div>
		<div class="bars" id="bars-3" style="transform-origin: 0 50%;">&nbsp;</div>
	</div>
</div>
<!--<div class="top-apps-menu">
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
</div>-->
<script type="text/javascript" src="{{asset('my-assets/jquery/jquery-3.6.0.min.js')}}"></script>
{{-- import animate tooltip --}}
<script type="text/javascript" src="{{asset('my-assets/bootstrap/js/popper.min.js')}}"></script>

<script type="text/javascript" src="{{asset('my-assets/bootstrap/js/bootstrap.min.js')}}"></script>
<script>

checkSession = function(){
	$.get('/checkSession', function(data){
		if(!data){
			window.location.reload();
		}
	});
}

const logout = function(){
	@if (auth()->user()->login_from_sso)
		let aa = open('https://sso.jkr.gov.my/nidp/app/logout','targetWindow','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=1,height=1');
		setTimeout(function(){
		document.getElementById('logoutApp').submit();
	aa.close();}, 500)
		@else
		document.getElementById('logoutApp').submit();
	@endif
}

function checkSite(){
	$.get(window.location.href, function(res, o, u){ 

		if(u.status !== 200){
			alert('Something went wrong. Please contact administator');
		}

	}).done(function() {
		//alert( "second success" );
	})
	.fail(function() {
		alert('Something went wrong. Please contact administator');
	})
	.always(function() {
		//alert( "finished" );
	});
}

jQuery(document).ready(function() {

	@if (env('APP_ENV') == 'production')
		setInterval(() => {
			checkSite();
		}, 10000);
	@endif
	// $("body").fadeIn(1000);
	minAll();

    if(navigator.platform.indexOf('Win') == 0){
        $('.sleft-menu').css({
            'padding-right':'20px'
        })
    }

	var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
	var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
	return new bootstrap.Popover(popoverTriggerEl)
	})

    $('.spakat-full').slideDown();

	$('#pg-apps').on('load', function(){
		stopLoading();
	});

	setInterval(function(){
		checkSession();
	}, 5000)

    $('#lebar').text($(window).width());
    $(window).resize(function() {
        $('#lebar').text($(window).width());
        $('#lebar2').text($(window).width());
    });
})
</script>

<!--Begin Comm100 Live Chat Code-->
<div id="comm100-button-96660202-8d9b-4082-bf85-78ea32fc9567"></div>
<script type="text/javascript">
  var Comm100API=Comm100API||{};(function(t){function e(e){var a=document.createElement("script"),c=document.getElementsByTagName("script")[0];a.type="text/javascript",a.async=!0,a.src=e+t.site_id,c.parentNode.insertBefore(a,c)}t.chat_buttons=t.chat_buttons||[],t.chat_buttons.push({code_plan:"96660202-8d9b-4082-bf85-78ea32fc9567",div_id:"comm100-button-96660202-8d9b-4082-bf85-78ea32fc9567"}),t.site_id=40100370,t.main_code_plan="96660202-8d9b-4082-bf85-78ea32fc9567",e("https://vue.comm100.com/livechat.ashx?siteId="),setTimeout(function(){t.loaded||e("https://standby.comm100vue.com/livechat.ashx?siteId=")},5e3)})(Comm100API||{})
</script>
<!--End Comm100 Live Chat Code-->

</body>
</html>
