@extends('layouts.app')

@section('title', 'Admin')

@section('scripts')
    <link rel="stylesheet" href="{{ asset('css/admin_style.css') }}">
@endsection

@section('main')

    <a class='settings-title m-3' href="admin/add">Pridať produkt</a>
    <section class="col-xl-10 col-lg-9 col-md-8">
        <div class="row">
            <!--Product -->
            @foreach($products as $product)
                <div class="product col-sm-12 col-md-6 col-lg-3 col-xl-2 m-5">
                    <a href="/admin/{{ $product->id }}" class="single-product">
                        <div class="wish-icon">
                            <img class="product-img w-100" src="{{ asset('images/'.$product->src_image) }}" alt="Klobuk">
                        </div>
                        <div class="product-info">
                            <h3 class="product-title">{{$product->name}}</h3>
                        <!-- <h4 class="product-old-price">{{$product->price}} €</h4> -->
                            <h4 class="product-price">{{$product->price}} €</h4>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </section>
@endsection
