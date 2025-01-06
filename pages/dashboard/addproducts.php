<?php
session_start();
?>
<?php
if (isset($_POST["add_product"])) {
  $product_name = $_POST["product_name"];
  $product_price = $_POST["product_price"];
  $product_image = $_POST["product_image"];

  $errors = array();

  if (empty($product_name) || empty($product_price) || empty($product_image)) {
    array_push($errors, "All fields are required");
  }

  if (strlen($product_price) < 0) {
    array_push($errors, "Product price must be at least 0$");
  }

  if (!empty($product_name)) {
    require_once "../database.php";

    $sql = "SELECT * FROM products WHERE product_name = ?";
    $stmt = mysqli_stmt_init($conn);

    if (mysqli_stmt_prepare($stmt, $sql)) {
      mysqli_stmt_bind_param($stmt, "s", $product_name);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      $rowCount = mysqli_num_rows($result);

      if ($rowCount > 0) {
        array_push($errors, "Product name already exists!");
      }
    } else {
      die("Something went wrong with the prepared statement.");
    }
  }

  if (count($errors) > 0) {
    foreach ($errors as $error) {
      echo "<div class='alert alert-danger'>$error</div>";
    }
  } else {
    $sql = "INSERT INTO products (product_name, product_price, product_image) VALUES (?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);

    if (mysqli_stmt_prepare($stmt, $sql)) {
      mysqli_stmt_bind_param($stmt, "sss", $product_name, $product_price, $product_image);
      mysqli_stmt_execute($stmt);
      echo "<div class='alert alert-success'>You added a product successfully.</div>";
    } else {
      die("Something went wrong with the insert statement.");
    }
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ADD PRODUCTS</title>
  <link rel="stylesheet" href="../../Styles/addproducts.css">
  <link rel="stylesheet" href="../../Styles/header.css">
</head>

<body>
  <?php include('headerd.php'); ?>
  <div class="container">

    <div class="addproduct-header">
      <header>Add product</header>
    </div>
    <form method="POST" action="addproducts.php" class="add-product">
      <div class="addproduct-box">
        <div class="input-box"><input type="text" name="product_name" class="input-field" placeholder="Enter product name" required> </div>
        <div class="input-box"> <input type="number" name="product_price" min="0" class="input-field" placeholder="Enter product price" required> </div>
        <div class="input-box"> <input type="file" name="product_image" class="input-field" required accept="image/png, image/jpg, image/jpeg, image/webp"> </div>
        <div class="input-box"> <input type="submit" name="add_product" class="submit-btn" value="Add product" required> </div>
      </div>

    </form>

  </div>
</body>

</html>