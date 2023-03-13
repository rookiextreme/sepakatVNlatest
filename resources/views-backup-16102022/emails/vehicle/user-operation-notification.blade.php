<!DOCTYPE html>
<html>

<head>
    <title>{{ $details['title'] }}</title>
</head>

<body>
    Assalamualaikum / Salam Sejahtera<br/><br/>
    {{-- @if (count($details['usersOperation']) > 0)
        @foreach ($details['usersOperation'] as $userOperation)
            {{ $userOperation->name }},
        @endforeach
    @endif --}}

    <p>
        Kenderaan {{ $details['plate_no'] }} baru didaftarkan.
    </p>

    Sila <a href="{{ $details['url'] }}">Klik</a> pautan untuk melakukan semakan/pengesahan.

    <p>Jika telah membuat semakan/pengesahan, abaikan mesej ini.</p>

    <p>Sekian, Terima Kasih.</p>
</body>

</html>
