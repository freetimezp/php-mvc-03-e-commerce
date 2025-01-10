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

    .details {
        background-color: #eee;
        box-shadow: 0px 0px 10px #aaa;
        width: 100%;
        position: absolute;
        min-height: 100px;
        top: 100%;
        left: 0;
        padding: 10px;
        z-index: 10;
    }

    .hide {
        display: none;
    }

    .details span {
        position: absolute;
        top: 10px;
        right: 10px;
        cursor: pointer;
        background-color: #888;
        color: #fff;
        padding: 1px 2px;
        border-radius: 4px;
    }
</style>


<section id="main-content" class="container" style="margin: auto;">
    <section class="wrapper">
        <?php if (isset($profile_data) && is_object($profile_data)): ?>
            <div style="min-height: 400px;">
                <div class="col-md-4 mb profile-block">
                    <div class="white-panel pn" style="box-shadow: 0 0 20px #aaa; border: solid thin #eee;">
                        <div class="white-header">
                            <h5>TOP USER</h5>
                        </div>
                        <p><img src="<?= ASSETS ?>admin/assets/img/ui-zac.jpg" class="img-circle" width="80"></p>
                        <p class="name">
                            <b><?= ucfirst($profile_data->name); ?></b>
                        </p>

                        <div class="row">
                            <div class="col-md-6">
                                <p class="small mt">MEMBER SINCE</p>
                                <p class="year">
                                    <?= date("jS M Y", strtotime($profile_data->date)); ?>
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

                <?php if (isset($orders) && is_array($orders)): ?>
                    <div class="col-md-8" style="box-shadow: 0 0 20px #aaa; border: solid thin #eee;">
                        <h3>Orders:</h3>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Delivery Address</th>
                                    <th>City/State</th>
                                    <th>Mobile</th>
                                    <th>...</th>
                                </tr>
                            </thead>
                            <tbody onclick="show_details(event)">
                                <?php foreach ($orders as $order): ?>
                                    <tr style="position: relative;">
                                        <td><?= $order->id ?></td>
                                        <td><?= date("jS M Y", strtotime($order->date)) ?></td>
                                        <td>$<?= $order->total ?></td>
                                        <td><?= $order->delivery_address ?></td>
                                        <td><?= $order->country . "/" . $order->state ?></td>
                                        <td><?= $order->mobile_phone ?></td>
                                        <td>
                                            <i class="fa fa-arrow-down"></i>
                                            <div class="js-order-details details hide">
                                                <span>close</span>
                                                <?php if (isset($order->details) && is_array($order->details)): ?>
                                                    <h5>Order #<a style="color: blue;"><?= $order->id ?></a> details:</h5>
                                                    <table class="table" style="margin-top: 10px;">
                                                        <thead>
                                                            <tr>
                                                                <th>Qty</th>
                                                                <th>Description</th>
                                                                <th>Amount</th>
                                                                <th>Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($order->details as $detail): ?>
                                                                <tr>
                                                                    <td><?= $detail->qty ?></td>
                                                                    <td><?= $detail->description ?></td>
                                                                    <td>$<?= $detail->amount ?></td>
                                                                    <td>$<?= $detail->total ?></td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                    <h5>Grand Total: $ <?= $order->grand_total ?> </h5>
                                                <?php else: ?>
                                                    <div>
                                                        No details for this order..
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>

                    <div>
                        <h3>No orders yet..</h3>
                        Try to buy something...
                    </div>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <h3 style="text-align:center;">Sorry, that profile could not be found</h3>
        <?php endif; ?>
    </section>
</section>

<script>
    function show_details(e) {
        var row = e.target.parentNode;
        //console.log(row);
        var details = row.querySelector(".js-order-details");
        //console.log(details);
        var closeBtn = details?.querySelector('span');

        //get all rows
        var all = document.querySelectorAll(".js-order-details");
        if (all.length > 0) {
            for (let i = 0; i < all.length; i++) {
                all[i].classList.add("hide");
            }
        }

        //show order details box
        if (details) {
            if (details.classList.contains('hide')) {
                details.classList.remove("hide");
            }
        }


        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                if (!details.classList.contains('hide')) {
                    details.classList.add("hide");
                }
            });
        }

    }
</script>

<?php $this->view("footer", $data);  ?>