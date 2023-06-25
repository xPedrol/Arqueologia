<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Layout extends Component
{
    public $title;
    public $description;



    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title = 'Home', $description='Patrimônio Arqueológico')
    {
        $this->title = $title;
        $this->description = $description;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.layout',['title' => $this->title, 'description' => $this->description]);
    }
}
