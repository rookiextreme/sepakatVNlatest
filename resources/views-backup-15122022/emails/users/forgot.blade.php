<!DOCTYPE html>
<html>
<head>
    <title>{{ $details['title'] }}</title>
</head>
<body>
    @switch($details['lang'])
        @case('bm')
            Assalamualaikum / Salam Sejahtera,<br/>
            <p>Sila Klik <a href="{{ $details['url'] }}"> di sini</a> untuk tukar kata laluan</p>

            <p>Terima kasih</p>

            @break
        @case('en')
            Please be upon you / Greetings,<br/>
            <p><a href="{{ $details['url'] }}"> Change Password</a></p>
            <p>Please click <a href="{{ $details['url'] }}"> here</a> to change password</p>
        
            <p>Thank You</p>

            @break
        @default
            
    @endswitch

    <p>SPaKAT</p>
</body>
</html>