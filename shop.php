<?php

include 'config.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>

    <!-- css file -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
    <!-- Header File -->
    <?php include 'header.php';?>

    <section class="heading">
    <h3>Shop</h3>
    <p> <a href="home.php">Home</a> / Shop </p>
    </section>
    
    <section class="products">
        
        <div class="box-container">
            <?php
                $select_products=mysqli_query($conn,"SELECT * FROM `products`") or die('query failed');
                if(mysqli_num_rows($select_products)>0){
                    while($fetch_products=mysqli_fetch_assoc($select_products)){
            ?>
            <form action="" method="POST" class="box">
                <a href="view_page.php?pid=<?php echo $fetch_products['id'];?>" class=""></a>
                <div class="price">Rs.<?php echo $fetch_products['price'];?>/-</div>
                <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="" class="image">
                <div class="name"><?php echo $fetch_products['name']; ?></div>
                <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
                <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
                <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
                <input type="submit" value="add to wishlist"  name="add_to_wishlist" class="option-btn">
                <input type="submit" value="add to cart"  name="add_to_cart" class="btn">

            </form>
            <?php
                }
            }else{
                echo '<p class="empty">no products addeed yet!</p>';
    
            }
            ?>
        </div>

    </section>



    <!-- Footer File -->
    <?php include 'footer.php'?>

    <!-- JavaScript File -->
    <script src="js/script.js"></script>

</body>
</html>