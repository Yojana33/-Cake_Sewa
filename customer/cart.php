<?php 
   session_start();
   
   if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
  }else{
    $user_id = '';
   
  };
   include 'header.php';
   
   if(isset($_POST['update_cart'])){
    $cart_id = $_POST['cart_id'];
    $cart_quantity = $_POST['cart_quantity'];
    mysqli_query($conn, "UPDATE `sessions` SET product_quantity = '$cart_quantity' WHERE session_id = '$cart_id'")or die(mysqli_error($conn));
    $message2[] = 'cart quantity updated!';
 }
 
 if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "UPDATE `sessions` SET status = 'delete' WHERE session_id = '$delete_id'") or die(mysqli_error($conn));

    $message[] = 'Cart quantity deleted!';
}


?> 

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
  
    <title>OCS - Cart</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/userpage.css">
    <link rel="stylesheet" href="fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" type="text/css" href="css/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="css/owl.theme.default.min.css">
</head>

<body>
    <!-- ============================================================== -->
    <!-- main wrapper -->


    <div class="container-fluid dashboard-content">

        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title">Cart</h2>
                    <p class="pageheader-text">Proin placerat ante duiullam scelerisque a velit ac porta, fusce sit amet
                        vestibulum mi. Morbi lobortis pulvinar quam.</p>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php" class="breadcrumb-link">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Your cart</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mx-5">

            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                                        <?php   if(isset($message2)){
                                                        foreach($message2 as $message2){
                                                            echo '
                                                            <div class="message">
                                                                <span>'.$message2.'</span>
                                                                <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
                                                            </div>
                                                            ';
                                                        }
                                                        }?>
                                    <tr>
                                        <th>S. No.</th>
                                        <th>Product Name</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                    <tbody>



                                        <?php
                                                        $grand_total = 0;
                                                        $select_cart = mysqli_query($conn, "SELECT * FROM `sessions` WHERE user_id = '$user_id' AND status = 'pending' ") or die(mysqli_error($conn));
                                                        if(mysqli_num_rows($select_cart) > 0){
                                                            while($fetch_cart = mysqli_fetch_assoc($select_cart)){ 
                                                        
                                                            // $status = ($fetch_cart['status'] == 'complete') ? 'Complete' : '';
                                                            // if ($status == 'complete') {
                                                    ?>
                                        <tr>
                                            <?php  
                                                                    $products_id=$fetch_cart['product_id'];
                                                                    $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE  id = '$products_id' ") or die('query failed');
                                                                    if(mysqli_num_rows($select_products) > 0){
                                                                    while($fetch_products = mysqli_fetch_assoc($select_products)){
                                                                    ?>
                                            <td><img src="../images/<?php echo $fetch_products['image']; ?>"
                                                    height="100" alt=""></td>
                                            <td>
                                                <?php echo $fetch_products['name']; ?>
                                            </td>
                                            <td>
                                                <?php echo $fetch_products['price']; ?>/-
                                            </td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="hidden" name="cart_id"
                                                        value="<?php echo $fetch_cart['session_id']; ?>">

                                                    <input type="number" name="cart_quantity" min="1"
                                                        max="<?php echo $fetch_products['stock']; ?>"
                                                        value="<?php echo $fetch_cart['product_quantity']; ?>">
                                                    <?php
                                                                    }  ;  
                                                                    } else{
                                                                        echo '<p class="empty">no products added yet!</p>';
                                                                    };
                                                                

                                                                    ?>
                                                    <input type="submit" name="update_cart" value="update"
                                                        class="fas fa-sync-alt">
                                                </form>
                                            </td>
                                            <td>
                                                <?php echo $sub_total = ($fetch_cart['price'] * $fetch_cart['product_quantity']); ?>/-
                                            </td>
                                            <td><a href="cart.php?delete=<?php echo $fetch_cart['session_id']; ?>"
                                                    class="btn btn-danger btn-outline-light my-2 my-sm-0"
                                                    onclick="return confirm('delete this from cart?');">delete</a></td>

                                        </tr>
                                        <?php
                                                    $grand_total += $sub_total;
                                                    $product_id = $fetch_cart['product_id'];
                                                    //$grand_total += $sub_total;
                                                    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
                                                    $host = $_SERVER['HTTP_HOST'];
                                                    $folder = trim(dirname($_SERVER['PHP_SELF']), '/');
                                                    $base_url = "{$protocol}://{$host}/{$folder}/";
                                                    $timestamp = time();
                                                    $randomPart = rand(1000, 9999);
                                                    $products_id = "$products_id$timestamp$randomPart$user_id";



                                                                                // include '../esewa/setting.php'; ?>
                                            
                                            <?php
                                                  }                 
                                                }
                                                 else{
                                                    echo '<tr><td style="padding:20px; text-transform:capitalize;" colspan="6">no item added</td></tr>';
                                                };
                                                 
                                                    
                                                ?>
                                                                                                            <tr>
                                                            <tr class="table-bottom">
                                                                <td colspan="4">grand total :</td>
                                                                <td>rs<?php echo $grand_total; ?>/-</td>
                                                            </tr>
                                                            </tbody>
                                                            </table>

                                                            <div class="cart-btn">  
                                                                <a href="shop.php" class="btn">continue shopping</a>
                                                                <form action="" method="post">

                                                                <input type="submit" value="order now" class="btn <?php echo ($grand_total > 0)?'':'disabled'; ?>" name="order_btn">
                                                                <!-- <input type="submit" value="order now" class="btn" name="order_btn"> -->
                                                                <!-- <a href="checkout.php" class="btn <?php echo ($grand_total > 0)?'':'disabled'; ?>">proceed to checkout</a> -->

                                                                </form>
                                                                <form action="https://uat.esewa.com.np/epay/main" method="POST">
                                                                <input value="<?php echo $grand_total ?>" name="tAmt" type="hidden">
                                                                <input value="<?php echo $grand_total ?>" name="amt" type="hidden">
                                                                <input value="0" name="txAmt" type="hidden">
                                                                <input value="0" name="psc" type="hidden">
                                                                <input value="0" name="pdc" type="hidden">
                                                                <input value="EPAYTEST" name="scd" type="hidden">
                                                                <input value="<?php echo  $products_id ?>" name="pid" type="hidden">

                                                                <input value="<?php echo $base_url ?>../esewa/esewa_payment_success.php?q=su" type="hidden" name="su">
                                                                <input value="<?php echo $base_url ?>../esewa/esewa_payment_failed.php?q=fu" type="hidden" name="fu">
                                                        
   
                                                             
                                                                    <div class="middle-container">
                                                                        <div class="middle-section">
                                                                                <div class="payment-section">
                                                                                <!-- <h2>Buy Online With:</h2> -->
                                                                                <div class="payment-options">
                                                                                    <input class="img" value="Submit"  src="../images/esewa.png" type="image">
                                                                                </div>
                                                                                </div>
                                                                        </div>
                                                                    </div>
                                                                    </form>
                                               
                                               
                                                


                                                            
                                                            </div>

                                                            </div>


                                    </tbody>
                          
                            </table>             
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>