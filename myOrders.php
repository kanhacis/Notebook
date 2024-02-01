<title>myOrders</title>

<!-- Include Navbar start -->
<?php include("navbar.php") ?>
<!-- Include Navbar end -->

<!-- Include connection file start -->
<?php include("connection.php") ?>
<!-- Include connection file end -->

<style>
    table {
        width: 100%;
    }

    table>thead>tr>th {
        text-transform: uppercase;
        padding: 10px;
        border-bottom: 2px solid gray;
    }

    table>tbody>tr>td {
        padding: 10px;
        border-bottom: 1px solid silver;
    }
</style>


<!-- User orders start -->
<section style='height:85.5%; background-color:#f6f4f5;'>
    <div class="container main py-5 px-5">
        <span class="h1 fw-bold mb-0">My&nbsp;💫&nbsp;orders</span>

        <div class="row my-5">
            <table>
                <thead>
                    <tr>
                        <th>Order Id</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($conn->connect_error) {
                        die("Failed connection" . $conn->connect_error);
                    } else {
                        session_start();
                        $email = $_SESSION["email"];
                        $query1 = "SELECT * FROM userRegistration WHERE email='$email'";
                        $result = $conn->query($query1);
                        $user = $result->fetch_assoc();
                        $userId = $user["userId"];

                        // Get all order where userId=userId
                        $query2 = "SELECT * FROM Orders t1 JOIN Product t2 ON t1.productId=t2.id WHERE t1.userId=$userId";
                        $result = $conn->query($query2);

                        while ($row = $result->fetch_assoc()) {
                            $totalAmount = $row['quantity'] * $row['price'];
                            echo "
                                    <tr>
                                        <td>{$row['orderId']}</td>
                                        <td>{$row['name']}</td>
                                        <td>{$row['orderDate']}</td>
                                        <td>{$row['quantity']}</td>
                                        <td><i class='bi bi-currency-dollar'></i>{$row['price']}</td>
                                        <td><i class='bi bi-currency-dollar'>$totalAmount.00</i></td>
                                    </tr>
                                ";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<!-- User orders end -->