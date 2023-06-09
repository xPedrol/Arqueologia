<?php

namespace App\View\Components;

use Illuminate\View\Component;

class footer extends Component
{
    public $firstBanners = [
        [
            'title' => 'Casa Setecentista de Mariana',
            'itemList' => [
                [
                    'title' => 'Casa Setecentista de Mariana',
                    'url' => 'home',
                    'isInternal' => true
                ],
                [
                    'title' => 'CEP: 35400-000',
                    'isInternal' => false
                ],
                [
                    'title' => 'Telefone: (31) 3849-1000',
                    'isInternal' => false
                ]
            ]
        ],
        [
            'title' => 'Edifício da GeoHistória - UFV',
            'itemList' => [
                [
                    'title' => 'Rua Purdue, 632 - Santo Antonio, Viçosa - MG',
                    'isInternal' => false
                ],
                [
                    'title' => 'CEP: 36579-900',
                    'isInternal' => false
                ]
            ]
        ],
        [
            'title' => 'Acesso',
            'itemList' => [
                [
                    'title' => 'Início',
                    'url' => 'home',
                    'isInternal' => true
                ],
                [
                    'title' => 'Fontes',
                    'url' => 'fontes',
                    'isInternal' => true
                ],
            ]
        ]
    ];
    public $sites = [
        [
            'title' => 'LAMPEH',
            'link' => 'http://www.lampeh.ufv.br/',
        ],
        [
            'title' => 'UFV',
            'link' => 'https://www.ufv.br/',
        ],
        [
            'title' => 'IPHAN',
            'link' => 'http://portal.iphan.gov.br/',
        ],
        [
            'title' => 'FAPEMIG',
            'link' => 'https://fapemig.br/pt/',
        ],
        [
            'title' => 'CNPq',
            'link' => 'https://cnpq.br/',
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
        return view('components.footer', ['sites' => $this->sites, 'firstBanners' => $this->firstBanners]);
    }
}
