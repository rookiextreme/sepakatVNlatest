<?php
namespace App\Models\Fleet;

use App\Models\Kenderaan\Dokumen;
use App\Models\Location\Cawangan;
use App\Models\RefCategory;
use App\Models\RefOwner;
use App\Models\RefSubCategory;
use App\Models\RefSubCategoryType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class FleetLookupVehicleDisasterReady extends Model
{
    use HasFactory;

    protected $table = 'fleet.fleet_lookup_vehicle_disasterready_view';

    protected $fillable = [];

    public function cawangan()
    {
        return $this->belongsTo(RefOwner::class, 'cawangan_id');
    }

    public function hasCategory()
    {
        return RefCategory::find($this->category_id);
    }

    public function hasSubCategory()
    {
        return RefSubCategory::find($this->sub_category_id);
    }

    public function hasSubCategoryType()
    {
        return RefSubCategoryType::find($this->sub_category_type_id);
    }

    public function hasPersonIncharge(){
        return $this->belongsTo(User::class, 'person_incharge_id');
    }

    public function hashVehicleImagePrimary(){
        Log::info('::hashVehicleImagePrimary');
        $query = Dokumen::where([
            'fleet_department_id' => $this->id,
            'doc_type' =>  'gambarKenderaan',
            'is_primary' => true
        ]);

        Log::info($query->toSql());
        return $query->first();
    }

}
