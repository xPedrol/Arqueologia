<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Layout extends Component
{
    public $title;
    public $hasAside;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title = 'Home', $hasAside = false)
    {
        $this->title = $title;
        $this->hasAside = $hasAside;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.layout',['title' => $this->title, 'aside' => $this->hasAside]);
    }
}
