<!-- ADMIN HEADER -->
<?php $this->view("admin/header", $data);  ?>


<!-- ADMIN SIDEBAR -->
<?php $this->view("admin/sidebar", $data);  ?>

<style type="text/css">
    .add_new,
    .edit_product {
        width: 700px;
        height: 500px;
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
    .edit_product button {
        position: absolute;
        bottom: 20px;
        right: 20px;
    }

    .add_new button.btn-secondary,
    .edit_product button.btn-secondary {
        position: absolute;
        bottom: 20px;
        right: 80px;
    }
</style>

<h3>Products</h3>

<div class="row mt">
    <div class="col-md-12">
        <div class="content-panel">
            <table class="table table-striped table-advance table-hover">
                <h4>
                    Product |
                    <button class="btn btn-primary btn-sm" onclick="show_add_new(event)">
                        <i class="fa fa-plus"></i> Add new
                    </button>
                </h4>

                <!-- add new Product -->
                <div class="add_new hide">
                    <h4 class="mb">
                        <i class="fa fa-angle-right"></i> Add new Product
                    </h4>

                    <form class="form-horizontal style-form" method="post">
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">Description:</label>
                            <div class="col-sm-10">
                                <input name="product-title" type="text" class="form-control"
                                    id="product-description" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">Quantity:</label>
                            <div class="col-sm-4">
                                <input name="product-quantity" type="number" class="form-control"
                                    id="product-quantity" value="1" required>
                            </div>
                        </div>

                        <div class="form-group d-flex">
                            <label class="col-sm-2 col-sm-2 control-label">Category:</label>
                            <div class="col-sm-4">
                                <select name="product-category" id="product-category" class="form-control">
                                    <option>Choose:</option>
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

                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">Price:</label>
                            <div class="col-sm-10">
                                <input name="product-price" type="number" class="form-control"
                                    id="product-price" value="0.00" step="0.01" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">Image:</label>
                            <div class="col-sm-10">
                                <input name="product-image" type="file" class="form-control"
                                    id="product-image" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">Image2(optional):</label>
                            <div class="col-sm-10">
                                <input name="product-image-2" type="file" class="form-control"
                                    id="product-image-2" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">Image3(optional):</label>
                            <div class="col-sm-10">
                                <input name="product-image-3" type="file" class="form-control"
                                    id="product-image-3" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">Image4(optional):</label>
                            <div class="col-sm-10">
                                <input name="product-image-4" type="file" class="form-control"
                                    id="product-image-4" required>
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
                <!-- end add new product -->

                <!-- edit product -->
                <div class="edit_product hide">
                    <h4 class="mb">
                        <i class="fa fa-angle-right"></i> Edit product
                    </h4>

                    <form class="form-horizontal style-form" method="post">
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">Product:</label>
                            <div class="col-sm-10">
                                <input name="product" type="text" class="form-control" id="product_edit" required>
                            </div>
                        </div>

                        <button type="button" class="btn btn-sm btn-secondary"
                            onclick="show_edit_product(0, '', event)">Cancel
                        </button>
                        <button type="button" class="btn btn-sm btn-primary"
                            onclick="collect_edit_data(event)">Save
                        </button>
                    </form>
                </div>
                <!-- end edit product -->

                <hr>
                <thead>
                    <tr>
                        <th><i class="fa fa-bullhorn"></i> Product</th>
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
                        <td><a href="basic_table.html#">Example row</a></td>
                        <td><span class="label label-info label-mini">Enabled</span></td>
                        <td>
                            <button class="btn btn-primary btn-xs">
                                <i class="fa fa-pencil"></i>
                            </button>
                            <button class="btn btn-danger btn-xs">
                                <i class="fa fa-trash-o "></i>
                            </button>
                        </td>
                    <?php endif; ?>
                </tbody>
            </table>
        </div><!-- /content-panel -->
    </div><!-- /col-md-12 -->
</div><!-- /row -->

<script>
    var EDIT_ID = 0;
    var product = document.getElementById("product");

    function show_add_new() {
        const show_box = document.querySelector(".add_new");
        show_box.classList.toggle('hide');
        product.value = "";
    };

    function show_edit_product(id, product, e) {
        EDIT_ID = id;

        const show_edit_box = document.querySelector(".edit_product");
        let product_input = document.getElementById("product_edit");

        if (product_input) {
            product_input.value = product;
        }

        show_edit_box.classList.toggle('hide');
    };

    function collect_data(e) {
        if (product.value.trim() == "" || !isNaN(product.value.trim())) {
            alert("Plaese, enter a new product name..");
        }

        var data = product.value.trim();

        send_data({
            data: data,
            data_type: "add_product"
        });
    };

    function collect_edit_data(e) {
        let product_input = document.getElementById("product_edit");

        if (product_input.value.trim() == "" || !isNaN(product_input.value.trim())) {
            alert("Plaese, enter a new product name..");
        }

        var data = product_input.value.trim();

        send_data({
            id: EDIT_ID,
            product: data,
            data_type: "edit_product"
        });
    };

    function send_data(data = {}) {
        const ajax = new XMLHttpRequest();

        ajax.addEventListener("readystatechange", function() {
            if (ajax.readyState == 4 && ajax.status == 200) {
                handle_result(ajax.responseText);
            }
        });

        //console.log(data);

        ajax.open("POST", "<?= ROOT ?>ajax_product", true);
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
                } else if (obj.data_type == 'edit_product') {
                    //console.log(obj);
                    show_edit_product(0, '', false);

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