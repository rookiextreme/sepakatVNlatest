<link rel="shortcut icon" href="{{asset('my-assets/favicon/favicon.png')}}">

<!--JQuery version that is being used across the apps-->
{{-- <script src="my-assets/jquery/jquery-3.4.1.min.js"></script> --}}

<!--importing bootstrap-->
<link rel="stylesheet" href="{{ asset('css/app.css')}}">

<!--Universal Cubixi styling including Admin, ESS, Mobile and Public.-->
<link href="{{asset('my-assets/css/cubixi.css')}}" rel="stylesheet" type="text/css">

<link href="{{asset('css/public.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css/dashboard.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css/side-menu.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css/header.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css/footer.css')}}" rel="stylesheet" type="text/css">

<!--importing bootstrap-->
<link href="{{asset('my-assets/bootstrap/css/bootstrap.css')}}" rel="stylesheet" type="text/css" />

<link href="{{asset('my-assets/fontawesome-pro/css/light.min.css')}}" rel="stylesheet">
<script src="{{asset('my-assets/fontawesome-pro/js/all.js')}}"></script>

<link href="{{asset('my-assets/plugins/select2/dist/css/select2.css')}}" rel="stylesheet" />
<script type="text/javascript" src="{{asset('my-assets/jquery/jquery-3.6.0.min.js')}}"></script>
<script type="text/javascript" src="{{asset('my-assets/bootstrap/js/bootstrap.min.js')}}"></script>

<link href="{{asset('my-assets/css/forms.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('my-assets/css/admin-menu.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('my-assets/css/admin-list.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('my-assets/css/manager.css')}}" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="{{asset('my-assets/plugins/datepicker/css/bootstrap-datepicker.css')}}">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">

<script src="{{asset('my-assets/spakat/spakat.js')}}" type="text/javascript"></script>

<script src="{{asset('my-assets/plugins/select2/dist/js/select2.js')}}"></script>
<!--Importing Icons-->
<script src="{{ asset('js/app.js') }}" defer></script>
<script type="text/javascript">

	jQuery(document).ready(function() {
        initTab();

		window.livewire.on('goToPage', () => {
            initTab();
        });

        // $('select').select2({
		// 	width: '60px',
		// 	theme: "classic",
		// 	minimumResultsForSearch: -1
        // });
    });

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
	function openPgInFrame(clink) {
		createCookie('comAppsLink', clink, 1);
		window.open(clink, "pg-apps");
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
</script>
<style type="text/css">
	body {
		background-color:#6f6c65;
	}
	.sleft-menu ul li a {
		color:#b5b4b4;
	}
	.sleft-menu ul li ul li a {
		color:#bcbbbb;
	}
	.subside {
		display: none;
	}
	@media (max-width: 991.98px) {
	}
</style>
@livewireStyles
