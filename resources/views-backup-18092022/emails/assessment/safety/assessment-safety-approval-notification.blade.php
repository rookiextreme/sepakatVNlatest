<!DOCTYPE html>
<html>

<head>
    <title>{{ $details['title'] }}</title>
</head>

<body>
    Hi Pemohon.
    Di Bawah adalah senarai permohonan kenderaan<br/>
    @if (count($details['assessment_safety_vehicle_list']) > 0)
        <table>
            <thead>
                <th>Bil</th>
                <th>No Pendaftaran</th>
                <th>Status</th>
                <th>Pautan</th>
            </thead>
            <tbody>
                @foreach ($details['assessment_safety_vehicle_list'] as $assessment_safety_vehicle)
                <tr>
                    <td>{{$loop->index+1}}</td>
                    <td>{{$assessment_safety_vehicle->plate_no}}</td>
                    <td>{{$assessment_safety_vehicle->hasAssessmentVehicleStatus->desc}}</td>
                    <td>
                        <a href="{{route('.redirect', [
                            'redirectTo' => route('assessment.safety.register', ['id' => $assessment_safety_vehicle->hasAssessmentDetail->id, 'tab' => 5])]
                        )}}">Pautan</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <p>Sekian, Terima Kasih.</p>
</body>

</html>
