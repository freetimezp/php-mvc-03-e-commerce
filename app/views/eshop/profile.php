<?php $this->view("header", $data);  ?>


<style>
    .pn {
        height: auto;
    }

    .white-panel .white-header {
        background: #dddddd;
    }

    .white-panel .white-header h5 {
        color: #cc700f;
    }

    .white-panel .small {
        color: #174b73;
        font-size: 16px;
    }

    .white-panel p.name {
        color: #000;
        font-size: 21px;
    }

    .white-panel p.price {
        color: #000;
        font-size: 16px;
    }

    .white-panel p.year {
        color: #000;
        font-size: 16px;
    }
</style>

<section id="main-content">
    <section class="wrapper">
        <div style="min-height: 400px;">
            <div class="col-md-4 mb profile-block">
                <div class="white-panel pn" style="box-shadow: 0 0 20px #aaa; border: solid thin #eee;">
                    <div class="white-header">
                        <h5>TOP USER</h5>
                    </div>
                    <p><img src="<?= ASSETS ?>admin/assets/img/ui-zac.jpg" class="img-circle" width="80"></p>
                    <p class="name">
                        <b><?= ucfirst($data['user_data']->name); ?></b>
                    </p>

                    <div class="row">
                        <div class="col-md-6">
                            <p class="small mt">MEMBER SINCE</p>
                            <p class="year">
                                <?= date("jS M Y", strtotime($data['user_data']->date)); ?>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="small mt">TOTAL SPEND</p>
                            <p class="price">$ 47,60</p>
                        </div>
                    </div>

                    <hr style="opacity: 0.3; width: 90%; margin: 10px auto;">

                    <div class="row">
                        <div class="col-md-6">
                            <p class="small mt" style="color: #d2795a; font-size: 15px; cursor: pointer;">
                                <i class="fa fa-edit" style="color: #d2795a;"></i> EDIT
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="small mt" style="color: red; font-size: 15px; cursor: pointer;">
                                <i class="fa fa-trash"></i> DELETE
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>



<?php $this->view("footer", $data);  ?>