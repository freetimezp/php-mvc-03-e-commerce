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
                                <a data-toggle="collapse" data-parent="#accordian" href="#<?= $cat->category ?>">
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
                                        <?php foreach ($categories as $sub_cat): ?>
                                            <?php if ($sub_cat->parent == $cat->id): ?>
                                                <li>
                                                    <a href="#">
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

        <div class="shipping text-center"><!--shipping-->
            <img src="<?= ASSETS . THEME ?>images/home/shipping.jpg" alt="" />
        </div><!--/shipping-->
    </div>
</div>