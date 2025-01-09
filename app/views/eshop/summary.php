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

		<?php if (is_array($orders)): ?>

			<div class="register-req">
				<p>Summary..</p>
			</div>

			<div class="row mt">
				<div class="col-md-12">

					<?php foreach ($orders as $order): ?>
						<?php
						$order = (object)$order;
						?>

						<div class="js-order-details details">
							<div style="display:flex; gap: 10px;">
								<table class="table" style="flex: 1; margin: 4px;">
									<tr>
										<th>Country</th>
										<td><?= $order->country ?></td>
									</tr>
									<tr>
										<th>State</th>
										<td><?= $order->state ?></td>
									</tr>
									<tr>
										<th>Delivery Address 1</th>
										<td><?= $order->address1 ?></td>
									</tr>
									<tr>
										<th>Delivery Address 2</th>
										<td><?= $order->address2 ?></td>
									</tr>
								</table>
								<table class="table" style="flex: 1; margin: 4px;">
									<tr>
										<th>Zip/Postal Code</th>
										<td><?= $order->postal_code ?></td>
									</tr>
									<tr>
										<th>Home Phone</th>
										<td><?= $order->home_phone ?></td>
									</tr>
									<tr>
										<th>Mobile Phone</th>
										<td><?= $order->mobile_phone ?></td>
									</tr>
									<tr>
										<th>Date</th>
										<td><?= date("Y-m-d H:i:s") ?></td>
									</tr>
								</table>
							</div>
							<div style="padding: 10px; text-align: center; font-size: 20px; background-color: #e7e0e0;">
								Message: <?= $order->message ?>
							</div>

							<hr>
							<h5>Order Summary</h5>
							<table class="table" style="margin-top: 10px;">
								<thead>
									<tr>
										<th>Description</th>
										<th>Qty</th>
										<th>Price</th>
										<th>Total</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($order_details as $detail): ?>
										<tr>
											<td><?= $detail->description ?></td>
											<td><?= $detail->cart_qty ?></td>
											<td>$<?= $detail->price ?></td>
											<td>$<?= $detail->cart_qty * $detail->price ?></td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
							<h5 style="float: right;">Grand Total: $ <?= $sub_total ?> </h5>
						</div>

						<hr style="clear: both; opacity: 0.2;">

						<div class="pull-right" style="margin-bottom: 20px;">
							<a href="<?= ROOT ?>checkout">
								<input type="button" class="btn btn-default" value="Back to Checkout">
							</a>

							<form method="POST" style="display: inline-block;">
								<input type="submit" class="btn btn-warning" value="Pay">
							</form>
						</div>
					<?php endforeach; ?>

					<hr style="clear: both; opacity: 0.2;">
				</div><!-- /col-md-12 -->
			</div><!-- /row -->
		<?php else: ?>
			<div>
				<h1>Add some products to cart..</h1>
				<a href="<?= ROOT ?>checkout">
					<input type="button" class="btn btn-default" value="Back to Checkout">
				</a>
			</div>
		<?php endif; ?>
	</div>
</section> <!--/#cart_items-->

<script type="text/javascript">
	function get_states(id) {
		//console.log(id);

		send_data({
			id: id.trim()
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

		ajax.open("POST", `<?= ROOT ?>ajax_checkout/${data_type}/` + JSON.stringify(data), true);
		ajax.send();
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
							`<option value="${obj.data[i].id}">
							${obj.data[i].state}
							</option>`;
					}
				}
			}
		}
	};
</script>

<?php $this->view("footer", $data);  ?>