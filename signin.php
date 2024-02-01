<title>SignIn</title>

<!-- SignIn Logic in php start -->
<?php
function handleSiginForm()
{
  include "navbar.php";

  include "connection.php";

  if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    } else {
      $sql = "SELECT email, password FROM userRegistration WHERE email='$email'";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row["password"];

        if (password_verify($password, $hashedPassword)) {
          $_SESSION["email"] = $email;

          // Redirect to dashboard page
          header("Location: index.php");
        } else {
          $_SESSION["errMsg"] = "Invalid email or password! Please try again.";
        }
      }
    }
  }

  // Check if the user is already logged in 
  if (isset($_SESSION["email"])) {
    // You can redirect the user to the dashboard or home page
    header("Location: index.php");
    exit();
  }
}

// Call function
handleSiginForm();
?>
<!-- SignIn Logic in php end -->


<!-- SignIn start -->
<section class="vh-100" style="background-color: #f6f4f5; margin-bottom:-48px;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col col-xl-10">
        <div class="card" style="border-radius: 1rem;">
          <div class="row g-0">
            <div class="col-md-6 col-lg-7 d-flex align-items-center">
              <div class="card-body p-4 p-lg-5 text-black">

                <form method="POST" id="signin">
                  <div class="d-flex align-items-center mb-3 pb-1">
                    <span class="h1 fw-bold mb-0">Notebook&nbsp;💫&nbsp;therapy</span>
                  </div>

                  <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Sign into your account</h5>

                  <div class="form-outline mb-4">
                    <input type="email" name="email" id="email" class="form-control form-control-lg" />
                    <label class="form-label" for="email">Email address</label>
                  </div>

                  <div class="form-outline mb-4">
                    <input type="password" name="password" id="password" class="form-control form-control-lg" />
                    <label class="form-label" for="password">Password</label>
                  </div>

                  <?php
                  if ($_SESSION["errMsg"]) {
                    echo "<div class='alert alert-danger' role='alert'>Invalid email or password! Please try again.</div>";
                  }
                  $_SESSION["errMsg"] = "";
                  ?>

                  <div class="pt-1 mb-4">
                    <button class="btn btn-dark btn-lg btn-block" name="login" type="submit">SignIn</button>
                  </div>

                  <p class="mb-5 pb-lg-2" style="color: #393f81;">Don't have an account? <a href="signup.php" style="color: #393f81;">Register here</a></p>
                </form>
              </div>
            </div>
            <div class="col-md-6 col-lg-5 d-none d-md-block">
              <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/img1.webp" alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
            </div>
          </div>
        </div>
      </div>
    </div>
    <hr>
  </div>
</section>
<!-- SignIn end -->

<!-- Include footer start -->
<?php include("footer.php") ?>
<!-- Include footer end -->