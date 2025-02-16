<?php $this->view("header", $data);  ?>


<section id="cart_items">
	<div class="container">
		<div class="breadcrumbs">
			<ol class="breadcrumb">
				<li><a href="#">Home</a></li>
				<li class="active">Shopping Cart</li>
			</ol>
		</div>
		<div class="table-responsive cart_info" style="margin-top: -50px;">
			<table class="table table-condensed">
				<thead>
					<tr class="cart_menu">
						<td class="image">Item</td>
						<td class="description">Description</td>
						<td class="price">Price</td>
						<td class="quantity">Quantity</td>
						<td class="total">Total</td>
						<td></td>
					</tr>
				</thead>
				<tbody>
					<?php if ($rows): ?>
						<?php foreach ($rows as $row): ?>
							<tr>
								<td class="cart_product">
									<a href=""><img style="width: 200px;" src="<?= ROOT . $row->image ?>" alt=""></a>
								</td>
								<td class="cart_description">
									<h4><?= $row->description ?></h4>
									<p>Product ID: <?= $row->id ?></p>
								</td>
								<td class="cart_price">
									<p>$<?= $row->price ?></p>
								</td>
								<td class="cart_quantity">
									<div class="cart_quantity_button">
										<a class="cart_quantity_up"
											href="<?= ROOT ?>add_to_cart/add_quantity/<?= $row->id ?>">
											+
										</a>

										<input class="cart_quantity_input" type="text" name="quantity"
											value="<?= $row->cart_qty ?>" autocomplete="off" size="2"
											oninput="edit_quantity(this.value, '<?= $row->id ?>')">

										<a class="cart_quantity_down"
											href="<?= ROOT ?>add_to_cart/subtract_quantity/<?= $row->id ?>">
											-
										</a>
									</div>
								</td>
								<td class="cart_total">
									<p class="cart_total_price">$<?= $row->price * $row->cart_qty ?></p>
								</td>
								<td class="cart_delete">
									<a class="cart_quantity_delete"
										delete_id="<?= $row->id ?>"
										onclick="delete_item(this.getAttribute('delete_id'))"
										href="<?= ROOT ?>add_to_cart/remove/<?= $row->id ?>">
										<i class="fa fa-times"></i>
									</a>
								</td>
							</tr>
						<?php endforeach; ?>
					<?php else: ?>
						<tr>
							<td>Cart is empty..</td>
						</tr>
					<?php endif; ?>
				</tbody>
			</table>
			<div style="float:right; font-size: 25px; font-weight: 700;" class="">
				Sub Total: $<?= isset($sub_total) ? number_format($sub_total, 2) : 0 ?>
			</div>
		</div>

		<hr class="clear: both;" style="opacity: 0.6;">

		<div class="pull-right">
			<a href="<?= ROOT ?>shop">
				<input type="button" class="btn btn-default" value="Continue Shopping">
			</a>

			<a href="<?= ROOT ?>checkout">
				<input type="button" class="btn btn-warning" value="Checkout">
			</a>
		</div>
	</div>
</section> <!--/#cart_items-->

<br><br>

<script type="text/javascript">
	function edit_quantity(quantity, id) {
		if (isNaN(quantity)) return;

		send_data({
			quantity: quantity.trim(),
			id: id.trim()
		}, "edit_quantity");
	};

	function delete_item(id) {
		send_data({
			id: id.trim()
		}, "delete_item");
	};

	function send_data(data = {}, data_type = "") {
		const ajax = new XMLHttpRequest();

		ajax.addEventListener("readystatechange", function() {
			if (ajax.readyState == 4 && ajax.status == 200) {
				handle_result(ajax.responseText);
			}
		});

		ajax.open("POST", `<?= ROOT ?>ajax_cart/${data_type}/` + JSON.stringify(data), true);
		ajax.send();
	};

	function handle_result(result) {
		//console.log(result);

		if (result != "") {
			var obj = JSON.parse(result);

			if (typeof obj.data_type != 'undefined') {
				if (obj.data_type == "edit_quantity") {
					window.location.href = window.location.href;
				} else if (obj.data_type == "delete_item") {
					window.location.href = window.location.href;
				}
			}
		}
	};
</script>

<?php $this->view("footer", $data);  ?>