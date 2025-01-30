<!-- ADMIN HEADER -->
<?php $this->view("admin/header", $data);  ?>


<!-- ADMIN SIDEBAR -->
<?php $this->view("admin/sidebar", $data);  ?>

<style type="text/css">
    .add_new,
    .edit_product {
        width: 700px;
        height: 600px;
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

    .edit_product_images img {
        max-width: 200px;
        height: 150px;
        margin: 20px 10px;
    }
</style>

<h3>Products</h3>

<div class="row mt">
    <div class="col-md-12">
        <div class="content-panel">
            <!-- search start -->
            <form method="GET">
                <table class="search-table table table-striped table-condensed">
                    <tr>
                        <th>Description</th>
                        <td colspan="3">
                            <input type="text" placeholder="Type text for search.." class="form-control"
                                name="description">
                        </td>

                        <th>Category</th>
                        <td>
                            <select class="form-control" name="category">
                                <option value="">--Choose--</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>Brands</th>
                        <td>
                            <label for="abrand">
                                <input id="abrand" type="checkbox" class="form-checkbox-input"
                                    name="brand-0">
                                A Brand |
                            </label>
                            <label for="bbrand">
                                <input id="bbrand" type="checkbox" class="form-checkbox-input"
                                    name="brand-1">
                                B Brand
                            </label>
                        </td>
                    </tr>

                    <tr>
                        <th>Price</th>
                        <td>
                            <label for="">Min</label>
                            <input type="number" step="0.01" class="form-control" value="0"
                                name="price">
                            <label for="">Max</label>
                            <input type="number" step="0.01" class="form-control" value="0"
                                name="price">
                        </td>

                        <th>Quantity</th>
                        <td>
                            <label for="">Min</label>
                            <input type="number" step="0.01" class="form-control" value="0"
                                name="quantity">

                            <label for="">Max</label>
                            <input type="number" step="0.01" class="form-control" value="0"
                                name="quantity">
                        </td>

                        <th>Year</th>
                        <td>
                            <select class="form-control" name="year">
                                <option value="">--Choose--</option>
                            </select>
                        </td>
                    </tr>
                </table>
            </form>
            <!-- search end -->

            <hr style="opacity: 0.2;">

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

                        <div class="form-group d-flex">
                            <label class="col-sm-2 col-sm-2 control-label">Brand:</label>
                            <div class="col-sm-4">
                                <select name="product-brand" id="product-brand" class="form-control">
                                    <option>Choose:</option>
                                    <?php if (isset($brands)): ?>
                                        <?php foreach ($brands as $brand_row): ?>
                                            <option value="<?= $brand_row->id ?>">
                                                <?= $brand_row->brand ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <br style="clear: both;"><br>

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
                                    id="product-image" required
                                    onchange="display_image(this.files[0], this.name, 'js-product-images-add')">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">Image2(optional):</label>
                            <div class="col-sm-10">
                                <input name="product-image-2" type="file" class="form-control"
                                    id="product-image-2" required
                                    onchange="display_image(this.files[0], this.name, 'js-product-images-add')">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">Image3(optional):</label>
                            <div class="col-sm-10">
                                <input name="product-image-3" type="file" class="form-control"
                                    id="product-image-3" required
                                    onchange="display_image(this.files[0], this.name, 'js-product-images-add')">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">Image4(optional):</label>
                            <div class="col-sm-10">
                                <input name="product-image-4" type="file" class="form-control"
                                    id="product-image-4" required
                                    onchange="display_image(this.files[0], this.name, 'js-product-images-add')">
                            </div>
                        </div>

                        <div class="js-product-images-add edit_product_images">
                            <img src="" alt="">
                            <img src="" alt="">
                            <img src="" alt="">
                            <img src="" alt="">
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
                            <label class="col-sm-2 col-sm-2 control-label">Description:</label>
                            <div class="col-sm-10">
                                <input name="product-title" type="text" class="form-control"
                                    id="edit-product-description" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">Quantity:</label>
                            <div class="col-sm-4">
                                <input name="product-quantity" type="number" class="form-control"
                                    id="edit-product-quantity" value="1" required>
                            </div>
                        </div>

                        <div class="form-group d-flex">
                            <label class="col-sm-2 col-sm-2 control-label">Category:</label>
                            <div class="col-sm-4">
                                <select name="product-category" id="edit-product-category" class="form-control">
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

                        <div class="form-group d-flex">
                            <label class="col-sm-2 col-sm-2 control-label">Brand:</label>
                            <div class="col-sm-4">
                                <select name="product-brand" id="edit-product-brand" class="form-control">
                                    <option>Choose:</option>
                                    <?php if (isset($brands)): ?>
                                        <?php foreach ($brands as $brand_row): ?>
                                            <option value="<?= $brand_row->id ?>">
                                                <?= $brand_row->brand ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <br style="clear: both;"><br>


                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">Price:</label>
                            <div class="col-sm-10">
                                <input name="product-price" type="number" class="form-control"
                                    id="edit-product-price" value="0.00" step="0.01" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">Image:</label>
                            <div class="col-sm-10">
                                <input name="edit-product-image" type="file" class="form-control"
                                    id="edit-product-image" required
                                    onchange="display_image(this.files[0], this.name, 'js-product-images-edit')">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">Image2(optional):</label>
                            <div class="col-sm-10">
                                <input name="product-image-2" type="file" class="form-control"
                                    id="edit-product-image-2" required
                                    onchange="display_image(this.files[0], this.name, 'js-product-images-edit')">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">Image3(optional):</label>
                            <div class="col-sm-10">
                                <input name="product-image-3" type="file" class="form-control"
                                    id="edit-product-image-3" required
                                    onchange="display_image(this.files[0], this.name, 'js-product-images-edit')">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">Image4(optional):</label>
                            <div class="col-sm-10">
                                <input name="product-image-4" type="file" class="form-control"
                                    id="edit-product-image-4" required
                                    onchange="display_image(this.files[0], this.name, 'js-product-images-edit')">
                            </div>
                        </div>

                        <div class="js-product-images-edit edit_product_images"></div>


                        <button type="button" class="btn btn-sm btn-secondary"
                            onclick="show_edit_product()">Cancel
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
                        <th>#</th>
                        <th>Product</th>
                        <th>Image</th>
                        <th>Quantity</th>
                        <th>Category</th>
                        <th>Brand</th>
                        <th>Price</th>
                        <th>Date</th>
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
                            <td>No products here</td>
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
    let productDescription = document.getElementById("edit-product-description");

    let productImage = document.getElementById("product-image");
    let productImage2 = document.getElementById("product-image-2");
    let productImage3 = document.getElementById("product-image-3");
    let productImage4 = document.getElementById("product-image-4");

    function show_add_new() {
        const show_box = document.querySelector(".add_new");
        show_box.classList.toggle('hide');
        productDescription.value = "";
    };

    function show_edit_product(id, product, e) {
        const show_edit_box = document.querySelector(".edit_product");

        if (e) {
            var a = e.currentTarget.getAttribute("info");
            var info = JSON.parse(a.replaceAll("'", '"'));

            //console.log(info);
            EDIT_ID = info.id;

            let edit_product_description = document.querySelector("#edit-product-description");
            if (edit_product_description) {
                edit_product_description.value = info.description;
            }

            let edit_product_category = document.querySelector("#edit-product-category");
            if (edit_product_category) {
                edit_product_category.value = info.category;
            }

            let edit_product_brand = document.querySelector("#edit-product-brand");
            if (edit_product_brand) {
                //console.log(info);
                edit_product_brand.value = info.brand;
            }

            let edit_product_quantity = document.querySelector("#edit-product-quantity");
            if (edit_product_quantity) {
                edit_product_quantity.value = info.quantity;
            }

            let edit_product_price = document.querySelector("#edit-product-price");
            if (edit_product_price) {
                edit_product_price.value = info.price;
            }

            let js_product_images = document.querySelector(".js-product-images");
            if (js_product_images) {
                js_product_images.innerHTML = `<img src="<?= ROOT ?>${info.image}" />`;
                if (info.image2) {
                    js_product_images.innerHTML += `<img src="<?= ROOT ?>${info.image2}" />`;
                }
                if (info.image3) {
                    js_product_images.innerHTML += `<img src="<?= ROOT ?>${info.image3}" />`;
                }
                if (info.image4) {
                    js_product_images.innerHTML += `<img src="<?= ROOT ?>${info.image4}" />`;
                }
            }
        }

        show_edit_box.classList.toggle('hide');
    };

    function collect_data(e) {
        var data = new FormData();

        var productDescription = document.getElementById("product-description");
        if (productDescription.value.trim() == "" || !isNaN(productDescription.value.trim())) {
            alert("Plaese, enter a new product description..");
            return;
        }

        var productQuantity = document.getElementById("product-quantity");
        if (productQuantity.value.trim() == "" || isNaN(productQuantity.value.trim())) {
            alert("Plaese, enter product quantity..");
            return;
        }

        var productCategory = document.getElementById("product-category");
        if (productCategory.value.trim() == "" || isNaN(productCategory.value.trim())) {
            alert("Plaese, choose product category..");
            return;
        }

        var productBrand = document.getElementById("product-brand");
        if (productBrand.value.trim() == "" || isNaN(productBrand.value.trim())) {
            alert("Plaese, choose product brand..");
            return;
        }

        var productPrice = document.getElementById("product-price");
        if (productPrice.value.trim() == "" || isNaN(productPrice.value.trim())) {
            alert("Plaese, enter product price..");
            return;
        }

        var productImage = document.getElementById("product-image");
        if (productImage.files.length == 0) {
            alert("Plaese, choose product image..");
            return;
        }


        var productImage2 = document.getElementById("product-image-2");
        if (productImage2.files.length > 0) {
            data.append('image2', productImage2.files[0]);
        }

        var productImage3 = document.getElementById("product-image-3");
        if (productImage3.files.length > 0) {
            data.append('image3', productImage3.files[0]);
        }

        var productImage4 = document.getElementById("product-image-4");
        if (productImage4.files.length > 0) {
            data.append('image4', productImage4.files[0]);
        }


        var productDescription = productDescription.value.trim();
        var productQuantity = productQuantity.value.trim();
        var productCategory = productCategory.value.trim();
        var productBrand = productBrand.value.trim();
        var productPrice = productPrice.value.trim();


        data.append('description', productDescription);
        data.append('quantity', productQuantity);
        data.append('category', productCategory);
        data.append('brand', productBrand);
        data.append('price', productPrice);
        data.append('image', productImage.files[0]);
        data.append('data_type', "add_product");

        send_data_files(data);
    };

    function collect_edit_data(e) {
        var data = new FormData();

        var productDescription = document.getElementById("edit-product-description");
        if (productDescription.value.trim() == "" || !isNaN(productDescription.value.trim())) {
            alert("Plaese, enter a new product description..");
            return;
        }

        var productQuantity = document.getElementById("edit-product-quantity");
        if (productQuantity.value.trim() == "" || isNaN(productQuantity.value.trim())) {
            alert("Plaese, enter product quantity..");
            return;
        }

        var productCategory = document.getElementById("edit-product-category");
        if (productCategory.value.trim() == "" || isNaN(productCategory.value.trim())) {
            alert("Plaese, choose product category..");
            return;
        }

        var productBrand = document.getElementById("edit-product-brand");
        if (productBrand.value.trim() == "" || isNaN(productBrand.value.trim())) {
            alert("Plaese, choose product brand..");
            return;
        }

        var productPrice = document.getElementById("edit-product-price");
        if (productPrice.value.trim() == "" || isNaN(productPrice.value.trim())) {
            alert("Plaese, enter product price..");
            return;
        }


        var productImage = document.getElementById("edit-product-image");
        if (productImage.files.length > 0) {
            data.append('image', productImage.files[0]);
        }

        var productImage2 = document.getElementById("edit-product-image-2");
        if (productImage2.files.length > 0) {
            data.append('image2', productImage2.files[0]);
        }

        var productImage3 = document.getElementById("edit-product-image-3");
        if (productImage3.files.length > 0) {
            data.append('image3', productImage3.files[0]);
        }

        var productImage4 = document.getElementById("edit-product-image-4");
        if (productImage4.files.length > 0) {
            data.append('image4', productImage4.files[0]);
        }


        var productDescription = productDescription.value.trim();
        var productQuantity = productQuantity.value.trim();
        var productCategory = productCategory.value.trim();
        var productBrand = productBrand.value.trim();
        var productPrice = productPrice.value.trim();


        data.append('description', productDescription);
        data.append('quantity', productQuantity);
        data.append('category', productCategory);
        data.append('brand', productBrand);
        data.append('price', productPrice);
        data.append('data_type', "edit_product");
        data.append('id', EDIT_ID);

        send_data_files(data);
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

    function send_data_files(formdata) {
        const ajax = new XMLHttpRequest();

        ajax.addEventListener("readystatechange", function() {
            if (ajax.readyState == 4 && ajax.status == 200) {
                handle_result(ajax.responseText);
            }
        });

        //console.log(formdata);

        ajax.open("POST", "<?= ROOT ?>ajax_product", true);
        ajax.send(formdata);
    };

    function handle_result(result) {
        //console.log("Status OK: " + "Products");
        //console.log(result);

        if (result != "") {
            var obj = JSON.parse(result);
            //console.log(obj);

            if (typeof obj.data_type != 'undefined') {
                if (obj.data_type == 'add_new') {
                    if (obj.message_type == 'info') {
                        //alert(obj.message);
                        show_add_new();

                        var table_body = document.querySelector("#table_body");
                        table_body.innerHTML = obj.data;

                    } else {
                        //alert(obj.message);
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
                    if (obj.message_type == 'info') {
                        show_edit_product(0, '', false);
                        var table_body = document.querySelector("#table_body");
                        table_body.innerHTML = obj.data;

                    } else {
                        //alert(obj.message);
                    }
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
    };

    function display_image(file, name, element) {
        var index = 0;

        if (name == 'product-image-2') {
            index = 1;
        } else if (name == 'product-image-3') {
            index = 2;
        } else if (name == 'product-image-4') {
            index = 3;
        }

        var images_holder = document.querySelector("." + element);
        var images = images_holder.querySelectorAll("img");

        images[index].src = URL.createObjectURL(file);

    };
</script>

<!-- ADMIN FOOTER -->
<?php $this->view("admin/footer", $data);  ?>