<nav class="navbar py-4 fixed-top navbar-expand-lg navbar-dark">
    <div class="container">
        <div class="d-flex flex-grow-1 flex-md-grow-1 flex-nowrap justify-content-between">
            <div class="d-flex align-items-center">
                <a class="navbar-brand text-wrap usePoppins navbarTitle m-0 p-0" href="{{ route('home') }}">Patrimônio
                    Arqueológico</a>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
                    aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <i class="menuIcon fa-solid fa-bars"></i>
            </button>
        </div>
        <div class="collapse navbar-collapse flex-grow-1 flex-md-grow-0" id="navbarText">
            <ul class="navbar-nav mb-2 mb-lg-0">
                @foreach ($navItems as $item)
                    @if (!isset($item['navItems']))
                        <li class="nav-item">
                            <a class="nav-link usePoppins" href="{{ route($item['url']) }}">{{ $item['title'] }}</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle usePoppins" href="#" role="button"
                               data-bs-toggle="dropdown" aria-expanded="false">
                                {{ $item['title'] }}
                            </a>
                            <ul class="dropdown-menu">
                                @foreach ($item['navItems'] as $subItem)
                                    <li>
                                        <a class="dropdown-item"
                                           href="{{ route($subItem['url']) }}">{{ $subItem['title'] }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                @endforeach
            </ul>
            <div class="ms-lg-5 d-flex align-items-center">
                @auth
                    <ul class="navProfileUl">
                        <li class="nav-item dropdown navProfile d-flex align-items-center">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                               aria-expanded="false">
                                <i class="fa-solid fa-user text-white"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item dropdown-item-overflow">Logado como {{auth()->user()->login}}</a></li>
                                <li><a class="dropdown-item" href="{{route('logout')}}">Deslogar</a></li>
                            </ul>
                        </li>
                    </ul>
                @endauth
                @guest
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a type="button" href="{{ route('login') }}"
                           class="btn btn-outline-light btn-navbar-auth">Login</a>
                        <a href="{{ route('register') }}" type="button" class="btn btn-outline-light btn-navbar-auth">Register</a>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</nav>
