<?php

namespace App\Http\Livewire\Admin\Dashboard;

use App\Models\Identifier\Jabatan;
use App\Models\Identifier\Kementerian;
use Livewire\Component;
use Livewire\WithPagination;

class DepartmentList extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    
    public $Ministries;
    public $selected_id = -1;
    public $hoii = "as";

    //add modal
    public $ministryid;
    public $departmentName;

    public function render()
    {
        $this->Ministries = Kementerian::all();
        return view('livewire.admin.dashboard.department-list',  [
            'jabatans' => Jabatan::paginate(5),
        ]);
    }

    public function confirmToAdd(){

        $this->validate([
            'ministryid' => 'required',
            'departmentName' => 'required'
        ]);

        Jabatan::create([
            'kementerian_id' => $this -> ministryid,
            'jabatan' => $this -> departmentName
        ]);

        session()->flash('message', 'Jabatan Berjaya Ditambah');
        $this->dispatchBrowserEvent('department-added');
    }

    public function modalDeleteConfirm($id){
        $this-> selected_id = $id;
    }

    public function confirmToDelete(){
        if($this->selected_id){
            $jabatan = Jabatan::find($this->selected_id);
            $jabatan->delete();
            session()->flash('message', 'Jabatan Berjaya Dihapuskan');
        }
    }

}
