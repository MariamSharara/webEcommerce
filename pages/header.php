<nav class="menu">
  <ul>
    <li>
      <a href="index.php"><img class="logo" src="../Images/logo.png" alt="nice logo" /></a>
    </li>
    <li><a href="About.php">About</a></li>
    <?php
    if (isset($_SESSION["user"])) {
      echo '<li><a href="logout.php">Logout</a></li>';
    } else {
      echo '<li><a href="login.php">Login</a></li>';
    }
    ?>
    <li><a href="cart.php">Cart</a></li>
  </ul>
</nav>