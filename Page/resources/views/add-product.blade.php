@extends('layouts.app')

@section('title', 'Product add')

@section('scripts')

@endsection

@section('main')
    <main class="container-fluid">
        <form class="filter m-3" enctype="multipart/form-data" action="{{url('admin')}}" method="post">
            @csrf
            <div class="row">
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
                                <input type="radio" id={{$category->third_id}} name="category" value={{$category->third_id}}>
                                <label for={{$category->third_id}}>{{$category->first_name}}
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
                <label for="file">Hlavný obrázok</label>
                <input type="file" name="file" id="file">
                <label for="images">Ostatné obrázky</label>
                <input type="file" name="images[]" id="images" multiple>

            </div>
            <label for='price'>Cena</label>
            <input type="number" name="price" id="price" min="0" max="10000" step="0.01" value="0">
            <h5>Opis:</h5>
            <textarea name="description" id="textarea"></textarea>
             <h5>Meno:</h5>
            <input type="text" name="name">
            <button type='submit' class="btn btn-secondary ml-3" id="add_product">Ulož</button>
            @if($errors->any())
                {{ implode('', $errors->all('Chyba: vyplňte všetky údaje.')) }}
            @endif
        </form>
    </main>

@endsection
