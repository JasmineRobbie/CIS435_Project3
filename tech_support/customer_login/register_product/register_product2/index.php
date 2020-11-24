<?php include '../../../view/header.php'?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel = 'stylesheet' href = '../../../main.css'>
</head>
<body>

<h2> Register Product </h2>
<?php

    if(isset($_GET['id'])){

        $productCode = $_GET['id'];

        echo "<p>Product (".$productCode.") was registered successfully</p>";

    }




?>




</body>
</html>






<?php include '../../../view/footer.php'?>
