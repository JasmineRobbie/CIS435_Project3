<?php
require_once('../../model/database.php');
require_once('../../model/customer_db.php');
require_once('../../model/product_db.php');
require_once('../../model/registration_db.php');


//$email = '';
//$results = array()'';

if(isset($_GET['email']))
{
    $email = $_GET['email'];

    $nameQuery = "SELECT `firstName`, `lastName`, `customerID` FROM `customers` WHERE email = :email";

    $executeName = $db->prepare($nameQuery);

    $executeName->bindValue(':email', $email);

    $executeName->execute();

    $results = $executeName->fetch();

    $customerID = $results['customerID'];
}


?>

<?php

    $productQuery = "SELECT `name`, `productCode` FROM `products`";



    $executeProduct = $db->prepare($productQuery);

    $executeProduct->bindValue(':email', $email);

    $executeProduct->execute();

    $productNames = $executeProduct->fetchAll();

    foreach($productNames as $rows){

        $productCode = $rows['productCode'];

    }



?>


<?php include '../../view/header.php'?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register Product Page 1</title>
    <link rel = "stylesheet" href = "../../main.css">
    </head>
    <body>
        <main>
            <h2>Register Product<h2>
                <table style = "border: none;">
                    <form method="post">
                                <tr>
                                    <td style = 'border: none;'>Customer:</td>
                                    <?php
                                        echo "<td style = 'border: none;'>";
                                        echo "<p>".$results['firstName'].' '.$results['lastName']."</p>";
                                        echo "</td>";
                                    ?>

                                </tr>
                                <tr>
                                    <td style = 'border: none;'>Product:</td>
                                    <td style = 'border: none;'>

                                        <select single = "single" name = 'product_name'>

                                            <?php

                                                foreach($productNames as $rows){

                                                    echo '<option>'.$rows['name'].'</option>';

                                                }


                                            ?>
                                        </select>

                                    </td>
                                </tr>


                                <tr>
                                    <td style = 'border: none;'></td>
                                    <td style = 'border: none;'><button name = 'registerButton'>Register Product</button></td>
                                </tr>


                                <?php

                                    if(isset($_POST['registerButton'])){

                                        $product_name = $_POST['product_name'];


                                        $productCodeQuery = "SELECT `productCode` FROM `products` WHERE `name` = :name";

                                        $executeProductCode = $db->prepare($productCodeQuery);

                                        $executeProductCode->bindValue(':name', $product_name);


                                        if($executeProductCode->execute()){

                                            if($results = $executeProductCode->fetch()){

                                                $productCode = $results['productCode'];
                                            }else{
                                                echo 'nothing';
                                            }







                                            $registerName = $_POST['product_name'];

                                            $registerQuery = "INSERT INTO `registrations`(`customerID`, `productCode`) VALUES (:customerID, :productCode)";

                                            $executeRegister = $db->prepare($registerQuery);

                                            $executeRegister->bindValue(':customerID', $customerID);
                                            $executeRegister->bindValue(':productCode', $productCode);



                                            if($executeRegister->execute()){

                                                echo "executed";

                                                header("location: register_product2/index.php?id=".$productCode);



                                            }else{
                                                echo 'Customer already registered';
                                            }
                                        }else{
                                            echo 'something went wrong';
                                        }

                                    }


                                ?>
                    </form>
                </table>
        </main>
    </body>
</html>

<?php include '../../view/footer.php'?>
