<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Elie Saab</title>
  <link rel="stylesheet" href="../Styles/index.css" />
</head>

<body>
  <div class="page-1">
    <?php include('header.php'); ?>
    <div class="landing-slogan">
      <h1 class="h1-landing">ELIE SAAB</h1>
      <p class="p-landing">
        “Elegance is a statement, an attitude. Elegant women are women of
        character with confidence.”
      </p>
    </div>
    <div>
      <button class="shopnowbutton"><a href="shopping.php">SHOP NOW</a></button>
    </div>
  </div>
  <div class="page-2">
    <h1 class="h1-page2">Our Summer Collection - 2024</h1>
    <p class="p-page2">
      The collection embodies an enchanting journey of meticulously designed
      pieces that create magical moments for your little ones.
    </p>
    <img class="collection-spring-pic" src="../Images/collection.webp" alt="collection-spring-pic" />
  </div>
  <div class="page-3">
    <center>
      <h1 class="h1-page3">OUR PRODUCTS</h1>
    </center>
    <div class="product">
      <img src="../Images/product1.webp" alt="product1" class="pic" />
      <h5>CLASSIC COLLECTION</h5>
      <p>Our finest pieces made with unparalleled craftsmanship</p>
    </div>
    <div class="product">
      <img src="../Images/product3.webp" alt="product3" class="pic" />
      <h5>STATEMENT SELECTION</h5>
      <p>Spectacular fashion to spruce up any look</p>
    </div>
    <div class="product">
      <img src="../Images/product2.webp" alt="product2" class="pic" />
      <h5>BOLD MOVE</h5>
      <p>Unique pieces that bear our unique personality</p>
    </div>
  </div>
  <div class="page-4">
    <div class="det">
      <div class="img-details">
        <img class="elie" src="../Images/contact.webp" alt="ELIE" />
      </div>
      <div class="details">
        <h1 class="h1-page4">CONTACT DETAILS</h1>
        <div>
          <h3 class="h3-page4">MAILING ADDRESS</h3>
          <p class="p1-page4">LEBANON, Beirut District</p>
        </div>
        <div>
          <h3 class="h3-page4">EMAIl ADDRESS</h3>
          <p class="p2-page4">Eliesaab@email.com</p>
        </div>
        <div>
          <h3 class="h3-page4">PHONE NUMBER</h3>
          <p class="p3-page4">(+961)12-345-678</p>
        </div>
      </div>
    </div>
  </div>
</body>

</html>