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
            <table class="table table-striped table-advance table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($messages) && is_array($messages)): ?>
                        <?php foreach ($messages as $message): ?>
                            <tr style="position: relative;">
                                <td><?= $message->id ?></td>
                                <td><?= ucfirst($message->name) ?></td>
                                <td><?= $message->email ?></td>
                                <td><?= $message->subject ?></td>
                                <td><?= $message->message ?></td>
                                <td><?= date("d M Y", strtotime($message->date)) ?></td>
                                <td style="cursor: pointer;">
                                    delete <i class="fa fa-trash-o" style="color: red;"></i>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div><!-- /content-panel -->
    </div><!-- /col-md-12 -->
</div><!-- /row -->


<!-- ADMIN FOOTER -->
<?php $this->view("admin/footer", $data);  ?>