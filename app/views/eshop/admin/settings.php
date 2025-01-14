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
                    <?php if ($page_title == 'socials'): ?>
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

                        <input type="submit" value="Save Settings" class="btn btn-primary pull-right"
                            style="margin: 20px;">
                    <?php elseif ($page_title == 'slider_images'): ?>

                        <?php if ($action == 'show'): ?>
                            <thead>
                                <th>Header Text 1 </th>
                                <th>Header Text 2 </th>
                                <th>Main Message</th>
                                <th>Product link</th>
                                <th>Product Image</th>
                                <th>Disabled</th>
                                <th>Action</th>
                            </thead>
                            <tbody>

                            </tbody>

                            <a href="<?= ROOT ?>admin/settings/slider_images?action=add">
                                <input type="button" value="Add Row" class="btn btn-primary pull-right"
                                    style="margin: 20px;">
                            </a>
                        <?php else: ?>
                            <h3>Add new row</h3>

                            <div class="form-group">
                                <label for="header_text_1">Header 1</label>
                                <input type="text" name="header_text_1" class="form-control"
                                    placeholder="Header text 1" id="header_text_1">
                            </div>
                            <div class="form-group">
                                <label for="header_text_2">Header 2</label>
                                <input type="text" name="header_text_2" class="form-control"
                                    placeholder="Header text 2" id="header_text_2">
                            </div>
                            <div class="form-group">
                                <label for="message_text">Main Message</label>
                                <textarea name="message_text" id="message_text" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="content_link">Content Link</label>
                                <input type="text" name="content_link" class="form-control"
                                    placeholder="Content Link" id="content_link">
                            </div>

                            <div class="form-group">
                                <label for="message_text">Slider Image</label>
                                <input type="file" name="image" class="form-control">
                            </div>

                            <input type="submit" value="Add new" class="btn btn-primary pull-right">
                        <?php endif; ?>

                    <?php endif; ?>

                </table>


            </form>

        </div><!-- /content-panel -->
    </div><!-- /col-md-12 -->
</div><!-- /row -->



<!-- ADMIN FOOTER -->
<?php $this->view("admin/footer", $data);  ?>