<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;

class FormTest extends Component
{
    public $err;

    public function render()
    {
        return view('livewire.auth.form-test');
    }
}
