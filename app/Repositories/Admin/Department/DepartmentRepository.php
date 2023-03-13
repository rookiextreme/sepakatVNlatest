<?php

namespace App\Repositories\Admin\Department\DepartmentRepository;

use App\Models\Identifier\Jabatan;
use App\Models\User;

class DepartmentRepository
{
    public function action($data)
    {
        $department = Jabatan::find($data['id']);

        if($data['action'] == 'update'){
            echo 'update';
        }
    }
}
