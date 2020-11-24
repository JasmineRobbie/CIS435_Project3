
 <?php

 include('../model/database.php');

	function searchCustomersByLastName($last_name)
	{
		global $db;
		$query = "SELECT * FROM customers WHERE lastName = '$last_name'";

		$statement = $db->prepare($query);
		$statement->execute();
		$customers = $statement->fetchAll();
		$statement->closeCursor();	
		return $customers;
	}

 ?>
 <?php 	include('../view/header.php'); ?> 

 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Search</title>
    <link rel= 'stylesheet' href='../main.css'>
</head>
	<main>
		<h1>Customer Search</h1>
		<form method="post">
				<table class="table">
					<tr>
						<td><lable>Last Name: </lable></td>
						<td><input type="text" name="last_name"  /></td>
						<td><input type="submit" name="searchForm" value="Search" /></td>
					</tr>
				</table>
		</form>
		
		<?php 

if(isset($_POST['searchForm']) )
{
	$last_name = htmlspecialchars($_POST['last_name']);
	$customers = "";
	if($last_name != ""){
		$customerInfo = searchCustomersByLastName($last_name);
	}

	if(!$customerInfo)
	{
		?> <h2>No Result</h2> <?php
	}
	else
	{
		?>
			<h1>Results</h1>

			<table>
				<tr>
					<td>Name</td>
					<td>Email Address</td>
					<td>City</td>
					<td></td>
				</tr>
				
				<?php foreach ($customerInfo as $customer)  
				{?> 
					<tr>
						<td>
							<?php echo $customer['firstName'] . " " 
							. $customer['lastName']; ?>
						</td>
						<td><?php echo $customer['email']; ?></td>
						<td><?php echo $customer['city']; ?></td>
						<td><form action="update_customer_info.php" method="post"
							id="updateCustomer">
						<input type="hidden" name="customer_id"
						value="<?php echo $customer['customerID']; ?>"/>
						<input type="submit" value="Select" name="updateCustomerForm" />
						</form>
						</td>
					</tr>
				<?php 
				}?>
			</table>
		<?php 
	}
}

?>
</main>
<?php include('../view/footer.php'); ?>  
