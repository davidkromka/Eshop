<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\ProductVariant;
use ErrorException;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Product;

class BrandsController extends Controller
{
    private function filter($products)
    {

        $filteredSizes = array();
        $filteredColors = array();
        $filteredMaterials = array();

        $lte = 1000;
        $gte = 0;
        $sort = 'az';
        try {
            $length = sizeof(explode('/', url()->full()));
            $queryString = explode('?', explode('/', url()->full())[$length-1])[1];//parse_url(url()->full(), PHP_URL_QUERY);

            foreach (explode('&', $queryString) as $parameter) {
                $key = explode('=', $parameter)[0];
                $value = explode('=', $parameter)[1];

                if (str_contains($key, 'size'))
                    $filteredSizes[$key] = $value;
                if (str_contains($key, 'color'))
                    $filteredColors[$key] = $value;
                if (str_contains($key, 'material'))
                    $filteredMaterials[$key] = $value;

                if ($key == 'price_gte')
                    $gte = $value;
                if ($key == 'price_lte')
                    $lte = $value;

                if ($key == 'sort')
                    $sort = $value;
            }

            if (sizeof($filteredMaterials) != 0)
                $products = $products->whereIn('products.id', function ($query) use ($filteredMaterials) {
                    $query->select('product_material.product_id')
                        ->from('product_material')
                        ->join('materials', 'product_material.material_id', '=', 'materials.id')
                        ->whereIn('materials.name', $filteredMaterials)
                        ->get();
                });

            if (sizeof($filteredColors) != 0 or sizeof($filteredSizes) != 0)
                $products = $products->whereIn('products.id', function ($query) use ($filteredColors, $filteredSizes) {
                    $query->select('product_variants.product_id')
                        ->from('product_variants');
                    if (sizeof($filteredColors) != 0)
                        $query->join('colors', 'product_variants.color_id', '=', 'colors.id')
                            ->whereIn('colors.name', $filteredColors);
                    if (sizeof($filteredSizes) != 0)
                        $query->whereIn('product_variants.size', $filteredSizes);

                    $query->get();
                });

            $products = $products->where('products.price', '>=', $gte)
                ->where('products.price', '<=', $lte);

            switch ($sort) {
                case 'az':
                    $products = $products->orderBy('products.name');
                    break;
                case 'za':
                    $products = $products->orderByDesc('products.name');
                    break;
                case 'lp':
                    $products = $products->orderBy('products.price');
                    break;
                case 'hp':
                    $products = $products->orderByDesc('products.price');
                    break;
            }

        }
        catch(ErrorException $ex)
        {
            $products = $products->orderBy('products.name');
        }

        return (object)['products'  => $products->select('products.*')->paginate(2),
            'sizes'     => array_values($filteredSizes),
            'colors'    => array_values($filteredColors),
            'materials' => array_values($filteredMaterials),
            'gte'       => $gte,
            'lte'       => $lte,
            'sort'      => $sort];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::where('id', '>', 0);

        $filtered = $this->filter($products);
        $products = $filtered->products;
        //unset($filtered['products']);


        $brandsList = Brand::orderBy('name')->get();
        $colorsList = Color::orderBy('name')->get();
        /*$sizeList   = ProductVariant::select('size')
            ->whereIn('product_id', array_column($products->items(), 'id'))
            ->get();*/
        $materialsList = Material::orderBy('name')->get();

        $name = 'Značky';

        return view('brands.index')->with(['brandsList'   => $brandsList,
                                                'colorsList'   => $colorsList,
                                                //'sizesList'    => $sizeList,
                                                'materialsList'=> $materialsList,
                                                'name'         => $name,
                                                'products'     => $products,
                                                'filters'      => $filtered]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $products = Product::join('product_brand', 'products.id', '=', 'product_brand.product_id')
            ->where('brand_id', $id);

        $filtered = $this->filter($products);
        $products = $filtered->products;
        //unset($filtered['products']);

        $brandsList = Brand::orderBy('name')->get();
        $colorsList = Color::orderBy('name')->get();
        /*$sizeList   = ProductVariant::select('size')
            ->whereIn('product_id', array_column($products->items(), 'id'))
            ->get();*/
        $materialsList = Material::orderBy('name')->get();

        $name = Brand::select('name')->find($id)->name;



        return view('brands.index')->with(['brandsList'   => $brandsList,
            'colorsList'   => $colorsList,
            //'sizesList'    => $sizeList,
            'materialsList'=> $materialsList,
            'name'         => $name,
            'products'     => $products,
            'filters'      => $filtered]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
