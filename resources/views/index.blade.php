@php

    use App\Http\Controllers\Setting\SettingAnnounceDAO;
    use App\Http\Controllers\ApplicationDAO;

    $SettingAnnounceDAO = new SettingAnnounceDAO();
    $SettingAnnounceDAO->mount();
    $announce_list = $SettingAnnounceDAO->getList();

    $ApplicationDAO = new ApplicationDAO();
    $ApplicationDAO->mount();

    $lang = $ApplicationDAO->lang;
    $lblRegister = $ApplicationDAO->lblRegister;
    $lblLogin = $ApplicationDAO->lblLogin;
    $lblSsoLogin = $ApplicationDAO->lblSsoLogin;
    $lblDashboard = $ApplicationDAO->lblDashboard;
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
<link href="https://spakat.jkr.gov.my/" rel="alternate" hreflang="x-default">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="description" content="Aplikasi pengurusan kenderaan JKR dalam menguruskan rekod kenderaan, penilaian, penyenggaraan dan kemudahan logistik untuk JKR seluruh Malaysia"><link rel="canonical" href="https://spakat.jkr.gov.my/">
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" /> <meta http-equiv="Pragma" content="no-cache" /> <meta http-equiv="Expires" content="0" />
<meta property="og:site_name" content="SPaKAT">
<meta property="og:type" content="website">
<meta property="og:url" content="https://spakat.jkr.gov.my">
<meta property="og:title" content="JKR SPaKAT : Sistem Aplikasi Pengurusan Kenderaan Atas Talian">
<meta property="og:description" content="Aplikasi pengurusan kenderaan JKR dalam menguruskan rekod kenderaan, penilaian, penyenggaraan dan kemudahan logistik untuk JKR seluruh Malaysia">
<meta property="og:image" content="//spakat.cubixi.com/img/mod-spakat.jpg">
<title>JKR SPaKAT :: Sistem Aplikasi Pengurusan Kenderaan Atas Talian</title>
<!-- import area for frequently used files-->
<link rel="shortcut icon" href="my-assets/favicon/favicon.png">
<script src="my-assets/spakat/spakat.js" type="text/javascript"></script>
<link href="my-assets/css/cubixi.css" rel="stylesheet" type="text/css">
<link href="my-assets/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />

<link href="my-assets/css/side-menu.css" rel="stylesheet" type="text/css">
<link href="my-assets/fontawesome-pro/css/light.css" rel="stylesheet">

<script src="my-assets/fontawesome-pro/js/all.min.js" type="text/javascript"></script>
<!--eof import-->
<script>
function includeHTML() {
    var z, i, elmnt, file, xhttp;
    /* Loop through a collection of all HTML elements: */
    z = document.getElementsByTagName("*");
    for (i = 0; i < z.length; i++) {
      elmnt = z[i];
      /*search for elements with a certain atrribute:*/
      file = elmnt.getAttribute("w3-include-html");
      if (file) {
        /* Make an HTTP request using the attribute value as the file name: */
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4) {
            if (this.status == 200) {elmnt.innerHTML = this.responseText;}
            if (this.status == 404) {elmnt.innerHTML = "Page not found.";}
            /* Remove the attribute, and call this function once more: */
            elmnt.removeAttribute("w3-include-html");
            includeHTML();
          }
        }
        xhttp.open("GET", file, true);
        xhttp.send();
        /* Exit the function: */
        return;
      }
    }
}
</script>
<style type="text/css">
	body {
		display: none;
        background-color: #4e3f2e;
	}
    .tanda-dummy {
        border-style:solid;
        border-width:1px;
        border-color:transparent;
    }
    .memo-dte {
        color:#3a3a3a;
        font-size:0.8em;
        font-family: avenir;
        text-transform: uppercase;
        margin-bottom:10px;
        letter-spacing: 2px;
        margin-top:20px;
    }
    .memo-txt {
        color:#3a3a3a;
        font-size:1.1em;
        font-family: helve-bold;
        margin-bottom:10px;
    }
    .memo-sig {
        color:#3a3a3a;
        font-size:0.9em;
        font-family: helve-bold;
        margin-top:10px;
    }
	.cloudback {
		position:relative;
		left:0px;
		top:0px;

		width:100%;
		height:650px;
	}
	.spakat-brand {
		text-align: right;
		padding-top:0px;
		padding-right:0px;
		max-width: 250px;
	}
	.spakat-brand #jkr-logo {
		height:50px;
	}
	.spakat-brand #spakat-logo {
		margin-top:20px;
		height:50px;
	}
	.epi-full {
		margin-top:6px;
		margin-right:6px;
		font-family: lato;
		font-size: 14px;
		line-height: 16px;
		text-align: right;
		color: #221c19;
	}
	.parallax-head {
		position: absolute;
		top:60px;
		left:0px;
		width: 100%;
		height:100px;
		background: transparent;
		z-index: 14;
	}
	.parallax-window-woksyop {
		position:absolute;
		top:100px;
		height:450px;
		left:0px;
		width:100%;
    	background: transparent;
		z-index:3;
		background-position: bottom center;
	}
	.parallax-window-fleet {
		position:absolute;
		top:200px;
		height:450px;
		left:0px;
		width: 100%;
    	background: transparent;
		z-index:13;
	}
	.parallax-window-cloud {
		position:absolute;
		top:0px;
		height:357px;
		left:0px;
		width:100%;
    	background: transparent;
		z-index:10;
	}
	.spakat-dropcase-footer {
		margin-top:-2px;
		line-height: 10px;
		display: inline-block;
		padding-right:5px;
	}
	.spakat-dropcase {
		float:left;
		margin-top:-2px;
		line-height: 10px;
		display: inline-block;
		padding-right:5px;
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
	.divline {
		height:3px;width:100px;background-color:#cccac5;
		margin-top:50px;
	}
	.divlinesm {
		height:2px;width:50px;background-color:#afafaf;margin-top:30px;
	}
	.divlinexs {
		height:1px;width:40px;background-color:#cccac5;
		margin-top:10px;
		margin-bottom:10px;
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
	.fa-envelope {
		color:white !important;
	}
	.icon-fr {
		margin-top:30px;
	}
	.icon-fr img {
		height:80px
	}
	.jkr-mobile {
		display: none;
	}
    .carousel-item {
        padding-left:10%;
        padding-right:10%;
    }
    .modal-content {
        border-radius: 0.5rem;
    }
    .modal {
        margin-top:16vh;
    }
    .modal-dialog {
        height:50vh;
    }
    .modal-header {
        display: none;
    }
	@media (max-width: 991.98px) {
		.theme-img {
			width:100%;
			max-width:400px;
		}
		.spakat-brand #jkr-logo {
			display:none !important;
		}
		.jkr-mobile {
			display: block;
			position:absolute;
			right:0px;
			width:100%;
			text-align: right;
			top:-35px;
			height:50px;
			z-index: 30;
			text-align: right;
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
		.spakat-dropcase {
			margin-top:-2px;
		}
	}
	@media (max-width: 768px) {
		.spakat-dropcase {
			margin-top:-8px;
			line-height: 10px;
		}
	}
	@media (max-width: 575.98px) {
		@supports (-webkit-overflow-scrolling: touch) {

		}
        .local-content {
            padding-left:20px;
            padding-right:20px;
        }
		.icon-fr {
			margin-top:30px;
		}
		.icon-fr img {
			height:100px
		}
		.spakat-brand #spakat-logo {
			height:40px;
		}
		.jkr-mobile {
			display: block;
			position: absolute;
			right:0px;
			top:-35px;
			padding-right:40px;
			width:150px;
			z-index: 30;
			text-align: right;
		}
        .modal {
            margin-top:3vh;
        }
        .modal-dialog {
            height:77vh;
        }
        .modal-header {
            display: block;
            margin-bottom:0px;
        }
        .modal-header img {
            height:30px;
        }
        .modal-body {
            padding-top:0px;
            padding-bottom:0px;
        }
        .memo-dte {
            color:#3a3a3a;
            font-size:0.95em;
            font-family: avenir;
            text-transform: uppercase;
            margin-bottom:10px;
            letter-spacing: 2px
        }
        .memo-txt {
            color:#3a3a3a;
            font-size:1.5em;
            font-family: helve-bold;
            margin-bottom:10px;
        }
        .memo-sig {
            color:#3a3a3a;
            font-size:1.1em;
            font-family: helve-bold;
            margin-top:10px;
        }
        .memo-cnt {
            font-size:18px;
        }
        .carousel-item {
            max-height: 60vh;
            overflow-y:scroll;
            margin-top:0px;
        }
        .epi-full {
            padding-left:50px;
        }
	}
</style>
</head>
<body>
<div class="top-apps-menu">
	<img src="my-assets/img/spakat-small-min.png" id="menu-logo"/>
	<div class="full">Sistem Aplikasi<br/>Pengurusan Kenderaan<br/>Atas Talian </div>
	<ul class="bunch-menu">
		<li class="row-menu"><i class="fal fa-sign-in"></i> <a href="/login">{{$lblLogin}}</a></li>
        @env('production')
        <li class="row-menu"><i class="fal fa-sign-in"></i> <a href="{{'https://sso.jkr.gov.my/nidp/idff/sso?option=credential&target='.route('cb.sso.login')}}">{{$lblSsoLogin}}</a></li>
        @endenv
		<li class="row-menu"><i class="fal fa-user"></i> <a aria-label='register1'  href="{{route('register')}}">{{$lblRegister}}</a></li>
	</ul>
    <a href="?lang=en" class="lingo-menu">Bahasa Inggeris</a>
    <p>&nbsp;</p>
    <div style="font-size:0.7em;color:#999999">&copy; 2021 Jabatan Kerja Raya Malaysia</div>
</div>
<div class="whole">
    <div class="parallax-window-fleet" data-parallax="scroll" data-image-src="my-assets/img/fleet-min.png" data-z-index="3" data-speed="0.9"></div>
	<div class="parallax-window-woksyop" data-parallax="scroll" data-image-src="my-assets/img/woksyop-min.png" data-z-index="2" data-speed="0.7"></div>
	<div class="cloudback" data-parallax="scroll" data-image-src="my-assets/img/cloud.jpg" data-z-index="1" data-speed="0.5"></div>
	<div class="parallax-head" data-parallax="scroll" data-z-index="4" data-speed="0.4">
		<div class="container">
			<div class="row">
				<div class="col-xl-6 col-lg-6 col-sm-6 col-md-6 col-7">
					<div class="spakat-brand">
						<img src="my-assets/img/logo.png" class="d-inline" id="jkr-logo"/>
						<img src="my-assets/img/spakat-small-min.png" class="d-inline d-sm-inline-flex" id="spakat-logo"/>
						<div class="epi-full">Sistem Aplikasi Pengurusan Kenderaan Atas Talian</div>
					</div>
				</div>
				<div class="col-xl-6 col-lg-6 col-sm-6 col-md-6 col-5 pt-3 d-none d-sm-block home-menu">
					@if (!auth()->user())
						<button class="btn btn-blank" aria-label='register2' onClick="goTo('{{route("register")}}')"> {{$lblRegister}} </button>
						<div class="btn-group">
                            <button class="btn btn-login" aria-label="logmasuk1" onClick="goTo('{{route("login")}}')"> {{$lblLogin}}</button>
                            @env('production')
                                <button class="btn btn-login" onClick="goTo('{{'https://sso.jkr.gov.my/nidp/idff/sso?option=credential&target='.route('cb.sso.login')}}')"> {{$lblSsoLogin}}</button>
                            @endenv
                        </div>
					@else
						<a class="btn btn-theme" href="{{route('dashboard')}}"> {{$lblDashboard}}</a>
					@endif
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-xs-12 col-12 back-content" style="position: relative;">
			<div class="jkr-mobile">
				<div class="container"><img src="my-assets/img/logo.png" style="max-height: 70px;"/></div>
			</div>
			<div class="container">
                <div style="max-width: 600px;">
                    <div class="officialdesc mt-5">
                        <span class="spakat-dropcase"><img src="my-assets/img/spakat-small-min.png" style="height:30px;line-height: 12px;"></span>
                        @php
                            if($lang == 'en'){
                                echo "is an application purposely developed for managing the Government fleet regarding procurement, usage, maintenance, and disposal.";
                            }else{
                                echo "merupakan pangkalan data kenderaan milik kerajaan secara sistematik melibatkan pengurusan aset yang menyeluruh daripada perolehan, penggunaan, penyelenggaraan dan pelupusan.";
                            }
                        @endphp
                    </div>
                </div>
                <div class="divline"></div>
                <img src="my-assets/img/theme-rekod.jpg" class="theme-img"/>
                <div class="submodule" style="color: #77acd6;">{{$lang == 'en' ? 'Vehicle Records' : 'Pengurusan Rekod Kenderaan'}}</div>
                <div class="moduledesc" style="max-width: 400px;">{{$lang == 'en' ? "A database to upkeep the details of the department's fleets, project vehicles, plants, and machinery owned by the Government" : "Pangkalan data bagi kenderaan jabatan, Projek, Loji dan jentera milik kerajaan."}}</div>
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="icon-fr"><img src="my-assets/img/icon-rekod-kenderaan.svg"></div>
                        <div class="mytitle">{{$lang == 'en' ? 'Vehicle Information' : 'Maklumat Kenderaan'}}</div>
                        <div class="mycontent">{{$lang == 'en' ? "To manage the details of the department's vehicle, project's vehicle, plants, and machinery owned by the Government." : "Pendaftaran kenderaan jabatan, Projek, Loji dan jentera milik kerajaan."}}</div>
                        <div class="divlinesm"></div>
                    </div>
                    <!--<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="icon-fr"><img src="my-assets/img/icon-dashboard.svg"></div>
                        <div class="mytitle">Dashboard &amp; Laporan</div>
                        <div class="mycontent">Melaporkan maklumat-maklumat kenderaan dan alatan, peruntukan kewangan, status permohonan dan penilaian dan sebagainya melalui paparan graf dan jadual interaktif.
                        </div>
                        <div class="divlinesm"></div>
                    </div>-->
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="icon-fr"><img src="my-assets/img/icon-saman.svg"></div>
                        <div class="mytitle">{{$lang == 'en' ? 'Summon Records' : 'Rekod Saman'}}</div>
                        <div class="mycontent">{{$lang == 'en' ? "To register and update summon record and payment relating to Government's vehicle." : "Pendaftaran dan pengemaskinian rekod dan bayaran saman kenderaan jabatan milik kerajaan."}}
                        </div>
                        <div class="divlinesm"></div>
                    </div>
                    <!--<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="icon-fr"><img src="my-assets/img/icon-sejarah.svg"></div>
                        <div class="mytitle">Sejarah dan Arkib</div>
                        <div class="mycontent">Merekod serta mempersembahkan perjalanan aktiviti kenderaan dalam bentuk garis masa untuk rujukan akan datang. Juga menyimpan rekod-rekod aktiviti bagi kenderaan yang telah dilupuskan.
                        </div>
                        <div class="divlinesm"></div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="icon-fr"><img src="my-assets/img/icon-reminder.svg"></div>
                        <div class="mytitle">Notifikasi Peringatan</div>
                        <div class="mycontent">Memberi makluman secara automatik dan berkala untuk penyenggaran kenderaan, insurans atau cukai jalan atau  automatik peringatan terkini secara berkala melalui email</div>
                        <div class="divlinesm"></div>
                    </div>-->
                </div>
                <p>&nbsp</p>
                <hr/>
                <img src="my-assets/img/theme-penilaian.jpg" class="theme-img"/>
                <div class="submodule" style="color:#238e13">{{$lang == 'en' ? "Vehicle Assessment" : "Penilaian Kenderaan"}}</div>
                <div class="moduledesc" style="max-width: 400px;">{{$lang == 'en' ? "The process of assessing and evaluating Government vehicle" : "Proses penilaian yang dijalankan ke atas kenderaan milik kerajaan Persekutuan, Negeri dan Persendirian."}}</div>
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="icon-fr"><img src="my-assets/img/icon-nilai-kenderaan-baharu.svg"></div>
                        <div class="mytitle">
                            @php
                                if($lang == 'en'){
                                    echo "New Vehicle<br/>Assessment";
                                }else{
                                    echo "Penilaian Kenderaan<br/>Baharu";
                                }
                            @endphp
                        </div>
                        <div class="mycontent">
                            @php
                            if($lang == 'en'){
                                echo "Assistance to assess newly procured vehicle to ensure it is complying the standards and specification stated in the procurement requirement";
                            }else{
                                echo "Perkhidmatan penilaian secara fizikal dan semakan spesifikasi ke atas kenderaan yang dibeli oleh agensi kerajaan supaya menepati standard serta kehendak agensi.";
                            }
                            @endphp
                        </div>
                        <div class="divlinesm"></div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="icon-fr"><img src="my-assets/img/icon-nilai-prestasi.svg"></div>
                        <div class="mytitle">
                            @php
                                if($lang == 'en'){
                                    echo "Performance and Safety<br/>Assessment";
                                }else{
                                    echo "Penilaian Prestasi<br/>dan Tahap Keselamatan";
                                }
                            @endphp
                        </div>
                        <div class="mycontent">
                            @php
                            if($lang == 'en'){
                                echo "Assistance to evaluate the level of performance and safety to ensure it is safe and sound for daily usage";
                            }else{
                                echo "Perkhidmatan penilaian secara tahunan bagi Kenderaan Kerajaan untuk menilai tahap keselamatan dan prestasi kenderaan bagi memastikan kenderaan selamat digunakan dan berupaya beroperasi pada tahap optimum.";
                            }
                            @endphp
                        </div>
                        <div class="divlinesm"></div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="icon-fr"><img src="my-assets/img/icon-nilai-kemalangan.svg"></div>
                        <div class="mytitle">
                            @php
                                if($lang == 'en'){
                                    echo "Accident<br/>Assessment";
                                }else{
                                    echo "Penilaian Kerosakan Akibat Kemalangan";
                                }
                            @endphp
                        </div>
                        <div class="mycontent">
                            @php
                            if($lang == 'en'){
                                echo "Assistance to assess the damage and cost to be incurred due to accident involving the Government's fleet";
                            }else{
                                echo "Perkhidmatan penilaian kerosakan dan penentuan anggaran kos pembaikan atau penggantian komponen akibat dari kemalangan yang melibatkan kenderaan kerajaan.";
                            }
                            @endphp
                        </div>
                        <div class="divlinesm"></div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="icon-fr"><img src="my-assets/img/icon-nilai-harga.svg"></div>
                        <div class="mytitle">
                            @php
                            if($lang == 'en'){
                                echo "Current Value<br/>Assessment";
                            }else{
                                echo "Penilaian Harga Semasa<br/>Kenderaan";
                            }
                            @endphp
                        </div>
                        <div class="mycontent">
                            @php
                            if($lang == 'en'){
                                echo "Assistance to assess the current value of a particular vehicle";
                            }else{
                                echo "Perkhidmatan penilaian bagi penentuan harga semasa kenderaan.";
                            }
                            @endphp
                        </div>
                        <div class="divlinesm"></div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="icon-fr"><img src="my-assets/img/icon-nilai-pelupusan.svg"></div>
                        <div class="mytitle">
                            @php
                            if($lang == 'en'){
                                echo "Disposal<br/>Assessment";
                            }else{
                                echo "Penilaian Untuk<br/>Pelupusan";
                            }
                            @endphp
                        </div>
                        <div class="mycontent">
                            @php
                            if($lang == 'en'){
                                echo "Assistance to assess the economical value of the Government's assets so it can be justified for disposal";
                            }else{
                                echo "Perkhidmatan penilaian untuk mengeluarkan aset alih kerajaan daripada milikan, kawalan, simpanan dan rekod yang secara fizikalnya masih ada dalam simpanan tetapi tidak digunakan atau tidak ekonomik untuk dibaiki.";
                            }
                            @endphp
                        </div>
                        <div class="divlinesm"></div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="icon-fr"><img src="my-assets/img/icon-nilai-pinjaman.svg"></div>
                        <div class="mytitle">
                            @php
                            if($lang == 'en'){
                                echo "Government Loan<Br/>Assessment";
                            }else{
                                echo "Penilaian Pinjaman<Br/>Kerajaan";
                            }
                            @endphp
                        </div>
                        <div class="mycontent">
                            @php
                            if($lang == 'en'){
                                echo "Assistance to evaluate the current value of the desired vehicle being applied under the Government loan";
                            }else{
                                echo "Perkhidmatan penilaian kenderaan untuk penentuan harga kenderaan terpakai dan tempoh ekonomi kenderaan bagi pegawai kerajaan yang ingin memohon pinjaman bagi pembelian kenderaan.";
                            }
                            @endphp
                        </div>
                        <div class="divlinesm"></div>
                    </div>
                </div>
                <p>&nbsp</p>
                <hr/>
                <img src="my-assets/img/theme-penyenggaraan.jpg" class="theme-img"/>
                <div class="submodule" style="color:#c65218">
                    @php
                    if($lang == 'en'){
                        echo "Vehicle Maintenance";
                    }else{
                        echo "Penyenggaraan Kenderaan";
                    }
                    @endphp
                </div>
                <div class="moduledesc" style="max-width: 400px;">
                    @php
                    if($lang == 'en'){
                        echo "Service to perform inspection and maintenance for the Government assets";
                    }else{
                        echo "Perkhidmatan pemeriksaan kerosakan dan penyelenggaraan bagi kenderaan milik agensi kerajaan.";
                    }
                    @endphp
                </div>
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="icon-fr"><img src="my-assets/img/icon-sub-waran.svg"></div>
                        <div class="mytitle">
                            @php
                            if($lang == 'en'){
                                echo "Budget Allocation Management";
                            }else{
                                echo "Pengurusan Peruntukan Waran";
                            }
                            @endphp
                        </div>
                        <div class="mycontent">
                            @php
                            if($lang == 'en'){
                                echo "Managing the allocation of yearly budget under the category of MHPV (Maintenance of Heavy Plant and Vehicle) as well as monitoring the utilization of the budget given";
                            }else{
                                echo "Pengurusan agihan peruntukan penyenggaraan kenderaan dan jentera di bawah kategori MHPV (Maintenance of Heavy Plant and Vehicle) serta memantau penggunaan bajet.";
                            }
                            @endphp
                        </div>
                        <div class="divlinesm"></div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="icon-fr"><img src="my-assets/img/icon-pemeriksaan.svg"></div>
                        <div class="mytitle">
                            @php
                            if($lang == 'en'){
                                echo "Faulty Inspection";
                            }else{
                                echo "Pemeriksaan Kerosakan";
                            }
                            @endphp
                        </div>
                        <div class="mycontent">
                            @php
                            if($lang == 'en'){
                                echo "Assistance to inspect faulty either for regular checks or on-demand";
                            }else{
                                echo "Perkhidmatan pemeriksaan kerosakan kenderaan secara berkala atau on-demand bagi memenuhi keperluan polisi jabatan.";
                            }
                            @endphp
                        </div>
                        <div class="divlinesm"></div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="icon-fr"><img src="my-assets/img/icon-penyenggaraan.svg"></div>
                        <div class="mytitle">
                            @php
                            if($lang == 'en'){
                                echo "Maintenance";
                            }else{
                                echo "Penyenggaraan";
                            }
                            @endphp
                        </div>
                        <div class="mycontent">
                            @php
                            if($lang == 'en'){
                                echo "Assistance in providing the fix or routine inspection";
                            }else{
                                echo "Perkhidmatan penyenggaraan secara rutin atau on-demand bagi membaiki kerosakan kenderaan.";
                            }
                            @endphp
                        </div>
                        <div class="divlinesm"></div>
                    </div>
                </div>
                <p>&nbsp</p>
                <hr/>
                <img src="my-assets/img/theme-logistik.jpg" class="theme-img"/>
                <div class="submodule" style="color:#600e3f">{{$lang == 'en' ? 'Logistics' : 'Logistik'}}</div>
                <div class="moduledesc" style="max-width: 400px;">
                    @php
                    if($lang == 'en'){
                        echo "Facility to enable transport booking for the usage of official as well as handling disaster";
                    }else{
                        echo "Perkhidmatan Tempahan kenderaan bagi urusan rasmi jabatan dan siap siaga bencana.";
                    }
                    @endphp
                </div>
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="icon-fr"><img src="my-assets/img/icon-tempah-kenderaan.svg"></div>
                        <div class="mytitle">
                            @php
                            if($lang == 'en'){
                                echo "Vehicle Booking";
                            }else{
                                echo "Tempahan Kenderaan";
                            }
                            @endphp
                        </div>
                        <div class="mycontent">
                            @php
                            if($lang == 'en'){
                                echo "Assistance in transport booking using the department's fleet for official used like attending function, courses etc.";
                            }else{
                                echo "Perkhidmatan tempahan kenderaan jabatan bagi kegunaan rasmi jabatan seperti menghadiri mesyuarat/kursus/bengkel.";
                            }
                            @endphp
                        </div>
                        <div class="divlinesm"></div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="icon-fr"><img src="my-assets/img/icon-siaga-bencana.svg"></div>
                        <div class="mytitle">
                            @php
                            if($lang == 'en'){
                                echo "Disaster Preparation";
                            }else{
                                echo "Siap Siaga Bencana";
                            }
                            @endphp
                        </div>
                        <div class="mycontent">
                            @php
                            if($lang == 'en'){
                                echo "Assistance in providing vehicle to be used purposely in handling disaster";
                            }else{
                                echo "Perkhidmatan pinjaman kenderaan Jabatan Kerja Raya yang diistihar bagi kegunaan Ketika siap siaga bencana.";
                            }
                            @endphp
                        </div>
                        <div class="divlinesm"></div>
                    </div>
                </div>
                <p>&nbsp;</p>
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
{{--@foreach ($announce_list as $announce)
    <div class="bars" id="bars-{{$loop->index}}">&nbsp;</div>
@endforeach--}}
<div class="btnJumpTop" onclick="scrollToTop()">
	<i class="fal fa-arrow-up fa-lg" style="color:#ffffff !important;"></i>
</div>
<div class="mycookies">
	<div class="container">This website uses cookies to improve your experience. We'll assume you're ok with this, but you can opt-out if you wish. <a href="" style="font-size:14px;color:#ffffff">Read more</a><button type="button" class="btn btn-light btn-sm" onClick="acceptCookie();">Accept</button></div>
</div>

<!-- Modal -->
<div class="modal fade modal-dialog-centered modal-dialog-scrollable" id="myModal" tabindex="-1" aria-labelledby="staticBackdropLabel" data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="position: relative;height:100%;">
            <button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close" style="position:absolute;right:15px;top:15px;z-index:10"></button>
            <div class="modal-header">
                <img src="my-assets/img/spakat-small-min.png"/>
            </div>
            <div class="modal-body">
                <!--carousel start-->
                <div id="announcementIndicators" class="carousel carousel-dark slide" data-bs-ride="carousel" style="height: 90%">
                    <div class="carousel-indicators" style="bottom:-60px">
                        @foreach ($announce_list as $announce)
                            <button type="button" data-bs-target="#announcementIndicators" data-bs-slide-to="{{$loop->index}}" class="active" aria-current="true" aria-label="Slide 1"></button>
                        @endforeach
                      </div>
                    <div class="carousel-inner" style="height:100%">

                        {{-- @json($announce_list) --}}
                        @foreach ($announce_list as $announce)
                            <div class="carousel-item {{$loop->index == 0 ? 'active' : ''}}">
                                <div>
                                    <div class="memo-dte">{{$announce->created_at}}</div>
                                    <div class="memo-txt">{{$announce['title_'.$lang]}}</div>
                                    <div class="memo-cnt">{{$announce['desc_'.$lang.'_1']}} {{$announce['desc_'.$lang.'_2']}}</div>
                                    <div class="memo-sig">{{$announce->createdBy->name}}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#announcementIndicators" data-bs-slide="prev" style="margin-left:-20px">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#announcementIndicators" data-bs-slide="next" style="margin-right:-20px">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="visually-hidden">Next</span>
                    </button>
                </div>
                <!--carousel end-->
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="my-assets/jquery/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="my-assets/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="my-assets/plugins/parallax/parallax.js"></script>

<script>
function checkSite(){
        $.get(window.location.href, function(res, o, u){

            console.log(u);

            if(u.status == 200){
                //alert('Server down, please contact administrator');
            } else {
                alert('Something went wrong. Please contact administator');
            }

        }).done(function() {
            //alert( "second success" );
        })
        .fail(function() {
            alert('Something went wrong. Please contact administator');
        })
        .always(function() {
           // alert( "finished" );
        });
    }

jQuery(document).ready(function() {

    @if (env('APP_ENV') == 'production')
		setInterval(() => {
			checkSite();
		}, 10000);
	@endif


	$('.parallax-window-woksyop').parallax();
	$('.parallax-window-fleet').parallax();
	$('.parallax-head').parallax();
	$('.cloudback').parallax();

    //changing footer
    $(window).on('resize', function(){
        var cwid = $(document).width();
        if(parseInt(cwid) <= 576) {
            $('.signature').html('&copy; 2021 JKR');
            $('#lingo-txt').html('EN');
        }else{
            $('.signature').html('&copy; 2021 Jabatan Kerja Raya Malaysia');
            $('#lingo-txt').html('Bahasa Inggeris');
        }
    });

    //defaault
    var cwid = $(document).width();
    if(parseInt(cwid) <= 576) {
        $('.signature').html('&copy; 2021 JKR');
        $('#lingo-txt').html('EN');
    }else{
        $('.signature').html('&copy; 2021 Jabatan Kerja Raya Malaysia');
        $('#lingo-txt').html('Bahasa Inggeris');
    }

    //var myModal = new bootstrap.Modal(document.getElementById('myModal'));
    var myModal = $('#myModal');

    @if ($announce_list->count()>0)
        myModal.show();
        myModal.modal('show');
        @else
        myModal.hide();
        myModal.modal('hide');
    @endif

	$("body").fadeIn(1000);
})
</script>
</body>
</html>
