<link href="{{ asset('css/navbar.css') }}" rel="stylesheet">
<header class="header">
    <div class="headerContent d-flex align-items-center justify-content-between w-100 h-100">
        <div class="d-flex align-items-center">
            <h1 class="navTitle">Patrimônio Arqueológico</h1>
        </div>
        <div>
            <nav class="d-none d-md-flex justify-content-center w-100">
                <div class="d-flex align-items-strench navItems">
                    @foreach($navItems as $item)
                        @if(!isset($item['navItems']))
                            <a href="{{route($item['url'])}}" class="nav-link useRobotoCondensed">
                                <span class="beforeSpan">{{$item['title']}}</span>
                            </a>
                        @else
                            <a class="nav-link dropdown-toggle useRobotoCondensed" role="button"
                               data-bs-toggle="dropdown"
                               aria-expanded="false">
                                {{$item['title']}}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                @foreach($item['navItems'] as $subItem)
                                    <li>
                                        <a class="nav-link useRobotoCondensed dropdown-nav-link"
                                           href="{{route($subItem['url'])}}">{{$subItem['title']}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    @endforeach
                </div>
            </nav>
        </div>
        <div class="d-block d-md-none">
            <button class="d-flex align-items-center justify-content-center menuButton navbar-toggler" type="button"
                    data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown"
                    aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>
    </div>
</header>
<div class="d-md-none collapse navbar-collapse mobileMenu" id="navbarNavDropdown">
    <ul class="navbar-nav">
        @foreach($navItems as $item)
            @if(!isset($item['navItems']))
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{route($item['url'])}}">{{$item['title']}}</a>
                </li>
            @else
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown"
                       aria-expanded="false">
                        {{$item['title']}}
                    </a>
                    <ul class="dropdown-menu">
                        @foreach($item['navItems'] as $subItem)
                            <li><a class="dropdown-item" href="{{route($subItem['url'])}}">{{$subItem['title']}}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endif
        @endforeach
    </ul>
</div>
