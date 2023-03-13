<?php
namespace App\Models\Fleet;

use App\Models\Identifier\KenderaanStatus;
use App\Models\Kenderaan\Dokumen;
use App\Models\Location\Placement;
use App\Models\Maintenance\MaintenanceJob;
use App\Models\RefBranch;
use App\Models\RefCategory;
use App\Models\RefOwner;
use App\Models\RefOwnerType;
use App\Models\RefState;
use App\Models\RefSubCategory;
use App\Models\RefSubCategoryType;
use App\Models\RefVehicleStatus;
use App\Models\User;
use App\Models\Vehicle\Brand;
use App\Models\Vehicle\VehicleModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class FleetProject extends Model
{
    use HasFactory;

    protected $table = 'fleet.fleet_project';

    protected $fillable = [
        'project_name',
        'contract_no',
        'hopt',
        'contractor_name',
        'ministry',
        'project_start_dt',
        'project_end_dt',
        'project_cpc_dt',
        'created_by'
    ];

    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by');
    }

}
