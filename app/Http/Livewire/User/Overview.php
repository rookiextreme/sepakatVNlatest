<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Overview extends Component
{

    public $totalApproval = 0;
    public $totalRegistered = 0;
    public $totalRevoked = 0;
    public $totalLocked = 0;

    public function mount(){
        
        $this->totalApproval = User::whereHas('detail', function($q){
            $q->whereHas('refStatus', function($q2){
                $q2->where('code', '03');
            });
        })->count();

        $this->totalRegistered = User::whereHas('detail', function($q){
            $q->whereHas('refStatus', function($q2){
                $q2->where('code', '06');
            });
        })->count();

        $this->totalRevoked = User::whereHas('detail', function($q){
            $q->whereHas('refStatus', function($q2){
                $q2->where('code', '08');
            });
        })->count();

        $this->totalLocked = User::whereHas('detail', function($q){
            $q->whereHas('refStatus', function($q2){
                $q2->where('code', '07');
            });
        })->count();

        Log::info('This is some useful information.'. logger($this->totalLocked));

    }

    public function render()
    {
        return view('livewire.user.overview');
    }
}
