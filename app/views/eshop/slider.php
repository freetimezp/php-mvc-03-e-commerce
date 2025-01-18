<section id="slider"><!--slider-->
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div id="slider-carousel" class="carousel slide" data-ride="carousel">

                    <?php if (isset($slider_rows) && is_array($slider_rows)): ?>
                        <ol class="carousel-indicators">
                            <?php foreach ($slider_rows as $key => $row): ?>
                                <li data-target="#slider-carousel"
                                    data-slide-to="<?= $key ?>"
                                    class="<?= $key == 0 ? 'active' : ''; ?>">
                                </li>
                            <?php endforeach; ?>
                        </ol>

                        <?php $num = 0; ?>

                        <div class="carousel-inner">
                            <?php foreach ($slider_rows as $row): $num++; ?>
                                <div class="item <?= $num == 1 ? 'active' : ''; ?>">
                                    <div class="col-sm-6">
                                        <h1>
                                            <span><?= substr($row->header_text_1, 0, 1) ?></span>
                                            <?= substr($row->header_text_1, 1) ?>
                                        </h1>
                                        <h2><?= $row->header_text_2 ?></h2>
                                        <p><?= $row->text ?></p>
                                        <a href="<?= $row->link ?>">
                                            <button type="button" class="btn btn-default get">Get it now</button>
                                        </a>
                                    </div>
                                    <div class="col-sm-6">
                                        <img src="<?= ROOT . $row->image ?>" alt=""
                                            style="border-radius: 50%;"
                                            class="girl img-responsive" />
                                        <img src="<?= ASSETS . THEME ?>images/home/pricing.png" class="pricing" alt="" />
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                            <i class="fa fa-angle-left"></i>
                        </a>
                        <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
</section><!--/slider-->