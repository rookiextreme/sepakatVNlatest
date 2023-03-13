@php
    use App\Http\Controllers\ApplicationDAO;

    $ApplicationDAO = new ApplicationDAO();
    $ApplicationDAO->mount();

    $lblForgotPassword = $ApplicationDAO->lblForgotPassword;
    $lblEmail = $ApplicationDAO->lblEmail;
    $lblSend = $ApplicationDAO->lblSend;
    $lblForgotUsername = $ApplicationDAO->lblForgotUsername;
    $lblBtnNewUser = $ApplicationDAO->lblBtnNewUser;

@endphp
<div>
	<div class="login-box">
        @if ($err)
            <div  class="alert alert-danger">
                {{$response}}
            </div>
        @endif
		<div class="top-title pb-2">{{$lblForgotPassword}}</div>
        <form wire:submit.prevent="send">
            <div class="row">
                <div class="col-md-12">

                        <div class="form-group">
                            <label for="ttl_196">{{$lblEmail}}<em>*</em></label> <input
                                wire:model="email"
                                type="text" autocomplete="off" class="form-control" name="email"
                                id="email" value="" placeholder="abc@email.com">
                                @error('email') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>

                </div>
            </div>


            <div class="form-group center">
                <button type="submit" class="btn btn-module">{{$lblSend}}</button>
            </div>
        </form>
		<hr/>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"><a href="{{route('register')}}" class="btn-supplement float-start">{{$lblBtnNewUser}}</a>
            <a href="{{route('forgot.account')}}" class="btn-supplement float-end">{{$lblForgotUsername}}</a>
        </div>
	</div>

	<p>&nbsp;</p>
</div>
