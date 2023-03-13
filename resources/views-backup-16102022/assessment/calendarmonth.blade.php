{{-- @php
	$selectedMonth = Request('selectedMonth') ? Request('selectedMonth') : '';
    $selectedYear = Request('selectedYear') ? Request('selectedYear') : '';
	// $listAppoinments = Request('listAppoinments') ? Request('listAppoinments') : '';
@endphp --}}
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		<title>Jadual Temujanji</title>

        <!--Universal Cubixi styling including Admin, ESS, Mobile and Public.-->
        <link href="{{asset('my-assets/css/cubixi.css')}}" rel="stylesheet" type="text/css">

        <script type="text/javascript" src="{{asset('my-assets/jquery/jquery-3.6.0.min.js')}}"></script>

        <!--importing bootstrap-->
        <link href="{{asset('my-assets/bootstrap/css/bootstrap.css')}}" rel="stylesheet" type="text/css" />

        <link href="{{asset('my-assets/css/manager.css')}}" rel="stylesheet" type="text/css">
		<link href="{{asset('my-assets/bootstrap/css/bootstrap-grid.min.css')}}" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="{{asset('my-assets/bootstrap/js/bootstrap.js')}}"></script>

        <link href="{{asset('my-assets/fontawesome-pro/css/light.min.css')}}" rel="stylesheet">
<script src="{{asset('my-assets/fontawesome-pro/js/all.js')}}"></script>

		<link rel="stylesheet" type="text/css" href="{{asset('my-assets/plugins/bootstrap-yearcalendar/css/jquery.bootstrap.year.calendar.css')}}">

		<link href='{{asset('my-assets/plugins/fullcalendar-4.4.0/packages/core/main.css')}}' rel='stylesheet' />
		<link href='{{asset('my-assets/plugins/fullcalendar-4.4.0/packages/timegrid/main.css')}}' rel='stylesheet' />
		<link href='{{asset('my-assets/plugins/fullcalendar-4.4.0/packages/daygrid/main.css')}}' rel='stylesheet' />
		<link href='{{asset('my-assets/plugins/fullcalendar-4.4.0/packages/list/main.css')}}' rel='stylesheet' />



		<script type="text/javascript" src="{{asset('my-assets/plugins/bootstrap-yearcalendar/js/jquery.bootstrap.year.calendar.js')}}"></script>

    	<script src='{{asset('my-assets/plugins/fullcalendar-4.4.0/packages/core/main.js')}}'></script>
		<script src='{{asset('my-assets/plugins/fullcalendar-4.4.0/packages/interaction/main.js')}}'></script>
		<script src='{{asset('my-assets/plugins/fullcalendar-4.4.0/packages/daygrid/main.js')}}'></script>
		<script src='{{asset('my-assets/plugins/fullcalendar-4.4.0/packages/timegrid/main.js')}}'></script>
		<script src='{{asset('my-assets/plugins/fullcalendar-4.4.0/packages/list/main.js')}}'></script>

		<style>
            body {
				/*background: -webkit-linear-gradient(right, #f1f1f1 50%, #3374b5 50%);*/
                margin:10px;
                background-color: #f4f5f2;
			}
			@font-face{
		 		font-family: "Lato-Regular";
  				src: url("../fonts/Lato-Medium.ttf") format("truetype");
		 	}

		 	@font-face{
		 		font-family: "Lato-Bold";
  				src: url("../fonts/Lato-Bold.ttf") format("truetype");
		 	}

		 	@font-face{
			 	font-family: "HelveticaNeue-Light";
	  			src: url("../fonts/HelveticaNeue-Light.ttf") format("truetype");
	  		}

            @font-face{
			 	font-family: "HelveticaNeue-Regular";
	  			src: url("../fonts/HelveticaNeue-Regular.ttf") format("truetype");
	  		}

	  		@font-face{
			 	font-family: "HelveticaNeue-Bold";
	  			src: url("../fonts/HelveticaNeue-Bold.ttf") format("truetype");
	  		}


	  		@font-face{
			 	font-family: "Avenir-Book";
	  			src: url("../fonts/Avenir-Book.ttf") format("truetype");
	  		}

	  		@font-face{
			 	font-family: "Avenir-Black";
	  			src: url("../fonts/Avenir-Black.ttf") format("truetype");
	  		}



			.form-title{
				text-align: left;
			    font-family: 'Lato-Bold';
			    letter-spacing: normal;
			    font-size: 1.875rem;
			    color: #484848;
			    font-weight: bold;
			    line-height: 1;
			}

			.form-subtitle{
				text-align: left;
				font-family: 'Avenir-Black';
				letter-spacing: normal;
				font-size: 1rem;
				color: #5C5C5C;
				font-weight: normal;
				line-height: 1;
			}

			.btnSubstyle{
			    font-family: 'HelveticaNeue-Bold';
			    font-size: 0.6875rem;
			    color: #fff;
			    line-height: 1;
			    letter-spacing: normal;
			    background-color: #484848;
			    border-color: #484848;
			    text-transform: uppercase;
			    opacity: 1;
			}

			.btnSubstyle:hover{
			   	background-color: #B3B3B2;
			  	opacity: 1;
			  	border-color: #B3B3B2;
			}

			.btnSubstyle:focus {
    			outline: 0 !important;
    			box-shadow: none !important;
			}

			button:disabled,
			button[disabled]{
			  background-color: #B3B3B2;
			  opacity: 1;
			  border-color: #B3B3B2;
			}

			.side-container {
			    min-height: 100vh;
			    background-color: #3374B5;
			    padding: 0;
			}

			#gradmodal {
		  		background-image: linear-gradient(to bottom, rgba(240, 243, 245, 1), rgba(255, 255, 255,1));
		  		border: none;
		  		box-shadow: 0.1rem 0.1rem 1rem rgba(0,0,0,.6)!important;
		  		border-radius: 20px;
			}

			.footerdescmodal{
				font-family: 'Lato-Medium';
			    line-height: 0.7;
			    letter-spacing: normal;
			    font-weight: 800;
			    font-size: 0.75rem;
			    color: #929292;
		    	margin: 15px;
			}

			.iconimg{
				margin-top: auto;
				opacity: 0.7;
			}

			.iconimg:hover{
				opacity: 1;
				cursor: pointer;
			}

			textarea {
				resize: none;
			}

			.loading {
			    background: white;
			    z-index: 100000;
			    height: 100%;
			    width: 100%;
			    position: fixed;
			    opacity: 70%;
			}

			.list-group-item {
			  cursor: move;
			  cursor: -webkit-grabbing;
			}

			@media (min-width: 1200px){

				.container-custom {
					max-width: 100%;
    				margin-right: 2%;
    				margin-left: 0px;
				}
			}

			@media (min-width: 1000px){

				.contentdiv{
					padding-left: 50px;
	    			padding-right: 50px;
	    			padding-top: 50px;
	    			padding-bottom: 50px;
				}
			}

			/* START SweetAlert css */

			.swal-footer {
			  text-align: center;
			}

			/* END */

		</style>

        <style>
            #calendarmonth {
                width: 100%;
                background-color: #FFFFFF;
                padding:10px;
                /*border: 1px solid #8D8A84;
                border-radius: 15px;
                box-shadow: 0 2px 2px 0 rgba(0,0,0,.14), 0 3px 1px -2px rgba(0,0,0,.2), 0 1px 5px 0 rgba(0,0,0,.12);*/
            }

            .fc-button-group{
                font-family: 'Lato-Medium';
                font-size: 0.8125rem;
                color: #fff;
                letter-spacing: normal;
                opacity: 1;
            }

            .fc-today-button{
                font-family: 'Lato-Medium';
                font-size: 0.8125rem;
                color: #fff;
                letter-spacing: normal;
                opacity: 1;
            }

            .fc-time{
                font-family: 'Carlito-Bold';
                font-size: 0.8125rem;
                color: #ffffff;
                letter-spacing: normal;
                font-weight: 700;
            }
            .fc-title{
                font-family: 'Lato-Medium';
                font-size: 0.8125rem;
                letter-spacing: normal;
                color: #ffffff;
            }

            .fc-day-header{
                font-family: 'Lato-Medium';
                font-weight: 900;
                letter-spacing: normal;
                font-size: 0.875rem;
                color: #000000;
            }

            .fc-center{
                font-family: 'Lato-Bold';
                font-weight: 700;
                letter-spacing: normal;
                font-size: 0.9375rem;
                color: #000000;
            }

            .fc-day-number{
                text-decoration: none !important;
                font-family: 'Lato-Medium' !important;
                font-weight: 700 !important;
                color: #000000 !important;
            }
            .fc-day-number:hover{
                color: #1715af !important;
                font-family: 'Lato-Bold' !important;
            }

            .fc-day.fc-widget-content:hover{

                background-color: #dae7f5 !important;
                cursor:pointer !important;
            }

            .fc-not-start, .fc-not-end{

                background-color:orange !important;
                border:1px solid orange !important;

            }
            .spectitle {
                font-family: helvetica-bold;
                font-size:24px;
                letter-spacing: -1px;
                margin-bottom:20px;
                background-color:transparent;
                margin-top:20px;
                margin-left:10px;
            }
        </style>

	</head>
	<body class="container-custom">
		<!-- <div class="loading d-flex justify-content-center align-items-center">
			<img src="appsets/global/img/delivery_rider_2.gif">
		</div> -->
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                <div class="spectitle">Jadual Temujanji</div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 pt-3" style="padding-right:20px">
                <div class="dropdown float-end">
                    <span class="btn cux-btn bigger dropdown-toggle" type="button" id="mode_listing" data-bs-toggle="dropdown" aria-expanded="false"><i class="fal fa-people-carry"></i> Semua Kumpulan</span>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="mode_listing">
                    <li><a class="dropdown-item" onclick="parent.openPgInFrame('')">F1</a></li>
                    <li><a class="dropdown-item" onclick="parent.openPgInFrame('')">F2</a></li>
                    <li><a class="dropdown-item" onclick="parent.openPgInFrame('')">F3</a></li>
                    <li><a class="dropdown-item" onclick="parent.openPgInFrame('')">TM1 LV-HM</a></li>
                    <li><a class="dropdown-item" onclick="parent.openPgInFrame('')">TM2 LV-LM</a></li>
                    <li><a class="dropdown-item" onclick="parent.openPgInFrame('')">TM2 EMP</a></li>
                    </ul>
                </div>
            </div>
        </div>
		<div class="row m-0" id="body-row">
			<!-- Sidebar -->
			<div class='col-12'>
				<div id='calendarmonth'></div>
			</div>
		</div>

  		<script>

            $(document).ready(function () {
	  			var calendarEl = document.getElementById('calendarmonth');

				var eventsArray = [];
				console.log(eventsArray);
				@php

                    foreach ($listAppoinments as $appoinment){
                        $refnumber = $appoinment->refnumber;
						$aptdate = $appoinment->appointmentdate;
                @endphp
					eventsArray.push({ title: '{{ $refnumber }}', start: '{{ $aptdate }}' });
				@php
                    }
                @endphp



	  		    var calendar = new FullCalendar.Calendar(calendarEl, {
	  		    	plugins: [ 'interaction', 'dayGrid' ],
	  		        header: {
	  		          left: 'prevYear,prev,next,nextYear today',
	  		          center: 'title',
	  		          right: 'dayGridMonth,dayGridWeek,dayGridDay'
	  		        },
	  		        defaultDate: new Date({{$selectedYear}},{{$selectedMonth-1}}),

	  		        navLinks: true, // can click day/week names to navigate views
	  		        editable: true,
	  		        eventLimit: true, // allow "more" link when too many events
                    events: eventsArray,

	  		    });

	  		    calendar.render();
	  		});


  		</script>

	</body>
</html>
