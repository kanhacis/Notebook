<!-- Include connection file start -->
<?php include("connection.php") ?>
<!-- Include connection file end -->

<?php
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    $msg = "";

    $productId = $_GET["id"];

    // Get the userId via email which is stored in session
    session_start();
    $email = $_SESSION["email"];

    $sql = "SELECT * FROM userRegistration WHERE email='$email'";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();
    $userId = $user["userId"];

    // Check the product already in the cart
    $sql = "SELECT * FROM CartItem WHERE userId=$userId AND productId=$productId";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        header("Location: productInfo.php?id=$productId");
    } else {
        // Insert the product item in the cart
        $query = "INSERT INTO CartItem (userId, productId, quantity) VALUES($userId, $productId, 1)";
        $result = $conn->query($query);
        if ($result === TRUE) {
            header("Location: productInfo.php?id=$productId");
        } else {
            header("Location: index.php");
        }
    }
}
?>