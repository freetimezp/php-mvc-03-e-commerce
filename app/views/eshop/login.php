<?php $this->view("header", $data); ?>

<section id="form" style="margin-top: 100px; margin-bottom: 100px;"><!--form-->
	<div class="container">
		<div class="row">
			<div class="col-sm-4 col-sm-offset-4">
				<div class="login-form"><!--login form-->
					<div class="text-danger">
						<?php check_error(); ?>
					</div>
					<h2>Login to your account</h2>
					<form action="#">
						<input type="text" placeholder="Name" />
						<input type="email" placeholder="Email Address" />
						<span>
							<input type="checkbox" class="checkbox">
							Keep me signed in
						</span>
						<button type="submit" class="btn btn-default">Login</button>
					</form>
					<br>
					Dont have an account?
					<a href="<?= ROOT ?>signup">
						Signup here
					</a>
				</div><!--/login form-->
			</div>
		</div>
	</div>
</section><!--/form-->


<?php $this->view("footer", $data);  ?>