<title>SignUp</title>

<!-- Include connection file start -->
<?php include("navbar.php") ?>
<!-- Include connection file end -->

<!-- Include connection file start -->
<?php include("connection.php") ?>
<!-- Include connection file end -->

<!-- Get the data from the signup page start -->
<?php

$errMsg = "";

if (isset($_POST["registration"])) {
  $email = $_POST["email"];
  $password1 = $_POST["password1"];
  $password2 = $_POST["password2"];

  if ($password1 != $password2) {
    $errMsg = "Password and confirm password do not match.";
  } 
  else {
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    } 
    else {
      $check_query = "SELECT email FROM userRegistration WHERE email='$email'";
      $result = $conn->query($check_query);

      if ($result->num_rows > 0) {
        $errMsg = "An account with this email already exists.";
      } 
      else if($password1 != $password2){
        $errMsg = "Password & confirm password does not match.";
      }
      else {
        $hashed_password = password_hash($password1, PASSWORD_DEFAULT);

        $insert_query = "INSERT INTO userRegistration (email, password) VALUES('$email', '$hashed_password')";
        $result = $conn->query($insert_query);

        if ($result === TRUE) {
          $errMsg = "Registration successfully!";
        } 
        else {
          $errMsg = "Error during registration. Please try again.";
        }
      }
    }
  }
}
?>

<!-- Get the data from the singin page end -->
<!-- <script>
  $(document).ready(function() {
    $("#signup").submit(function(e) {
      e.preventDefault();

      let email = $("#email").val();
      let password1 = $("#password1").val();
      let password2 = $("#password2").val();

      if ((!email) || (!password1) || (!password2)) {
        Swal.fire({
          icon: "warning",
          text: "All fields are required!",
          timer: 1000,
          showCancelButton: false,
          showConfirmButton: false
        });
      } else if (password1 != password2) {
        Swal.fire({
          icon: "error",
          text: "Password & confirm password does not match!",
          timer: 1000,
          showCancelButton: false,
          showConfirmButton: false
        });
      } else {
        let myData = {
          email: email,
          password1: password1,
          password2: password2,
          signup: 1
        };
        $.ajax({
          type: "POST",
          url: window.location.href,
          data: myData,

          success: function(response) {
            Swal.fire({
              icon: "success",
              text: "Account created successfully!",
              timer: 1000,
              showCancelButton: false,
              showConfirmButton: false
            });
            $('#signup').trigger("reset");
          },
          error: function() {
            Swal.fire({
              icon: "error",
              text: "Something went wrong, try again",
              timer: 2000,
              showCancelButton: false,
              showConfirmButton: false
            });
          }
        });
      }

    });
  });
</script> -->



<!-- Signup start -->
<section class="vh-100" style="background-color: #f6f4f5; margin-bottom:-48px;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col col-xl-10">
        <div class="card" style="border-radius: 1rem;">
          <div class="row g-0">
            <div class="col-md-6 col-lg-5 d-none d-md-block">
              <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/img1.webp" alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
            </div>
            <div class="col-md-6 col-lg-7 d-flex align-items-center">
              <div class="card-body p-4 p-lg-5 text-black">

                <form method="POST">
                  <div class="d-flex align-items-center mb-3 pb-1">
                    <span class="h1 fw-bold mb-0">Notebook&nbsp;💫&nbsp;therapy</span>
                  </div>

                  <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Sign up your account</h5>

                  <div class="form-outline mb-4">
                    <input type="email" name="email" id="email" class="form-control form-control-lg" />
                    <label class="form-label" for="email">Email address</label>
                  </div>

                  <div class="form-outline mb-4">
                    <input type="password" name="password1" id="password1" class="form-control form-control-lg" />
                    <label class="form-label" for="password1">Password</label>
                  </div>

                  <div class="form-outline mb-4">
                    <input type="password" name="password2" id="password2" class="form-control form-control-lg" />
                    <label class="form-label" for="password2">Password (Again)</label>
                  </div>

                  <?php
                  if ($errMsg == "Registration successfully!") {
                    echo "<div class='alert alert-success' role='alert'>$errMsg</div>";
                  }
                  else if($errMsg == "An account with this email already exists."){
                    echo "<div class='alert alert-danger' role='alert'>$errMsg</div>";
                  }
                  else if($errMsg == "Error during registration. Please try again."){
                    echo "<div class='alert alert-danger' role='alert'>$errMsg</div>";
                  }
                  else if($errMsg == "Password and confirm password do not match."){
                    echo "<div class='alert alert-danger' role='alert'>$errMsg</div>";
                  }
                  ?>

                  <div class="pt-1 mb-4">
                    <button class="btn btn-dark btn-lg btn-block" name="registration" type="submit">SignUp</button>
                  </div>

                  <p class="mb-5 pb-lg-2" style="color: #393f81;">Already have an account? <a href="signin.php" style="color: #393f81;">Login here</a></p>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <hr>
  </div>
</section>
<!-- Signup end -->

<!-- Include footer start -->
<?php include("footer.php") ?>
<!-- Include footer end -->