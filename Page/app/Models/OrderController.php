<?php

namespace App\Http\Controllers;

use App\Models\OrderContent;
use App\Models\ProductVariant;
use App\Models\Shopping_cart;
use App\Models\Shopping_cart_content;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        if (Auth::check())
        {
            $userId = auth()->user()->id;

            $cart = Shopping_cart::where("user_id", $userId)->first();

            Shopping_cart_content::where("shopping_cart_id", $cart->id)->delete();

            $cart->delete();
        }
        else
        {
            $userId = NULL;
            $request->session()->put('content', []);
            $request->session()->put('count', []);
        }

        $data = $request->all();
        //var_dump($data);
        $Order = new Order;

        $Order->user_id = $userId;

        $Order->delivery_option_id = $data['Delivery'];
        $Order->payment_option_id  = $data['Payment'];

        $Order->first_name = $data['personalInfoFirstName'];
        $Order->last_name  = $data['personalInfoLastName'];

        $Order->phone_number = $data['personalInfoPhone'];
        $Order->email        = $data['personalInfoEmail'];

        $Order->delivery_address = $data['deliveryAddress'];
        $Order->billing_address  = $data['billingAddress'];

        $Order->setCreatedAt(now());
        $Order->setUpdatedAt(now());

        $Order->save();

        foreach (array_keys($data) as $key)
            if (str_contains($key, "productCount"))
            {
                $variantId = explode("_", $key)[1];

                $content = new OrderContent();
                $content->order_id = $Order->id;
                $content->product_variant_id = $variantId;
                $content->product_count = $data[$key];
                $content->product_price = $data[str_replace('Count', 'Price', $key)];
                $content->timestamps = false;
                $content->save();

                $variant = ProductVariant::find($variantId);
                $variant->stock = $variant->stock -1;
                $variant->timestamps = false;
                $variant->save();

            }

        return redirect('/');
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
