<?php

namespace App\View\Components;

use Illuminate\View\Component;

class navbar extends Component
{
    public $navItems = [
        [
            'title' => 'Quem somos',
            'url' => 'about'
        ],
        [
            'title' => 'Associe-se!',
            'url' => 'register',
            'guest'=> true,
        ],
        [
            'title' => 'Associados',
            'url' => 'members',
            'auth'=> true,
            'role'=>'admin'

        ],
        [
            'title' => 'Cidades',
            'url' => 'fontes'
        ],
        [
            'title' => 'Relatos Viajantes',
            'url' => 'relatosQuadrilatero'
        ],
        [
            'title' => 'Contato',
            'url' => 'contact'
        ]
    ];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $this->checkAuth($this->navItems);
        return view('components.navbar', ['navItems' => $this->navItems]);
    }

    private function checkAuth(&$navItems)
    {
        foreach ($navItems as $key => $navItem) {
            if(isset($navItem['guest']) && !!$navItem['guest'] && auth()->check()){
                unset($navItems[$key]);
                continue;
            }
            if (isset($navItem['auth']) && !!$navItem['auth'] && !auth()->check()) {
                unset($navItems[$key]);
                continue;
            }
            if (isset($navItem['removeWhenAuth']) && !!$navItem['removeWhenAuth'] && auth()->check()) {
                unset($navItems[$key]);
                continue;
            }
            if (isset($navItem['role']) && auth()->user()->role != $navItem['role']) {
                unset($navItems[$key]);
                continue;
            }
            if (isset($navItems[$key]['navItems'])) {
                $this->checkAuth($navItem['navItems']);
            }
        }
    }
}
