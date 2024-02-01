<!-- Include connection file start -->
<?php include("connection.php") ?>
<!-- Include connection file end -->

<?php
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    session_start();
    $email = $_SESSION["email"];

    # Get the active user id using email
    $sql = "SELECT * FROM userRegistration WHERE email='$email'";
    $result = $conn->query($sql);
    $data = $result->fetch_assoc();
    $id = $data["userId"];

    # Get all the product id of active user from the CartItem
    $sql = "SELECT * FROM CartItem WHERE userId = $id";
    $result = $conn->query($sql);
    $length = $result->num_rows;

    while ($data = $result->fetch_assoc()) {
        // Insert cart items in order table
        $pId = $data["productId"];
        $qt = $data["quantity"];
        $query1 = "INSERT INTO Orders (userId, productId, quantity) VALUES($id, $pId, $qt)";
        $conn->query($query1);

        // Remove products which are present in your cart
        $query2 = "DELETE FROM CartItem WHERE userId=$id AND productId=$pId";
        $conn->query($query2);
    }
    header("Location: myOrders.php");
}
?>