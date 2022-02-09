<header class="navbar navbar-expand-sm navbar-dark">
    <div class="collapse navbar-collapse mr-auto" id="navbar-content">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="#">ŽENY</a>
            </li>
            <li class="nav-item">
                <a href="#">MUŽI</a>
            </li>
            <li class="nav-item">
                <a href="#">DETI</a>
            </li>
        </ul>
    </div>
    <!--title-->
    <a class="navbar-brand mx-auto" href="{{ url('/') }}">LOGO</a>
    <!--options bar search, login, bookmark, cart-->
    <ul class="navbar-nav ml-auto">
        <li><a data-toggle="collapse" href="#searchbar" role="button" aria-expanded="false" aria-controls="collapseExample">
                <img src="{{ asset('images/search.svg') }}"
                     alt="Vyhľadávanie produktov a ketogórií." width="35" height="35">
            </a></li>
        <li><div class="collapse collapse-horizontal" id="searchbar">
                <div class="input-group rounded">
                    <form action="/search" method="get">
                        <input class="form-control rounded mr-3" type="search" placeholder="Hľadať"  name="search"/>
                    </form>
                </div>
            </div></li>
        <li class="dropdown">
            <a href="" class="btn p-0 dropdown" data-toggle="modal" data-target="#modal_login_register" id="usr" aria-haspopup="true" aria-expanded="false">
                <img src="{{ asset('images/login.svg') }}"
                     alt="Prihlásenie alebo registrácia" width="35" height="35">
            </a>
            @if (Auth::check())
            <ul class="dropdown-menu" aria-labelledby="usr">
                <li class="mb-2">
                    <a href="#">Objednávky</a>
                </li>
                <li class="mb-2">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <a href="route('logout')"
                                         onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                            {{ __('Odhlásiť sa') }}
                        </a>
                    </form>
                </li>
            </ul>
            @endif
        </li>
        <li><a href="#">
                <img src="{{ asset('images/bookmark.svg') }}"
                     alt="Záložky" width="35" height="35">
            </a></li>
        <li><a href="{{ url('cart') }}">
                <img src="{{ asset('images/shopping_cart.svg') }}"
                     alt="Nákupný košík" width="35" height="35">
            </a></li>
    </ul>
</header>
