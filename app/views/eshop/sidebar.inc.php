<div class="col-sm-3">
    <div class="left-sidebar">
        <h2>Category</h2>
        <div class="panel-group category-products" id="accordian"><!--category-productsr-->

            <?php if (isset($categories)): ?>
                <?php foreach ($categories as $cat):
                    if ($cat->parent > 0) continue;

                    //grab from categories that contains parent
                    $parents = array_column($categories, "parent");
                ?>

                    <!--category with children items-->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a
                                    <?= in_array($cat->id, $parents) ? 'data-toggle="collapse"' : ''; ?>
                                    data-parent="#accordian"
                                    href="<?=
                                            in_array($cat->id, $parents)
                                                ? '#' . $cat->category
                                                : ROOT . 'shop/category/' . $cat->category; ?>">
                                    <?= $cat->category ?>

                                    <?php if (in_array($cat->id, $parents)): ?>
                                        <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                                    <?php endif; ?>
                                </a>
                            </h4>
                        </div>

                        <?php if (in_array($cat->id, $parents)): ?>

                            <div id="<?= $cat->category ?>" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <ul>
                                        <li>
                                            <a href="<?= ROOT . 'shop/category/' . $cat->category; ?>">
                                                All
                                            </a>
                                        </li>
                                        <?php foreach ($categories as $sub_cat): ?>
                                            <?php if ($sub_cat->parent == $cat->id): ?>
                                                <li>
                                                    <a href="<?= ROOT . 'shop/category/' . $sub_cat->category; ?>">
                                                        <?= $sub_cat->category ?>
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>

                        <?php endif; ?>

                    </div>

                <?php endforeach; ?>
            <?php endif; ?>

        </div><!--/category-products-->

        <!-- search start -->
        <h2>Advanced Search</h2>
        <form method="GET">
            <table class="search-table table">
                <tr>
                    <td colspan="5">
                        <input type="text" placeholder="Type product name.." class="form-control"
                            name="description" value="<?php Search::get_sticky('textbox', 'description') ?>">
                    </td>
                </tr>

                <tr>
                    <td colspan="5">
                        <select class="form-control" name="category">
                            <option value="--Choose--">--Choose--</option>
                            <?php Search::get_categories('category') ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td colspan="5">
                        <div><b>Brands:</b></div>
                        <?php Search::get_brands() ?>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div><b>Price range:</b></div>
                        <div class="well price-range">
                            <input type="text" class="span2" value="" data-slider-min="0" data-slider-max="1000" data-slider-step="5" data-slider-value="[50,950]" id="sl2"><br />
                            <b>$ 0</b> <b class="pull-right">$ 1000</b>
                        </div>

                        <input type="hidden" step="0.01" class="form-control min-price" name="min-price"
                            value="<?php Search::get_sticky('number', 'min-price') ?>">
                        <input type="hidden" step="0.01" class="form-control max-price" name="max-price"
                            value="<?php Search::get_sticky('number', 'max-price') ?>">
                    </td>
                </tr>

                <tr>
                    <td>
                        <div><b>Quantity:</b></div>

                        <label for="">Min</label>
                        <input type="number" step="0.01" class="form-control" name="min-qty"
                            value="<?php Search::get_sticky('number', 'min-qty') ?>">

                        <label for="">Max</label>
                        <input type="number" step="0.01" class="form-control" name="max-qty"
                            value="<?php Search::get_sticky('number', 'max-qty') ?>">
                    </td>
                </tr>

                <tr>
                    <td>
                        <div><b>Year:</b></div>

                        <select class="form-control" name="year">
                            <option value="--Choose--">--Choose--</option>
                            <?php Search::get_years('year') ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td colspan="4">
                        <input type="submit" value="Search" class="btn btn-success" name="search">
                    </td>
                </tr>
            </table>
        </form>
        <!-- search end -->

        <div class="shipping text-center"><!--shipping-->
            <img src="<?= ASSETS . THEME ?>images/home/shipping.jpg" alt="" />
        </div><!--/shipping-->
    </div>
</div>

<script>
    var price_range = document.querySelector(".price-range");
    price_range.addEventListener("mousemove", change_price_range);

    function change_price_range(e) {
        var tooltip = e.currentTarget.querySelector(".tooltip-inner");
        var min_price = document.querySelector(".min-price");
        var max_price = document.querySelector(".max-price");

        var values = tooltip.innerHTML;
        var parts = values.split(":");

        min_price.value = parts[0].trim();
        max_price.value = parts[1].trim();

    }

    function exit_price_range(e) {

    }
</script>