<title>Profile</title>

<!-- Include Navbar start -->
<?php include("navbar.php") ?>
<!-- Include Navbar end -->

<!-- Include connection file start -->
<?php include("connection.php") ?>
<!-- Include connection file end -->

<style>
    section {
        padding-top: 5%;
    }

    .main {
        border: 1px solid #8c8c8c;
        background-color: white;
        border-radius: 10px;
    }

    .navigate>li {
        padding: 0px 0px 10px 10px;
    }

    .navigate>li>a {
        color: #6666ff;
    }
</style>


<?php
session_start();
$userEmail = $_SESSION["email"];

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    if (isset($_POST["update"])) {
        $msg = "";

        $fname = $_POST["fname"];
        $lname = $_POST["lname"];
        $email = $_POST["email"];
        $mobile = $_POST["mobile"];
        $address = $_POST["address"];

        $sql = "SELECT * FROM userRegistration WHERE email='$userEmail'";
        $result = $conn->query($sql);
        $user = $result->fetch_assoc();
        $userId = $user["userId"];

        $sql = "UPDATE userRegistration SET email='$email', address='$address', fname='$fname', lname='$lname', mobile='$mobile' WHERE userId='$userId'";
        $result = $conn->query($sql);
        $_SESSION["email"] = $email;

        if ($result) {
            $msg = "Profile updated successfully!";
        }
    }
}

$sql = "SELECT * FROM userRegistration WHERE email='$email'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();
$userId = $user["userId"];
$fname = $user["fname"];
?>

<script>
    $(document).ready(function() {
        $("#updateProfile").submit(function(e) {
            e.preventDefault();

            let fname = $("#fname").val();
            let lname = $("#lname").val();
            let email = $("#email").val();
            let mobile = $("#mobile").val();
            let address = $("#address").val();

            if ((!fname) || (!lname) || (!email) || (!mobile) || (!address)) {
                Swal.fire({
                    icon: "warning",
                    text: "All fields are required!",
                    timer: 1000,
                    showCancelButton: false,
                    showConfirmButton: false
                });
            } else {
                let myData = {
                    fname: fname,
                    lname: lname,
                    email: email,
                    mobile: mobile,
                    address: address,
                    update: 1
                };
                $.ajax({
                    type: "POST",
                    url: "http://127.0.0.1:8001/profile.php",
                    data: myData,
                    success: function(data) {
                        if (data) {
                            Swal.fire({
                                icon: "success",
                                text: "Profile update successfully!",
                                timer: 1000,
                                showCancelButton: false,
                                showConfirmButton: false
                            })
                        }
                    }
                });
            }
        });
    });
</script>


<!-- User profile start -->
<section class="pb-2" style='background-color:#f6f4f5;'>
    <div class="container py-5 px-5">
        <div class="row">
            <div class="col-lg-8 main">
                <br>
                <span class="h1 fw-bold mx-4 mb-0">My&nbsp;💫&nbsp;profile</span>
                <form action="" method="POST" class="mx-4" id="updateProfile"><br><br>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-outline mb-4">
                                <input type="text" name="fname" id="fname" value="<?php echo $user['fname'] ?>" class="form-control form-control-lg" />
                                <label class="form-label" for="fname">First name</label>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-outline mb-4">
                                <input type="text" name="lname" id="lname" value="<?php echo $user['lname'] ?>" class="form-control form-control-lg" />
                                <label class="form-label" for="lname">Last name</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-outline mb-4">
                                <input type="email" name="email" id="email" value="<?php echo $user['email'] ?>" class="form-control form-control-lg" />
                                <label class="form-label" for="email">Email address</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-outline mb-4">
                                <input type="text" name="mobile" id="mobile" value="<?php echo $user['mobile'] ?>" class="form-control form-control-lg" />
                                <label class="form-label" for="mobile">Contact no.</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-outline mb-4">
                                <input type="text" name="address" id="address" value="<?php echo $user['address'] ?>" class="form-control form-control-lg" />
                                <label class="form-label" for="address">Address</label>
                            </div>
                        </div>
                    </div>

                    <?php
                    if ($msg) {
                        echo "<div class='row mx-1'>
                                    <div class='alert alert-primary' role='alert'>
                                        $msg
                                    </div>
                                </div>";
                    }
                    ?>

                    <div class="row">
                        <div class="mb-4">
                            <!-- <button class="btn btn-dark btn-lg btn-block" name="update" type="button" id="updateProfile">Update</button> -->
                            <input type="submit" value="Update" name="update" class="btn btn-dark">
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-lg-3 offset-1 main h-50">
                <br>
                <span class="h1 fw-bold mx-4 mb-0">Navigation's</span>
                <ul class="my-3 navigate">
                    <li><a href="/myOrders.php">My orders</a></li>
                    <li><a href="/index.php">All products</a></li>
                    <li><a href="/viewCart.php">My cart</a></li>
                    <li><a href="/contact.php">Contact</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>

<div>
    <h1>Hello, Kanha</h1>
</div>
<!-- User profile end -->
