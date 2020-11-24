<?php include '../view/header.php'?>
<?php require_once('../model/database.php');?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Incident</title>
    <link rel= 'stylesheet' href='../main.css'>
</head>
    <body>
        <main>
            <h2>Get Customer</h2>
            <p>You must enter the customer's email address to select the customer</p>

            <form method = 'post'>
                Email:
                <input type = 'text' name = 'email'>
                <span><button name = 'getCustomerButton'>Get Customer</button></span>
            </form>

            <?php
            //retrieve cutomer info
                if(isset($_POST['getCustomerButton']))
                {
                    $email = $_POST['email'];
                    $searchCustomerQuery = "SELECT `customerID` FROM `customers` WHERE email = :email";
                    $executeCustomerSearch = $db->prepare($searchCustomerQuery);
                    $executeCustomerSearch->bindValue(':email', $email);

                    //IF all goe well, next page
                    if($executeCustomerSearch->execute()){
                        $results = $executeCustomerSearch->fetch();
                        $customerID = $results['customerID'];
                        header("location: page2/index.php?customerID=".$customerID);
                    }
                }
            ?>
        </main>
    </body>
</html>

<?php include '../view/footer.php'?>