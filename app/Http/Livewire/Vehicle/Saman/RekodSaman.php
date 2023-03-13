<?php

namespace App\Http\Livewire\Vehicle\Saman;

use App\Models\Saman\MaklumatKenderaanSaman;
use Livewire\WithPagination;
use Livewire\Component;

class RekodSaman extends Component
{   
    use WithPagination;
    public $summon_list = [];

    protected $listeners = [
        'render'
    ];

    public function mount()
    {
        if(request('id'))
        {
            $summon_list = MaklumatKenderaanSaman::where('status_saman_id', request('id'))->paginate(10);

        }else{

            $summon_list = MaklumatKenderaanSaman::paginate(10);

        }

        return $summon_list;
    }
}
