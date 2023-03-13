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

@endphp
<div>
    <style type="text/css">
        @media (max-width: 575.98px) {
            .form-group {
                width:100%;
                padding-left:0px;
                padding-right:0px;
            }
            .form-control {
                width:100%;
            }
        }
    </style>
    <div class="login-box">
        <p>
        @if(!empty(request('message')))
            <div class="text-center text-success">{{request('message')}}</div>
        @endif
        </p>
        <div class="top-title pb-2">{{$lblLogin}}</div>
        @if ($err)
            <div  class="alert alert-danger">
                {{$response}}
            </div>
        @endif
        <!--method="post"-->
        <form method="post" wire:submit.prevent="signin" id="frm_sso_login">
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-md-10 col-sm-10 col-12">
                    <div class="form-group">
                    <label for="ttl_196">{{$lblUsername}} <em>*</em></label>
                        <!-- <input
                            type="text" class="form-control" name="userid"
                            id="userid" required value="" placeholder=""> -->
                            <input type="text" wire:model="username" class="form-control" style="width:100%" autocapitalize="none" autocorrect="off">
                            @error('username')
                                <span class="error text-danger">{{$message}}</span>
                            @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-md-10 col-sm-10 col-12">
                    <div class="form-group">
                        <label for="ttl_196">{{$lblPassword}} <em>*</em></label>
                        <!-- <input
                            type="password" class="form-control" name="password"
                            id="password" required
                            value=""
                            placeholder=""> -->
                            <input type="password" wire:model="password" class="form-control">
                            @error('password')
                                <span class="error text-danger">{{$message}}</span>
                            @enderror
                    </div>
                </div>
            </div>
            <div class="form-group center">
                <button type="submit" class="btn btn-module">{{$lblBtnLogin}}</button>
                <button type="reset" class="btn btn-reset">{{$lblBtnReset}}</button>
            </div>
            <hr/>
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"><a href="{{route('register')}}" class="btn-supplement float-start">{{$lblBtnNewUser}}</a>
                <a href="{{route('forgot')}}" class="btn-supplement float-end">{{$lblBtnForgotPass}}</a>
            </div>
        </form>
    </div>

</div>
