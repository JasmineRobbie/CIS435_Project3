<?php
require_once('../model/database.php');

$value = false;
$loginError = false;

if(isset($_POST['loginButton'])){

    $email = $_POST['email'];

   // $email = isset($_POST['email']) ? $_POST['name'] : '';
   // if(isset($_POST['loginButton']))
// {

    $emailQuery = "SELECT `email` FROM `customers` WHERE email  = :email";
    $execute = $db->prepare($emailQuery);
    $execute->bindValue(':email', $email);

    if($execute->execute()){
        $results = $execute->fetchAll();
        $rowCount = $execute->rowCount();

        if($rowCount == 0)
        {
            $loginError = true;
        }
        else
        {
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

        <!-- Call JS form to validate login -->
        <script src = 'scripts/Form.js'></script>
    </head>
    <body>
        <h2>Customer Login </h2>
        <p>You must login before you can register a product</p>

        <form method = 'post'>
            Email <input name = 'email' id = 'email' type = 'text'>
            <span>
                <button type ='submit' name = 'loginButton' onclick = "return Form()">Login</button>
            </span>
        </form>
    </body>
</html>

<?php include '../view/footer.php'?>
