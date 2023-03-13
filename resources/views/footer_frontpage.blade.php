@php
    use App\Http\Controllers\ApplicationDAO;

    $ApplicationDAO = new ApplicationDAO();
    $ApplicationDAO->mount();

    $lang = $ApplicationDAO->lang;

    $lblTerms = $ApplicationDAO->lblTerms;
    $lblCondition = $ApplicationDAO->lblCondition;

@endphp
<div class="container-fluid shade-morning">
        <div class="container" style="position: relative;">
            <div class="link">
                <div class="jumplink text-left"><a href="https://www.jkr.gov.my/" target="_blank"><img src="my-assets/img/jkr.svg" class="img-fluid"></a></div>
                <div class="jumplink"><a href="https://www.facebook.com/JKRWoksyopPersekutuanKL/" target="_blank"><img src="my-assets/img/facebook.svg" class="img-fluid"></a></div>
                <div class="jumplink"><a href="https://twitter.com/JKRWoksyop?s=20" target="_blank"><img src="my-assets/img/twitter.svg" class="img-fluid"></a></div>
            </div>
            <div class="lingo">
                <small>{{$lang == 'en' ? 'Change to ': 'Tukar ke '}}</small><a href="?lang={{$lang == 'bm' ? 'en' : 'bm'}}">{{$lang == 'en' ? 'Malay Language': 'Bahasa Inggeris'}}</a>
            </div>
            <div class="horz-big-separator" style="background-color:#dddfdb;"></div>
            <div class="row">
                <div class="col-xl-6 col-lg-9 col-md-8 col-sm-11 col-12 urusetia-box">
                    <div class="committee">
                        <div class="urusetiatxt">Urusetia</div>
                        <div class="urusetia"><img src="my-assets/img/spakat-small-min.png" class="mb-4"></div>
                        <span class="cawangan">Cawangan Kejuruteraan Mekanikal, </span>
                        <span class="cawangan">JKR Woksyop Persekutuan</span>
                        <div class="address">No 2, Jalan Arowana, 55300 Kuala Lumpur,</div><div class="address">Wilayah Persekutuan Kuala Lumpur</div>
                        <div class="combo-btn">
                            <div class="title"><i class="fal fa-envelope fa-lg"></i></div>
                            <div class="subject">spakat@jkr.gov.my</div>
                        </div>
                    </div>
                    <img src="my-assets/img/bottom-land-min.png" class="land-rover-left">
                </div>
                <div class="col-xl-6 col-lg-3 col-md-4 col-sm-1 col-0 p-0 land-rover-box">
                    <img src="my-assets/img/bottom-land-min.png" class="land-rover float-end">
                </div>
            </div>
        </div>
    </div>
	<div class="container-fluid sfooter">
		<div class="container">
			<div class="row">
				<div class="col-xl-6 col-lg-6 col-sm-6 col-md-6 col-12 signature">&copy; 2021 Jabatan Kerja Raya Malaysia</div>
				<div class="col-xl-6 col-lg-6 col-sm-6 col-md-6 term-box"><a href="" class="terms">{{$lblTerms}} &amp; {{$lblCondition}}</a></div>
			</div>
		</div>
	</div>
