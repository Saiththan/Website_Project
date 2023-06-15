<?php

@include 'config.php';

session_start();

if(!isset($_SESSION['user_id'])){
    //header('location:login.php');
 }else{
    $user_id = $_SESSION['user_id'];
 }

if(isset($_POST['add_to_wishlist'])){

    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];

    $check_wishlist_numbers = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

    if(mysqli_num_rows($check_wishlist_numbers) > 0){
        $message[] = 'already added to wishlist';
    }elseif(mysqli_num_rows($check_cart_numbers) > 0){
        $message[] = 'already added to cart';
    }else{
        mysqli_query($conn, "INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_image')") or die('query failed');
        $message[] = 'product added to wishlist';
    }

}



?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>search page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   

<?php include 'header.php'; ?>

<section class="heading">
    <h3>search page</h3>
    <p> <a href="home.php">home</a> / search </p>
</section>

<section class="search-form">
    <form action="" method="POST">
        <input type="text" class="box" placeholder="search products..." name="search_box">
        <input type="submit" class="btn" value="search" name="search_btn">
    </form>
</section>



<section class="slider-card" style="padding-top: 0;">


      <?php
        
        if(isset($_POST['search_btn']) || isset($_GET['searching'])){

        if(!isset($_POST['search_btn'])){
            $search_box=$_GET['searching'];
            
        }else{
            $search_box = mysqli_real_escape_string($conn, $_POST['search_box']);
        }
         
         $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE name LIKE '%{$search_box}%'") or die('query failed');

         if(mysqli_num_rows($select_products) > 0 ){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
       <form action="" method="POST" class="card">
         
         
        <div class="card-content">
                <span class="category-value"><?php echo $fetch_products['category']; ?></span>
                <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="" class="card-img">
                <h1 class="card-title"><a href="view_page.php?pid=<?php echo $fetch_products['id'];?>"><?php echo $fetch_products['name']; ?></a></h1>
                <p class="card-title">Rs.<?php echo $fetch_products['price'];?></p>
                    
                <div class="card-footer">
                    <input type="submit" value="Add To Wishlist"  name="add_to_wishlist" class="btn-card btn-success-card">
                    <input type="submit" value="Add To Cart"  name="add_to_cart" class="btn-card btn-border-card add-to-cart">

                </div>
                        
                <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
                <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
                <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">

            </div>
         

      </form>
      <?php
         }
            }else{
                echo '<p class="empty">no result found!</p>';
            }
        }else{
            echo '<p class="empty">search something!</p>';
        }
      ?>


</section>





<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>