@php
    use App\Http\Controllers\ApplicationDAO;

    $ApplicationDAO = new ApplicationDAO();
    $ApplicationDAO->mount();

    $lblForgotUsername = $ApplicationDAO->lblForgotUsername;
    $lblEmail = $ApplicationDAO->lblEmail;
    $lblSend = $ApplicationDAO->lblSend;

    $lblBtnReset = $ApplicationDAO->lblBtnReset;
    $lblRegister = $ApplicationDAO->lblRegister;
    $lblBtnForgotPass = $ApplicationDAO->lblBtnForgotPass;
    $lblOtherOptions = $ApplicationDAO->lblOtherOptions;

@endphp
<div>
	<div class="login-box">
        @if ($err)
            <div  class="alert alert-danger">
                {{$response}}
            </div>
        @endif
		<div class="top-title pb-2">{{$lblForgotUsername}}</div>
        <form wire:submit.prevent="send">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="ttl_196">{{$lblEmail}} <em>*</em></label> <input
                            wire:model="email"
                            type="text" class="form-control" name="email" autocomplete="off"
                            id="email" value="" placeholder="abc@email.com">
                            @error('email') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="form-group center">
                <button type="submit" class="btn btn-module">{{$lblSend}}</button>
                <button type="button" class="btn btn-reset" onClick="resetForm()">{{$lblBtnReset}}</button>
            </div>
        </form>
		<hr/>
		<div class="mini-title mt-5">{{$lblOtherOptions}}&nbsp;<i class="fal fa-caret-down"></i></div>
		<ul class="bunch-menu">
			<li class="row-menu"><a href="{{route('register')}}">{{$lblRegister}}</a></li>
            <li class="row-menu"><a href="{{route('forgot')}}">{{$lblBtnForgotPass}}</a></li>
		</ul>
	</div>

	<p>&nbsp;</p>
</div>
