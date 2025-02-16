<?php $this->view("header", $data);  ?>

<div id="contact-page" class="container">
	<div class="bg">
		<div class="row">
			<div class="col-sm-12">
				<h2 class="title text-center">Contact <strong>Us</strong></h2>
			</div>
		</div>
		<div class="row" style="padding: 30px 0;">
			<div class="col-sm-8">
				<div class="contact-form">
					<h2 class="title text-center">Get In Touch</h2>

					<?php if (is_array($errors) && count($errors) > 0): ?>
						<?php foreach ($errors as $error): ?>
							<div class="status alert alert-danger">
								<?= $error ?>
							</div>
						<?php endforeach; ?>
					<?php endif; ?>

					<?php if (isset($_GET['success'])): ?>
						<div class="status alert alert-success">Message sent successfully</div>
					<?php endif; ?>

					<form id="main-contact-form" class="contact-form row" name="contact-form" method="post">
						<div class="form-group col-md-6">
							<input type="text" name="name" class="form-control" required="required" placeholder="Name"
								value="<?= isset($POST['name']) ? $POST['name'] : "" ?>">
						</div>
						<div class="form-group col-md-6">
							<input type="email" name="email" class="form-control" required="required" placeholder="Email"
								value="<?= isset($POST['email']) ? $POST['email'] : "" ?>">
						</div>
						<div class="form-group col-md-12">
							<input type="text" name="subject" class="form-control" required="required" placeholder="Subject"
								value="<?= isset($POST['subject']) ? $POST['subject'] : "" ?>">
						</div>
						<div class="form-group col-md-12" style="text-align: left !important; overflow:auto;">
							<textarea name="message" id="message" class="form-control" rows="8"
								placeholder="Your Message Here" style="text-align: left;"><?= isset($POST['message']) ? trim($POST['message']) : "" ?></textarea>
						</div>
						<div class=" form-group col-md-12">
							<input type="submit" name="submit" class="btn btn-primary pull-right" value="Submit">
						</div>
					</form>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="contact-info">
					<h2 class="title text-center">Contact Info</h2>
					<address>
						<?= nl2br(htmlentities(Settings::contact_info())) ?>
					</address>
					<div class="social-networks">
						<h2 class="title text-center">Social Networking</h2>
						<ul>
							<li>
								<a href="<?= Settings::facebook_link() ?>"><i class="fa fa-facebook"></i></a>
							</li>
							<li>
								<a href="<?= Settings::twitter_link() ?>"><i class="fa fa-twitter"></i></a>
							</li>
							<li>
								<a href="<?= Settings::instagram_link() ?>"><i class="fa fa-instagram"></i></a>
							</li>
							<li>
								<a href="<?= Settings::youtube_link() ?>"><i class="fa fa-youtube"></i></a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>


		<h2 class="title"><strong>Find us</strong></h2>
		<div class="row" style="margin: 20px 0;">
			<div class="col-12">
				<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d817324.2912233509!2d35.591399746834604!3d47.709520085766655!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sru!2sua!4v1737750946713!5m2!1sru!2sua" width="800" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
			</div>
		</div>
	</div>
</div><!--/#contact-page-->

<?php $this->view("footer", $data);  ?>