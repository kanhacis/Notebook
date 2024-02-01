<title>Product Info</title>

<!-- Include Navbar start -->
<?php include("navbar.php") ?>
<!-- Include Navbar end -->

<!-- Include connection file start -->
<?php include("connection.php") ?>
<!-- Include connection file end -->


<?php 
    $id = $_GET['id'];
    
    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }
    else{
        $sql = "SELECT * FROM Product WHERE id='$id'";
        $result = $conn->query($sql);

        $data = $result->fetch_assoc();
        
        // Close the result set
        $result->close();
    }
?>

<script>
    $(document).ready(function () { 
        $("#addToCart").click(function (e) { 
            e.preventDefault();
            
            let productId = $(this).attr("productId");
            console.log(productId)
            let myData = {productId:productId};

            let cartCount = $("#cartCount").text();
            cartCount = Number(cartCount);

            $.ajax({
                type:"POST",
                url:`addToCart.php?id=${productId}`,
                data:myData,
                success:function(data){
                    if(data){
                        Swal.fire({icon:"success", text:"Item added to cart", timer:1000, showCancelButton: false, showConfirmButton: false})
                    }
                }
            });
            cartCount+=1;
            $("#cartCount").text(cartCount);
            $("button").prop('disabled', true);
         });
     })
</script>


<div class="container">
    <div class="productInfo">
        <div class="image w-50">
            <div class="my-5 mx-5">
                <img src="<?php echo $data["image"] ?>" class="w-100" alt="productImage">
            </div>
        </div>

        <div class="details w-50">
            <div class="my-5 mx-5">
                <h5 class="mb-3"><i class="bi bi-card-heading"></i>&nbsp;<?php echo $data["name"] ?></h5>
                <h5 class="mb-4"><i class="bi bi-currency-dollar"></i><?php echo $data["price"] ?></h5>
                <h5 class="mb-4"><i class="bi bi-bookmark-star-fill"></i>&nbsp;<?php echo $data["category"] ?></h5>

                <div class="addToCart mb-4">
                    <?php 
                        session_start();
                        if($_SESSION["email"]){ 
                            echo "<button class='text-white' id='addToCart' productId=$id>ADD TO CART</button>";
                        }
                        else{
                            echo "<button type='submit'><a href='signin.php' class='text-white'>ADD TO CART</a></button>";
                        }
                        session_abort();
                    ?>
                </div>
                
                <div class="desc">
                    <h5><i class="bi bi-card-heading"></i>&nbsp;Description</h5>
                    <p><?php echo $data["description"] ?></p>
                </div>

                <div class="image2">
                    <img src='<?php echo $data["image"] ?>' alt='productImage'>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Include footer start -->
<?php include("footer.php") ?>
<!-- Include footer end -->


<script>
    // Get current cart count from the navbar
    function updateCount() { 
        document.getElementsByClassName("count")[0].innerHTML++;
    } 
</script>