<!DOCTYPE html>
<html>

<head>
    <title>{{ $details['title'] }}</title>
</head>

<body>
    Assalamualaikum / Salam Sejahtera<br/>
    <p>Tuan / Puan </p>

    <p>Peringatan tarikh senggara kenderaan anda hampir tiba .</p>

    <p>Nombor Plat : {{ $details['plate_no'] }}</p>
    <p>Tarikh Senggara : {{ \Carbon\Carbon::parse($details['next_service_dt'])->format('d F Y') }}</p>

    <p>Sekian, terima kasih.</p>

</body>

</html>
