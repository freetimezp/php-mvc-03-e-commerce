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
        buser-radius: 4px;
    }
</style>

<h3><?= $page_title ?></h3>

<div class="row mt">
    <div class="col-md-12">
        <div class="content-panel">
            <form method="post">
                <table class="table table-striped table-advance table-hover">
                    <thead>
                        <tr>
                            <th>Setting</th>
                            <th>Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($settings) && is_array($settings)): ?>
                            <?php foreach ($settings as $row): ?>
                                <tr>
                                    <td><?= ucwords(str_replace("_", " ",  $row->setting)) ?></td>
                                    <td>
                                        <input type="text" class="form-control"
                                            name="<?= $row->setting ?>"
                                            value="<?= $row->value ?>"
                                            placeholder="Type value">
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>

                <input type="submit" value="Save Settings" class="btn btn-primary"
                    style="margin: 20px;">
            </form>

        </div><!-- /content-panel -->
    </div><!-- /col-md-12 -->
</div><!-- /row -->



<!-- ADMIN FOOTER -->
<?php $this->view("admin/footer", $data);  ?>