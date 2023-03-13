<!DOCTYPE html>
<html>

<head>
    <title>{{ $details['title'] }}</title>
</head>

<body>
    Assalamualaikum / Salam Sejahtera,
    <p> Kenderaan anda {{ $details['plat_no'] }} 
        mempunyai {{$details['summon_total']}} saman yang perlu diselesaikan
    </p>
    <p>
        @if(isset($details['summonList']))
            @foreach ($details['summonList'] as $summon)
                - {{$summon->summon_notice_no}} <br/>
            @endforeach
        @endif
    </p>

    <p>
        Klik <a href="{{ $details['url'] }}">pautan</a> untuk muat naik resit / gambar untuk bukti pembayaran.
    </p>
    
    <p>Jika telah membuat pembayaran, abaikan mesej ini</p>

    <p>Terima Kasih.</p>

</body>

</html>
