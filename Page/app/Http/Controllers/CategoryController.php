<?php

namespace App\Http\Controllers;

use App\Models\Product;
use ErrorException;
use Illuminate\Http\Request;
use App\Models\FirstLevelCategory;
use App\Models\SecondLevelCategory;
use App\Models\ThirdLevelCategory;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Material;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;
use League\Flysystem\Exception;

class CategoryController extends Controller
{
    private function sizeCompare($size1, $size2)
    {
        if (is_numeric($size1) and is_numeric($size2))
        {
            if ($size1 == $size2) return 0;
            if ($size1 > $size2)  return -1;
            if ($size1 < $size2)  return 1;
        }

        if ( str_contains($size1, 'S') and !str_contains($size2, 'S')) return 1;
        if (!str_contains($size1, 'S') and  str_contains($size2, 'S')) return -1;

        if ( str_contains($size1, 'L') and !str_contains($size2, 'L')) return -1;
        if (!str_contains($size1, 'L') and  str_contains($size2, 'L')) return 1;

        if ( str_contains($size1, 'M') and  str_contains($size2, 'M')) return 0;

        if ( str_contains($size1, 'S') and  str_contains($size2, 'S'))
        {
            $xcount1 = substr_count($size1, 'X');
            $xcount2 = substr_count($size2, 'X');
            if ($xcount1 == $xcount2) return 0;
            if ($xcount1 > $xcount2)  return 1;
            if ($xcount1 < $xcount2)  return -1;

        }
        if ( str_contains($size1, 'L') and  str_contains($size2, 'L'))
        {
            $xcount1 = substr_count($size1, 'X');
            $xcount2 = substr_count($size2, 'X');
            if ($xcount1 == $xcount2) return 0;
            if ($xcount1 > $xcount2)  return -1;
            if ($xcount1 < $xcount2)  return 1;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $categoryName
     * @return \Illuminate\Http\Response
     */
    public function show($categoryName)
    {
        $categoryLevel = (int)explode("-", $categoryName)[0];
        $categoryId    = (int)explode("-", $categoryName)[1];

        /*
        $category1 = FirstLevelCategory:: where('name', $categoryName)->get();
        $category2 = SecondLevelCategory::where('name', $categoryName)->get();
        $category3 = ThirdLevelCategory:: where('name', $categoryName)->get();
        */
        switch ($categoryLevel) {
            case 1:
                $products = Product::join('3rd_level_categories', 'products.3rd_level_category_id', '=', '3rd_level_categories.id')
                                   ->join('2nd_level_categories', '3rd_level_categories.2nd_level_category_id', '=', '2nd_level_categories.id')
                                   ->join('1st_level_categories', '2nd_level_categories.1st_level_category_id', '=', '1st_level_categories.id')
                                   ->where('1st_level_categories.id', '=', $categoryId);
                $chosenCategory = FirstLevelCategory::find($categoryId);
                break;
            case 2:
                $products = Product::join('3rd_level_categories', 'products.3rd_level_category_id', '=', '3rd_level_categories.id')
                                   ->join('2nd_level_categories', '3rd_level_categories.2nd_level_category_id', '=', '2nd_level_categories.id')
                                   ->where('2nd_level_categories.id', '=', $categoryId);
                $chosenCategory = SecondLevelCategory::find($categoryId);
                break;
            case 3:
                $products = Product::join('3rd_level_categories', 'products.3rd_level_category_id', '=', '3rd_level_categories.id')
                                   ->where('3rd_level_categories.id', '=', $categoryId);
                $chosenCategory = ThirdLevelCategory::find($categoryId);
                break;
        }

        $filteredSizes = array();
        $filteredBrands = array();
        $filteredColors = array();
        $filteredMaterials = array();

        $lte = 1000;
        $gte = 0;
        $sort = 'az';
        try {
            $queryString = explode('?', explode('/', url()->full())[4])[1];//parse_url(url()->full(), PHP_URL_QUERY);

            foreach (explode('&', $queryString) as $parameter) {
                $key = explode('=', $parameter)[0];
                $value = explode('=', $parameter)[1];

                if (str_contains($key, 'size'))
                    $filteredSizes[$key] = $value;
                if (str_contains($key, 'brand'))
                    $filteredBrands[$key] = $value;
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

            if (sizeof($filteredBrands) != 0)
                $products = $products->whereIn('products.id', function ($query) use ($filteredBrands) {
                    $query->select('product_brand.product_id')
                        ->from('product_brand')
                        ->join('brands', 'product_brand.brand_id', '=', 'brands.id')
                        ->whereIn('brands.name', $filteredBrands)
                        ->get();
                });

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

            switch ($sort)
            {
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
        catch (ErrorException $ex)
        {
            $products = $products->orderBy('products.name');
        }

        $products = $products->select('products.*');

        error_log($products->toSql());
        $products = $products->paginate(2);

        $categories = array();//[][][] = "000";
        $firstLevelCategories = FirstLevelCategory::all();//orderBy('name')->get();

        for ($i = 0; $i < sizeof($firstLevelCategories); $i++) {
            if ($categoryLevel == 1 and $categoryId == $firstLevelCategories[$i]->id) $superCategory = $firstLevelCategories[$i];
            $x = $firstLevelCategories[$i]->id."-".$firstLevelCategories[$i]->name;
            $categories[$x] = array();
            $secondLevelCategories = SecondLevelCategory::where('1st_level_category_id', $firstLevelCategories[$i]->id)->orderBy('name')->get();

            for ($j = 0; $j < sizeof($secondLevelCategories); $j++) {
                if ($categoryLevel == 2 and $categoryId == $secondLevelCategories[$j]->id) $superCategory = $firstLevelCategories[$i];
                $y = $secondLevelCategories[$j]->id."-".$secondLevelCategories[$j]->name;
                $categories[$x][$y] = array();
                $thirdLevelCategories = ThirdLevelCategory::where('2nd_level_category_id', $secondLevelCategories[$j]->id)->orderBy('name')->get();

                for ($k = 0; $k < sizeof($thirdLevelCategories); $k++) {
                    if ($categoryLevel == 3 and $categoryId == $thirdLevelCategories[$k]->id) $superCategory = $firstLevelCategories[$i];
                    $categories[$x][$y][$k] = $thirdLevelCategories[$k]->id."-".$thirdLevelCategories[$k]->name;
                }
            }
        }

        $colors    = Color::orderBy('name')->get();
        $brands    = Brand::orderBy('name')->get();
        $materials = Material::orderBy('name')->get();
        switch($superCategory->name)
        {
            case 'Oblečenie':
                $sizes = ['XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL'];
                break;
            case 'Obuv':
                $sizes = ['35', '36', '37', '38', '39', '40', '41', '42', '43', '44', '45'];
                break;
            default:
                $sizes = ['onesize'];
                break;
        }

        return view('category')->with(['products'=>$products,
            'chosenCategory'=>$chosenCategory->name,
            'sizes'=>(array)$sizes,
            'brands'=>$brands,
            'materials'=>$materials,
            'colors'=>$colors,
            'categories'=>(object)['superCategory' => $superCategory,
                'subCategories' => $categories[$superCategory->id."-".$superCategory->name]],
            'filters'=>(object)['sizes'     => array_values($filteredSizes),
                'brands'    => array_values($filteredBrands),
                'colors'    => array_values($filteredColors),
                'materials' => array_values($filteredMaterials),
                'gte'       => $gte,
                'lte'       => $lte,
                'sort'      => $sort]]);
    }

    public function search(Request $request) {
        $search = $request->get('search');
        $products = Product::where('name', 'like', '%'.$search.'%')
            ->orWhere('description', 'like', '%'.$search.'%')
            ->get();
        $count = $products->count();
        return view('search')->with(['products' => $products,
        'count' => $count,
            'search' => $search]);
    }
}
