<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Table extends Component
{

    public $query;
    public $columns;
    public $route;
    public $params;
    public $data;
    public $caption;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($data, $columns, $query, $route, $caption, $params = [])
    {
        $this->data = $data;
        $this->columns = $columns;
        $this->route = $route;
        $this->params = $params;
        $this->query = $query;
        $this->caption = $caption;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        //remove columns line with show = false
        foreach ($this->columns as $key => $column) {
            if (isset($column['show']) && !$column['show']) {
                unset($this->columns[$key]);
            }
        }
        return view('components.table', ['query' => $this->query, 'columns' => $this->columns, 'data' => $this->data, 'params' => $this->params, 'caption' => $this->caption]);
    }
}
