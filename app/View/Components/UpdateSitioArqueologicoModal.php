<?php

namespace App\View\Components;

use Illuminate\View\Component;

class UpdateSitioArqueologicoModal extends Component
{
    public $sitio = null;
    public $name = 'new';

    public function __construct($sitio, $name = 'new')
    {
        $this->sitio = $sitio;
        $this->name = $name;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.update-sitio-arqueologico-modal');
    }
}
