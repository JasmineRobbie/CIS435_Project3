<?php
require_once('../model/database.php');


$value = false;
$incorrectLogin = false;
if(isset($_POST['loginButton'])){

    $email = $_POST['email'];

    $emailQuery = "SELECT `email` FROM `customers` WHERE email  = :email";

    $executeStatement = $db->prepare($emailQuery);

    $executeStatement->bindValue(':email', $email);

    if($executeStatement->execute()){
        $results = $executeStatement->fetchAll();

        $rowCount = $executeStatement->rowCount();

        if($rowCount == 0){
            $incorrectLogin = true;
        }else{
            foreach($results as $row){
                $sendEmail = $row['email'];
                $value = true;

                header("location: register_product/index.php?email=".$sendEmail);


            }
        }



    }

}



?>





<?php include '../view/header.php'?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel = 'stylesheet' href = '../main.css'>
    <script src = 'scripts/validateForm.js'></script>
</head>
<body>
    <h2>Customer Login </h2>
    <p>You must login before you can register a product</p>

    <form method = 'post'>
        Email <input name = 'email' id = 'email' type = 'text'>
        <span>
            <button type ='submit' name = 'loginButton' onclick = "return validateForm()">Login</button>
        </span>
    </form>



</body>
</html>

<?php include '../view/footer.php'?>
