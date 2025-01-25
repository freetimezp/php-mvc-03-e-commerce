<?php $this->view("header", $data);  ?>

<section>
	<div class="container">
		<div class="row">
			<?php $this->view("sidebar.inc", $data);  ?>

			<div class="col-sm-9">
				<div class="blog-post-area">
					<h2 class="title text-center">Latest From our Blog</h2>

					<?php if (isset($rows) && is_array($rows)): ?>
						<?php foreach ($rows as $key => $row): ?>
							<!-- single blog post start -->
							<div class="single-blog-post">
								<h3><?= ucfirst(htmlspecialchars($row->title)) ?></h3>
								<div class="post-meta">
									<ul>
										<li>
											<i class="fa fa-user"></i>
											<?= ucfirst(htmlspecialchars($row->author_data->name)) ?>
										</li>
										<li><i class="fa fa-clock-o"></i> <?= date("H:i a", strtotime($row->date)) ?></li>
										<li><i class="fa fa-calendar"></i> <?= date("M jS, Y", strtotime($row->date)) ?></li>
									</ul>
									<span>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star-half-o"></i>
									</span>
								</div>
								<a href="<?= ROOT ?>post/<?= $row->url_address ?>">
									<img src="<?= ROOT . $row->image ?>" alt="">
								</a>
								<p style="text-align: justify;">
									<?= nl2br(htmlspecialchars(substr($row->post, 0, 200))) ?>...
								</p>
								<a class="btn btn-primary" href="<?= ROOT ?>post/<?= $row->url_address ?>">
									Read More
								</a>
							</div>
							<!-- single blog post end -->
						<?php endforeach; ?>
					<?php endif; ?>

					<div class="pagination-area">
						<ul class="pagination">
							<li><a href="" class="active">1</a></li>
							<li><a href="">2</a></li>
							<li><a href="">3</a></li>
							<li><a href=""><i class="fa fa-angle-double-right"></i></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php $this->view("footer", $data);  ?>