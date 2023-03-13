<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use App\Repositories\Users\UserRepository;
use Livewire\Component;
use Livewire\Livewire;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class Registered extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    
    public function render()
    {

        //dd(User::has('detail')->get());
        return view('livewire.user.registered', [
            'users' => User::whereHas('detail', function($q){
                $q->whereHas('refStatus', function($q2){
                    $q2->where('code', '06');
                });
            })->paginate(5)
        ]);
    }
}
