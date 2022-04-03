<?php

if (!isset($_GET['action'])) {
	$_GET['action'] = '';
}
session_start();

switch($_GET['action']){

	case 'addTopping': 
		$result = array();
		$result['errormsg'] = '';
		$result['success'] = 0;

		if (isset($_GET['topping']) && strlen(str_replace(' ', '', $_GET['topping'])) > 0 ) {
			if (!isset($_SESSION['toppings'])) {
				$_SESSION['toppings'] = array();
			}
			$_SESSION['toppings'][] = $_GET['topping'];
			$result['success'] = 1;
		} else {
			$result['success'] = 0;
			$result['errormsg'] = 'No Topping Entered';
		}

		echo json_encode($result);
		exit;
	break;

	case 'getToppings'; 
		$result = array();
		$result['errormsg'] = '';
		$result['success'] = 1;
		$result['toppings'] = array();

		if (isset($_SESSION['toppings'])) {
			$result['toppings'] = $_SESSION['toppings'];
			$result['success'] = 1;
		}

		echo json_encode($result);
		exit;
	break;

	case 'deleteTopping':

		$result = array();
		$result['errormsg'] = '';
		$result['success'] = 0;

		$toppingsBefore = count($_SESSION['toppings']);
		$toppings = $_SESSION['toppings'];

		if(sizeof($_SESSION['toppings']) > 1){
			array_splice($_SESSION['toppings'], $_GET['toppingId'], 1);
		}else{
			unset($_SESSION['toppings']);
		}

		if(!isset($_SESSION['toppings'])){
			$result['success'] = 1;
			echo json_encode($result);
			return;
		}

		if(count($_SESSION['toppings']) < $toppingsBefore){
			$result['success'] = 1;
		}else{
			$result['errormsg'] = "The topping was not removed";
		}
		echo json_encode($result);
		exit;
	break;


	case 'updateCost': 
		$result = array();
		$result['errormsg'] = '';
		$result['success'] = 0;

		if (isset($_GET['costTopping']) && strlen(str_replace(' ', '', $_GET['costTopping'])) > 0 ) {
			if (!isset($_SESSION['costTopping'])) {
				$_SESSION['costTopping'] = array();
			}
			$_SESSION['costTopping'] = $_GET['costTopping'];
			$result['success'] = 1;
		} else {
			$result['success'] = 0;
			$result['errormsg'] = 'No cost Entered';
		}

		echo json_encode($result);
		exit;
	break;

	case 'getCost'; 
		$result = array();
		$result['errormsg'] = '';
		$result['success'] = 1;
		$result['costTopping'] = '';

		if (isset($_SESSION['costTopping'])) {
			$result['costTopping'] = $_SESSION['costTopping'];
			$result['success'] = 1;
		}

		echo json_encode($result);
		exit;
	break;



	default: 
		printForm();
}


function printForm()
{ ?>
	<!DOCTYPE html>
	<html>

	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Pizza delivery ACC</title>
		<link rel="icon" type="image/vnd.microsoft.icon" href="pizza.ico" sizes="32x32">

		<script src="./js/jquery.min.js"></script>
		<!-- CSS only -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
		<!-- JavaScript Bundle with Popper -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
		<!-- Animate.css source -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
		<!-- sweetalert2 soruce -->
		<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<!-- Mapbox -->
		<script src='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.js'></script>
		<link href='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.css' rel='stylesheet' />


	</head>

	<body>


	<!-- Navbar  -->
	<nav class="navbar navbar-expand-lg navbar-light bg-warning">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand animate__animated animate__backInRight animate__slower" href="#!">🚴‍♂️ Pizza delivery</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    </ul>
                    <form class="d-flex">
                        <button class="btn btn-outline-dark" type="submit">
                            <i class="bi-cart-fill me-1"></i>
                            Cart
                            <span class="badge bg-dark text-white ms-1 rounded-pill">
								1
							</span>
                        </button>
                    </form>
                </div>
            </div>
        </nav>



		<!-- Header -->
        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder animate__animated animate__rubberBand">JUST SAY PIZZA! 🍕</h1>
                    <p class="lead fw-normal text-white-50 mb-0">The best pizza in the whole world!</p>
                </div>
            </div>
        </header>








		<!-- Page content -->
		<section>
			<div class="row mt-4 mx-0">

				<!-- Card section  -->
				<div class="col-8">
					<h1 class="text-center">Toppings list</h1>

					<div class="container px-4 px-lg-5 mt-5">
						<div id="card-toppings" class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
						</div>
					</div>
				</div>




				<!-- Recive section  -->
				<div class="col-4 px-3">

					<!-- Table elements -->
					<h1 class="text-center">Your order</h1>
					<table class="table table-striped">
					<thead>
						<tr>
						<th scope="col">List of products</th>
						<th scope="col">$</th>
						</tr>
					</thead>
					<tbody>
						<tr>
						<th class="text-capitalize" scope="row">sodas</th>
						<td>$11.99</td>
						</tr>
						<tr>
						<th class="text-capitalize" scope="row">classic pizza</th>
						<td>$12.99</td>
						</tr>
						<tr>
						<th class="text-capitalize" scope="row">extra toppings</th>
							<td>$ <span id="ToppingsCost">0</span></td>
						</tr>


						<tr class="table-info">
						<th scope="row">
							<div class="text-center">
								Total:
							</div>
						</th>
						<td><strong>$<span id="TotalCost">24.99</span></strong></td>
						</tr>
					</tbody>
					</table>
					<div class="mt-4 text-center">

						<div class="row">
							<div class="col-6">
								<form action="https://www.paypal.com/donate" method="post" target="_blank">
									<input type="hidden" name="hosted_button_id" value="P7D2MFG462U34" />
									<input type="image" src="https://www.paypalobjects.com/en_US/MX/i/btn/btn_donateCC_LG.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
									<img alt="" border="0" src="https://www.paypal.com/en_MX/i/scr/pixel.gif" width="1" height="1" />
								</form>
							</div>
							<div class="col-6">
								<button id="payment" type="button" class="btn btn-success">Submit Order</button>
							</div>
						</div>



					</div>




					<!-- Topping list -->
							<div class="mt-5">
								<h3>Toppings in your cart: 
									<span id="LengthToppings">0</span>
								</h2>

								<div class="row">
									<div class="text-center">
										<ul class="p-0" id="listToppings"></ul>
									</div>
									
									<label class=" mt-3 mb-2" for="topping">Don't see your favorite topping listed? Let us know and we will call you to see if we can integrate it into your order
									(The final price may increase)
									</label>
									<div class="col-8">
										<div class="input-group mb-3">
											<div class="input-group-prepend">
												<span class="input-group-text" id="inputGroup-sizing-default">Your own topping:</span>
											</div>
											<input type="text" name="topping" id="topping" value="" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
										</div>
									</div>

									<div class="col-4">
										<button type="button" onclick="addTopping()" class="btn btn-warning">Add it!</button>
									</div>
								</div>
							</div>



					<!-- Map -->
					<h4 class="mt-5">Approximate delivery area</h4>
					<div id='map' style='width: 500px; height: 200px;'></div>
					<small>
						Isn't that your address? Don't worry! you can drag the marker to another part of the map
					</small>
					<script src="./js/maps.js"></script>
				</div>






			</div>
        </section>












		<script src="./js/index.js"></script>
	</body>





	<footer class="py-5 bg-dark">
    	<div class="container"><p class="m-0 text-center text-white">Copyright &copy; 2022 by Alexander Carreno </p></div>
    </footer>


	</html>
<?php
}
?>