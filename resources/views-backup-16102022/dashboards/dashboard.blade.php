@extends('dashboards.app')


@section('title', 'Dashboard')
@section('subtitle', 'Sepintas lalu')


@section('content')
<script src="{{asset('my-assets/plugins/highcharts/code/highcharts.js')}}"></script>
<script src="{{asset('my-assets/plugins/highcharts/code/modules/variable-pie.js')}}"></script>
<script src="{{asset('my-assets/plugins/highcharts/code/modules/accessibility.js')}}"></script>
<script>
jQuery(document).ready(function() {
})
</script>
<style type="text/css">

	.self-container {
        width:55%;
        margin-left:auto;
        margin-right:auto;
    }

    .dsh-sec {
		text-transform: uppercase;
		font-family: mark-bold;
		font-size:12px;

		color:#000000;
		letter-spacing: 0px;
		text-decoration: none;
	}

	.round-point {
        position: relative;

        width:140px;
        height:210px;
        /*background: rgb(125,125,125);
        background: linear-gradient(307deg, rgba(125,125,125,1) 0%, rgba(193,198,189,1) 100%);*/
        background: rgb(242,244,240);
        background: radial-gradient(circle, rgba(242,244,240,1) 100%, rgba(228,229,226,1) 0%);
        margin-left:auto;
        margin-right:auto;
        padding:0px;

        border-radius: 15px 15px 15px 15px;
        -moz-border-radius: 15px 15px 15px 15px;
        -webkit-border-radius: 15px 15px 15px 15px;
        border-style: solid;
        border-color:#c8c8cc;
        border-width:1px;
        -webkit-box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.23);
        -moz-box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.23);
        box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.23);
        transition: all .2s ease-in-out;
    }
    .round-point:hover {
        transform: scale(1.1);
    }

	.pointer {
        position:absolute;
        right:-90px;
        width:40px;
    }
    .spectitle {
        font-family: helvetica-bold;
        font-size:24px;
        letter-spacing: -1px;
        margin-bottom:20px;
    }

	.round-point .shadow-point {
        position: absolute;
        margin-left:auto;
        margin-right:auto;
        top:240px;
        width: 140px;
        height: 20px;
        background-color: rgba(106,106,106,0.2);
        border-radius: 100px / 50px;
        cursor: pointer;
         /* Add the blur effect */
        filter: blur(8px);
        -webkit-filter: blur(8px);
    }
    .round-point .my-badge {
        position: absolute;
        top:-18px;
        right:-18px;
        background-color: #e9b600;
        -webkit-border-radius: 255px;
        -moz-border-radius: 255px;
        border-radius: 255px;
        height:30px;
        width: 30px;
        text-align: center;
        font-family: mark-bold;
        font-size: 16px;
        line-height: 28px;
        padding-right:0px;
        color:#ffffff;
    }
    .round-point .txt {
        position: absolute;
        top:90px;
        width:100%;

        border-top-style: solid;
        border-top-color:#e3e3eb;
        border-top-width:1px;
        color:#252525;
        padding-top:12px;
        padding-left:12px;
    }
    .round-point .txt .section, .special .txt .section {
        text-align: left;

        font-family:avenir;
        text-transform: uppercase;
        letter-spacing:1px;
        font-size:12px;
        line-height: 14px;
    }
    .round-point .txt .count {
        font-size:30px;
        font-family:helve-bold;
        line-height: 30px;
        color:#212121;
        margin-top:10px;
        margin-bottom:0px;
    }
    .round-point .txt .terms {
        font-size:14px;
        font-family:avenir;
        line-height: 14px;
        color:#212121;
    }
    .round-point .crc {
        width:100%;
        height:90px;
        cursor: pointer;
        vertical-align: middle;
        text-align: center;
        -webkit-border-top-left-radius: 14px;
        -webkit-border-top-right-radius: 14px;
        -moz-border-radius-topleft: 14px;
        -moz-border-radius-topright: 14px;
        border-top-left-radius: 14px;
        border-top-right-radius: 14px;
        overflow: hidden;

        background-position: cover;
        background-repeat: no-repeat;
    }
    .lcal-2 {
        width:30px;
    }
    .lcal-3 {
        width:100px;
    }
    .lcal-4 {
        width:200px;
    }
    .cux-box {
        min-width:400px;
        min-height:300px;
        width:60%;
        height:50%;
    }
    a.list {
        font-family: lato;
        cursor:pointer;
        color:#000000;
        text-decoration: none;
    }
    a.list:hover {
        color:darkseagreen;
    }
    @media (max-width: 1399.98px) {
		/*X-Large devices (large desktops, less than 1400px)*/
		/*X-Large*/
	}
	@media (max-width: 1199.98px) {
		/*Large devices (desktops, less than 1200px)*/
		/*Large*/
	}
	@media (max-width: 991.98px) {
		/* Medium devices (tablets, less than 992px)*/
		/*medium*/
	}
	@media (max-width: 767.98px) {
		/* Small devices (landscape phones, less than 768px)
		/*small*/
	}
	@media (max-width: 575.98px) {
		/*X-Small devices (portrait phones, less than 576px)*/
		/*x-small*/
        .self-container {
            margin-top:4%;
            width:100%;
            padding-left:20px;
            padding-right:20px;
        }
        .round-point {
            width:100%;
        }
        .round-point .pointer {
            display: none;
        }
        .round-point .txt .section {
            font-family:avenir;
            font-size:14px;
            line-height: 16px;
        }
        .round-point .txt .count {
            font-size:40px;
            font-family:avenir-bold;
            line-height: 30px;
            color:#212121;
            margin-top:10px;
            margin-bottom:0px;
        }
        .round-point .my-badge {
            top:-12px;
            right:-12px;
        }
        .special {
            height:110px;
            margin-top:20px;
        }
        .special .crc {
            -webkit-border-radius: 15px;
            -webkit-border-top-right-radius: 0;
            -moz-border-radius: 15px;
            -moz-border-radius-topright: 0;
            border-radius: 15px;
            border-top-right-radius: 0;
            height: 108px;
            width:34%;

            border-right-style: solid;
            border-right-color:#c2c2c2;
            border-right-width:1px;

            background-position: center center;
        }
        .special .txt {
            position: absolute;
            top:0px;
            left:35%;
            width:50%;

            border-top-style: none;
            color:#252525;
            padding-top:12px;
            padding-left:12px;
        }
        .special .shadow-point {
            top:140px;
            width:100%;
            background-color: rgba(106,106,106,0.2);
            border-radius: 100px / 50px;
        }
        .round-point:hover {
            transform: none;
            border-style: solid;
            border-color:#a9a9ae;
            border-width:1px;
        }
	}

	@media (max-width: 991.98px) {
	}
</style>
<div class="breadcrumb"></div>
<div class="p-2">
	<div class="self-container">
        @php
            $roleAccessCode = Auth()->user()->roleAccess() ? Auth()->user()->roleAccess()->code: null;
        @endphp
	</div>
</div>
<!--<script type="text/javascript">
	var pieColors = ["#988992","#5e7485","#832c2d","#77615a","#e9a386","#d9a751","#bfbfaa","#ca6174","#6aa5ab","#427ba6","#fab8ac"];
	Highcharts.chart('chrtJobFamily', {
		chart: {
			type: 'variablepie'
		},
		title: {
			text: ''
		},
		tooltip: {
			headerFormat: '',
			pointFormat: '<span style="color:{point.color}">\u25CF</span> <b> {point.name}</b><br/>' +
				'Area (square km): <b>{point.y}</b><br/>' +
				'Population density (people per square km): <b>{point.z}</b><br/>'
		},
		plotOptions: {
				variablepie: {
					allowPointSelect: true,
					colors: pieColors,
					cursor: 'pointer',
					dataLabels: {
						enabled: false,
						format: '<b>{point.name}</b>: {point.percentage:.1f} %'
					}
				}
			},
		series: [{
			minPointSize: 10,
			innerSize: '20%',
			zMin: 0,
			name: 'countries',
			data: [{
				name: 'Spain',
				y: 505370,
				z: 92.9
			}, {
				name: 'France',
				y: 551500,
				z: 118.7
			}, {
				name: 'Poland',
				y: 312685,
				z: 124.6
			}, {
				name: 'Czech Republic',
				y: 78867,
				z: 137.5
			}, {
				name: 'Italy',
				y: 301340,
				z: 201.8
			}, {
				name: 'Switzerland',
				y: 41277,
				z: 214.5
			}, {
				name: 'Germany',
				y: 357022,
				z: 235.6
			}]
		}],
		exporting: {
			enabled: false
		},
		credits: {
			enabled: false
		}
	});


doChunk();
</script>-->


@endsection

