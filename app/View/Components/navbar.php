<?php

namespace App\View\Components;

use Illuminate\View\Component;

class navbar extends Component
{
    public $navItems = [
        [
            'title' => 'Quem somos',
            'url' => 'home'
        ],
        [
            'title' => 'Associe-se!',
            'url' => 'home'
        ],
        [
            'title' => 'Associados',
            'url' => 'home'
        ],
        [
            'title' => 'Serviços',
            'navItems' => [
                [
                    'title' => 'Documentos',
                    'url' => 'home'
                ],
                [
                    'title' => 'Convênios',
                    'url' => 'home'
                ],
                [
                    'title' => 'Eventos',
                    'url' => 'home'
                ],
                [
                    'title' => 'Cursos',
                    'url' => 'home'
                ],
                [
                    'title' => 'Notícias',
                    'url' => 'home'
                ],
            ]
        ],
        [
            'title' => 'Contato',
            'url' => 'home'
        ],
        [
            'title' => 'Login',
            'url' => 'home'
        ],
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
            if (isset($navItem['auth']) && !!$navItem['auth'] && !auth()->check()) {
                unset($navItems[$key]);
                continue;
            }
            if (isset($navItem['removeWhenAuth']) && !!$navItem['removeWhenAuth'] && auth()->check()) {
                unset($navItems[$key]);
                continue;
            }
            if (isset($navItem['role']) && auth()->user()->cargo != $navItem['role']) {
                unset($navItems[$key]);
                continue;
            }
            if (isset($navItems[$key]['navItems'])) {
                $this->checkAuth($navItems[$key]['navItems']);
            }
        }
    }
}
