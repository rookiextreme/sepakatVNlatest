<!DOCTYPE html>
<html>

<head>
    <title>{{ $details['title'] }}</title>
</head>

<body>
    Assalamualaikum / Salam sejahtera,<br/>
    Di Bawah adalah senarai permohonan kenderaan<br/>
    @if (count($details['assessment_new_vehicle_list']) > 0)
        <table>
            <thead>
                <th>Bil</th>
                <th>No Pendaftaran</th>
                <th>Status</th>
                <th>Pautan</th>
            </thead>
            <tbody>
                @foreach ($details['assessment_new_vehicle_list'] as $assessment_new_vehicle)
                <tr>
                    <td>{{$loop->index+1}}</td>
                    <td>{{$assessment_new_vehicle->plate_no}}</td>
                    <td>{{$assessment_new_vehicle->hasAssessmentVehicleStatus->desc}}</td>
                    <td>
                        <a href="{{route('.redirect', [
                            'redirectTo' => route('assessment.new.register', ['id' => $assessment_new_vehicle->hasAssessmentDetail->id, 'tab' => 5])]
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
