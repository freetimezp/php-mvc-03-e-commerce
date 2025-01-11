<?php $this->view("header", $data);  ?>


<section id="advertisement">
	<div class="container">
		<img src="<?= ASSETS ?>eshop/images/shop/advertisement.jpg" alt="" />
	</div>
</section>

<section>
	<div class="container">
		<div class="row">
			<?php $this->view("sidebar.inc", $data) ?>

			<div class="col-sm-9 padding-right">
				<div class="features_items"><!--features_items-->
					<h2 class="title text-center">Features Items</h2>

					<?php if (isset($rows)): ?>
						<?php foreach ($rows as $row): ?>
							<?php $this->view("products-inc", $row);  ?>
						<?php endforeach; ?>
					<?php endif; ?>

				</div><!--features_items-->
				<ul class="pagination">
					<li class="active"><a href="">1</a></li>
					<li><a href="">2</a></li>
					<li><a href="">3</a></li>
					<li><a href="">&raquo;</a></li>
				</ul>
			</div>
		</div>
	</div>
</section>


<?php $this->view("footer", $data);  ?>