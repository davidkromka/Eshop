<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductImage;
use App\Models\ProductMaterial;
use App\Models\ProductVariant;
use App\Models\Color;
use ErrorException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shopping_cart;
use App\Models\Shopping_cart_content;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $colors = ProductVariant::join('colors', 'product_variants.color_id', '=', 'colors.id')
                                ->where('product_variants.product_id', $id)
                                ->select('colors.id','colors.name')
                                ->distinct('colors.name')
                                ->get()->toArray();

        try
        {
            $colorQuery = explode('=', explode('/', url()->full())[4])[1];
            foreach ($colors as $color)
                if ($color['id'] == intval($colorQuery))
                {
                    $selectedColor = $color;
                    break;
                }
        }
        catch (ErrorException $ex)
        {
            $selectedColor = $colors[0];
        }
        finally
        {
            error_log($selectedColor['id']);
            error_log($selectedColor['name']);
            $sizes = ProductVariant::where('product_id', $id)
                                   ->where('color_id', $selectedColor['id'])
                                   ->distinct('size')
                                   ->get()->toArray();
        }

        $product = Product::find($id);

        $brands = ProductBrand::join('brands', 'product_brand.brand_id', '=', 'brands.id')
                              ->where('product_brand.product_id', $id)
                              ->get();
        $materials = ProductMaterial::join('materials', 'product_material.material_id', '=', 'materials.id')
                                    ->where('product_material.product_id', $id)
                                    ->get();

        /*$variants = ProductVariant::join('colors', 'product_variants.color_id', '=', 'colors.id')
                                  ->where('product_variants.product_id', $id)
                                  ->get();*/
        $images = ProductImage::where('product_images.product_id', $id)->orderBy('src_image')->get();

        $cart = session()->get('cart');
        if ($cart == null)
            $cart = [];
        else
            session()->put('cart', 'ahoj');


        //$images = ProductImage::where('product_id', $product->id)->get();

        return view('product')->with(['product'    => $product,
                                           'brands'     => $brands,
                                           'materials'  => $materials,
                                           'images'     => $images,
                                           'cart'       => $cart,
                                           'sizes'      => $sizes,
                                           'availableColors' => $colors,
                                           'selectedColor'   => $selectedColor,]);
    }

    public function store(Request $request)
    {
        $productVariant = ProductVariant::join('colors', 'product_variants.color_id', '=', 'colors.id')
            ->where('product_variants.product_id', $request->id)
            ->where('colors.name', $request->color)
            ->where('product_variants.size', $request->size)
            ->select('product_variants.id')->first();
        if (Auth::check()) {
            $cart = Shopping_cart::where('user_id', auth()->user()->id)->first();
            if (empty($cart)) {
                $cart = Shopping_cart::create(['user_id' => auth()->user()->id, 'last_time_active' => "2011-01-02 00:00:00"]);
            }
            //::join('product_variants', 'shopping_carts_content.product_variant_id', '=', 'product_variants.id')

            $product = Shopping_cart_content::where('shopping_cart_id', $cart->id)
                                            ->where('product_variant_id', $productVariant['id'])->first();

            if (empty($product)) {
                try
                {
                    $Content = new Shopping_cart_content;
                    $Content->shopping_cart_id = $cart->id;
                    $Content->product_variant_id = $productVariant['id'];
                    $Content->product_count = 1;
                    $Content->save();
                    //$x = Shopping_cart_content::create(['shopping_cart_id' => $cart->id, 'product_variant_id' => $x, 'product_count' => 1]);

                }
                catch (\Exception $e)
                {
                    error_log($e->getMessage());
                }
            }
            else {
                Shopping_cart_content::where('id', $product->id)->increment('product_count', 1);
            }
        }
        else {
            $content = $request->session()->get('content');
            if (empty($content)) {
                $request->session()->put('content', []);
                $request->session()->put('count', []);
            }

            if(in_array([$request->id, $request->color, $request->size, $productVariant['id']], session('content'))) {
                $key = array_search([$request->id, $request->color, $request->size, $productVariant['id']], session('content'));
                $arr = session()->get('count');
                $arr[$key] = $arr[$key]+1;
                $request->session()->put('count', $arr);
            }
            else {
                $request->session()->push('content', [$request->id, $request->color, $request->size, $productVariant['id']]);
                $request->session()->push('count', 1);
            }
        }
        return redirect('/');
    }
}
