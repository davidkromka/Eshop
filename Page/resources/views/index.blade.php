@extends('layouts.app')

@section('title', 'Home')

@section('scripts')
    <link rel="stylesheet" href="{{ asset('css/homepage_style.css') }}">
@endsection

@section('main')
    @if($admin)
        <a class='nav-title' href="{{ url('admin') }}">Nastavenia</a>
    @endif
    <section id="carouselSlide" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselSlide" data-slide-to="0" class="active"></li>
            <li data-target="#carouselSlide" data-slide-to="1"></li>
            <li data-target="#carouselSlide" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner" id="col-slide">
            <a href="#" class="carousel-item active">
                <img class="carousel-img d-block w-100" src="{{ asset('images/sport.jpg') }}" alt="First">
                <div class="carousel-caption">
                    <h5>Športová kolekcia</h5>
                    <p>Teraz za zvýhodnené ceny</p>
                </div>
            </a>
            <a href="#" class="carousel-item">
                <img class="carousel-img d-block w-100" src="{{ asset('images/kabat.jpg') }}" alt="Second">
                <div class="carousel-caption">
                    <h5>Nové trendy</h5>
                    <p>Kabáty</p>
                </div>
            </a>
            <a href="#" class="carousel-item">
                <img class="carousel-img d-block w-100" src="{{ asset('images/jesen.jpg') }}" alt="Kabat">
                <div class="carousel-caption">
                    <h5>Jesenná kolekcia</h5>
                    <p>Všetko pre jesennú vychádzku</p>
                </div>
            </a>
        </div>
        <a class="carousel-control-prev" href="#carouselSlide" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselSlide" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </section>

    <section id="carousel-slide" class="d-none d-sm-block carousel slide" data-ride="carousel">
        <h3 class="mt-5 mx-3">Podobné</h3>
        <ol class="carousel-indicators">
            <li data-target="#carouselSlide" data-slide-to="0" class="active"></li>
            <li data-target="#carouselSlide" data-slide-to="1"></li>
            <li data-target="#carouselSlide" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-2">
                            <a href="#" class="card p-2">
                                <div class="wish-icon">
                                    <img class="product-img w-100" src="{{ asset('images/klobuk.jpg') }}" alt="Klobuk">
                                    <button class="btn"><img src="{{ asset('images/bookmark.svg') }}" alt="bookmark" width="35" height="35"></button>
                                </div>
                                <div class="card-body px-0">
                                    <h5 class="card-title">Čierny Klobúk</h5>
                                    <p class="card-text">5 €</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-2">
                            <a href="#" class="card p-2">
                                <div class="wish-icon">
                                    <img class="product-img w-100" src="{{ asset('images/klobuk.jpg') }}" alt="Klobuk">
                                    <button class="btn"><img src="{{ asset('images/bookmark.svg') }}" alt="bookmark" width="35" height="35"></button>
                                </div>
                                <div class="card-body px-0">
                                    <h5 class="card-title">Čierny Klobúk</h5>
                                    <p class="card-text">5 €</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-2">
                            <a href="#" class="card p-2">
                                <div class="wish-icon">
                                    <img class="product-img w-100" src="{{ asset('images/klobuk.jpg') }}" alt="Klobuk">
                                    <button class="btn"><img src="{{ asset('images/bookmark.svg') }}" alt="bookmark" width="35" height="35"></button>
                                </div>
                                <div class="card-body px-0">
                                    <h5 class="card-title">Čierny Klobúk</h5>
                                    <p class="card-text">5 €</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-2">
                            <a href="#" class="card p-2">
                                <div class="wish-icon">
                                    <img class="product-img w-100" src="{{ asset('images/klobuk.jpg') }}" alt="Klobuk">
                                    <button class="btn"><img src="{{ asset('images/bookmark.svg') }}" alt="bookmark" width="35" height="35"></button>
                                </div>
                                <div class="card-body px-0">
                                    <h5 class="card-title">Čierny Klobúk</h5>
                                    <p class="card-text">5 €</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-2">
                            <a href="#" class="card p-2">
                                <div class="wish-icon">
                                    <img class="product-img w-100" src="{{ asset('images/klobuk.jpg') }}" alt="Klobuk">
                                    <button class="btn"><img src="{{ asset('images/bookmark.svg') }}" alt="bookmark" width="35" height="35"></button>
                                </div>
                                <div class="card-body px-0">
                                    <h5 class="card-title">Čierny Klobúk</h5>
                                    <p class="card-text">5 €</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-2">
                            <a href="#" class="card p-2">
                                <div class="wish-icon">
                                    <img class="product-img w-100" src="{{ asset('images/šaty.jpg') }}" alt="Klobuk">
                                    <button class="btn"><img src="{{ asset('images/bookmark.svg') }}" alt="bookmark" width="35" height="35"></button>
                                </div>
                                <div class="card-body px-0">
                                    <h5 class="card-title">Indické šaty</h5>
                                    <p class="card-text">15 €</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-2">
                            <a href="#" class="card p-2">
                                <div class="wish-icon">
                                    <img class="product-img w-100" src="{{ asset('images/šaty.jpg') }}" alt="Klobuk">
                                    <button class="btn"><img src="{{ asset('images/bookmark.svg') }}" alt="bookmark" width="35" height="35"></button>
                                </div>
                                <div class="card-body px-0">
                                    <h5 class="card-title">Indické šaty</h5>
                                    <p class="card-text">15 €</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-2">
                            <a href="#" class="card p-2">
                                <div class="wish-icon">
                                    <img class="product-img w-100" src="{{ asset('images/šaty.jpg') }}" alt="Klobuk">
                                    <button class="btn"><img src="{{ asset('images/bookmark.svg') }}" alt="bookmark" width="35" height="35"></button>
                                </div>
                                <div class="card-body px-0">
                                    <h5 class="card-title">Indické šaty</h5>
                                    <p class="card-text">15 €</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-2">
                            <a href="#" class="card p-2">
                                <div class="wish-icon">
                                    <img class="product-img w-100" src="{{ asset('images/šaty.jpg') }}" alt="Klobuk">
                                    <button class="btn"><img src="{{ asset('images/bookmark.svg') }}" alt="bookmark" width="35" height="35"></button>
                                </div>
                                <div class="card-body px-0">
                                    <h5 class="card-title">Indické šaty</h5>
                                    <p class="card-text">15 €</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-2">
                            <a href="#" class="card p-2">
                                <div class="wish-icon">
                                    <img class="product-img w-100" src="{{ asset('images/šaty.jpg') }}" alt="Klobuk">
                                    <button class="btn"><img src="{{ asset('images/bookmark.svg') }}" alt="bookmark" width="35" height="35"></button>
                                </div>
                                <div class="card-body px-0">
                                    <h5 class="card-title">Indické šaty</h5>
                                    <p class="card-text">15 €</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carousel-slide" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carousel-slide" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </section>
@endsection
