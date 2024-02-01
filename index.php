<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>

<style>
    .hero>img{
        width: 100vw;
    }
    .search {
        position: absolute;
        top: 44%;
    }

    .search>form>input {
        width: 500px;
        height: 46px;
        border: 1px solid gray;
        opacity: 0.7;
    }

    @media (max-width:1000px) {
        /* .hero>img{
            display: none;
        } */
        .hero .search>form{
            display: none;
        }
    }
</style>

<body>
    <!-- Include Navbar start -->
    <?php include("navbar.php") ?>
    <!-- Include Navbar end -->

    <!-- Hero section start -->
    <div class="container hero">
        <img src="images/hero.png" alt="hero">
        <div class="search">
            <form action="category.php?=" method="GET">
                <input type="search" name="category" class="form-control rounded-pill" placeholder="enter category...">
            </form>
        </div>
    </div>
    <!-- Hero section end -->

    <!-- Include Products file start -->
    <?php include("products.php") ?>
    <!-- Include Products file end -->

    <!-- Include Footer start -->
    <?php include("footer.php") ?>
    <!-- Include Footer end -->
</body>

</html>