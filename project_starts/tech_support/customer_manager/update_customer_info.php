<?php
	
	require('../model/database.php');


	function updateSelectedCustomerInfo($customerID, $firstName, $lastName, $address, $city, 
									$state, $postalCode, $countryCode, $phone, $email, $password){
		global $db;
		$query = "UPDATE customers SET 

	 				 firstName = '$firstName', lastName = '$lastName', address = '$address', city = '$city', 
	 				 state = '$state', postalCode = '$postalCode', countryCode = '$countryCode', phone = '$phone',
	 				 email = '$email', password = '$password'

				WHERE customerID = '$customerID'";

		$statement = $db->prepare($query);
		$statement->execute();
		$statement->closeCursor();

	}

	function getCustomerByCustomerID($customerID){
			global $db;

			$query = "SELECT * FROM customers WHERE customerID = '$customerID'";

			$statement = $db->prepare($query);
			$statement->execute();
			$customer = $statement->fetch();
			$statement->closeCursor();	
			return $customer;
	}

?>

 <?php 	include('../view/header.php'); ?> 

	<?php

	if(isset($_POST['submit_update_customer_form'])){

			$firstName = htmlspecialchars($_POST['firstName']);
		 	$lastName = htmlspecialchars($_POST['lastName']);
		 	$address = htmlspecialchars($_POST['address']);
		 	$city = htmlspecialchars($_POST['city']);
		 	$state = htmlspecialchars($_POST['state']);
		 	$postalCode = htmlspecialchars($_POST['postalCode']);
		 	$phone = htmlspecialchars($_POST['phone']);
		 	$email = htmlspecialchars($_POST['email']);
		 	$password = htmlspecialchars($_POST['password']);
		 	$countryCode = htmlspecialchars($_POST['countryCode']);
			$customerID = $_POST['customer_id'];		

		updateSelectedCustomerInfo($customerID, $firstName, $lastName, 
									$address, $city, $state, $postalCode, 
									$countryCode, $phone, $email, $password);
		
		header("Location: index.php");

		}

		else if(isset($_POST['updateCustomerForm'])){
				$customerID = $_POST['customer_id'];
				$customer =  getCustomerByCustomerID($customerID);
		?>

<main>
		
	 	<form method="post">
				<table class="noBorders">
					<tr>
						<td><label>First Name:</label></td>
						<td><input type="input" name="firstName"
						value="<?php echo $customer['firstName']?>"></td>
						<?php 
								if(isset($firstName_error)){ ?>
						<td>
							<?php echo $firstName_error; ?>
						</td>
						 <?php } ?>
					</tr>
					<tr>
						<td><label>Last Name:</label></td>
						<td><input type="input" name="lastName" 
						value="<?php echo $customer['lastName']?>"></td>
					</tr>
					<tr>
						<td><label>Address:</label></td>
						<td><input type="input" name="address" size="50"
						value="<?php echo $customer['address']?>"></td>
					</tr>
					<tr>
						<td><label>City:</label></td>
						<td><input type="input" name="city"
						value="<?php echo $customer['city']?>"></td>
					</tr>
					<tr>
						<td><label>State:</label></td>
						<td><input type="input" name="state"
						value="<?php echo $customer['state']?>"></td>
					</tr>
					<tr>
						<td><label>Postal Code:</label></td>
						<td><input type="input" name="postalCode"
						value="<?php echo $customer['postalCode']?>"></td>
					</tr>
					<tr>
						<td><label>Country Code:</label></td>
						<td><input type="input" name="countryCode"
						value="<?php echo $customer['countryCode']?>"></td>
					</tr>
					<tr>
						<td><label>Phone:</label></td>
						<td><input type="input" name="phone"
						value="<?php echo $customer['phone']?>"></td>
					</tr>
					<tr>
						<td><label>Email:</label></td>
						<td><input type="input" name="email" size="50"
						value="<?php echo $customer['email']?>"></td>
					</tr>
					<tr>
						<td><label>Password:</label></td>
						<td><input type="input" name="password"
						value="<?php echo $customer['password']?>"></td>
					</tr>
					<tr>
						<td><input type="hidden" name="customer_id"
						value="<?php echo $customer['customerID']; ?>"/></td>
						<td><input type="submit" value="Update Customer" name="submit_update_customer_form"></td>
					</tr>
				</table>

			</form>

			<p><a href="index.php">Search Customers</a></p>
</main>

		<?php } ?>

 <?php include('../view/footer.php'); ?>  

