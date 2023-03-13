<?php

namespace App\Models\Logistic;

use App\Http\Livewire\Auth\Activation\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogisticPassenger extends Model
{
    use HasFactory;
    protected $table = 'logistic.passenger';
    protected $fillable = [
        'logistic_booking_vehicle_id',
        'name',
        'phone_no',
        'created_by',
        'updated_by'
    ];

    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(){
        return $this->belongsTo(User::class, 'updated_by');
    }

}
