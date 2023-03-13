@php
    $lang = request('lang') ? request('lang') : 'bm';
@endphp
<div class="whole">
    <div class="cloud-top">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-xs-6 col-6" style="position: relative;">
                    <div class="spakat-header">
                        <img src="{{ asset('my-assets/img/spakat-small-min.png')}}" class="d-inline d-sm-inline-flex"/>
                    </div>
                    <div class="jkr-float"><img src="{{ asset('my-assets/img/logo.png')}}"/></div>
                    <div class="triangle-float"><img src="{{ asset('my-assets/img/triangle-min.png')}}" class="img-fluid"/></div>
                    <div class="spakat-fullname">Sistem Aplikasi Pengurusan Kenderaan Atas Talian</div>
                </div>
                <div class="col-xl-6 col-lg-6 col-xs-6 col-6 d-none d-sm-block home-menu">
                    <div class="row">
                        <div class="col-md-12">
                            {{-- <div wire:ignore class="float-end ps-2 mb-0 mt-0">
                                <div class="select2-small">
                                    <select class="selectpicker flag-list">
                                        <option {{$lang == 'en' ? 'selected': ''}} value="en">English</option>
                                        <option {{$lang == 'my' ? 'selected': ''}}  value="my">Melayu</option>
                                    </select>
                                </div>
                            </div> --}}
                            <a class="btn btn-blank" href="/"><img width="25px" height="25px" src="{{ asset('my-assets/img/home-grey.svg')}}"/></a>
                            <a class="btn btn-login" href="{{route('login')}}">{{$lblLogin}}</a>
                            <p>&nbsp;</p>
                            <a href="?lang=en" id="lingo-txt">Bahasa Inggeris</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-xs-12 col-12" style="position: relative;">
            <div class="back-content p-0">
                <div class="container pt-3">
                    <div class="top-title">{{$ttlDaftar}}</div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                          <li class="breadcrumb-item"><a href="/"><img src="{{ asset('my-assets/img/home-grey.svg')}}"/></a></li>
                          <li class="breadcrumb-item active" aria-current="page">{{$ttlDaftar}}</li>
                        </ol>
                    </nav>
                    <hr/>
                    <form wire:submit.prevent="save" class="row mt-3">
                        <div id="base-form">
                            <div class="row">
                                <div class="col-xl-4 col-lg-6 col-md-8 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label for="ttl_196">{{$lblFullName}} <em class="text-danger">*</em></label>
                                        <input
                                            wire:model="name"
                                            type="text" class="form-control" name="fullname"
                                            autocomplete="off"
                                            id="fullname"
                                            value=""
                                            onkeyup="changeToUpperCase(this)"
                                            placeholder="">
                                            @error('name') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="ttl_196">{{$lblIdentityNo}} <em class="text-danger">*</em></label>
                                        <input
                                            wire:model="identityNo"
                                            type="text" class="form-control" name="identityNo"
                                            autocomplete="off"
                                            id="icno"
                                            value=""
                                            maxlength="14"
                                            placeholder="XXXXXXXXXXXX">
                                            @error('identityNo') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="ttl_196">{{$lblEmail}} <em class="text-danger">*</em></label>
                                        <input wire:model="email"
                                            type="text" class="form-control" name="email"
                                            autocomplete="off"
                                            onchange="setEmail(this.value)"
                                            id="email"
                                            value=""
                                            placeholder="">
                                            @error('email') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="ttl_196">{{$lblMobile}}<em class="text-danger">*</em></label>
                                        <input
                                            wire:model="phone"
                                            type="text" class="form-control" name="mobile"
                                            autocomplete="off"
                                            id="mobile"
                                            value=""
                                            placeholder="">
                                            @error('phone') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="ttl_196">{{$lblOffice}}</label>
                                        <input
                                            wire:model="office"
                                            type="text" class="form-control" name="office"
                                            autocomplete="off"
                                            id="office"
                                            value=""
                                            placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12 form-group">
                                    <label class="form-label">{{$lblRegisterPurpose}} <em class="text-danger">*</em> <i class="fa fa-info-circle"></i></label>
                                    <div class="form-check form-check-inline mr-2">
                                        <input wire:change="registerPurposeChanged()" class="form-check-input" type="radio" wire:model="registerPurpose" name="registerPurpose" id="is_jkr" value="is_jkr">
                                        <label class="form-check-label cursor-pointer" for="is_jkr">{{$lblJKR}}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input wire:change="registerPurposeChanged()" class="form-check-input" type="radio" wire:model="registerPurpose" name="registerPurpose" id="is_gover_agency" value="is_gover_agency">
                                        <label class="form-check-label cursor-pointer" for="is_gover_agency">{{$lblGoverAgency}}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input wire:change="registerPurposeChanged()" class="form-check-input" type="radio" wire:model="registerPurpose" name="registerPurpose" id="is_contractor" value="is_contractor">
                                        <label class="form-check-label cursor-pointer" for="is_contractor">{{$lblContractor}}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input wire:change="registerPurposeChanged()" class="form-check-input" type="radio" wire:model="registerPurpose" name="registerPurpose" id="is_public" value="is_public">
                                        <label class="form-check-label cursor-pointer" for="is_public">{{$lblPublic}}</label>
                                    </div>
                                </div>
                                @error('registerPurpose') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        @if ($registerPurpose == 'is_jkr' || $registerPurpose == 'is_gover_agency')
                        <div id="sect-govt">

                            @if ($registerPurpose == 'is_jkr' || $registerPurpose == 'is_gover_agency')
                                <div class="row">
                                    <div class="col-xl-4 col-lg-6 col-md-8 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label for="ttl_196">{{$lblDesignation}} <em class="text-danger">*</em></label>
                                            <input
                                                wire:ignore
                                                type="text" class="form-control" name="designation"
                                                autocomplete="off"
                                                id="designation"
                                                value=""
                                                placeholder="">
                                                @error('designation') <span class="error text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>

                                @if ($registerPurpose == 'is_jkr')
                                    <div class="row">
                                        <div class="col-sm-12 col-12 form-group">
                                            <label class="form-label">{{$lblOwnership}} <em class="text-danger">*</em></label>

                                            @foreach ($owner_type_list as $owner_type)
                                                <div class="form-check form-check-inline mr-2">
                                                    <input wire:change="ownershipChanged()" class="form-check-input" type="radio" wire:model="owner_type_id" name="owner_type_id" id="is_ownership_{{$owner_type->code}}" value="{{$owner_type->id}}">
                                                    <label class="form-check-label cursor-pointer" for="is_ownership_{{$owner_type->code}}">{{$owner_type['desc_'.$lang]}}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                        @error('owner_type_id') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                @endif

                            @endif

                            @if ($registerPurpose == 'is_jkr')
                            <div class="row">
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 form-group">
                                    <label class="form-label">{{$lblBranch}} <em class="text-danger">*</em></label>
                                    <div>
                                        <select data-livewire="@this" class="form-select branch_id" id="branch_id" name="branch_id" data-placeholder="[Sila pilih]">
                                            @if($owner_type_id)
                                                <option value="">Pilih</option>
                                                @foreach ($owner_branch_list as $owner_branch )
                                                    <option value="{{$owner_branch->id}}" {{$branch_id == $owner_branch->id ? 'selected': ''}}>{{$owner_branch->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    @error('branch_id') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            @endif

                            @if ($registerPurpose == 'is_gover_agency')
                                <div class="row">
                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 form-group">
                                        <label class="form-label">{{$lblAgency}} <em class="text-danger">*</em></label>
                                        <div>
                                            <select data-livewire="@this" class="form-select division_id" id="agency_id" wire:model="agency_id" name="agency_id" data-placeholder="[Sila pilih]">
                                                <option value="">Pilih</option>
                                                @foreach ($agency_list as $agency )
                                                    <option value="{{$agency->id}}" {{$agency_id == $agency->id ? 'selected' : ''}}>{{$agency->desc}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('agency_id') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            @endif

                            @if ($registerPurpose == 'is_jkr' || $registerPurpose == 'is_gover_agency')
                                <div class="row">
                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 form-group">
                                        <label class="form-label">{{$lblDivision}}</label>

                                        @if($registerPurpose == 'is_jkr')
                                        <input
                                        wire:ignore
                                        type="text" id="division_desc" class="form-control" name="division_desc"
                                        autocomplete="off"
                                        id="division_desc"
                                        value=""
                                        placeholder="">
                                        @error('division_desc') <span class="error text-danger">{{ $message }}</span> @enderror
                                        @endif

                                        @if($registerPurpose == 'is_gover_agency')
                                            <input
                                            wire:ignore
                                            type="text" id="division_desc" class="form-control" name="division_desc"
                                            autocomplete="off"
                                            id="division_desc"
                                            value=""
                                            placeholder="">
                                            @error('division_desc') <span class="error text-danger">{{ $message }}</span> @enderror
                                        @endif
                                    </div>
                                </div>
                            @endif

                        </div>
                        @else
                        @if ($registerPurpose == 'is_contractor')
                        <div id="sect-contractor">
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 form-group">
                                    <label class="form-label">{{$lblCompName}} <em class="text-danger">*</em></label>
                                    <input wire:model="companyName" type="text" autocomplete="off" class="form-control" id="companyname" name="companyname" value="" placeholder="cth. Syarikat Maju Jaya Sdn Bhd">
                                    @error('companyName') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12 form-group">
                                    <label class="form-label">{{$lblSSM}} <em class="text-danger">*</em></label>
                                    <input wire:model="ssm_no" type="text" autocomplete="off" class="form-control" id="rocno" name="rocno" value="" placeholder="cth. 1111111-X">
                                    @error('ssm_no') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 form-group">
                                    <label class="form-label">{{$lblProject}} <em class="text-danger">*</em></label>
                                    <input wire:model="latest_project_name" type="text" autocomplete="off" class="form-control" id="latest_project_name" name="latest_project_name" value="" placeholder="cth. Pembinaan 3 Blok Sekolah">
                                    @error('latest_project_name') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 form-group">
                                    <label class="form-label">{{$lblGovern}} <em class="text-danger">*</em></label>
                                    <div wire:ignore>
                                        <select wire:model="companyKem" class="form-select company_kem" id="company_kem" name="company_kem" data-placeholder="[Sila pilih]">
                                            <option value="">Pilih</option>
                                            @foreach ($ministryLists as $list )
                                                <option value="{{$list->id}}">{{$list->desc}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('companyKem') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <script>
                                $('#company_kem').select2({
                                    width : '100%',
                                    theme : "classic"
                                }).on('change', function (e) {
                                    @this.set('companyKem', $(this).val());
                                });
                            </script>
                        </div>
                        @endif
                        @endif
                        <div class="row">
                            <div class="col-xl-6"><hr/></div>
                        </div>

                        <div class="form-group col-md-12">
                            @if($err)
                                <div class="text-danger">{{$response}}</div>
                            @endif
                        </div>
                        <div class="form-group col-md-2" id="captcha_container">
                            <div>
                                <img wire:ignore id="reload_captcha" src="{{captcha_src('capcha')}}">
                                <span class="cursor-pointer" onclick="reloadCaptcha()">&nbsp;reload</span>
                            </div>
                            <input wire:ignore type="text" autocomplete="off" class="form-control mt-2" id="captcha_code" name="code" value="">
                            @error('code') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group center">
                            <button type="submit" class="btn btn-module">{{$lblDaftar}}</button>
                            <button type="reset" class="btn btn-reset">{{$lblReset}}</button>
                        </div>
                        <p>&nbsp;</p>
                    </form>

                    <div wire:loading.flex class="justify-content-center mt-2 mb-2" wire:target="save">
                        <span class="text-success">Sila Tunggu ... </span>
                    </div>
                </div>
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
<!--
<div class="btnJumpTop" onclick="scrollToTop()">
    <i class="fal fa-arrow-up fa-lg" style="color:#ffffff !important;"></i>
</div>
<div class="mycookies">
    <div class="container">This website uses cookies to improve your experience. We'll assume you're ok with this, but you can opt-out if you wish. <a href="" style="font-size:14px;color:#ffffff">Read more</a><button type="button" class="btn btn-light btn-sm" onClick="acceptCookie();">Accept</button></div>
</div>-->
<script type="text/javascript">

    // function updateFormat(model, self){
    //     var key = event.keyCode || event.charCode;
    //     console.log('key' , key);
    //     if(model == 'identityNo'){
    //         let x = $('#icno').val();

    //         if(key == 8){
    //             $('#icno').val(x);
    //         } else {
    //             if(x.length !== 7 || x.length !== 9){
    //                 x = x.replace(/[^\w\s]/gi, "");
    //             }

    //             if(x.length >= 6 && key !== 8){
    //                 x = x.substring(0, 6) + "-" + x.substring(6, x.length);
    //             }

    //             if(x.length >= 9 && key !== 8){
    //                 x = x.substring(0, 9) + "-" + x.substring(9, x.length);
    //             }
    //             $('#icno').val(x);
    //         }

    //     }
    // }

    function setEmail(email){
        console.log('emai', email);
        @this.set('email', email);
    }

    window.livewire.on('registerPurposeChanged', registerPurpose => {

        console.log('registerPurpose ', registerPurpose);

        $('#designation').on('change', function(e){
            e.preventDefault();
            console.log('designation ', $(this).val());
            @this.set('designation', $(this).val());
            @this.initSelect2();
        });

        $('#division_desc').on('change', function(e){
            e.preventDefault();
            console.log('division_desc ', $(this).val());
            @this.set('division_desc', $(this).val());
            @this.initSelect2();
        });

        $('#agency_id').select2({
            width : '100%',
            theme : "classic"
        }).on('change', function (e) {
            @this.set('agency_id', $(this).val());
            @this.initSelect2();
        });
        $('#branch_id').select2({
            width : '100%',
            theme : "classic"
        }).on('change', function (e) {
            @this.set('branch_id', $(this).val());
            @this.getDivision();
        });
        $('#division_id').select2({
            width : '100%',
            theme : "classic"
        }).on('change', function (e) {
            @this.set('division_id', $(this).val());
            @this.getUnit();
        });
        $('#unit_id').select2({
            width : '100%',
            theme : "classic"
        }).on('change', function (e) {
            @this.set('unit_id', $(this).val());
            @this.getUnitSub();
        });
        $('#unit_sub_id').select2({
            width : '100%',
            theme : "classic"
        }).on('change', function (e) {
            @this.set('unit_sub_id', $(this).val());
            @this.initSelect2();
        });

        $('#captcha_code').on('change', function(e){
            e.preventDefault();
            @this.set('code', $(this).val());
        });
    });

    window.livewire.on('ownershipChanged', ownership => {

    console.log('ownership ', ownership);

        $('#agency_id').select2({
            width : '100%',
            theme : "classic"
        }).on('change', function (e) {
            @this.set('agency_id', $(this).val());
            @this.getBranch();
        });

        $('#branch_id').select2({
            width : '100%',
            theme : "classic"
        }).on('change', function (e) {
            @this.set('branch_id', $(this).val());
            @this.getDivision();
        });

        $('#division_id').select2({
            width : '100%',
            theme : "classic"
        }).on('change', function (e) {
            @this.set('division_id', $(this).val());
        });

    });

    window.livewire.on('initSelect2', data => {
        $('select').select2({
            width : '100%',
            theme : "classic"
        });
    });

    window.livewire.on('captchaIsValid', data => {
        $('#captcha_container').html('valid');
    });

    window.livewire.on('reloadCaptcha', data => {
        $('#reload_captcha').attr('src', "{{captcha_src('capcha')}}")
    });

    reloadCaptcha = function(){
        return $.get("{{route('reload.captcha')}}", function(res){
            $('#reload_captcha').attr('src', res);
        })
    }

    changeToUpperCase = function(self){
        self.value = self.value.toLocaleUpperCase();
    }

</script>
