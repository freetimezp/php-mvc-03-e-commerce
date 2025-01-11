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

					<?php if (isset($rows) && is_array($rows)): ?>
						<?php foreach ($rows as $row): ?>
							<?php $this->view("products-inc", $row);  ?>
						<?php endforeach; ?>
					<?php else: ?>
						<h3 style='text-align: center;'>No items were found by this Category</h3>
					<?php endif; ?>

				</div><!--features_items-->

				<?php if (isset($rows) && is_array($rows)): ?>
					<ul class="pagination">
						<li class="active"><a href="">1</a></li>
						<li><a href="">2</a></li>
						<li><a href="">3</a></li>
						<li><a href="">&raquo;</a></li>
					</ul>
				<?php endif; ?>

			</div>
		</div>
	</div>
</section>


<?php $this->view("footer", $data);  ?>