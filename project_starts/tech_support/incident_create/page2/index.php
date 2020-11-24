<?php include '../../view/header.php'?>
<?php require_once('../../model/database.php');

    //if(isset($_POST['customerID']))
    if(isset($_GET['customerID']))
    {
        //retrieve data
        $customerID = $_GET['customerID'];
        $customerQuery = "SELECT `firstName`, `lastName` FROM `customers` WHERE customerID = :customerID";
        $executeCustomerInfo = $db->prepare($customerQuery);
        $executeCustomerInfo->bindValue(':customerID', $customerID);
        
        if($executeCustomerInfo->execute()){
            $elements = $executeCustomerInfo->fetchAll();

            foreach($elements as $rows)
            {
                $firstName = $rows['firstName'];
                $lastName = $rows['lastName'];
            }
        }
    }
?>

<?php
    $productQuery = "SELECT `productCode` FROM `registrations` WHERE customerID = :customerID";
    $productInfo = $db->prepare($productQuery);
    $productInfo->bindValue(':customerID',$customerID);

    if($productInfo->execute())
    {
        $productCodesList = array();
        $productNamesList = array();

        while($elements = $productInfo->fetch())
        {
            $productNameQuery = "SELECT `name` FROM `products` WHERE productCode = :productCode";
            $executeProductInfo = $db->prepare($productNameQuery);
            $executeProductInfo->bindValue(':productCode', $elements['productCode']);

            if($executeProductInfo->execute())
            {
                while($productName = $executeProductInfo->fetch())
                {
                    array_push($productNamesList, $productName['name']);
                }
            }   
         }
     }
        
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Create Incident Page 2</title>
        <link rel='stylesheet' href = '../../main.css'>
    </head>

    <h1>
        Create Incident
    </h1>

    <body>
        <main>
            <table  style = 'border: none;'>
                    <form method="post">
                        <tr>
                            <td style = 'border: none;'>Customer:</td>
                            <td style = 'border: none;'><p name="customer_name"><?php echo $firstName.' '.$lastName?></p></td>
                        </tr>
                        <tr>
                            <td style = 'border: none;'>Product:</td>
                            <td style = 'border: none;'>
                            
                                <select single = 'single' name = 'product_name'>

                                    <?php 

                                        foreach($productNamesList as $productNames){
                                            echo "<option>" .$productNames. "</option>";
                                        }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td style = 'border: none;'>Title:</td>
                            <td style = 'border: none;'><input type = 'text' name="title"></p></td>
                        </tr>
                        <tr>
                            <td style = 'border: none;'>Description:</td>
                            <td style = 'border: none;'><textarea type = 'text' name="description"></textarea></td>
                        </tr>
                        <tr>
                            <td style = 'border: none;'></td>
                            <td style = 'border: none;'><button type = 'submit' name="createIncidentButton">Create Incident</button></td>
                        </tr>
                    </form>

                    <?php

                        if(isset($_POST['createIncidentButton']))
                        {
                            $productCodeQuery = "SELECT `productCode` FROM `products` WHERE `name` = :name";
                            $executeSearch = $db->prepare($productCodeQuery);
                            $executeSearch->bindValue(':name', $_POST['product_name']);

                            if($executeSearch->execute()){
                                
                                $productCode = $executeSearch->fetch();

                                $createIncidentQuery = "INSERT INTO `incidents`(`customerID`, `productCode`,`title`, `description`) VALUES (:customerID,:productCode,:title,:description)";

                                $executeStatement = $db->prepare($createIncidentQuery);

                                $executeStatement->bindValue(':customerID', $customerID);
                                $executeStatement->bindValue(':productCode', $productCode['productCode']);
                                $executeStatement->bindValue(':title', $_POST['title']);
                                $executeStatement->bindValue(':description', $_POST['description']);

                                if($executeStatement->execute()){
                                    echo "executed";
                                    header('location: page3/index.php');
                                }else{
                                    echo "Oops! something went wrong";
                                }
                            }
                        }
                    ?>
            </table>
        </main>
    </body>
</html>

<?php include '../../view/footer.php'?>