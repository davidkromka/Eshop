@extends('layouts.app')

@section('title', 'Product add')

@section('scripts')

@endsection

@section('main')
    <main class="container-fluid">
        <form action="{{url('admin', $id)}}" method="post">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="product" value="{{$id}}">
            {{ csrf_field() }}
            <input type="submit" class="btn btn-danger m-1" value="Odobrať"/>
        </form>
        <form action="{{url('admin/update')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row m-2">
                <div class="dropdown mr-3 mb-2">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Značka
                    </button>
                    <div class="dropdown-menu pre-scrollable" aria-labelledby="dropdownMenuButton">
                        @foreach($brands as $brand)
                            <div class="dropdown-item m-0">
                                <input type="radio" id={{$brand->id}} name="brand" value={{$brand->id}}>
                                <label for={{$brand->id}}>{{$brand->name}}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="dropdown mr-3 mb-2">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Kategória
                    </button>
                    <div class="dropdown-menu pre-scrollable" aria-labelledby="dropdownMenuButton">
                        @foreach($categories as $category)
                            <div class="dropdown-item m-0">
                                <input type="radio" id={{$category->id}} name="category" value={{$category->third_id}}>
                                <label for={{$category->id}}>{{$category->first_name}}
                                    ->{{$category->second_name}}->{{$category->third_name}}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="dropdown mr-3 mb-2">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Kolekcia
                    </button>
                    <div class="dropdown-menu pre-scrollable" aria-labelledby="dropdownMenuButton">
                        @foreach($collections as $collection)
                            <div class="dropdown-item m-0">
                                <input type="radio" id={{$collection->id}} name="collection" value={{$collection->id}}>
                                <label for={{$collection->id}}>{{$collection->name}}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="dropdown mr-3 mb-2">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Pohlavie
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <div class="dropdown-item m-0">
                            <input type="radio" id='m' name="sex" value='m'>
                            <label for='m'>muž</label>
                        </div>
                        <div class="dropdown-item m-0">
                            <input type="radio" id='f' name="sex" value='f'>
                            <label for='f'>žena</label>
                        </div>
                        <div class="dropdown-item m-0">
                            <input type="radio" id='k' name="sex" value='k'>
                            <label for='k'>dieťa</label>
                        </div>
                        <div class="dropdown-item m-0">
                            <input type="radio" id='u' name="sex" value='u'>
                            <label for='u'>univerzálna</label>
                        </div>
                    </div>
                </div>
            </div>
            <label for="file">Zmeň obrázok</label>
            <input type="file" name="file" id="file"/>
            <label for="file">Pridaj obrázky</label>
            <input type="file" name="images[]" id="images" multiple>
            <br>
            <label for="name">Zmeň meno</label>
            <input type="text" name="name" id="name">
            <label for='price'>Zmeň cenu</label>
            <input type="number" name="price" id="price" min="0" max="10000" step="0.01" value="0">
            <label for="textarea">Zmeň opis</label>
            <textarea name="description" id="textarea"></textarea>
            <br>
            <input type="hidden" id="id" name="id" value="{{$id}}">
            <div class="product col-sm-12 col-md-6 col-lg-4 col-xl-3">
                <h2>Hlavný obrázok</h2>
                <img class="product-img w-100" src="{{ asset('images/'.$product_image->src_image) }}" alt="Produkt">
            </div>
            <h2>Ďaľšie obrázky</h2>
            @foreach($images as $image)
                <div class="product col-sm-12 col-md-6 col-lg-4 col-xl-3">
                    <img class="product-img w-100" src="{{ asset('images/'.$image->src_image) }}" alt="Produkt">
                    <input type="checkbox" id="{{$image->id}}" value="{{$image->id}}" name="remove[]">
                    <label for="remove">Odstrániť</label>
                </div>
            @endforeach
            <button type='submit' class="btn btn-primary ml-3" id="add_product">Upraviť</button>
        </form>
        <form action="{{url('admin/removeVariant')}}" method="post">
            @csrf
            <h1>Varianty</h1>
            @foreach($variants as $variant)
                <div class="row m-3">
                    <p class="mx-2">Farba: {{$variant->name}} </p>
                    <p class="mx-2">Veľkosť: {{$variant->size}} </p>
                    <p class="mx-2">Počet kusov: {{$variant->stock}} </p>
                    <input type="hidden" name="id" value="{{$variant->variant_id}}">
                    <input type="submit" class="btn btn-danger m-1" value="Odobrať"/>
                </div>
            @endforeach

        </form>
        <form action="{{url('admin/variant')}}" method="post">
            @csrf
            <h1 class="mt-3">Nový variant</h1>
            <label for="size">Veľkosť</label>
            <input type="text" name="size" id="size">
            <label for='count'>Počet</label>
            <input type="number" name="count" id="count" min="0" max="10000" step="1" value="10">
            <input type="hidden" name="id" id="id" value="{{$id}}">
            <div class="row">
                <div class="dropdown m-3">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Farba
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        @foreach($colors as $color)
                            <div class="dropdown-item m-0">
                                <input type="radio" id={{$color->id}} name="color" value={{$color->id}}>
                                <label for={{$color->id}}>{{$color->name}}</label>
                            </div>
                        @endforeach
                    </div>
            </div>
            </div>
            <button type='submit' class="btn btn-primary m-3" id="add_product">Uložiť</button>
        </form>
    </main>
@endsection
