<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ModalVehicleType extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    
    public $is_display = 0;
    public $filter_by_role;
    public $title = "";
    public $sub_title = "";
    public $field_name = "";
    public $field_value = "";
    public $data_name = "";

    public function __construct($isDisplay, $filterByRole, $title, $subTitle, $fieldName, $fieldValue, $dataName)
    {
        $this->is_display = $isDisplay;
        $this->filter_by_role = $filterByRole;
        $this->title = $title;
        $this->sub_title = $subTitle;
        $this->field_name = $fieldName;
        $this->field_value = $fieldValue;
        $this->data_name = $dataName;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modal-vehicle-type', [
            'is_display' => $this->is_display,
            'filter_by_role' => $this->filter_by_role,
            'title' => $this->title,
            'sub_title' => $this->sub_title,
            'field_name' => $this->field_name,
            'field_value' => $this->field_value,
            'data_name' => $this->data_name,
        ]);
    }
}
