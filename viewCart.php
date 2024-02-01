<title>View Cart</title>

<style>
    .viewCart {
        margin-top: 5%;
        background-color: #e6acb9;
    }

    .viewCart>div {
        background-color: rgb(246, 244, 244);
    }

    .image>img {
        border: 3px solid #e6acb9;
    }

    .box>button {
        height: 50px;
        background-color: #e6acb9;
    }

    .image>img {
        transition: 0.5s ease;
    }

    .image>img:hover {
        transform: scale(1.5);
    }

    .quantity>h6>input {
        width: 50%;
        margin-top: -5%;
    }

    .delete>h6{
        color: black;
        cursor: pointer;
    }
</style>

<!-- Include navbar start -->
<?php include("navbar.php") ?>
<!-- Include navbar end -->
<hr>

<!-- Include connection file start -->
<?php include("connection.php") ?>
<!-- Include connection file end -->


<?php
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    // Get the userId via email which is stored in session
    session_start();
    $email = $_SESSION["email"];

    $sql = "SELECT * FROM userRegistration WHERE email='$email'";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();
    $userId = $user["userId"];

    // Get the product id from the cart based on userId
    $sql = "SELECT * FROM CartItem WHERE userId='$userId'";
    $result = $conn->query($sql);

    $productIds = "";

    while ($cart = $result->fetch_assoc()) {
        $productId = $cart["productId"];
        $productIds .= $productId . ',';
    }

    // Remove the trailing comma
    $productIds = rtrim($productIds, ',');

    // Check if there are any productIds before executing the next query
    if (!empty($productIds)) {
        $totalItem = 0;
        $totalAmount = 0;

        $sql = "SELECT * FROM Product t1 JOIN CartItem t2 ON t1.id = t2.productId WHERE t2.userId = '$userId'";
        $result = $conn->query($sql);

        echo
        "<div class='container rounded viewCart'> 
                    <br>
                        <span class='h1 text-white fw-bold mx-5 text-uppercase'>Your&nbsp;💫&nbsp;cart&nbsp;<i class='bi bi-cart3'></i></span>
                    <br>
                ";
        echo
        "<br>
                    <div class='row rounded mx-5'>
                        <div class='col-lg-2 text-center'>
                            <h6 class='my-2'>Image</h6>
                        </div>
                        <div class='col-lg-2 text-center'>
                            <h6 class='my-2'>Name</h6>
                        </div>
                        <div class='col-lg-2 text-center'>
                            <h6 class='my-2'>Quantity</h6>
                        </div>
                        <div class='col-lg-2 text-center'>
                            <h6 class='my-2'>Unit Price</h6>
                        </div>
                        <div class='col-lg-2 text-center'>
                            <h6 class='my-2'>Total Price</h6>
                        </div>
                        <div class='col-lg-2 text-center'>
                            <h6 class='my-2'>Delete</h6>
                        </div>
                    </div> 
                <br>";
        while ($data = $result->fetch_assoc()) {
            $totalItem += 1;
            $totalAmount += $data["price"] * $data["quantity"];

            $totalPrice = 0;
            $totalPrice = $data["price"] * $data["quantity"];

            echo
            "<div class='row rounded py-3 my-2 mx-5 cartUpdate'>
                        <div class='col-lg-2'>
                            <div class='image text-center'>
                                <img src='{$data['image']}' class='w-50 rounded-circle' alt=''>
                            </div>
                        </div>
                        <div class='col-lg-2'>
                            <div class='name text-center'>
                                <h6 style='margin-top:20%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;'>{$data['name']}</h6>
                            </div>
                        </div>
                        <div class='col-lg-2'>
                            <div class='quantity text-center'>
                                <h6 style='margin-top:18%; margin-left:25%;'>
                                    <input type='number' min=1 value={$data['quantity']} cartNo={$data['cartId']} currPrice={$data['price']} class='getQuantity form-control'>
                                </h6>
                            </div>
                        </div>
                        <div class='col-lg-2'>
                            <div class='price text-center'>
                                <h6 style='margin-top:20%;'>$ {$data['price']}</h6>
                            </div>
                        </div>
                        <div class='col-lg-2'>
                            <div class='price text-center'>
                                <h6 style='margin-top:20%;' id='totalPrice'>$ {$totalPrice}.00</h6>
                            </div>
                        </div>
                        <div class='col-lg-2'>
                            <div class='delete text-center'>
                                <h6 style='margin-top:20%;' class='deleteCartItem' cartId={$data['cartId']} cartIdPrice={$totalPrice}><i class='bi bi-x-lg'></i></h6>
                            </div>
                        </div>
                    </div>
                    <br>";
        }
        echo
        "<div class='container w-50 mx-5 rounded summary'>
                        <div class='box'>
                            <h2 class='py-3 mx-3 text-uppercase'>Cart Summary</h2>
                            <h5 class='mx-5 text-uppercase'>item count &nbsp;<span id='cartItemCount' style='background-color:black; padding:4px 9px; color:white; border-radius:60px'>$totalItem</span></h5>
                            <h5 class='mx-5 text-uppercase' id='grandTotal'>total amount $ {$totalAmount}</h5>
                            <button type='submit' class='mx-5 my-3 border-0 rounded w-25'><a href='#' class='h5 fw-bold text-uppercase text-white' id='orderNow'>order now</a></button>
                        </div>
                    </div> <br>";
        echo "</div>";
    } else {
        echo
        "<div class='container h-50' style='display:flex; justify-content:center; align-items:center'>
                    <div class='heading my-5'>
                        <h1 class='text-center'>Your cart is empty</h1>
                        <a class='h3 text-center'>Go and buy your favourite products.</a><br>
                        <div class='text-center my-2 text-primary'><a class='h5' href='/index.php'>Buy Now</a></div>
                        <div class='text-center my-2 text-primary'><a class='h5' href='/myOrders.php'>View orders</a></div>
                    </div>
                </div>";
    }
}
?>

<!-- Include footer start -->
<?php include("footer.php") ?>
<!-- Include footer end -->

<!-- Increase & decrease cart item quantity -->
<script>
    $(document).ready(function() {
        $(".getQuantity").click(function(e) {
            e.preventDefault();

            let quantity = $(this).val();
            let cartId = $(this).attr("cartNo");
            let currentPrice = $(this).attr("currPrice");
            let totalPrice = $("#totalPrice").text().split(" ")[1];


            quantity = Number(quantity, 10);
            currentPrice = Number(currentPrice);

            let grandTotal = Number($("#grandTotal").text().split(" ")[3]);
            $("#grandTotal").text(`TOTAL AMOUNT $ ${grandTotal + currentPrice}`)

            mythis = this

            $.ajax({
                type: "POST",
                url: `process.php?quantity=${quantity}&cartItemId=${cartId}`,
                success: function() {
                    let total = currentPrice * quantity;
                    $(mythis).closest('.cartUpdate').find('#totalPrice').text(`$ ${total}.00`);
                }
            })
        })
    })
</script>

<!-- Delete cart item functionality -->
<script>
    $(".deleteCartItem").click(function (e) {
    e.preventDefault();
     
    let cartId = $(this).attr("cartId");
    let currCartPrice = Number($(this).attr("cartIdPrice"));
    
    let grandTotal = Number($("#grandTotal").text().split(" ")[3]);
    $("#grandTotal").text(`TOTAL AMOUNT $ ${grandTotal - currCartPrice}`)

    $.ajax({
        type:"POST",
        url: `process.php?id=${cartId}`,
        success:function(){
            // Update the cart count when cartItem delete
            let cartCount = Number($("#cartCount").text());
            $("#cartCount").text(cartCount-=1);

             // Update the cart count when cartItem deleted
            let cartItemCount = Number($("#cartItemCount").text());
            $("#cartItemCount").text(cartItemCount-=1)

            Swal.fire({icon:"success", text:"Item deleted", timer:1000, showCancelButton:false, showConfirmButton:false})
        }
    });
    // Remove the cartItem details when cartItem deleted
    $(this).closest('.cartUpdate').remove();
 })
</script>

<!-- Order now functionality -->
<script>
    $(document).ready(function () { 
        $("#orderNow").click(function (e) { 
            e.preventDefault();

            $.ajax({
                type:"POST",
                url: "order.php",
                success:function(data){
                    if(data){
                        $(".viewCart").children().remove();
                        $(".viewCart").append("<div class='container h-50' style='display:flex; justify-content:center; align-items:center'> <div class='heading my-5'><h1 class='text-center'>Your cart is empty</h1><a class='h3 text-center'>Go and buy your favourite products.</a><br><div class='text-center my-2 text-primary'><a class='h5' href='/index.php'>Buy Now</a></div></div></div>")
                        $(".viewCart").css({backgroundColor:'white'})
                        $(".viewCart").children().css({backgroundColor:'white'})
                        Swal.fire({icon:"success", text:"Order placed successfully!", timer:1000, showCancelButton:false, showConfirmButton:false})
                    }
                }
            })
        })
     })
</script>


<!-- Reload page in every 30 seconds start -->
<script>
    var isMouseActive = false;
    var isKeyPressed = false;
    var timeout = '';
    // Event listener for mousemove
    $(document).on('mousemove', function () {
        isMouseActive = true;
        clearTimeout(timeout);
        // Reset the flag after 5 seconds
        timeout = setTimeout(function () {
            isMouseActive = false;
            console.log(isMouseActive);
        }, 5000);
    });

    // Event listener for keydown
    $(document).on('keydown', function () {
        isKeyPressed = true;
        clearTimeout(timeout);

        // Reset the flag after 5 seconds
        timeout = (function () {
            isKeyPressed = false;
        }, 5000);
    });

    function checkForNewOrders() {
        // Check if the mouse is active or a key is pressed
        if (!isMouseActive && !isKeyPressed) {
            window.location.reload();
        }
    }
    setInterval(checkForNewOrders, 10000);
</script>
<!-- Reload page in every 30 seconds end -->