<header id="masthead" class="site-header" role="banner" itemtype="https://schema.org/WPHeader" itemscope="itemscope">
    <div id="sinatra-header" class="si-container__wide">
        <div id="sinatra-header-inner">

            <div class="si-container si-header-container">


                <div class="sinatra-logo si-header-element" itemtype="https://schema.org/Organization" itemscope="itemscope">
                    <div class="logo-inner"><h1 class="site-title" itemprop="name">
                            <a href="{{route('home')}}" rel="home" itemprop="url">
                                Patrimônio Arqueológico
                            </a>
                        </h1></div></div><!-- END .sinatra-logo -->

                <nav class="site-navigation main-navigation sinatra-primary-nav sinatra-nav si-header-element" role="navigation" itemtype="https://schema.org/SiteNavigationElement" itemscope="itemscope" aria-label="Site Navigation" aria-haspopup="true">
                    <ul id="sinatra-primary-nav" class="menu"><li id="menu-item-16" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-16"><a href="{{route('about')}}"><span>Quem somos</span></a></li>
                        <li id="menu-item-173" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-173"><a href="{{route('register')}}"><span>Associe-se!</span></a></li>
                        @if(Auth::check())
                        <li id="menu-item-146" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-146"><a href="{{route('members')}}"><span>Associados</span></a></li>
                        @endif
                        <li id="menu-item-95" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-95" aria-haspopup="true"><a href="https://arqueologia.lampeh.ufv.br/servicos/"><span>Serviços</span><svg class="si-icon" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><path d="M24.958 10.483c-0.534-0.534-1.335-0.534-1.868 0l-7.074 7.074-7.074-7.074c-0.534-0.534-1.335-0.534-1.868 0s-0.534 1.335 0 1.868l8.008 8.008c0.267 0.267 0.667 0.4 0.934 0.4s0.667-0.133 0.934-0.4l8.008-8.008c0.534-0.534 0.534-1.335 0-1.868z"></path></svg></a>
                            <ul class="sub-menu">
                                <li id="menu-item-136" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-136"><a href="{{route('fontes')}}"><span>Fontes</span></a></li>
                            </ul>
                        </li>
                        <li id="menu-item-174" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-174"><a href="{{route('contact')}}"><span>Contato</span></a></li>
                        <li id="menu-item-172" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-172"><a href="{{route('login')}}"><span>Login</span></a></li>
                    </ul></nav><!-- END .sinatra-nav -->
                <span class="si-header-element si-mobile-nav">
				<button class="si-hamburger hamburger--spin si-hamburger-sinatra-primary-nav" aria-label="Menu" aria-controls="sinatra-primary-nav" type="button">


			<span class="hamburger-box">
				<span class="hamburger-inner"></span>
			</span>

		</button>
			</span>

            </div><!-- END .si-container -->
        </div><!-- END #sinatra-header-inner -->
    </div><!-- END #sinatra-header -->
</header><!-- #masthead .site-header -->
