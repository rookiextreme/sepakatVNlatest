<?php

namespace App\Http\Livewire\Components\Enlarge\Image;
use Livewire\Component;


class ModalEnlargeImage extends Component
{
    public $img_title = "";
    public $img_url = "";

    protected $listeners = [
        'closeModal',
        'userEnlargeImageMD' => 'open',
    ];

    public function open($url)
    {
        $this->img_url = $url;
    }

    public function render()
    {
        return view('livewire.components.enlarge.image.modal-enlarge-image', [
            "img_url" => $this->img_url
        ]);
    }
}
