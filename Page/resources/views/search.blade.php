@extends('layouts.app')

@section('title', 'Nájdené')

@section('scripts')

@endsection

@section('main')
    <h4 class="m-3">Počet výsledkov pre hľadanie "{{$search}}": {{$count}}.</h4>
    <div class="row">
        <!--Product -->
        @foreach($products as $product)
            <div class="product col-sm-12 col-md-6 col-lg-3 col-xl-2 m-5">
                <a href="/products/{{ $product->id }}" class="single-product">
                    <div class="wish-icon">
                        <img class="product-img w-100" src="{{ asset('images/'.$product->src_image) }}" alt="Klobuk">
                        <button class="btn"><img src="{{ asset('images/bookmark.svg') }}" alt="bookmark" width="35" height="35"></button>
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
@endsection
