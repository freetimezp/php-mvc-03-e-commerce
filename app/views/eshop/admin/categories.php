<!-- ADMIN HEADER -->
<?php $this->view("admin/header", $data);  ?>


<!-- ADMIN SIDEBAR -->
<?php $this->view("admin/sidebar", $data);  ?>

<style type="text/css">
    .add_new,
    .edit_category {
        width: 700px;
        height: 400px;
        background-color: #cecccc;
        position: absolute;
        padding: 6px;
        display: block;
        box-shadow: 0px 0px 10px #aaa;
    }

    .hide {
        display: none;
    }

    .add_new button,
    .edit_category button {
        position: absolute;
        bottom: 20px;
        right: 20px;
    }

    .add_new button.btn-secondary,
    .edit_category button.btn-secondary {
        position: absolute;
        bottom: 20px;
        right: 80px;
    }
</style>

<h3>Categories</h3>

<div class="row mt">
    <div class="col-md-12">
        <div class="content-panel">
            <table class="table table-striped table-advance table-hover">
                <h4>
                    Product Categories |
                    <button class="btn btn-primary btn-sm" onclick="show_add_new(event)">
                        <i class="fa fa-plus"></i> Add new
                    </button>
                </h4>

                <!-- add new category -->
                <div class="add_new hide">
                    <h4 class="mb">
                        <i class="fa fa-angle-right"></i> Add new Category
                    </h4>

                    <form class="form-horizontal style-form" method="post">
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">Category:</label>
                            <div class="col-sm-10">
                                <input name="category" type="text" class="form-control" id="category" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">Parent(optional):</label>
                            <div class="col-sm-10">
                                <select name="parent" id="parent" class="form-control">
                                    <option value="0">Choose:</option>
                                    <?php if (isset($categories)): ?>
                                        <?php foreach ($categories as $cat_row): ?>
                                            <option value="<?= $cat_row->id ?>">
                                                <?= $cat_row->category ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <button type="button" class="btn btn-sm btn-secondary"
                            onclick="show_add_new(event)">Cancel
                        </button>
                        <button type="button" class="btn btn-sm btn-primary"
                            onclick="collect_data(event)">Save
                        </button>
                    </form>
                </div>
                <!-- end add new category -->

                <!-- edit category -->
                <div class="edit_category hide">
                    <h4 class="mb">
                        <i class="fa fa-angle-right"></i> Edit Category
                    </h4>

                    <form class="form-horizontal style-form" method="post">
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">Category:</label>
                            <div class="col-sm-10">
                                <input name="category_edit" type="text" class="form-control" id="category_edit" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">Parent(optional):</label>
                            <div class="col-sm-10">
                                <select name="parent_edit" id="parent_edit" class="form-control">
                                    <option value="0">Choose:</option>
                                    <?php if (isset($categories)): ?>
                                        <?php foreach ($categories as $cat_row): ?>
                                            <option value="<?= $cat_row->id ?>">
                                                <?= $cat_row->category ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <button type="button" class="btn btn-sm btn-secondary"
                            onclick="show_edit_category(0, '', event)">Cancel
                        </button>
                        <button type="button" class="btn btn-sm btn-primary"
                            onclick="collect_edit_data(event)">Save
                        </button>
                    </form>
                </div>
                <!-- end edit category -->

                <hr>
                <thead>
                    <tr>
                        <th><i class="fa fa-bullhorn"></i> Category</th>
                        <th><i class=" fa fa-table"></i> Parent</th>
                        <th><i class=" fa fa-edit"></i> Status</th>
                        <th><i class=" fa fa-edit"></i> Actions</th>

                    </tr>
                </thead>
                <tbody id="table_body">
                    <?php if (
                        isset($data['table_rows'])
                        && (!empty($table_rows) || $table_rows != "")
                    ): ?>
                        <?= $data['table_rows']; ?>
                    <?php else: ?>
                        <tr>
                            <td>no categories here</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <div>
                <?= Page::show_pagination_links() ?>
            </div>
        </div><!-- /content-panel -->
    </div><!-- /col-md-12 -->
</div><!-- /row -->

<script>
    var EDIT_ID = 0;
    var category = document.getElementById("category");
    let category_parent_input = document.getElementById("parent_edit");

    function show_add_new() {
        const show_box = document.querySelector(".add_new");
        show_box.classList.toggle('hide');
        category.value = "";
        category_parent_input.value = 0;
    };

    function show_edit_category(id, category, parent, e) {
        EDIT_ID = id;

        const show_edit_box = document.querySelector(".edit_category");
        let category_input = document.getElementById("category_edit");
        if (category_input) {
            category_input.value = category;
        }

        let category_parent_input = document.getElementById("parent_edit");
        if (category_parent_input) {
            category_parent_input.value = parent;
        }

        show_edit_box.classList.toggle('hide');
    };

    function collect_data(e) {
        var category = document.getElementById("category");
        if (category.value.trim() == "" || !isNaN(category.value.trim())) {
            alert("Plaese, enter a new category name..");
        }

        var parent = document.getElementById("parent");

        var category = category.value.trim();
        var parent = parent.value.trim();

        send_data({
            category: category,
            parent: parent,
            data_type: "add_category"
        });
    };

    function collect_edit_data(e) {
        let category_input = document.getElementById("category_edit");
        if (category_input.value.trim() == "" || !isNaN(category_input.value.trim())) {
            alert("Plaese, enter a new category name..");
        }

        let parent_input = document.getElementById("parent_edit");
        if (isNaN(parent_input.value.trim())) {
            alert("Plaese, choose a parent category..");
        }

        var category = category_input.value.trim();
        var parent = parent_input.value.trim();

        send_data({
            id: EDIT_ID,
            category: category,
            parent: parent,
            data_type: "edit_category"
        });
    };

    function send_data(data = {}) {
        const ajax = new XMLHttpRequest();

        ajax.addEventListener("readystatechange", function() {
            if (ajax.readyState == 4 && ajax.status == 200) {
                handle_result(ajax.responseText);
            }
        });

        ajax.open("POST", "<?= ROOT ?>ajax_category", true);
        ajax.send(JSON.stringify(data));
    };


    function handle_result(result) {
        //console.log(result);

        if (result != "") {
            var obj = JSON.parse(result);

            if (typeof obj.data_type != 'undefined') {
                if (obj.data_type == 'add_new') {
                    if (obj.message_type == 'info') {
                        alert(obj.message);
                        show_add_new();

                        var table_body = document.querySelector("#table_body");
                        table_body.innerHTML = obj.data;
                    } else {
                        alert(obj.message);
                    }
                } else if (obj.data_type == 'delete_row') {
                    //console.log(obj);
                    var table_body = document.querySelector("#table_body");
                    table_body.innerHTML = obj.data;
                } else if (obj.data_type == 'disable_row') {
                    //console.log(obj);
                    var table_body = document.querySelector("#table_body");
                    table_body.innerHTML = obj.data;
                } else if (obj.data_type == 'edit_category') {
                    //console.log(obj);
                    show_edit_category(0, '', '', false);

                    var table_body = document.querySelector("#table_body");
                    table_body.innerHTML = obj.data;
                }
            }
        }
    };

    function edit_row(id) {
        //console.log(id);

        send_data({
            data_type: ""
        });
    };

    function delete_row(id) {
        //console.log(id);

        var answer = confirm("Are you sure you want to delete this row?");

        if (!answer) return;

        send_data({
            data_type: "delete_row",
            id: id
        });
    };

    function disable_row(id, state) {
        send_data({
            data_type: "disable_row",
            id: id,
            current_state: state
        });
    }
</script>

<!-- ADMIN FOOTER -->
<?php $this->view("admin/footer", $data);  ?>