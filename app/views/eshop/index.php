<?php $this->view("header", $data);  ?>

<?php $this->view("slider", $data);  ?>

<section>
	<div class="container">
		<div class="row">
			<?php $this->view("sidebar.inc", $data) ?>

			<div class="col-sm-9 padding-right">
				<div class="features_items"><!--features_items-->
					<h2 class="title text-center">Features Items</h2>

					<?php if (isset($rows) && is_array($rows) > 0): ?>
						<?php foreach ($rows as $row): ?>
							<?php $this->view("products.inc", $row);  ?>
						<?php endforeach; ?>
					<?php else: ?>
						<div style="margin: 40px 20px;">
							<h3 style='text-align: center;'>No items here</h3>
						</div>
					<?php endif; ?>

					<!-- Pagination -->
					<?= Page::show_pagination_links() ?>
				</div><!--features_items-->

				<?php if (isset($segment_data) && is_array($segment_data)): ?>
					<div class="category-tab"><!--category-tab-->
						<div class="col-sm-12">
							<ul class="nav nav-tabs">
								<?php $num = 0; ?>
								<?php foreach ($segment_data as $key => $seg): $num++;  ?>
									<li class="<?= $num == 1 ? 'active' : '';  ?>">
										<a href="#<?= strtolower($key) ?>" data-toggle="tab">
											<?= $key ?>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>

						<div class="tab-content">
							<?php $num = 0; ?>

							<?php foreach ($segment_data as $key => $seg): $num++;  ?>
								<div class="tab-pane fade <?= $num == 1 ? 'active in' : '';  ?>"
									id="<?= strtolower($key) ?>">

									<?php if (is_array($seg)): ?>
										<?php foreach ($seg as $row): ?>
											<div class="col-sm-3">
												<div class="product-image-wrapper">
													<div class="single-products">
														<div class="productinfo text-center">
															<img src="<?= ROOT . $row->image ?>" alt=""
																style="width: 200px; height: 120px; object-fit: cover;" />
															<h2>$<?= $row->price ?></h2>
															<p><?= ucfirst($row->description) ?></p>
															<a href="<?= ROOT ?>add_to_cart/<?= $row->id ?>"
																class="btn btn-default add-to-cart">
																<i class="fa fa-shopping-cart"></i>Add to cart
															</a>
														</div>
													</div>
												</div>
											</div>
										<?php endforeach; ?>
									<?php endif; ?>

								</div>
							<?php endforeach; ?>

						</div>
					</div><!--/category-tab-->
				<?php endif; ?>

				<div class="recommended_items"><!--recommended_items-->
					<h2 class="title text-center">recommended items</h2>

					<div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
						<div class="carousel-inner">

							<?php if (isset($slider_bottom_rows) && is_array($slider_bottom_rows)): ?>
								<?php foreach ($slider_bottom_rows as $key => $slider_bottom_row): ?>
									<div class="item <?= $key == 0 ? 'active' : '' ?>">
										<?php foreach ($slider_bottom_row as $row): ?>
											<?php $this->view("products.inc", $row);  ?>
										<?php endforeach; ?>
									</div>
								<?php endforeach; ?>
							<?php endif; ?>

						</div>
						<a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
							<i class="fa fa-angle-left"></i>
						</a>
						<a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
							<i class="fa fa-angle-right"></i>
						</a>
					</div>
				</div><!--/recommended_items-->

			</div>
		</div>
	</div>
</section>

<?php $this->view("footer", $data);  ?>