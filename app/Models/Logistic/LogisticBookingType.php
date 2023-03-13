<?php

namespace App\Models\Logistic;

use App\Models\Fleet\FleetLookupVehicle;
use App\Models\LogisticBookingStatus;
use App\Models\LogisticStayStatus;
use App\Models\RefOwner;
use App\Models\RefSubCategoryType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class LogisticBookingType extends Model
{
    use HasFactory;

    protected $table = 'logistic.logistic_booking_type';

    protected $fillable = [
        'desc_bm',
        'desc_en',
        'updated_by',
        'created_by'
    ];

    public function updatedBy(){
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by');
    }

}
