<?php
session_start();
include('../database.php');
$product = null;
if (isset($_GET['edit'])) {
  $product_id = $_GET['edit'];
  $result = mysqli_query($conn, "SELECT * FROM products WHERE id = '$product_id'");
  $product = mysqli_fetch_assoc($result);
  if (!$product) {
    echo "Product not found.";
    exit;
  }
}

if (isset($_POST['update_product'])) {
  $product_name = $_POST['product_name'];
  $product_price = $_POST['product_price'];
  $product_image = $_FILES['product_image']['name'];
  $product_id = $_POST['product_id'];

  $errors = [];
  if (empty($product_name) || empty($product_price)) {
    $errors[] = "All fields are required.";
  }

  if (!empty($product_image)) {
    $target_dir = "../../image/";
    $target_file = $target_dir . basename($product_image);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp'];
    if (!in_array($imageFileType, $allowed_extensions)) {
      $errors[] = "Only JPG, JPEG, PNG, and WEBP images are allowed.";
    }

    if (empty($errors)) {
      move_uploaded_file($_FILES['product_image']['tmp_name'], $target_file);
    }
  } else {
    if ($product && isset($product['product_image'])) {
      $product_image = $product['product_image'];
    }
  }

  if (empty($errors)) {
    $sql = "UPDATE products SET product_name = ?, product_price = ?, product_image = ? WHERE id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sql)) {
      mysqli_stmt_bind_param($stmt, "ssss", $product_name, $product_price, $product_image, $product_id);
      if (mysqli_stmt_execute($stmt)) {
        echo "<div class='alert alert-success'>Product updated successfully.</div>";
        header("Location: viewproducts.php");
        exit;
      } else {
        echo "<div class='alert alert-danger'>Something went wrong. Please try again.</div>";
      }
    }
  } else {
    foreach ($errors as $error) {
      echo "<div class='alert alert-danger'>$error</div>";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update Product</title>
  <link rel="stylesheet" href="../../Styles/updateproducts.css">
  <link rel="stylesheet" href="../../Styles/header.css">
</head>

<body>
  <?php include('headerd.php'); ?>

  <div class="container">
    <div class="addproduct-header">
      <header>Update Product</header>
    </div>
    <?php if ($product): ?>
      <form method="POST" action="update_product.php" enctype="multipart/form-data" class="add-product">
        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">

        <div class="addproduct-box">
          <div class="input-box">
            <img src="../../image/<?php echo htmlspecialchars($product['product_image']); ?>" alt="Current Image" class="current-product-image">
          </div>

          <div class="input-box">
            <input type="text" name="product_name" class="input-field" value="<?php echo htmlspecialchars($product['product_name']); ?>" placeholder="Enter product name" required>
          </div>

          <div class="input-box">
            <input type="number" name="product_price" min="0" class="input-field" value="<?php echo htmlspecialchars($product['product_price']); ?>" placeholder="Enter product price" required>
          </div>

          <div class="input-box">
            <input type="file" name="product_image" class="input-field" accept="image/png, image/jpg, image/jpeg, image/webp">
          </div>

          <div class="input-box submit-btn-container">
            <input type="submit" name="update_product" class="submit-btn" value="Update Product">
            <button type="button" class="cancel-btn" onclick="window.location.href='viewproducts.php'">Cancel Product</button>
          </div>
        </div>
      </form>
    <?php else: ?>
      <div class="alert alert-danger">Product not found.</div>
    <?php endif; ?>
  </div>
</body>

</html>