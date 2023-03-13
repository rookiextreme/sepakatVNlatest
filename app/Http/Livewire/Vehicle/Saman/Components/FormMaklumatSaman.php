<?php

namespace App\Http\Livewire\Dashboard\Saman\Components;

use App\Models\Location\Cawangan;
use App\Models\Location\Daerah;
use App\Models\Location\Negeri;
use App\Models\Saman\MaklumatKenderaanSaman;
use App\Repositories\Summon\RegisterSummonRepository;
use Livewire\Component;

class FormMaklumatSaman extends Component
{
    public $informations = [];
    public $saman_id;

    public $branchs;
    public $states;
    public $cities;
    public $summon;

    public function mount()
    {
        $this->branchs = Cawangan::all();
        $this->states = Negeri::all();
        $this->cities = Daerah::all();
        $this->availableData();
        $this->status();

    }

    public function registerSummonRepository()
    {
        $respository = new RegisterSummonRepository();

        return $respository;
    }

 
    
    public function status()
    {
        if(request('id'))
        {
            $summon = MaklumatKenderaanSaman::find($this->saman_id);

            if(!empty($summon->statusSaman))
            {
                $this->summin = $summon->status_saman;
            }
        }else{
            $this->summon = 'draf';
        }
    }

    public function store() 
    {
        $data = [
            'id' => $this->saman_id,
            'state_id' => $this->informations['state_id'],
            'city_id' => $this->informations['city_id'],
            'branch_id' => $this->informations['branch_id'],
            'summon_type' => $this->informations['summon_type'],
            'summon_notice' => $this->informations['summon_notice'],
            'notice_date' => $this->informations['notice_date'],
            'receive_notice_date' => $this->informations['receive_notice_date'],
            'mistake_time' => $this->informations['mistake_date'],
            'city_code' => $this->informations['city_code'],
            'mistake_location' => $this->informations['mistake_location'],
            'compaun_total' => $this->informations['compaun_total'],

        ];

        $store = $this->registerSummonRepository()->storeSummonInformation($data);

        return [
            'message' => 'Berjaya disimpan'
        ];
    }

    public function availableData()
    {
        if(!empty($this->saman_id))
        {
            $saman = MaklumatKenderaanSaman::find($this->saman_id);

            if(!empty($saman->maklumatSaman)){
                
                $x = $saman->maklumatSaman;

                $this->informations = [
                    'state_id' => $x->state_id,
                    'city_id' => $x->daerah_id,
                    'branch_id' => $x->cawangan_id,
                    // 'summon_type' => $x->state_id,
                    'summon_notice' => $x->no_notis_saman,
                    'notice_date' => $x->tarikh_notis,
                    'mistake_date' => $x->masa_kesalahan,
                    'city_code' => $x->kod_daerah,
                    'mistake_location' => $x->tempat_kesalahan,
                    'compaun_total' => $x->jumlah_kompaun,
        
                ];
            }
            
        }
    }

    public function render()
    {
        return view('livewire.dashboard.saman.components.form-maklumat-saman');
    }

}
