<?php include '../view/header.php';

require('../model/database.php');
?>
<head>
  <link rel="stylesheet" type="text/css" href="../main.css">
</head>

<script language="Javascript" type="text/javascript">
  function validate(x) {
    if (confirm("OK to delete " + x + "?")) {
      return true;
    }
    else {
      return false;
    }
  }
  </script>
<main>

    <h1>Product List</h1>

    <!-- display a table of technicians -->
    <table>
        <tr>
            <th>Code</th>
            <th>Name</th>
            <th>Version</th>
            <th>Release Date</th>
            <th>&nbsp;</th>
        </tr>
        <?php foreach ($products as $products) : ?>
        <tr>
            <td><?php echo htmlspecialchars($products->getCode()); ?></td>
            <td><?php echo htmlspecialchars($products->getName()); ?></td>
            <td><?php echo htmlspecialchars($products->getVersion()); ?></td>
            <td><?php echo htmlspecialchars($products->getReleaseDate()); ?></td>
            <td><form action="." method="post">
                <input type="hidden" name="action"
                       value="delete_technician">
                <input type="hidden" name="technician_id"
                       value="<?php echo htmlspecialchars($technician->getID()); ?>">
                <input type="submit" value="Delete">
            </form></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <p><a href="?action=show_add_form">Add Products</a></p>

</main>
<?php include '../view/footer.php'; ?>
