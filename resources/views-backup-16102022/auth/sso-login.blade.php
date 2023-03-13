<script type="text/javascript" src="{{asset('my-assets/jquery/jquery-3.6.0.min.js')}}"></script>

<form method="POST" id="frm_sso_login" action="{{ route('cb.sso.login.action') }}">
    @csrf
    <input type="hidden" name="username" id="username">
    <input type="hidden" name="password" id="password">
</form>