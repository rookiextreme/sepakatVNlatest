<?php

namespace App\Http\Controllers\User;

use App\Models\RefRole;
use App\Models\RefWorkshop;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class Approval extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $limitPage = 5;
    public $list;
    public $tab = 'kakitangan';
    public $register_purpose;

    public function getUsers($register_purpose){
        $this->register_purpose = $register_purpose;
        return User::whereHas('detail', function($q){
            $q->where('register_purpose', $this->register_purpose)->whereHas('refStatus', function($q2){
                $q2->where('code', '03');
            });
        })->paginate($this->limitPage);
    }

    public function getUserRolesProperty(){
        return RefRole::all();
    }

    public function getWorkShopsProperty(){
        return RefWorkshop::all();
    }

}
