<!DOCTYPE html>
<html>
<head>
    <title>{{ $details['title'] }}</title>
</head>
<body>
    @switch($details['lang'])
        @case('bm')
        Assalamualaikum / Salam Sejahtera,<br/>
        <p>Pengguna ID : {{$details['username']}}</a></p>
       
        <p>Terima Kasih</p>
        @break

        @case('en')
        Please be upon you / Greetings,<br/>
        <p>Username : {{$details['username']}}</a></p>
       
        <p>Thank You</p>
        @break
    
        @default
            
    @endswitch
</body>
</html>