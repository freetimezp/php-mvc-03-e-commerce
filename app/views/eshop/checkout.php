<?php $this->view("header", $data);  ?>

<?php
if (isset($errors) && count($errors) > 0) {
	echo "<div class='container'>";

	foreach ($errors as $error) {
		echo "<div class='alert alert-danger text-center'>$error</div>";
	}

	echo "</div>";
}
?>

<section id="cart_items">
	<div class="container">
		<div class="breadcrumbs">
			<ol class="breadcrumb">
				<li><a href="#">Home</a></li>
				<li class="active">Check out</li>
			</ol>
		</div><!--/breadcrums-->

		<div class="review-payment" style="margin-top: -50px;">
			<h2>Review & Payment</h2>
		</div>

		<?php if (is_array($rows)): ?>

			<div class="register-req">
				<p>Please check fields in form..</p>
			</div><!--/register-req-->

			<?php
			$address1 = "";
			$address2 = "";
			$postal_code = "";
			$home_phone = "";
			$mobile_phone = "";
			$message = "";
			$country = "";
			$state = "";

			if (isset($POST_DATA)) {
				extract($POST_DATA); //we can use input names for showing
			}
			?>

			<div class="shopper-informations">
				<div class="row">
					<form method="POST">
						<div class="col-sm-3">
							<div class="shopper-info">
								<p>Shopper Information</p>
							</div>
						</div>
						<div class="col-sm-5 clearfix">
							<div class="bill-to">
								<p>Bill To</p>
								<div class="form-one">
									<input class="form-control" type="text" placeholder="Address 1 *" required
										style="margin-bottom: 15px;" name="address1" value="<?= $address1 ?>">
									<input class="form-control" type="text" placeholder="Address 2"
										style="margin-bottom: 15px;" name="address2" value="<?= $address2 ?>">
									<input class="form-control" type="text" placeholder="Zip / Postal Code *"
										name="postal_code" required value="<?= $postal_code ?>">
								</div>
								<div class="form-two">
									<select name="country" class="js-country" oninput="get_states(this.value)"
										style="margin-bottom: 15px;">
										<?php
										if ($country == "") {
											echo "<option>-- Country --</option>";
										} else {
											echo "<option>$country</option>";
										}
										?>

										<?php if (isset($countries)): ?>
											<?php foreach ($countries as $item): ?>
												<option value="<?= $item->country ?>"><?= $item->country ?></option>
											<?php endforeach; ?>
										<?php endif; ?>
									</select>
									<select name="state" class="js-state" required
										style="margin-bottom: 15px;" value="<?= $state ?>">
										<?php
										if ($state == "") {
											echo "<option>-- Choose state --</option>";
										} else {
											echo "<option>$state</option>";
										}
										?>
									</select>
									<input class="form-control" type="text" placeholder="Home Phone"
										style="margin-bottom: 15px;" name="home_phone" value="<?= $home_phone ?>">
									<input class="form-control" type="text" placeholder="Mobile Phone *"
										name="mobile_phone" required value="<?= $mobile_phone ?>">
								</div>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="order-message">
								<p>Shipping Order</p>
								<textarea name="message" placeholder="Notes about your order, Special Notes for Delivery"
									style="max-height: 200px;" class="form-control"><?= $message ?></textarea>
							</div>
						</div>
				</div>

				<hr class="clear: both;" style="opacity: 0.6;">

				<div class="pull-right">
					<a href="<?= ROOT ?>cart">
						<input type="button" class="btn btn-default" value="Back to Cart">
					</a>

					<input type="submit" class="btn btn-warning" value="Continue">
				</div>

				<br> <br> <br> <br>
				</form>
			</div>


		<?php else: ?>
			<div>
				<h1>Add some products to cart..</h1>
				<a href="<?= ROOT ?>shop">
					<input type="button" class="btn btn-default" value="Back to Shop">
				</a>
			</div>
		<?php endif; ?>
	</div>
</section> <!--/#cart_items-->

<script type="text/javascript">
	function get_states(country) {
		//console.log(country);

		send_data({
			id: country.trim()
		}, "get_states");
	};

	function send_data(data = {}, data_type = "") {
		const ajax = new XMLHttpRequest();

		ajax.addEventListener("readystatechange", function() {
			if (ajax.readyState == 4 && ajax.status == 200) {
				//console.log('Status OK');
				handle_result(ajax.responseText);
			}
		});

		var info = {};
		info.data_type = data_type;
		info.data = data;

		ajax.open("POST", "<?= ROOT ?>ajax_checkout", true);
		ajax.send(JSON.stringify(info));
	};

	function handle_result(result) {
		//console.log(result);

		if (result != "") {
			var obj = JSON.parse(result);

			if (typeof obj.data_type != 'undefined') {
				if (obj.data_type == "get_states") {
					var select_input = document.querySelector(".js-state");
					select_input.innerHTML = "<option>-- Choose state --</option>";

					for (var i = 0; i < obj.data.length; i++) {
						select_input.innerHTML +=
							`<option value="${obj.data[i].state}">
							${obj.data[i].state}
							</option>`;
					}
				}
			}
		}
	};
</script>

<?php $this->view("footer", $data);  ?>