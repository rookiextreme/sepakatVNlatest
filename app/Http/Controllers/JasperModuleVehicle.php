<?php

use App\Http\Controllers\Vehicle\VehicleDAO;
use App\Models\Maintenance\MaintenanceEvaluationLetter;
use App\Models\Maintenance\MaintenanceJob;
use App\Models\RefOwnerType;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

$carbon = new Carbon();
$carbon->setLocale('ms');

switch ($reportName) {
    case 'vehicle_list':
        $VehicleDAO = new VehicleDAO();
        $status = $request->status ? $request->status: 'approved';
        $ownerType = RefOwnerType::where([
            'display_for' => 'vehicle_register',
            'code' => $request->owner_type_code
        ])->first();
        if (ob_get_contents()) {ob_end_clean();}
        $query = $VehicleDAO->getTotalVehicle($status,$request->search,$request->fleet_view,$request->offset,$request->limit, $request->xid, $ownerType, $request);
        $title = $request->title;
        $module = [
            'fleet_department' => 'department',
        ];

        $params = [
            'asset_path' => public_path('my-assets'),
            'query' => $query,
            'title' => $title,
        ];
        break;

}
