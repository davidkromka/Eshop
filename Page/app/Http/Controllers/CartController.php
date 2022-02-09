<?php

namespace App\Http\Controllers;

use App\Models\DeliveryOption;
use App\Models\PaymentOption;
use App\Models\Shopping_cart_content;
use Illuminate\Http\Request;
use App\Models\Shopping_cart;
use App\Models\Product;
use App\Models\Country;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()) {
            //Shopping_cart_content::where('shopping_cart_id', 10)->delete();
            $products = [];
            $content = Shopping_cart::join('shopping_carts_content', 'shopping_carts.id', '=', 'shopping_carts_content.shopping_cart_id')
                                    ->join('product_variants', 'shopping_carts_content.product_variant_id', '=', 'product_variants.id')
                                    ->join('colors', 'product_variants.color_id', '=', 'colors.id')
                                    ->where('user_id', auth()->user()->id)->get();
            $price = 0;
            foreach ($content as $item) {
                $product = Product::where('id', $item->product_id)->first();
                array_push($products, [$product, $item->product_count, $item->name, $item->size, $item->product_variant_id]);
                $product_price = $product->price * $item->product_count;
                $price = $price + $product_price;
            }
            $tax_free = round($price*(1/1.2), 2);
        }
        else {
            $products = [];
            $colors = [];
            $sizes = [];
            $price = 0;
            $data = session('content');
            $count = session('count');
            if(!is_null($count)) {
                $size = count($data);

                for ($i = 0; $i < $size; $i++) {
                    $product = Product::where('id', $data[$i][0])->first();
                    array_push($products, [$product, $count[$i], $data[$i][1], $data[$i][2], $data[$i][3]]);
                    $product_price = $product->price * $count[$i];
                    $price = $price + $product_price;
                }
            }
            $tax_free = round($price*(1/1.2), 2);
        }
        return view('shoppingCart.cart')->with(['products' => $products,
            'price' => $price,
            'tax_free' => $tax_free,
            'countries' => Country::all(),
            'deliveryOptions' => DeliveryOption::all(),
            'paymentOptions' => PaymentOption::all()]);
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
        //
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
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Product $task)
    {
        if (Auth::check()) {
            $shoppingCart = Shopping_cart::where('user_id', auth()->user()->id)->first();
            $product = Shopping_cart_content::where('product_variant_id', $request->product)
                                            ->where('shopping_cart_id', $shoppingCart->id);
            $product->delete();
        }
        else {
            $key = array_search([$request->product], session('content'));
            $data = session('content');
            $count = session('count');
            unset($data[$key]);
            unset($count[$key]);
            $data=array_values($data);
            $count=array_values($count);
            $request->session()->put('count', $count);
            $request->session()->put('content', $data);
        }
        return redirect('cart');
    }

    public function changeCount(Request $request)
    {
        if (Auth::check()) {
            $count = $request->get('count');
            error_log($count);
            $id = $request->get('id');
            $shoppingCart = Shopping_cart::where('user_id', auth()->user()->id)->first();
            Shopping_cart_content::where('product_variant_id', $id)
                                 ->where('shopping_cart_id', $shoppingCart->id)
                                 ->update(['product_count' => $count]);
        }
        else {
            $key = array_search([$request->product], session('content'));
            $count = session('count');
            $count[$key] = $request->get('count');
            $request->session()->put('count', $count);
        }
        return redirect('cart');
    }
}

