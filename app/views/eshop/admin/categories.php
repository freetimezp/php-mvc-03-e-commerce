<!-- ADMIN HEADER -->
<?php $this->view("admin/header", $data);  ?>


<!-- ADMIN SIDEBAR -->
<?php $this->view("admin/sidebar", $data);  ?>


<h3>Categories</h3>

<div class="row mt">
    <div class="col-md-12">
        <div class="content-panel">
            <table class="table table-striped table-advance table-hover">
                <h4>
                    Product Categories |
                    <button class="btn btn-primary btn-xs">
                        <i class="fa fa-plus"></i> Add new
                    </button>
                </h4>

                <!-- add new category -->
                <div class="add_new"></div>

                <hr>
                <thead>
                    <tr>
                        <th><i class="fa fa-bullhorn"></i> Category</th>
                        <th class="hidden-phone"><i class="fa fa-question-circle"></i> Descrition</th>
                        <th><i class="fa fa-bookmark"></i> Price</th>
                        <th><i class=" fa fa-edit"></i> Status</th>
                        <th><i class=" fa fa-edit"></i> Actions</th>

                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><a href="basic_table.html#">Company Ltd</a></td>
                        <td class="hidden-phone">Lorem Ipsum dolor</td>
                        <td>12000.00$ </td>
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




<!-- ADMIN FOOTER -->
<?php $this->view("admin/footer", $data);  ?>