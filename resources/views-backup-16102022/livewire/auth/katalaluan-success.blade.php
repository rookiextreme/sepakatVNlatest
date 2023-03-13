<div>
	<div class="login-box">
		<div class="top-title pb-2">Lupa Kata Laluan</div>
        <form wire:submit.prevent="requestEmailForgotPassword">
            <div class="row">
                <div class="col-md-12">

                        <div class="form-group">
                            <label for="ttl_196">Email <em>*</em></label> <input
                                type="text" class="form-control" name="email"
                                wire:model="email"
                                id="email" required value="email" placeholder="abc@email.com">
                                @error('email')
                                <span class="error text-danger">{{ $message ?? '' }}</span>
                                @enderror
                        </div>

                </div>
            </div>


            <div class="form-group center">
                <button type="submit" class="btn btn-module">Set Kata Laluan</button>
                <button type="button" class="btn btn-reset" onClick="resetForm()">Set Semula</button>
            </div>
        </form>
		<hr/>
		<div class="mini-title mt-5">Opsyen Lain <i class="fal fa-caret-down"></i></div>
		<ul class="bunch-menu">
			<li class="row-menu"><a href="register.htm">Daftar Pengguna</a></li>
			<li class="row-menu"><a href="forgot.htm">Lupa Kata Laluan</a></li>
		</ul>
	</div>

	<p>&nbsp;</p>
</div>
