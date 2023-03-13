<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Revoked extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function dateFormat($data, $format){

        return Carbon::parse($data)->format($format);

    }
    
    public function render()
    {

        //dd(User::has('detail')->get());
        return view('livewire.user.revoked', [
            'users' => User::whereHas('detail', function($q){
                $q->whereHas('refStatus', function($q2){
                    $q2->where('code', '08');
                });
            })->paginate(5)
        ]);
    }
}
