<!-- MAIN SIDEBAR -->
<!-- sidebar start -->
<aside>
    <div id="sidebar" class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">
            <p class="centered">
                <a href="profile.html">
                    <img src="<?= ASSETS ?>admin/assets/img/ui-sam.jpg" class="img-circle" width="60">
                </a>
            </p>

            <h5 class="centered">
                <?= ucfirst($data['user_data']->name); ?>
            </h5>
            <h5 class="centered" style="color: #ffffff70; font-size: 12px;">
                <?= strtolower($data['user_data']->email); ?>
            </h5>

            <li class="sub-menu">
                <a href="javascript:;">
                    <i class="fa fa-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="sub-menu">
                <a href="<?= ROOT ?>admin/products">
                    <i class="fa fa-barcode"></i>
                    <span>Products</span>
                </a>
                <ul class="sub">
                    <li><a href="<?= ROOT ?>admin/products">View Products</a></li>
                </ul>
            </li>

            <li class="sub-menu">
                <a href="<?= ROOT ?>admin/categories">
                    <i class="fa fa-list-alt"></i>
                    <span>Categories</span>
                </a>
                <ul class="sub">
                    <li><a href="<?= ROOT ?>admin/categories">View Categories</a></li>
                </ul>
            </li>

            <li class="sub-menu">
                <a href="<?= ROOT ?>admin/orders">
                    <i class="fa fa-reorder"></i>
                    <span>Orders</span>
                </a>
            </li>

            <li class="sub-menu">
                <a href="<?= ROOT ?>admin/settings">
                    <i class="fa fa-cogs"></i>
                    <span>Settings</span>
                </a>
                <ul class="sub">
                    <li><a href="<?= ROOT ?>admin/settings/slider_images">Slider Images</a></li>
                </ul>
            </li>

            <li class="sub-menu">
                <a href="<?= ROOT ?>admin/users">
                    <i class="fa fa-user"></i>
                    <span>Users</span>
                </a>
                <ul class="sub">
                    <li><a href="<?= ROOT ?>admin/users/customers">Customers</a></li>
                    <li><a href="<?= ROOT ?>admin/users/admins">Admins</a></li>
                </ul>
            </li>

            <li class="sub-menu">
                <a href="<?= ROOT ?>admin/backup">
                    <i class="fa fa-hdd-o"></i>
                    <span>Website Backup</span>
                </a>
            </li>
        </ul>
        <!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end-->

<!-- MAIN CONTENT -->
<!-- main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <h3>Admin Pages</h3>
        <div class="row mt">
            <div class="col-lg-12">