<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Pagination extends Component
{
    public $query;
    public $maxPage;
    public $route;
    public $params;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($query, $maxPage, $route, $params = [])
    {
        $this->query = $query;
        $this->maxPage = $maxPage;
        $this->route = $route;
        $this->params = $params;
    }

    //


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.pagination', ['query' => $this->query, 'maxPage' => $this->maxPage, 'route' => $this->route, 'params' => $this->params]);
    }
}
