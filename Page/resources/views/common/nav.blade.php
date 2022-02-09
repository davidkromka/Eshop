<?php
use App\Models\FirstLevelCategory;
use App\Models\SecondLevelCategory;
use App\Models\ThirdLevelCategory;
use App\Models\Brand;
?>

<nav class="navbar navbar-expand-md navbar-dark" id="categories">
    <!--make menu button if screen smaller than lg-->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".collapse" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbar-content2">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class='nav-title' href="#">Akcia</a>
            </li>
            <li class="nav-item">
                <a class='nav-title' href="#">Novinky</a>
            </li>
            <li class="nav-item dropdown">
                <a data-target="{{ url('brands') }}" class="ndropdown-toggle nav-title" href="{{ url('brands') }}" id="brands" aria-haspopup="true" aria-expanded="false">
                    Značky
                </a>
                <div class="brand dropdown-menu pre-scrollable" aria-labelledby="brands">
                    <?php $brands = Brand::orderby('name')->get() ?>
                    @foreach($brands as $brand)
                        <a href="{{ url('brands', $brand->id ) }}">{{$brand->name}}</a>
                    @endforeach
                </div>
            </li>
            <?php
                $firstLevelCategories = FirstLevelCategory::all();
                foreach($firstLevelCategories as $cat1)
                {
                    echo '<li class="nav-item dropdown">';
                    echo '<a data-target="';
                    echo url("categories", '1-'.$cat1->id );
                    echo '" class="ndropdown-toggle nav-title" href="';
                    echo url("categories", '1-'.$cat1->id );
                    echo '" id="';
                    echo $cat1->name;
                    echo '" aria-haspopup="true" aria-expanded="false">';
                    echo $cat1->name;
                    echo '</a>';
                    echo '<div class="dropdown-menu dropdown-multicolumn p-0" aria-labelledby="';
                    echo $cat1->name;
                    echo '">';

                    $secondLevelCategories = SecondLevelCategory::where('1st_level_category_id', $cat1->id)->get();
                    foreach($secondLevelCategories as $cat2)
                    {
                        echo '<div class="dropdown-col">';
                        echo '<a href="';
                        echo url("categories", '2-'.$cat2->id );
                        echo '" class="dropdown-item category-title">';
                        echo $cat2->name;
                        echo '</a>';


                        $thirdLevelCategories = ThirdLevelCategory::where('2nd_level_category_id', $cat2->id)->get();
                        foreach ($thirdLevelCategories as $cat3)
                        {
                            echo '<a href="';
                            echo url("categories", '3-'.$cat3->id );
                            echo '" class="dropdown-item category-item">';
                            echo $cat3->name;
                            echo '</a>';
                        }
                        echo '</div>';
                    }
                    echo '</div>';
                    echo '</li>';
                }
            ?>
        </ul>
    </div>
</nav>
