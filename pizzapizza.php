<?php

/* *************************************************************************
 * Welcome to the Mendoza Corporation, PIZZA PIZZA code exercise.  We'd like 
 * to get to know your skillset and style.  We have this "application", 
 * designed to let a user create a list of the toppings they want on their pizza.  
 * We store this list on the backend in case the user leaves the application
 * and returns to the application at a later time.  Normally this would be done
 * in a database, but for this exercise we are using a PHP session.
 * 
 * There is one problem -- it doesn't allow the user to remove a topping if
 * they change their mind.  We'd like you to add that functionality to the
 * application.  We would prefer you stick to AJAX so that the imaginary part 
 * of the application interface does not have to be reloaded.  Aside from that,
 * you have complete creative freedom. 
 * 
 * So, this is your time to shine!  Show us who you are and what you can do.
 * Use images, css, javascipt that you would like. Make us say WOW!!!
 * 
 * If you have any questions, need any help or explanation of any of the
 * code below, please don't hesitate to contact daniela@unilinktransportation.com
 * *************************************************************************
 */


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

	default: 
		printForm();
}


function printForm()
{ ?>
	<!DOCTYPE html>
	<html>

	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Pizza Pizza</title>
		<script src="./jquery.min.js"></script>
		<script src="./index.js"></script>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
		<script src="https://use.fontawesome.com/b27ae9c473.js"></script>
	</head>

	<body>

		<div class="container py-3">
			<div class="row">
				<div class="form-group col-sm-12 col-lg-4">
					<label for="topping">What topping would you like?</label>
					<div class="input-group mb-3">
						<input type="text"  name="topping" id="topping" value="" class="form-control" >
						<div class="input-group-append">
							<button class="btn btn-outline-primary" id="btnSubmit" name="btnSubmit" type="button" >Add it!</button>
						</div>
					</div>
				</div>
			</div>


			<div class="row">
				<div class="col-sm-12 col-lg-4">
					<h1>YOUR PIZZA 🍕:</h1>
					<ul class="list-group" id="listToppings"></ul>
					<p class="h5 mt-3 hasToppings">Looks Yummy! 🤤</p>
					<p class="h5 mt-3 isEmpty">Your pizza is a blank canvas, Add some toppings!</p>
				</div>
			</div>
		</div>

	</body>

	</html>
<?php
}
?>