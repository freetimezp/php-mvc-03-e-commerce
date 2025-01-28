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

					<?php if (isset($rows) && is_array($rows) && !empty($rows)): ?>
						<?php foreach ($rows as $row): ?>
							<?php $this->view("products.inc", $row);  ?>
						<?php endforeach; ?>
					<?php else: ?>
						<div style="margin: 40px 20px;">
							<h3 style='text-align: center;'>No items here</h3>
						</div>
					<?php endif; ?>

				</div><!--features_items-->

				<!-- Pagination -->
				<?= Page::show_pagination_links() ?>
			</div>
		</div>
	</div>
</section>


<?php $this->view("footer", $data);  ?>