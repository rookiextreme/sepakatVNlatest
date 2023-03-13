<!DOCTYPE html>
<html>
<head>
    <title>{{ $details['title'] }}</title>
</head>
<body>
    @switch($details['lang'])
        @case('bm')
            Assalamualaikum / Salam Sejahtera,<br/>
            <p>Sila klik pautan di bawah untuk mengaktifkan akaun Spakat anda :</p>
        
            <a href="{{ $details['url'] }}">Klik Pautan</a>
        
            <p>Terima Kasih</p>
            @break
        @case('en')
            Please be upon you / Greetings,<br/>
            <p>Please link below to active your SPAKAT account :</p>
        
            <a href="{{ $details['url'] }}">Click here</a>
        
            <p>Thank You</p>
            @break
        @default
            
    @endswitch
</body>
</html>