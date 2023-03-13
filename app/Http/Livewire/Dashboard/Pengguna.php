<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Repositories\Users\UserRepository;

class Pengguna extends Component
{
    public $users;
    public $roles;
    public $role;
    public $hoii;

    public function mount()
    {

        $users = User::all();

        if(empty($users->status)){

            $this->users = $users;

        }

        $this->roles = Role::all();
    }

    public function action($id, $action)
    {
        $user = new UserRepository();

        $data = [
            'id' => $id,
            'action' => $action,
            'role' => $action == 'pass' ? $this->role[$id] : null
        ];

        $act = $user->tindakan($data);

        $users = User::all();

        if(empty($users->status)){

            $this->users = $users;

        }
    }

    public function render()
    {
        return view('livewire.dashboard.pengguna');
    }
}
