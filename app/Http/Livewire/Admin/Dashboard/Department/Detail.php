<?php

namespace App\Http\Livewire\Admin\Dashboard\Department;

use App\Models\Identifier\Jabatan;
use App\Models\Identifier\Kementerian;
use Livewire\Component;

class Detail extends Component
{
    public $selected_id;
    public $ministryName;
    public $departmentName;
    public $updateMode = false;

    public function mount()
    {

        $jabatan = Jabatan::find(request('id'));
        $ministry = Kementerian::find($jabatan->kementerian_id);
        
        $this->ministryName = $ministry->name;
        $this->selected_id = $jabatan -> id;
        $this->departmentName = $jabatan->jabatan;
    }

    public function render()
    {
        return view('livewire.admin.dashboard.department.detail');
    }

    public function save()
    {
        $this->validate([
            'departmentName' => 'required'
        ]);

        $jabatan = Jabatan::find($this->selected_id);
        $jabatan->update([
            'jabatan' => $this->departmentName
        ]);

        session()->flash('message', 'Maklumat Jabatan Berjaya dikemaskini.');
    }

}
