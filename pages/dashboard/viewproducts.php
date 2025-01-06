<?php
session_start();
include('../database.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Products</title>
  <link rel="stylesheet" href="../../Styles/viewproducts.css">
  <link rel="stylesheet" href="../../Styles/header.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
  <?php include('headerd.php'); ?>

  <div class="container">
    <section class="display_product">
      <table>
        <thead>
          <tr>
            <th>Product Id</th>
            <th>Product Image</th>
            <th>Product Name</th>
            <th>Product Price</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="product-table">
          <?php
          $display_product = mysqli_query($conn, "SELECT * FROM `products`");
          if (mysqli_num_rows($display_product) > 0) {
            $sl_no = 1;
            while ($row = mysqli_fetch_assoc($display_product)) {
              $image_path = $row['product_image'];
              if (!file_exists($image_path)) {
                $image_path = '../../image/default_image.webp';
              }
              echo "<tr id='product-" . $row['id'] . "'>";
              echo "<td>" . $sl_no++ . "</td>";
              echo "<td><img src='../../image/" . $row['product_image'] . "' alt='Product Image' class='product-image'></td>";
              echo "<td>" . htmlspecialchars($row['product_name']) . "</td>";
              echo "<td>$" . htmlspecialchars($row['product_price']) . "</td>";
              echo "<td>
                      <a href='#' class='delete_product_btn' data-id='" . $row['id'] . "' title='Delete Product'>
                        <img src='../../Images/delete.png' alt='Delete' class='icon'>
                      </a>
                      <a href='update_product.php?edit=" . $row['id'] . "' class='update_product_btn' title='Update Product'>
                        <img src='../../Images/update.png' alt='Update' class='icon'>
                      </a>
                    </td>";
              echo "</tr>";
            }
          } else {
            echo "<tr class='no-products'><td colspan='5'>No products available.</td></tr>";
          }

          ?>
        </tbody>
      </table>
    </section>
  </div>

  <script>
    $(document).ready(function() {
      $('.delete_product_btn').click(function(e) {
        e.preventDefault(); 
        var productId = $(this).data('id');

        if (confirm("Are you sure you want to delete this product?")) {
          $.ajax({
            url: 'delete_product.php',
            type: 'GET',
            data: {
              delete: productId
            },
            success: function(response) {
              $('#product-' + productId).remove();
            },
            error: function(xhr, status, error) {
              alert("Error: " + error); 
            }
          });
        }
      });
    });
  </script>

</body>

</html>