<!DOCTYPE html>
<html>

<head>
    <title>{{ $details['title'] }}</title>
</head>

<body>
    Tuan/Puan.
    @php
        $total = $details['detail']->hasVehicle->count();
    @endphp
    Terdapat satu Permohonan Pemeriksaan Kerosakan / Penyenggaraan baharu untuk tindakan selanjutnya. Sila login ke dalam sistem melalui pautan di bawah:
    <br/>

    <a href="{{route('.redirect', [ 'redirectTo' => route('maintenance.evaluation.register', ['id' => $details['detail']->id, 'tab' => 5])])}}">Pautan</a>

    <p>SISTEM SPAKAT</p>
</body>

</html>