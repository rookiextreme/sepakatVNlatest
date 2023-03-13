<!DOCTYPE html>
<html>

<head>
    <title>{{ $details['title'] }}</title>
</head>

<body>
    <p>{{$details['detail']->applicant_name}},</p>

    <p>Temujanji anda telah ditetapkan oleh pegawai kami. Dibawah adalah butiran temujanji berikut: </p>

    <table style="width: 100%">

        <tr>
            <td style="width: 5%;">Tarikh</td>
            <td>: {{Carbon\Carbon::parse($details['detail']->appointment_dt)->format('d F Y')}}</td>
        </tr>
        <tr>
            <td>Masa</td>
            <td>: {{Carbon\Carbon::parse($details['detail']->appointment_dt)->format('h:m A')}}</td>
        </tr>
        @if(count($details['detail']->hasVehicle)>0)
            <tr>
                <td>
                    No Pendaftaran Kenderaan
                </td>
                <td>: @foreach ($details['detail']->hasVehicle as $vehicle)@if($loop->index > 0),@endif{{$vehicle->plate_no}}@endforeach
                </td>
            </tr>
        @endif

    </table>

    <p>Sekian,</p>

    <p>Terima kasih</p>

    <p>SPaKAT</p>
</body>

</html>
