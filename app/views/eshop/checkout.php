<?php $this->view("header", $data);  ?>


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

		<div class="register-req">
			<p>Please use Register And Checkout to easily get access to your order history, or use Checkout as Guest</p>
		</div><!--/register-req-->

		<div class="shopper-informations">
			<div class="row">
				<div class="col-sm-3">
					<div class="shopper-info">
						<p>Shopper Information</p>
					</div>
				</div>
				<div class="col-sm-5 clearfix">
					<div class="bill-to">
						<p>Bill To</p>
						<div class="form-one">
							<form>
								<input type="text" placeholder="Address 1 *" required>
								<input type="text" placeholder="Address 2">
								<input type="text" placeholder="Zip / Postal Code *" required>
							</form>
						</div>
						<div class="form-two">
							<form method="POST">
								<select name="country" class="js-country" oninput="get_states(this.value)">
									<option>-- Country --</option>
									<?php if (isset($countries)): ?>
										<?php foreach ($countries as $item): ?>
											<option value="<?= $item->id ?>"><?= $item->country ?></option>
										<?php endforeach; ?>
									<?php endif; ?>
								</select>
								<select name="state" class="js-state" required>
									<option>-- Choose staten --</option>
								</select>
								<input type="text" placeholder="Phone *" required>
								<input type="text" placeholder="Mobile Phone">
							</form>
						</div>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="order-message">
						<p>Shipping Order</p>
						<textarea name="message" placeholder="Notes about your order, Special Notes for Delivery"
							style="max-height: 200px;"></textarea>
					</div>
				</div>
			</div>
		</div>

		<hr class="clear: both;" style="opacity: 0.6;">

		<div class="pull-right">
			<a href="<?= ROOT ?>cart">
				<input type="button" class="btn btn-default" value="Back to Cart">
			</a>

			<a href="<?= ROOT ?>payment">
				<input type="button" class="btn btn-warning" value="Payment">
			</a>
		</div>

		<br> <br> <br> <br>
	</div>
</section> <!--/#cart_items-->

<script type="text/javascript">
	function get_states(id) {
		send_data({
			id: id.trim()
		}, "get_states");
	};

	function send_data(data = {}, data_type = "") {
		const ajax = new XMLHttpRequest();

		ajax.addEventListener("readystatechange", function() {
			if (ajax.readyState == 4 && ajax.status == 200) {
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
					select_input.innerHTML = "<option>-- Choose staten --</option>";

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