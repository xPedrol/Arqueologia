<?php

namespace App\View\Components;

use Illuminate\View\Component;

class EmptyAlert extends Component
{

    public $message;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($message = 'Nenhum item encontrado.')
    {
        $this->message = $message;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.empty-alert');
    }
}
