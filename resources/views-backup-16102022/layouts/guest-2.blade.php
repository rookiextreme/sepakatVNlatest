@php
    use App\Http\Controllers\ApplicationDAO;

    $ApplicationDAO = new ApplicationDAO();
    $ApplicationDAO->mount();

    $lblRegister = $ApplicationDAO->lblRegister;
    $lblLogin = $ApplicationDAO->lblLogin;
    $lblSsoLogin = $ApplicationDAO->lblSsoLogin;
    $lblDashboard = $ApplicationDAO->lblDashboard;
    $lblUsername = $ApplicationDAO->lblUsername;
    $lblPassword = $ApplicationDAO->lblPassword;
    $lblBtnLogin = $ApplicationDAO->lblBtnLogin;
    $lblBtnReset = $ApplicationDAO->lblBtnReset;
    $lblBtnNewUser = $ApplicationDAO->lblBtnNewUser;
    $lblBtnForgotPass = $ApplicationDAO->lblBtnForgotPass;
	$lblRequestFP = $ApplicationDAO->lblRequestFP;

@endphp

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
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" /> <meta http-equiv="Pragma" content="no-cache" /> <meta http-equiv="Expires" content="0" />
<meta property="og:site_name" content="Cubixi">
<meta property="og:type" content="website">
<meta property="og:url" content="https://www.cubixi.com">
<meta property="og:title" content="JKR SPaKAT : Sistem Aplikasi Pengurusan Kenderaan Atas Talian">
<meta property="og:description" content="Pick and choose of what you need from our wide range of business solutions that maximize your people potential and organisation growth. Feel free to try our Free Plan!">
<meta property="og:image" content="//staging.cubixi.com/cubixi/pussets/img/mod-cubixi.jpg">
<title>JKR SPaKAT :: Sistem Aplikasi Pengurusan Kenderaan Atas Talian</title>
<link rel="shortcut icon" href="my-assets/favicon/favicon.png">

<!--JQuery version that is being used across the apps-->

<!--Universal Cubixi styling including Admin, ESS, Mobile and Public.-->
<link href="my-assets/css/cubixi.css" rel="stylesheet" type="text/css">

<!--importing bootstrap-->
<link href="my-assets/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />

<link href="my-assets/css/public.css" rel="stylesheet" type="text/css">
<link href="my-assets/css/side-menu.css" rel="stylesheet" type="text/css">

<!--Importing Icons-->
<script src="my-assets/bootstrap/js/popper.js"></script>

<script src="my-assets/spakat/spakat.js" type="text/javascript"></script>
<script src="my-assets/fontawesome-pro/js/all.min.js" type="text/javascript" ></script>
<link href="my-assets/fontawesome-pro/css/light.css" rel="stylesheet">
<link href="my-assets/css/forms.css" rel="stylesheet" type="text/css" />
<style type="text/css">
    .top-apps-menu {
		position: fixed;
		top:-90vh;
		height:89vh;
		width:100%;
		background-color: #f4f5f2;
		z-index: 30;
	}
    .login-box {
		display: table;
		max-width:350px;
        width:100%;
		margin-left:auto;
		margin-right:auto;
		padding-top:8vh;
		min-height:62vh;
	}
	.box-grad {
		background: rgb(2,0,36);
		background: -moz-radial-gradient(circle, rgba(2,0,36,1) 0%, rgba(74,101,112,1) 100%);
		background: -webkit-radial-gradient(circle, rgba(2,0,36,1) 0%, rgba(74,101,112,1) 100%);
		background: radial-gradient(circle, rgba(2,0,36,1) 0%, rgba(74,101,112,1) 100%);
		filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#020024",endColorstr="#4a6570",GradientType=1);
		height:357px;
		text-align: center;
	}
	.sleft-menu ul li a {
		color:#cccac5;
	}
	.sleft-menu ul li ul li a {
		color:#dddbd7;
	}
	.btnSignature {
        background-color:#656363;
    }
	.subside {
		display: none;
	}

	.divline {
		height:3px;width:100px;background-color:#cccac5;
		margin-top:50px;
	}
	.divlinesm {
		height:2px;width:50px;background-color:#afafaf;margin-top:30px;
	}
	.triangle-topleft {
      	width: 0;
      	height: 0;
      	border-top: 50px solid #22282b;
      	border-right: 50px solid transparent;
    }
	.triangle-topright {
      	width: 0;
      	height: 0;
      	border-top: 50px solid #22282b;
      	border-left: 50px solid transparent;
    }
	.hamburger {
		position: absolute;
		right: 7px;
		top: 20px;
		width: 24px;
		cursor: pointer;
		z-index:1201;
	}
	.hamburger .bars {
		height:2px;
		width:22px;
		/*transition: background 1s linear;*/
		background-color:#2A2929;
		margin-bottom:6px;

		-moz-transition: 300ms ease-in-out;
		-webkit-transition: 300ms ease-in-out;
		transition: 300ms ease-in-out;
	}
	.rotating {
		-webkit-animation: rotating 1s linear infinite;
		-moz-animation: rotating 1s linear infinite;
		-ms-animation: rotating 1s linear infinite;
		-o-animation: rotating 1s linear infinite;
		animation: rotating 1s linear infinite;
	}
	.icon-fr {
		margin-top:30px;
	}
	.icon-fr img {
		height:80px
	}
	@media (max-width: 991.98px) {
		body {
			width:100%;
			overflow-x: hidden;
		}
		.theme-img {
			width:100%;
			max-width:400px;
		}
		.parallax-window-woksyop {
			position:absolute;
			top:150px;
			height:210px;
			left:0px;
			width:100%;
			background: transparent;
			z-index:3;
			background-position: bottom center;
		}
		.parallax-window-fleet {
			position:absolute;
			top:230px;
			height:170px;
			left:0px;
			width: 100%;
			background: transparent;
			z-index:5;
		}
		.cloudback {
			position:relative;
			left:0px;
			top:0px;

			width:100%;
			height:400px;
		}
		.epi-full {
			font-size: 18px;
			line-height: 18px;
			max-width:190px;
			text-align: right;
		}
		/*.burger-box {
			display: block;
			position: fixed;
			top:10px;
			width:50px;
			right:20px;
			height:50px;
			z-index:1230;
			text-align: center;
		}
		.hamburger {
			position: absolute;
			right: 0px;
			top: 8px;
			width: 24px;
			cursor: pointer;
			z-index:1201;
		}*/

		.icon-fr img {
			height:90px
		}
		.officialdesc {
			font-family: helve-thin;
		}
		.moduledesc {
			font-family: mark;
			letter-spacing: 0px;
			font-size:20px;
		}
	}
</style>

</head>
<body>
<div class="top-apps-menu">
    <div class="container">
        <div class="login-box">
            <img src="my-assets/img/spakat-small-min.png" id="menu-logo"/>
            <div class="full">Sistem Aplikasi<br/>Pengurusan Kenderaan<br/>Atas Talian </div>
            <ul class="bunch-menu">
                <li class="row-menu"><i class="fal fa-home"></i> <a href="/">Laman Utama</a></li>
                <li class="row-menu"><i class="fal fa-user"></i> <a href="{{route('register')}}">Pengguna Baharu</a></li>
            </ul>
            <p>&nbsp;</p>
            <div style="font-size:0.7em;color:#999999">&copy; 2021 Jabatan Kerja Raya Malaysia</div>
        </div>
    </div>
</div>
<div class="cloud-top">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-8 col-sm-9 col-6" style="position: relative;">
                <div class="spakat-header" onClick="window.open('/', '_self');">
                    <img src="my-assets/img/spakat-small-min.png" class="d-inline d-sm-inline-flex"/>
                </div>
                <div class="jkr-float"><img src="my-assets/img/logo.png"/></div>
                <div class="triangle-float"><img src="my-assets/img/triangle-min.png" class="img-fluid"/></div>
                <div class="spakat-fullname">Sistem Aplikasi Pengurusan Kenderaan Atas Talian</div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-4 col-sm-3 col-6 d-none d-sm-block home-menu">
                <button class="btn btn-blank" onClick="window.open('/', '_self');"><img src="my-assets/img/home-grey.svg"/></button>
                <button class="btn btn-blank" onClick="goTo('/register')">{{$lblBtnNewUser}}</button>
                <!--<button class="btn btn-login" onClick="goTo('index.htm')">Log Masuk</button>-->
            </div>
        </div>
    </div>
</div>
<div class="whole">
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-xs-12 col-12" style="position: relative;">
			<div class="back-content p-0">
				<div class="container">
                   @yield('content')
				</div>
				@livewireScripts
    			<script src="{{ asset('js/app.js') }}" defer></script>
			</div>
		</div>
	</div>
	<!--start of footer-->
      @include('footer_frontpage')
    <!--end of footer-->
</div>
<div class="burger-box" onClick="togAppsMenu();">
	<div class="hamburger">
		<div class="bars" id="bars-1" style="transform-origin: 0 50%;">&nbsp;</div>
		<div class="bars" id="bars-2">&nbsp;</div>
		<div class="bars" id="bars-3" style="transform-origin: 0 50%;">&nbsp;</div>
	</div>
</div>
<script type="text/javascript" src="my-assets/jquery/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="my-assets/bootstrap/js/bootstrap.min.js"></script>

<script>
jQuery(document).ready(function() {
	$("body").fadeIn(1000);
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
