<?php

namespace App\View\Components;

use Illuminate\View\Component;

class notFoundHtml extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $show;

    public function __construct($show = false)
    {
        $this->show = $show;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.not-found-html');
    }
}
