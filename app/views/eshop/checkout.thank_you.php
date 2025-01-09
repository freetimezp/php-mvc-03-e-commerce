<?php $this->view("header", $data);  ?>

<div class="container" style="padding: 100px 0;">
    <h1 style="text-align: center; color: blue;">
        THANK YOU.
    </h1>
    <h3 style="text-align: center; color: orange;">
        HOPE YOU VISIT OUR SITE AGAIN SOON.
    </h3>


    <div style="text-align: center; display: flex; justify-content: center; gap: 10px;">
        <a href="<?= ROOT ?>shop">
            <input type="button" class="btn btn-primary" value="Continue Shopping">
        </a>
        <a href="<?= ROOT ?>profile">
            <input type="button" class="btn btn-primary" value="See my orders">
        </a>
    </div>
</div>

<?php $this->view("footer", $data);  ?>