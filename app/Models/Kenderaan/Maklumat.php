<?php

namespace App\Models\Kenderaan;

use App\Models\RefCategory;
use App\Models\RefSubCategory;
use App\Models\RefSubCategoryType;
use App\Models\Vehicle\Brand;
use App\Models\Vehicle\VehicleModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Maklumat extends Model
{
    use HasFactory;

    protected $table = 'kenderaans.maklumats';

    protected $fillable = [
        'pendaftaran_id',
        'category_id',
        'sub_category_id',
        'sub_category_type_id',
        'brand_id',
        'model_id',
        'no_chasis',
        'no_engine',
        'status',
        'tarikh_belian',
        'no_resit',
        'pembeli'
    ];

    public function pendaftaran()
    {
        return $this->belongsTo('App\Modes\Kenderaan\Pendaftaran');
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
        $result = RefSubCategoryType::find($this->sub_category_type_id);
        Log::info($result);
        return $result;
    }

    public function hasBrand()
    {
        return Brand::where('id', $this->brand_id)->first();
    }

    public function hasVehicleModel()
    {
        return VehicleModel::where('id', $this->model_id)->first();
    }
}
