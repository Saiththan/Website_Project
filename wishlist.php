<?php 

include 'config.php';

session_start();

// if(isset($_SESSION['user_id'])){
//     $user_id=$_SESSION['user_id'];
// }else{
//     $user_id='';
//     header('location:user_login.php');
// }

if(isset($_POST['add_to_cart'])){

    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = 1;

    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

    if(mysqli_num_rows($check_cart_numbers) > 0){
        $message[] = 'already added to cart';
    }else{

        $check_wishlist_numbers = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

        if(mysqli_num_rows($check_wishlist_numbers) > 0){
            mysqli_query($conn, "DELETE FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');
        }

        mysqli_query($conn, "INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
        $message[] = 'product added to cart';
    }

}

if(isset($_GET['delete'])){
    $delete_id=$_GET['delete'];
    mysqli_query($conn, "DELETE FROM `wishlist` WHERE id='$delete_id'") or die('query failed');
    header('location:wishlist.php');
}       
if(isset($_GET['delete_all'])){
    mysqli_query($conn, "DELETE FROM `wishlist` WHERE user_id='$user_id'") or die('query failed');
    header('location:wishlist.php');
}       

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>wishlist</title>
    <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom admin css file link  -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <section class="products">
        <h1 class="heading">your wishlist</h1>

        <div class="box-container">
                <?php
                //For Testing
                $user_id=1;
                
                $grand_total=0;
                $select_wishlists = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE user_id='$user_id'") or die('query failed');
                if(mysqli_num_rows($select_wishlists) > 0){
                    while($fetch_wishlists = mysqli_fetch_assoc($select_wishlists)){
            ?>
            <form action="" method="POST" class="box">
                <a href="wishlist.php?delete=<?php echo $fetch_wishlists['id'];?>" class="fas fa-times" onclick="return confirm('delete this from wishlist?');"></a>
                <a href="view_page.php?pid=<?php echo $fetch_wishlists['id'];?>" class="fas fa-eyes"></a>
                <img src="uploaded_img/<?php echo $fetch_wishlists['image']; ?>" alt="" class="image">
                <div class="name"><?php echo $fetch_wishlists['name']; ?></div>
                <div class="price"><?php echo $fetch_wishlists['price']; ?></div>
                <input type="hidden" name="product_name" value="<?php echo $fetch_wishlists['name']; ?>">
                <input type="hidden" name="product_price" value="<?php echo $fetch_wishlists['price']; ?>">
                <input type="hidden" name="product_image" value="<?php echo $fetch_wishlists['image']; ?>">
                <input type="submit" value="add to cart" name="add_to_cart" class="btn"> 

        
            
            </form>
            <?php
            $grand_total+=$fetch_wishlists['price'];
                }
            }else{
                echo '<p class="empty">no products added yet!</p>';
            }
            ?>
        </div>

        <div class="wishlist-total">
            <p>grand rotal : <span>Rs.<?php echo $grand_total;?>/=</span></p>
            <a href="shop.php" class="option-btn">continue shopping</a>
            <a href="wishlist.php?delete_all" class="delete-btn <?php echo($grand_total>1)?'':'disabled' ?>" onclick="return ('delete all from wishlist?');">delete all</a>
        </div>

    </section>


    <?php include 'footer.php'; ?>

    <script src="js/script.js"></script>
</body>
</html>