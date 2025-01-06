<!-- ADMIN HEADER -->
<?php $this->view("admin/header", $data);  ?>


<!-- ADMIN SIDEBAR -->
<?php $this->view("admin/sidebar", $data);  ?>

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

<h3>Orders</h3>

<div class="row mt">
    <div class="col-md-12">
        <div class="content-panel">
            <table class="table table-striped table-advance table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Customer</th>
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
                            <td>
                                <a href="<?= ROOT ?>profile/<?= $order->user->url_address ?>">
                                    <?= ucfirst($order->user->name) ?>
                                </a>
                            </td>
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

                                        <hr>

                                        <h5>Customer: <?= $order->user->name ?></h5>

                                        <table class="table">
                                            <tr>
                                                <th>Country</th>
                                                <td><?= $order->country ?></td>
                                            </tr>
                                            <tr>
                                                <th>State</th>
                                                <td><?= $order->state ?></td>
                                            </tr>
                                            <tr>
                                                <th>Delivery Address</th>
                                                <td><?= $order->delivery_address ?></td>
                                            </tr>
                                            <tr>
                                                <th>Home Phone</th>
                                                <td><?= $order->home_phone ?></td>
                                            </tr>
                                            <tr>
                                                <th>Mobile Phone</th>
                                                <td><?= $order->mobile_phone ?></td>
                                            </tr>
                                            <tr>
                                                <th>Date</th>
                                                <td><?= date("j M Y", strtotime($order->date)) ?></td>
                                            </tr>
                                        </table>

                                        <hr>
                                        <h5>Order Summary</h5>
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

                                        <hr>

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
        </div><!-- /content-panel -->
    </div><!-- /col-md-12 -->
</div><!-- /row -->

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


<!-- ADMIN FOOTER -->
<?php $this->view("admin/footer", $data);  ?>