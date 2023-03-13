<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use App\Repositories\Users\UserRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class Approval extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $selectedUsers = [];
    public $selectedUserId = -1;
    public $list;
    public $tab = '';

    public $selectAll = false;
    
    public function mount(){
        $this->selectedUsers = [];
    }

    public function render()
    {
        return view('livewire.user.approval', [
            'usersNonGov' => $this->usersNonGov,
            'usersGov' => $this->usersGov
        ]);
    }

    public function removeSpesificKey($key){
        if(in_array($key, $this->selectedUsers)){
            $mykey = array_search($key,$this->selectedUsers);
            unset($this->selectedUsers[$mykey]);
            Log::info('ada'.$mykey);
            Log::info($this->selectedUsers);
        } else {
            Log::info('x ada');
            Log::info($this->selectedUsers);
        }
    }

    public function updatedSelectAll($value){
        if($value){
            $this->selectedUsers =$this->users->pluck('id')->map(fn ($query)=>(string) $query)->toArray() ;
        } else {
            $this->selectedUsers = [];
        }
    }

    public function getUsersNonGovProperty(){
        return User::whereHas('detail', function($q){
            $q->where('gov_staff', false)->whereHas('refStatus', function($q2){
                $q2->where('code', '03');
            });
        })->paginate(5);
    }

    public function getUsersGovProperty(){
        return User::whereHas('detail', function($q){
            $q->where('gov_staff', true)->whereHas('refStatus', function($q2){
                $q2->where('code', '03');
            });
        })->paginate(5);
    }

    public function updatedChecked(){
        $this->selectAll=false;
    }

    public function gotoPage($page)
    {
        $this->page = $page;

        $this->emit('goToPage');
    }

}
