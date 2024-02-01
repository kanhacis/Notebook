<!-- Include connection file start -->
<?php include("connection.php") ?>
<!-- Include connection file end -->

<?php
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    $sql = "SELECT * FROM Product";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<div class='parent'>";
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
                            <h5 style='color: pink;' class='mb-5'><i class='bi bi-currency-dollar'></i>{$row['price']}</h5>
                        </div>
                    </div>";
        }
        echo "</div><br><br>";
    } else {
        echo "No records!";
    }

    // Close connection 
    $conn->close();
}
?>