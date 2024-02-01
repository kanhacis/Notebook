<title>Category</title>

<!-- Include Navbar start -->
<?php include("navbar.php") ?>
<!-- Include Navbar end -->

<!-- Include connection file start -->
<?php include("connection.php") ?>
<!-- Include connection file end -->

<?php
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    $category = $_GET["category"];

    $sql = "SELECT * FROM Product WHERE category='$category'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<div class='container parent'>";
        while ($row = $result->fetch_assoc()) {
            echo
            "<div class='child'> 
                        <div class='image'> 
                            <a href='/productInfo.php?id={$row['id']}'>
                                <img src='{$row['image']}' width='100%' alt=''>
                            </a> 
                        </div> 
                        <div class='about'> 
                            <h6 style='white-space: nowrap; overflow: hidden; text-overflow: ellipsis;'>{$row['name']}</h6>
                            <h5 style='color: pink;' class='mb-5'>{$row['price']}</h5>
                        </div> 
                    </div>";
        }
        echo "</div><br><br>";
    } else {
        echo
        "<div class='container my-5 h-50'>
                    <h1 class='text-center' style='margin-top:5%;'>No Records Found!</h1>
                    <h2 class='text-center my-3'>Related to $category category</h2>
                </div>";
    }
    // Close connection 
    $conn->close();
}
?>

<!-- Include footer start -->
<?php include("footer.php") ?>
<!-- Include footer end -->