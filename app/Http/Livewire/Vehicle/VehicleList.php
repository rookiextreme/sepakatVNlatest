<?php

namespace App\Http\Livewire\Vehicle;

use App\Models\Kenderaan\Pendaftaran;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class VehicleList extends Component
{
    
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $list;

    public function mount()
    {
        $checkroles = Auth::user()->hasRole(['pentadbir-sistem-spakat','jurutera-jkr','penolong-jurutera-jkr']);
        Log::info($checkroles);
    }

    public function render()
    {   $checkroles = Auth::user()->hasRole(['pentadbir-sistem-spakat','jurutera-jkr','penolong-jurutera-jkr']);
        
        if ($checkroles)
            return view('livewire.vehicle.vehicle-list', [
                'vehicleList' => Pendaftaran::paginate(5)
            ]);
        else
        return view('livewire.vehicle.vehicle-list', [
            'vehicleList' => Pendaftaran::paginate(5)
        ]);
    }
}
