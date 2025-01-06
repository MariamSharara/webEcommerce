<header>
  <div>
    <nav class="menu">
      <ul>
        <li>
          <a href="addproducts.php">Add products</a>
        </li>
        <li><a href="viewproducts.php">View products</a></li>
        <?php
        if (isset($_SESSION["user"])) {
          echo '<li><a href="../logout.php">Logout</a></li>';
        } else {
          echo '<li><a href="../login.php">Login</a></li>';
        }
        ?>
      </ul>
    </nav>
  </div>
</header>