<title>Admin</title>

<!-- Include Navbar start -->
<?php include("navbar.php") ?>
<!-- Include Navbar end -->

<!-- Include connection file start -->
<?php include("connection.php") ?>
<!-- Include connection file end -->

<!-- Product add code start -->
<?php
session_start();
if ($_SESSION["email"] == "admin@gmail.com") {
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        $msg = "";
        if (isset($_POST["addProduct"])) {
            $name = $_POST["name"];
            $price = $_POST["price"];
            $category = $_POST["category"];
            $desc = $_POST["desc"];

            if ($name && $price && $category && $desc) {
                if (isset($_FILES['image'])) {
                    move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $_FILES['image']['name']);
                    $image = "uploads/" . $_FILES['image']['name'];
                }

                // Use prepared statement to avoid SQL injection
                $sql = "INSERT INTO Product(name, price, category, image, description) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssss", $name, $price, $category, $image, $desc);
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    $msg = "Product added successfully!";
                } else {
                    $msg = "Something went wrong, Please try again!";
                }

                $stmt->close();
            } else {
                $msg = "All fields are required!";
            }
        }
    }
} else {
    header("Location: signin.php");
}
?>
<!-- Product add code end -->


<!-- Product add start -->
<section style="background-color: #f6f4f5; margin-bottom:-50px">
    <div class="container py-5">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col col-xl-10">
                <div class="card" style="border-radius: 1rem;">
                    <div class="d-flex align-items-center my-5 mx-5">
                        <span class="h1 fw-bold mb-0">Add&nbsp;💫&nbsp;your products</span>
                    </div>

                    <form method="POST" class="mx-5" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="price">Price</label>
                                <input type="number" class="form-control" name="price" id="price">
                            </div>
                        </div>

                        <div class="row my-3">
                            <div class="col-md-6">
                                <label for="category">Category</label>
                                <input type="text" class="form-control" name="category" id="category">
                            </div>
                            <div class="col-md-6">
                                <label for="image">Image</label>
                                <input type="file" class="form-control" name="image" id="image">
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-12">
                                <label for="desc">Description</label>
                                <textarea class="form-control" name="desc" id="desc" rows="7"></textarea>
                            </div>
                        </div>
                        <div class="row my-3">
                            <?php
                            if ($msg) {
                                echo
                                "<div class='alert alert-primary mx-3' role='alert'>
                                    $msg
                                </div>";
                            }
                            ?>
                        </div>
                        <div class="row my-3">
                            <div class="col-12">
                                <input type="submit" value="Add" name="addProduct" class="btn btn-dark w-100">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <hr>
</section>
<!-- Product add end -->


<!-- Include footer start -->
<?php include("footer.php") ?>
<!-- Include footer end -->