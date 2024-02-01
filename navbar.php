<!-- Include all required cdn's start -->
<?php include("cdn.php") ?>
<!-- Include all required cdn's end -->

<?php include("connection.php") ?>

<?php
if ($conn->connect_error) {
  die("Failed connection" . $conn->connect_error);
} else {
  // Get the userId via email which is stored in session
  session_start();
  $email = $_SESSION["email"];

  $sql = "SELECT * FROM userRegistration WHERE email='$email'";
  $result = $conn->query($sql);
  $user = $result->fetch_assoc();
  $userId = $user["userId"];

  // Get the product id from the cart based on userId
  $sql = "SELECT * FROM CartItem WHERE userId='$userId'";
  $result = $conn->query($sql);
  $count = $result->num_rows;
}
?>

<!-- Navbar start -->
<nav class="navbar navbar-expand-lg sticky-top" style='background-color:white'>
  <div class="container">
    <a class="navbar-brand logo" href="/index.php">Notebook&nbsp;💫&nbsp;therapy</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="index.php">Home</a>
        </li>
        
        <li class="nav-item">
          <a class="nav-link" href="about.php">About</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="contact.php">Contact</a>
        </li>

        <?php
        session_start();
        if (!$_SESSION["email"]) {
          echo
          '<li class="nav-item">
                <a class="nav-link" href="signin.php">SignIn</a>
              </li>';
        } else {
          echo
          '<li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
              </li>';
        }
        ?>
      </ul>

      <div class="d-flex ms-auto" role="search">
        <?php
        session_start();
        if ($_SESSION["email"]) {
          echo "<a href='viewCart.php' class='shopping'><span><i class='bi bi-cart-dash cart'></i>&nbsp; Shopping Cart&nbsp;<li class='mx-1 cartCount' id='cartCount'>$count</li></span></a>";
        } else {
          echo "<a href='signin.php' class='shopping'><span><i class='bi bi-cart-dash cart'></i>&nbsp; Shopping Cart&nbsp;</span></a>";
        }
        ?>

        <?php
        session_start();
        if ($_SESSION["email"] == "admin@gmail.com") {
          echo "<a href='admin.php' class='mx-3' style='margin-top:0px;'><i class='bi bi-person-circle fs-4'></i></a>";
        } else if ($_SESSION["email"] && $_SESSION["email"] != "admin@gmail.com") {
          echo "<a href='profile.php' class='mx-1' style='margin-top:0px;'><i class='bi bi-person-circle fs-4'></i></a>";
        } else {
          echo "<a href='signin.php' class='mx-3' style='margin-top:0px;'><i class='bi bi-person-circle fs-4'></i></a>";
        }
        ?>
      </div>
    </div>
  </div>
</nav>

<div class="container mt-4 mb-4 w-75">
  <ul class="allCategory">
    <div class="col-lg-2">
      <li class="type"><a href="index.php">All categories 👇</a></li>
    </div>

    <div class="col-lg-2">
      <li class="type"><a href="category.php?category=bullet journal">Bullet Journal 🌻</a></li>
    </div>

    <div class="col-lg-2">
      <li class="type"><a href="category.php?category=gift cards">Gift cards✨</a></li>
    </div>

    <div class="col-lg-2">
      <li class="type"><a href="category.php?category=tsuki">Tsuki ❣️</a></li>
    </div>

    <div class="col-lg-2">
      <li class="type"><a href="category.php?category=hinoki">Hinoki 🌲</a></li>
    </div>

    <div class="col-lg-2">
      <li class="type"><a href="category.php?category=seasonal launches">Seasonal Launches ⛄</a></li>
    </div>
  </ul>
</div>
<!-- Navbar end -->




<!-- 
  <li class="type"><a href="category.php?category=best sellers">Best Sellers ❣️</a></li>
    <li class="type"><a href="category.php?category=newest items">Newest items 🌻</a></li>
 -->