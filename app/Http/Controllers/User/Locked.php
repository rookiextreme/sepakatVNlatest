<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Locked extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function dateFormat($data, $format){

        return Carbon::parse($data)->format($format);

    }
    
    public function render()
    {

        //dd(User::has('detail')->get());
        return view('livewire.user.locked', [
            'users' => User::whereHas('detail', function($q){
                $q->has('isLocked');
            })->paginate(5)
        ]);
    }
}
