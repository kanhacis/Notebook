<!-- Include connection file start -->
<?php include("connection.php") ?>
<!-- Include connection file end -->

<?php
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET["id"];
$quantity = $_GET["quantity"];
$cartItemId = $_GET["cartItemId"];

if ($id) {
    $sql = "DELETE FROM CartItem WHERE cartId=$id";
    $result = $conn->query($sql);

    if ($result === TRUE) {
        header("Location: viewCart.php");
    }
} else if ($quantity && $cartItemId) {
    $query = "UPDATE CartItem SET quantity=$quantity WHERE cartId=$cartItemId";
    $result = $conn->query($query);

    if ($result === TRUE) {
        header("Location: viewCart.php");
    }
}

?>