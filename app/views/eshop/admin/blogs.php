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
                <tbody>
                    <?php if ($mode == 'read'): ?>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Author</th>
                                <th>Title</th>
                                <th>Post</th>
                                <th>Image</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <a href="<?= ROOT ?>admin/blogs?add_new=true">
                            <input type="button" class="btn btn-primary pull-right" value="Add new post"
                                style="margin: 15px;">
                        </a>

                        <?php if (isset($messages) && is_array($messages)): ?>
                            <?php foreach ($messages as $message): ?>
                                <tr style="position: relative;">
                                    <td><?= $message->id ?></td>
                                    <td><?= ucfirst($message->name) ?></td>
                                    <td><?= $message->title ?></td>
                                    <td><?= $message->post ?></td>
                                    <td>
                                        <img src="<?= $message->message ?>" alt="">
                                    </td>
                                    <td><?= date("d M Y", strtotime($message->date)) ?></td>
                                    <td style="cursor: pointer;">
                                        <a href="<?= ROOT ?>admin/messages?delete=<?= $message->id ?>">
                                            delete <i class="fa fa-trash-o" style="color: red;"></i>
                                        </a>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td>No posts yet..</td>
                            </tr>
                        <?php endif; ?>
                    <?php elseif ($mode == 'add_new'): ?>

                        <?php if (isset($errors)): ?>
                            <div class="status alert alert-danger">
                                <?= $errors ?>
                            </div>
                        <?php endif; ?>

                        <form method="post" enctype="multipart/form-data">
                            <div class="row" style="padding: 40px;">
                                <div style="margin-bottom: 20px;">
                                    <label for="title">Post Title:</label>
                                    <input type="text" id="title" name="title" placeholder="Title" class="form-control"
                                        value="<?= isset($POST['title']) ? $POST['title'] : "" ?>">
                                </div>

                                <div style="margin-bottom: 20px;">
                                    <label for="post">Post message:</label>
                                    <textarea type="text" id="post" name="post" class="form-control">
                                        <?= isset($POST['post']) ? $POST['post'] : "" ?>
                                    </textarea>
                                </div>

                                <div style="margin-bottom: 20px;">
                                    <label for="image">Post Image:</label>
                                    <input type="file" id="image" name="image" class="form-control">
                                </div>

                                <input type="submit" value="Post" class="btn btn-primary pull-right">
                            </div>
                        </form>
                    <?php elseif ($mode == 'delete_confirmed'): ?>
                        <div class="status alert alert-success">
                            <h3>Message was successfully deleted</h3>

                            <a href="<?= ROOT ?>admin/messages">
                                <input type="button" class="btn btn-sm btn-primary"
                                    value="Back to messages" />
                            </a>
                        </div>
                    <?php elseif ($mode == 'delete' && is_object($messages)): ?>
                        <div class="status alert alert-danger">
                            Are you sure you want to delete this message?
                        </div>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Author</th>
                                <th>Title</th>
                                <th>Post</th>
                                <th>Image</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tr style="position: relative;">
                            <td><?= $messages->id ?></td>
                            <td><?= ucfirst($messages->name) ?></td>
                            <td><?= $messages->email ?></td>
                            <td><?= $messages->subject ?></td>
                            <td><?= $messages->message ?></td>
                            <td><?= date("d M Y", strtotime($messages->date)) ?></td>
                            <td>
                                <a href="<?= ROOT ?>admin/messages?delete_confirmed=<?= $messages->id ?>">
                                    <input type="button" class="btn btn-sm btn-danger" value="delete" style="color: #fff;" />
                                </a>
                            </td>
                        </tr>

                    <?php endif; ?>
                </tbody>
            </table>
        </div><!-- /content-panel -->
    </div><!-- /col-md-12 -->
</div><!-- /row -->


<!-- ADMIN FOOTER -->
<?php $this->view("admin/footer", $data);  ?>