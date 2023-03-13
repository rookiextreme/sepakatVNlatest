<!DOCTYPE html>
<html>

<head>
    <title>{{ $details['title'] }}</title>
</head>

<body>
    Assalamualaikum / Salam sejahtera,<br/>
    Di Bawah adalah senarai tempahan yang telah ditolak.<br/>
    @if (count($details['booking_list']) > 0)
        @foreach ($details['booking_list'] as $booking)
            <label for="">Lokasi</label>
            <div>{{$booking->destination}}</div>
            <a href="{{route('.redirect', [
                'redirectTo' => route('logistic.booking.detail', ['id' => $booking->id])]
            )}}">Pautan</a>
        @endforeach
    @endif

    <p>Sekian, Terima Kasih.</p>
</body>

</html>
