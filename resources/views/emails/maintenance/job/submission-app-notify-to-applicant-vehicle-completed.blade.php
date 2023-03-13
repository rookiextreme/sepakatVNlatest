<!DOCTYPE html>
<html>

<head>
    <title>{{ $details['title'] }}</title>
</head>

<body>
    <p>{{$details['applicant_name']}},</p>

    <p>Kenderaan anda {{$details['vehicle']->plate_no}} telah selesai. </p>

    <p>Sekian,</p>

    <p>Terima kasih</p>

    <p>SPaKAT</p>
</body>

</html>
