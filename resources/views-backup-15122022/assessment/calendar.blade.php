<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		<title>Jadual Temujanji Woksyop</title>
        <link href="{{asset('my-assets/css/cubixi.css')}}" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="{{asset('my-assets/jquery/jquery-3.6.0.min.js')}}"></script>
		<link href="{{asset('my-assets/bootstrap/css/bootstrap.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('my-assets/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('my-assets/bootstrap/css/bootstrap-grid.min.css')}}" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="{{asset('my-assets/bootstrap/js/bootstrap.js')}}"></script>
        <link href="{{asset('my-assets/css/manager.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('my-assets/fontawesome-pro/css/light.min.css')}}" rel="stylesheet">
<script src="{{asset('my-assets/fontawesome-pro/js/all.js')}}"></script>
		<link rel="stylesheet" type="text/css" href="{{asset('my-assets/plugins/bootstrap-yearcalendar/css/jquery.bootstrap.year.calendar.css')}}">
        <script type="text/javascript" src="{{asset('my-assets/bootstrap/js/popper.min.js')}}"></script>

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
        <script src="{{ asset('my-assets/spakat/spakat.js') }}" type="text/javascript"></script>

		<style>
            @font-face {
                font-family: "lato-bold";
                src: url("../fonts/Lato-Bold.ttf") format("opentype");
            }
			body {
				/*background: -webkit-linear-gradient(right, #f1f1f1 50%, #3374b5 50%);*/
                background-color: #f4f5f2;
                padding-left:30px;
			}
            .mytitle {
                font-family: lato-bold;
                font-size:24px;
                color:#303030;
                letter-spacing:0px;
                letter-spacing: -1px;
                font-size: 24px;
                line-height: 26px;
                margin-top:30px;
            }
            .mytitle span {
                letter-spacing: 0px;
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
            .dropdown-item {
                font-family: mark;
                font-size:14px;
            }
            .dropdown-item i.fa {
                min-width:40px !important;
                text-align:left;
            }
            .dropdown-header {
                font-family: mark-bold;
                text-transform: uppercase;
                font-size:12px;
                color:#6d7466;
            }
            .dropdown-menu {
                -webkit-box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.23);
                -moz-box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.23);
                box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.23);
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
	#calendaryear{
		width: 100%;
		background-color: transparent;
		padding: 0 10px !important;
		/*border: 1px solid #8D8A84;
		border-radius: 15px;
		box-shadow: 0 2px 2px 0 rgba(0,0,0,.14), 0 3px 1px -2px rgba(0,0,0,.2), 0 1px 5px 0 rgba(0,0,0,.12);*/
	}

	.jqyc-header{
        font-family: helvetica-bold;
        font-size:24px;
		font-weight: 900;
		letter-spacing: normal;
		font-size: 1rem;
		color: #000000;
		padding: 5px
	}

	.jqyc-header:hover{
		cursor: pointer;
		background-color: #FFA500;
		color: #000000;
		border-radius: 5px;
		padding: 5px;

	}

	.jqyc-year-chooser{
		margin: auto !important;
	}

	.jqyc-year-chooser .btn{
		background-color: #484848;
		border-color: #FFFFFF;
	}

	.jqyc-range-choosen-between{
		border-radius: 0px !important;
		opacity: 0.7;
	}

	.jqyc-table{
		font-family: 'Lato-Medium';
		font-size: 0.875rem;
		letter-spacing: normal;
		font-weight: normal;
		color: #5C5C5C;
	}

	.jqyc-th{
		font-family: 'Lato-Medium';
	    font-weight: 900;
	    letter-spacing: normal;
	    font-size: 0.875rem;
	    color: #000000;
	}

    .grey-date{
		background-color:grey !important;
		color:white;
		border-radius:5px;

	}

	.orange-date{
		background-color:orange !important;
		color:white;
		border-radius:5px;
	}

	.date-tooltip{

		color: white;
	    padding: 10px;
	    position:absolute;
	    background-color:black;
	    border:2px solid #5C5C5C;
	    top:auto;
	    left: auto;
	    border-radius: 5px;
	    padding-left: 20px;
	    padding-right: 20px;
	    text-align: center;
	    opacity: 0.7;
	    display:none;
	}

	/* .date-tooltip:hover{
		display:block;background-color: red;
	}
	 */
	.has-tooltip:hover .date-tooltip{
		display:block;
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
    <!--class="container-custom"-->
	<body>
		<div class="mytitle">Jadual Temujanji <span>Penilaian</span></div>

		<div class="row m-0" id="body-row">
			<!-- Sidebar -->
			<div class='col-12'>
				<div class="row rowcard pb-5 pt-3" id="calendaryear"></div>
			</div>
		</div>

  		<script>

	  		$(document).ready(function () {
				/* hideLoaderGif(); */
	  			var currentYear = new Date().getFullYear();

	  		    $('#calendaryear').calendar({


                });

	  			$('#calendaryear').calendar('addRange', 2020, 4, 4, 2020, 4, 20);

	  		// for current year
	  			$('.jqyc-header').click(function(e){
					var selectedMonth = $(this).parent().attr('data-month');
					var selectedYear = $(this).attr('data-year');
					location.href = "{{ route('assessment.calendarmonth')}}?selectedMonth="+selectedMonth+"&selectedYear="+selectedYear;
	  			});

	  			$('.jqyc-td').click(function(e){
					var selectedMonth = $(this).attr('data-month');
					var selectedYear = $(this).attr('data-year');
					location.href = "{{ route('assessment.calendarmonth')}}?selectedMonth="+selectedMonth+"&selectedYear="+selectedYear;
	  			});
	  			// for change year
	  			$('#calendaryear').on('jqyc.changeYear', function (event) {

                    @php
                        foreach ($listAppoinments as $appoinment){

                                $theyear = date('Y', strtotime($appoinment->appointmentdate));
                                $themonth = date('n', strtotime($appoinment->appointmentdate));
                                $theday = date('d', strtotime($appoinment->appointmentdate));

                    @endphp

                    //alert('{{$theday}}-{{$themonth}}-{{$theyear}}');
                    $('.jqyc-day-{{$theday}}.jqyc-day-of-{{$themonth}}-month[data-year="{{$theyear}}"]').append("<div class='date-tooltip' style=''>PENYENGGARAAN<br/>WA1304A </div>")
                    $('.jqyc-day-{{$theday}}.jqyc-day-of-{{$themonth}}-month[data-year="{{$theyear}}"]').addClass("has-tooltip orange-date");

                    @php

                        }
                    @endphp


	  				$('.jqyc-header').click(function(e){
						var selectedMonth = $(this).attr('data-month');
						var selectedYear = $(this).attr('data-year');
						location.href = "{{ route('assessment.calendarmonth')}}?selectedMonth="+selectedMonth+"&selectedYear="+selectedYear;
	  				});

					$('.jqyc-td').click(function(e){
						var selectedMonth = $(this).attr('data-month');
						var selectedYear = $(this).attr('data-year');
						location.href = "{{ route('assessment.calendarmonth')}}?selectedMonth="+selectedMonth+"&selectedYear="+selectedYear;
					});

	  				$('.jqyc-range-choosen-between').click(function(e){
	  					location.replace("calendarmonth");
	  				});
	  		    });



	  			$('.jqyc-day-10.jqyc-day-of-3-month').attr({
		  			"position":"relative",

		  		});

                  @php
                    foreach ($listAppoinments as $appoinment){

                        $theyear = date('Y', strtotime($appoinment->appointmentdate));
                        $themonth = date('n', strtotime($appoinment->appointmentdate));
                        $theday = date('d', strtotime($appoinment->appointmentdate));
                        $refnumber = $appoinment->refnumber;
                        $email = $appoinment->email;
                        $name = $appoinment->name;

                  @endphp

                   // alert('{{$theday}}-{{$themonth}}-{{$theyear}}');
                    $('.jqyc-day-{{$theday}}.jqyc-day-of-{{$themonth}}-month[data-year="{{$theyear}}"]').append("<div class='date-tooltip' style=''>REF : {{$refnumber}} <br/> {{$email}} <br/>Name : {{$name}} </div>")
                    $('.jqyc-day-{{$theday}}.jqyc-day-of-{{$themonth}}-month[data-year="{{$theyear}}"]').addClass("has-tooltip orange-date");

                  @php

                        }
                  @endphp


	  		});


  		</script>

	</body>
</html>
