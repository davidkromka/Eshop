<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;
use App\Models\ThirdLevelCategory;
use App\Models\Collection;
use App\Models\Material;
use App\Models\Color;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductImage;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function check_admin() {
        $admins = Admin::all();
        $user = Auth::id();
        if ($admins->contains('user_id', $user)) {
            return true;
        }
        return false;
    }

    public function index()
    {
        if(! $this->check_admin()) {
            return back();
        }
        $products = Product::all();
        return view('admin')->with(['products'    => $products]);
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
        if(! $this->check_admin()) {
            return back();
        }
        foreach ([$request->name, $request->description, $request->category,
                     $request->collection, $request->sex, $request->price, $request->file] as $req) {
            if (is_null($req)) {
                return back()->withErrors("chyba");
            }
        }
        $img = explode(".", $request->file->getClientOriginalName());
        $img_name = md5($img[0]);
        $img_suffix = $img[1];
        $img_name = $img_name.'.'.$img_suffix;
        $request->file->storeAs('images', $img_name, ['disk' => 'img']);

        $product = Product::create(['name' => $request->name, '3rd_level_category_id' => $request->category,
            'collection_id' => $request->collection, 'relevant' => true, 'sex' => $request->sex,
            'description' => $request->description, 'price' => $request->price, 'src_image' => $img_name]);

        foreach ($request->file('images') as $image) {
        $or_name = explode(".", $image->getClientOriginalName());
        $name = md5($or_name[0]);
        $name_suffix = $or_name[1];
        $name = $name . '.' . $name_suffix;
        $image->storeAs('images', $name, ['disk' => 'img']);
        ProductImage::create(['product_id' => $product->id, 'src_image' => $name]);
        }
        return redirect('admin');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(! $this->check_admin()) {
            return back();
        }
        $brands = Brand::all();
        $categories = ThirdLevelCategory::select('3rd_level_categories.name as third_name',
            '3rd_level_categories.id as third_id','2nd_level_categories.name as second_name',
            '1st_level_categories.name as first_name')
            ->join('2nd_level_categories', '3rd_level_categories.2nd_level_category_id', '2nd_level_categories.id')
            ->join('1st_level_categories', '2nd_level_categories.1st_level_category_id', '1st_level_categories.id')->get();
        $collections = Collection::all();
        if($id == 'add') {
            return view('add-product')->with(['brands' => $brands,
                'categories' => $categories,
                'collections' => $collections]);
        }
        else {
            $colors = Color::all();
            $variants = ProductVariant::where('product_id', $id)
                ->select('product_variants.id as variant_id', 'product_variants.*', 'colors.*')
                ->join('colors', 'product_variants.color_id', 'colors.id')->get();
            $images = ProductImage::where('product_id', $id)->get();
            $product_img = Product::where('id', $id)->first();
            return view('edit-product')->with(['id' => $id,
                'brands' => $brands,
                'categories' => $categories,
                'collections' => $collections,
                'colors' => $colors,
                'variants' => $variants,
                'images' => $images,
                'product_image' => $product_img]);
        }
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
        if(! $this->check_admin()) {
            return back();
        }
        $product = Product::where('id', $id)->first();
        $variants = ProductVariant::where('product_id', $id)->get();
        if(file_exists(public_path('images/'. $product->src_image))) {
            unlink(public_path('images/' . $product->src_image));
        }
        foreach ($variants as $variant) {
            $variant->delete();
        }
        $images = ProductImage::where('product_id', $id)->get();
        foreach ($images as $img) {
            if(file_exists(public_path('images/'. $img->src_image))) {
                unlink(public_path('images/' . $img->src_image));
            }
            $img->delete();
        }
        $product->delete();
        return redirect('admin');
    }

    public function createVariant(Request $request) {
        if(! $this->check_admin()) {
            return back();
        }
        ProductVariant::create(['product_id' => $request->id, 'color_id' => $request->color,
            'size' => $request->size, 'stock' => $request->count]);
        return back();
    }

    public function updateProduct(Request $request) {
        if(! $this->check_admin()) {
            return back();
        }
        $product = Product::where('id', $request->id)->first();
        if (!is_null($request->name)){
            $product->name = $request->name;
        }
        if (!is_null($request->description)){
            $product->description = $request->description;
        }
        if (!is_null($request->category)){
            Product::where('id', $request->id)->update(['3rd_level_category_id'=>$request->category]);
        }
        if (!is_null($request->collection)){
            $product->collection_id = $request->collection;
        }
        if (!is_null($request->sex)){
            $product->sex = $request->sex;
        }
        if (!is_null($request->price)){
            $product->price = $request->price;
        }
        if (!is_null($request->file)){
            $img = explode(".", $request->file->getClientOriginalName());
            unlink(public_path('images/'. $product->src_image));
            $img_name = md5($img[0]);
            $img_suffix = $img[1];
            $img_name = $img_name.'.'.$img_suffix;
            $product->src_image = $img_name;
        }
        $product->save();
        if (! is_null($request->file('images'))) {
            foreach ($request->file('images') as $image) {
                $or_name = explode(".", $image->getClientOriginalName());
                $name = md5($or_name[0]);
                $name_suffix = $or_name[1];
                $name = $name . '.' . $name_suffix;
                $image->storeAs('images', $name, ['disk' => 'img']);
                ProductImage::create(['product_id' => $product->id, 'src_image' => $name]);
            }
        }
        if( ! is_null($request->remove) ) {
            $remove = $request->input('remove');
            foreach ($remove as $image) {
                ProductImage::where('id', $image)->delete();
            }
        }
        return redirect('admin/'.$request->id);
    }

    public function removeVariant(Request $request) {
        if(! $this->check_admin()) {
            return back();
        }
        echo $request->id;
        $variant = ProductVariant::where('id', $request->id)->first();
        $variant->delete();
        return back();
    }
}
