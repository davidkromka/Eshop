<?php $url = explode('/', Illuminate\Support\Facades\Request::fullUrl())[3]; ?>

@extends('layouts.app')

@section('title', 'Brands')

@section('scripts')
    <link rel="stylesheet" href="{{ asset('css/products_style.css') }}">

    <script>
        $(document).ready(() => {
            Array.from(document.getElementsByClassName("page-link")).forEach(link => {
                if (link.href != "")
                    link.href = link.href + "&sort={{ $filters->sort }}" +
                        "&price_gte={{ $filters->gte }}" +
                        "&price_lte={{ $filters->lte }}"
                        @for($i = 0; $i < sizeof($filters->materials); $i++)
                        + "&material_{{ $i + 1 }}={{ $filters->materials[$i] }}"
                        @endfor
                        @for($i = 0; $i < sizeof($filters->sizes); $i++)
                        + "&size_{{ $i + 1 }}={{ $filters->sizes[$i] }}"
                        @endfor
                        @for($i = 0; $i < sizeof($filters->colors); $i++)
                        + "&color_{{ $i + 1 }}={{ $filters->colors[$i] }}"
                @endfor
            });
        });
    </script>

@endsection

@section('main')
    <main class="wrapper">
        <div class="container-fluid m-0 mt-5">
            <div class="row">
                <!--sidebar-->
                <aside class="d-none d-md-block col-xl-2 col-lg-3 col-md-4">
                    <div class="sidebar">
                        <a href="#" class="sidebar-title"><h5>Značky</h5></a>
                        <ul class="sidebar-items">
                            @foreach($brandsList as $brand)
                                <li><a class="item" href="{{ url('brands', $brand->id ) }}">{{ $brand->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </aside>
                <!--brands-->
                <section class="col-xl-10 col-lg-9 col-md-8">
                    <h1>{{$name}}</h1>
                    <!--filters-->
                    <form class="filter m-3" action="{{url($url)}}" method="get" >
                        <div class="row">
                            <div class="dropdown mr-3 mb-2">
                                <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Zoradiť
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <div class="dropdown-item m-0">
                                        <input type="radio" id="sort_lp" name="sort" value="lp"
                                        @if ($filters->sort == 'lp')  <?php echo "checked='checked'";?> @endif>
                                        <label for="sort_lp">Od najlacnejších</label>
                                    </div>
                                    <div class="dropdown-item m-0">
                                        <input type="radio" id="sort_hp" name="sort" value="hp"
                                        @if ($filters->sort == 'hp')  <?php echo "checked='checked'";?> @endif>
                                        <label for="sort_hp">Od najdrahších</label>
                                    </div>
                                    <div class="dropdown-item m-0">
                                        <input type="radio" id="sort_az" name="sort" value="az"
                                        @if ($filters->sort == 'az')  <?php echo "checked='checked'";?> @endif>
                                        <label for="sort_az">A - Z</label>
                                    </div>
                                    <div class="dropdown-item m-0">
                                        <input type="radio" id="sort_za" name="sort" value="za"
                                        @if ($filters->sort == 'za')  <?php echo "checked='checked'";?> @endif>
                                        <label for="sort_za">Z - A</label>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown mr-3 mb-2">
                                <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Cena
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <div class="ml-3">
                                        <label for="lowest-price">Najnižšia cena v €</label>
                                        <input id="lowest-price" type="number" value="{{$filters->gte}}" min="0" max="1000" step="1" name="price_gte" />
                                        <label for="highest-price">Najvyššia cena v €</label>
                                        <input id="highest-price" type="number" value="{{$filters->lte}}" min="0" max="1000" step="1" name="price_lte" />
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown mr-3 mb-2">
                                <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Veľkosť
                                </button>
                                <div class="brand dropdown-menu" aria-labelledby="size-selection">
                                    <div class=" size-list mx-2 pre-scrollable">
                                        <?php $sizesList = ['XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL']; ?>
                                        @for($i = 0; $i < sizeof($sizesList); $i++)
                                            <input type="checkbox"
                                                   id="{{ $sizesList[$i] }}"
                                                   value="{{ $sizesList[$i] }}"
                                                   name="size_{{ $i }}"
                                            @if (in_array($sizesList[$i], (array)$filters->sizes))  <?php echo "checked='checked'";?> @endif>
                                            <label for="{{ $sizesList[$i] }}">{{ strtoupper($sizesList[$i]) }}</label><br>
                                        @endfor
                                        <div class="dropdown-divider"></div>
                                        <?php {$sizesList = ['35', '36', '37', '38', '39', '40', '41', '42', '43', '44', '45'];} ?>
                                        @for($i = 0; $i < sizeof($sizesList); $i++)
                                            <input type="checkbox"
                                                   id="{{ $sizesList[$i] }}"
                                                   value="{{ $sizesList[$i] }}"
                                                   name="size_{{ $i }}"
                                            @if (in_array($sizesList[$i], (array)$filters->sizes))  <?php echo "checked='checked'";?> @endif>
                                            <label for="{{ $sizesList[$i] }}">{{ strtoupper($sizesList[$i]) }}</label><br>
                                        @endfor
                                        <div class="dropdown-divider"></div>
                                        <?php {$sizesList = ['onesize'];} ?>
                                        @for($i = 0; $i < sizeof($sizesList); $i++)
                                            <input type="checkbox"
                                                   id="{{ $sizesList[$i] }}"
                                                   value="{{ $sizesList[$i] }}"
                                                   name="size_{{ $i }}"
                                            @if (in_array($sizesList[$i], (array)$filters->sizes))  <?php echo "checked='checked'";?> @endif>
                                            <label for="{{ $sizesList[$i] }}">{{ strtoupper($sizesList[$i]) }}</label><br>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown mr-3 mb-2">
                                <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Farba
                                </button>
                                <div class="brand dropdown-menu pre-scrollable" aria-labelledby="color-selection">
                                    <div class=" color-list mx-2">
                                        @for($i = 0; $i < sizeof($colorsList); $i++)
                                            <input type="checkbox"
                                                   id="{{ $colorsList[$i]->name }}"
                                                   value="{{ $colorsList[$i]->name }}"
                                                   name="color_{{ $i }}"
                                            @if (in_array($colorsList[$i]->name, (array)$filters->colors))  <?php echo "checked='checked'";?> @endif>
                                            <label for="{{ $colorsList[$i]->name }}">{{ $colorsList[$i]->name }}</label><br>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown mr-3 mb-2">
                                <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Materiál
                                </button>
                                <div class="brand dropdown-menu pre-scrollable" aria-labelledby="color-selection">
                                    <div class=" color-list mx-2">
                                        @for($i = 0; $i < sizeof($materialsList); $i++)
                                            <input type="checkbox"
                                                   id="material {{ $i + 1 }}"
                                                   value="{{ $materialsList[$i]->name }}"
                                                   name="material_{{ $i }}"
                                            @if (in_array($materialsList[$i]->name, (array)$filters->materials))  <?php echo "checked='checked'";?> @endif>
                                            <label for="material {{ $i + 1 }}">{{ $materialsList[$i]->name }}</label><br>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <input type="submit" class="btn btn-secondary ml-3" value="Použiť filtre">
                        </div>
                    </form>
                    <!--all product on the page-->
                    <div class="row">
                        <!--Product -->
                        @foreach($products as $product)
                            <div class="product col-sm-12 col-md-6 col-lg-4 col-xl-3">
                                <a href="/products/{{ $product->id }}" class="single-product">
                                    <div class="wish-icon">
                                        <img class="product-img w-100" src="{{ asset('images/'.$product->src_image) }}" alt="Klobuk">
                                        <button class="btn"><img src="{{ asset('images/bookmark.svg') }}" alt="bookmark" width="35" height="35"></button>
                                    </div>
                                    <div class="product-info">
                                        <h3 class="product-title">{{$product->name}}</h3>
                                        <h4 class="product-old-price"></h4>
                                        <h4 class="product-price">{{$product->price}} €</h4>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </section>
            </div>
        </div>
        <nav class="pager" aria-label="page navigation">
            {{ $products->links() }}
        </nav>
    </main>
@endsection
