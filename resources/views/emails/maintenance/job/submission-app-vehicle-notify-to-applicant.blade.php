<!DOCTYPE html>
<html>

<head>
    <title>{{ $details['title'] }}</title>
</head>

<body>
    Assalamualaikum / Salam sejahtera,<br/>
    Di Bawah adalah senarai permohonan kenderaan<br/>
    @if (count($details['maintenance_job_vehicle_list']) > 0)
        <table>
            <thead>
                <th>Bil</th>
                <th>No Pendaftaran</th>
                <th>Status</th>
                <th>Pautan</th>
            </thead>
            <tbody>
                @foreach ($details['maintenance_job_vehicle_list'] as $maintenance_job_vehicle)
                <tr>
                    <td>{{$loop->index+1}}</td>
                    <td>{{$maintenance_job_vehicle->plate_no}}</td>
                    <td>{{$maintenance_job_vehicle->hasMaintenanceVehicleStatus->desc}}</td>
                    <td>
                        <a href="{{route('.redirect', [
                            'redirectTo' => route('maintenance.job.register', ['id' => $maintenance_job_vehicle->hasMaintenanceDetail->id, 'tab' => 5])]
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
