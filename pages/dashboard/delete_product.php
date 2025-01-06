<?php
include '../database.php';
if (isset($_GET['delete'])) {
  $delete_id = $_GET['delete'];
  $delete_query = mysqli_query($conn, "Delete from products where id=$delete_id") or
    die("Query failed");
  if ($delete_query) {
    echo "Product deleted ";
    header('location: viewproducts.php');
  } else {
    echo "Product not deleted ";
    header('location: viewproducts.php');
  }
}
