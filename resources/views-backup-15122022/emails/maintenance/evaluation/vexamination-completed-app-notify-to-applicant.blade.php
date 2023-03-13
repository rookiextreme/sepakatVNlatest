<!DOCTYPE html>
<html>

<head>
    <title>{{ $details['title'] }}</title>
</head>

<body>
    <p>{{$details['detail']->hasMaintenanceDetail->applicant_name}},</p>

    <p>Kenderaan No Pendaftaran {{$details['detail']->plate_no}} telah selesai diperiksa. </p>

    {{--  <table style="width: 100%">

        <tr>
            <td style="width: 5%;">Tarikh</td>
            <td>: {{Carbon\Carbon::parse($details['detail']->appointment_dt)->format('d F Y')}}</td>
        </tr>
        <tr>
            <td>Masa</td>
            <td>: {{Carbon\Carbon::parse($details['detail']->appointment_dt)->format('h:m A')}}</td>
        </tr>

    </table>  --}}

    <p>Sekian,</p>

    <p>Terima kasih</p>

    <p>SPaKAT</p>
</body>

</html>
