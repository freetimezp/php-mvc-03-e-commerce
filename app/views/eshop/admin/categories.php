<!-- ADMIN HEADER -->
<?php $this->view("admin/header", $data);  ?>


<!-- ADMIN SIDEBAR -->
<?php $this->view("admin/sidebar", $data);  ?>

<style type="text/css">
    .add_new {
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

    .add_new button {
        position: absolute;
        bottom: 20px;
        right: 20px;
    }

    .add_new button.btn-secondary {
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

                        <button type="button" class="btn btn-sm btn-secondary"
                            onclick="show_add_new(event)">Cancel
                        </button>
                        <button type="button" class="btn btn-sm btn-primary"
                            onclick="collect_data(event)">Save
                        </button>
                    </form>

                </div>

                <hr>
                <thead>
                    <tr>
                        <th><i class="fa fa-bullhorn"></i> Category</th>
                        <th><i class=" fa fa-edit"></i> Status</th>
                        <th><i class=" fa fa-edit"></i> Actions</th>

                    </tr>
                </thead>
                <tbody id="table_body">
                    <tr>
                        <td><a href="basic_table.html#">Company Ltd</a></td>
                        <td><span class="label label-info label-mini">Enabled</span></td>
                        <td>
                            <button class="btn btn-success btn-xs">
                                <i class="fa fa-check"></i>
                            </button>
                            <button class="btn btn-primary btn-xs">
                                <i class="fa fa-pencil"></i>
                            </button>
                            <button class="btn btn-danger btn-xs">
                                <i class="fa fa-trash-o "></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div><!-- /content-panel -->
    </div><!-- /col-md-12 -->
</div><!-- /row -->

<script>
    var category = document.getElementById("category");

    function show_add_new() {
        const show_box = document.querySelector(".add_new");
        show_box.classList.toggle('hide');
        category.value = "";
    };

    function collect_data(e) {
        if (category.value.trim() == "" || !isNaN(category.value.trim())) {
            alert("Plaese, enter a new category name..");
        }

        var data = category.value.trim();

        send_data({
            data: data,
            data_type: "add_category"
        });
    };

    function send_data(data = {}) {
        const ajax = new XMLHttpRequest();

        ajax.addEventListener("readystatechange", function() {
            if (ajax.readyState == 4 && ajax.status == 200) {
                handle_result(ajax.responseText);
            }
        });

        ajax.open("POST", "<?= ROOT ?>ajax", true);
        ajax.send(JSON.stringify(data));
    };


    function handle_result(result) {
        //console.log(result);

        if (result != "") {
            var obj = JSON.parse(result);

            if (typeof obj.message_type != 'undefined') {
                if (obj.message_type == 'info') {
                    alert(obj.message);
                    show_add_new();

                    var table_body = document.querySelector("#table_body");
                    table_body.innerHTML = obj.data;
                } else {
                    alert(obj.message);
                }
            }
        }

    };
</script>

<!-- ADMIN FOOTER -->
<?php $this->view("admin/footer", $data);  ?>