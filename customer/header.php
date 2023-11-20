<?php
include '../conect.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
};

if (isset($_POST['add_product'])) {
    // sqloperator _ store function
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $details = mysqli_real_escape_string($conn, $_POST['details']);
    $category_id = $_POST['category_id'];
    $stock = $_POST['stock'];
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_img/' . $image;
    $flavor_id = $_POST['flavor_id'];

    $level = $_POST['details'];

    // Retrieve flavor price based on the selected level
    $flavor_price_query = mysqli_query($conn, "SELECT price FROM `flavors` ") or die('Query failed');
    if (mysqli_num_rows($flavor_price_query) > 0) {
        $flavor_price_row = mysqli_fetch_assoc($flavor_price_query);
        $flavor_price = $flavor_price_row['price'];
    } else {
        // Handle the case if the flavor price is not found for the selected level
        $flavor_price = 0; // Default price or appropriate fallback value
    }

    $select_product_name = mysqli_query($conn, "SELECT name FROM `products` WHERE name = '$name'") or die('Query failed');

    if (mysqli_num_rows($select_product_name) > 0) {
        $message[] = 'Product name already added';
    } else {
        if ($level == 'level_1') {
            $price = $flavor_price + 10;
        } else if ($level == 'level_2') {
            $price = $flavor_price + 20;
        } else if ($level == 'level_3') {
            $price = $flavor_price + 30;
        }

        // Insert into 'products' table
        $insert_product_query = mysqli_query($conn, "INSERT INTO `products` (name, stock, image, price, category_id, details, flavor_id, status) VALUES ('$name', '$stock', '$image', '$price', '$category_id', '$details', '$flavor_id', 'custom')") or die(mysqli_error($conn));
        $product_id = mysqli_insert_id($conn); // Get the last inserted product_id

        // Insert into 'orders' table
        $insert_order_query = mysqli_query($conn, "INSERT INTO `orders` (user_id,payment_status, method, created_at) VALUES ('$user_id','pending', 'cash on delivery', NOW())") or die(mysqli_error($conn));
        $order_id = mysqli_insert_id($conn); // Get the last inserted order_id

        // Insert into 'line_items' table
        $quantity = $_POST['stock'];
        $insert_line_item_query = mysqli_query($conn, "INSERT INTO `line_items` (product_id, quantity, product_price, order_id) VALUES ('$product_id', '$quantity', '$price', '$order_id')") or die(mysqli_error($conn));

        if ($insert_product_query && $insert_order_query && $insert_line_item_query) {
            if ($image_size > 2000000) {
                $message_1[] = 'File size is too large';
            } else {
                move_uploaded_file($image_tmp_name, $image_folder);
                $message[] = 'plz wait for our message !';
            }
        } else {
            $message[] = 'Product could not be added!';
        }
    }
}



// <!-- product CRUD section starts  -->



if (isset($_POST['order_btn'])) {
    // Retrieve form data

    $created_at = date('Y-m-d');

    $cart_total = 0;
    $cart_products = array();
    $cart_query = mysqli_query($conn, "SELECT * FROM `sessions` WHERE user_id = '$user_id' AND status='pending'") or die(mysqli_error($conn));

    if (mysqli_num_rows($cart_query) > 0) {
        // Insert order for each product in the cart
        $order_id = null; // Initialize order_id
        while ($cart = mysqli_fetch_assoc($cart_query)) {
            $session_id = $cart['session_id']; // Assuming the sessions table has a 'session_id' column
            $quantity = $cart['product_quantity'];
            $product_id = $cart['product_id'];
            $product_price = $cart['price'];

            // Verify if product quantity is available
            $product_query = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$product_id'") or die(mysqli_error($conn));
            if (mysqli_num_rows($product_query) > 0) {
                $product_data = mysqli_fetch_assoc($product_query);
                $product_stock = $product_data['stock'];
                if ($quantity > $product_stock) {
                    $message[] = $product_data['name'] . ' is out of stock. You can only order up to ' . $product_stock . ' units.';
                    continue;
                }
                // Update product stock
                mysqli_query($conn, "UPDATE `products` SET stock = stock - $quantity WHERE id = '$product_id'") or die(mysqli_error($conn));
                $sub_total = ($product_price * $quantity);
                $cart_total += $sub_total;
                $cart_products[] = $product_data['name'] . ' (' . $quantity . ') ';

                // Insert order for the current product
                if ($order_id == null) {

                    $method = "cash on delivery";
                    // Create new order and retrieve the order ID
                    mysqli_query($conn, "INSERT INTO `orders`(user_id,method, created_at) VALUES ('$user_id','$method', '$created_at')") or die(mysqli_error($conn));
                    $order_id = mysqli_insert_id($conn); // Get the auto-generated order ID
                }

                // Insert product into line_items with the order ID
                mysqli_query($conn, "INSERT INTO `line_items`(order_id, product_id, product_price, quantity) VALUES ('$order_id', '$product_id', '$product_price', '$quantity')") or die(mysqli_error($conn));
            }
        }
    }

    if (empty($cart_products)) {
        $message[] = 'Your cart is empty or all items are out of stock.';
    } else {
        $quantity = implode(', ', $cart_products);
        $order_query = mysqli_query($conn, "SELECT * FROM `orders`") or die(mysqli_error($conn));
        mysqli_query($conn, "DELETE FROM `sessions` WHERE user_id = '$user_id' ") or die(mysqli_error($conn));

        if (mysqli_num_rows($order_query) > 0) {
            $message2[] = 'Order placed successfully!';
        } else {
            $message2[] = 'Order placed successfully!';

            // Calculate total price and update sessions status to "complete"
            // mysqli_query($conn, "UPDATE `orders` SET total_price = $cart_total WHERE user_id = '$user_id'") or die(mysqli_error($conn));
        }
    }

    // Display messages

    // Display messages
    if (!empty($message)) {
        foreach ($message as $msg) {
            echo "<script>alert('$msg');</script>";
        }
    } else {
        echo "<script>alert('Order placed successfully!');</script>";
    }
}

if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $price = $_POST['price'];
    $product_quantity = $_POST['quantity'];

    // Check if the product is already added to the cart
    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `sessions` WHERE product_id = '$product_id' AND user_id = '$user_id' ") or die(mysqli_error($conn));

    if (mysqli_num_rows($check_cart_numbers) > 0) {
        $message[] = 'Already added to cart!';
    } else {
        // Check if the product is in stock
        $check_stock = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$product_id'") or die(mysqli_error($conn));

        if (mysqli_num_rows($check_stock) > 0) {
            $row = mysqli_fetch_assoc($check_stock);
            $product_stock = $row['stock'];

            if ($product_stock >= $product_quantity) {
                // Check if the product was added within the last 10 minutes
                $recent_cart = mysqli_query($conn, "SELECT * FROM `sessions` WHERE   TIMESTAMPDIFF(MINUTE, session_start_time, NOW()) <= 10") or die(mysqli_error($conn));

                if (mysqli_num_rows($recent_cart) > 0) {
                    $message[] = 'You can only add one product every 10 minutes!';
                } else {
                    // Insert the product into the sessions table
                    $session_start_time = date('Y-m-d H:i:s');
                    mysqli_query($conn, "INSERT INTO `sessions`(user_id, product_id, price,product_quantity, session_start_time) VALUES('$user_id', '$product_id', '$price', '$product_quantity', '$session_start_time')") or die(mysqli_error($conn));
                    $message[] = 'Product added to cart!';
                }
            } else {
                $message[] = 'Sorry, the product is out of stock!';
            }
        } else {
            $message[] = 'Invalid product!';
        }
    }

    $_SESSION['message'] = $message;
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sweet Cake</title>

    <!-- swiper link  -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> -->
    <!-- cdn icon link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- custom css file  -->
    <link rel="stylesheet" href="../css/style.css">


</head>

<body>

    <!-- header section start here  -->
    <header class="header">
        <div class="logoContent">
            <a href="#" class="logo"><img src="../images/logo.png" alt=""></a>
            <h1 class="logoName">BakerySewa </h1>
        </div>


        <nav class="navbar">
            <a href="index.php">home</a>
            <a href="#product">product</a>
            <a href="order.php">order</a>
            <a href="custome_product.php">custom</a>


            <?php if (isset($_SESSION['username'])) { ?>
                <a href="../login/logout.php" onclick="return confirm('logout from the website?');">Logout</a>

                <li class="nav-item"></li>
            <?php } else { ?>
                <a href="../login/login.php" class="nav-link">Login</a>
                <a href="../login/register.php" class="nav-link">Register</a>
            <?php } ?>

        </nav>

        <div class="icon">
            <?php if (isset($_SESSION['user_id'])) {
                $select_cart_number = mysqli_query($conn, "SELECT * FROM `sessions` WHERE user_id = '$user_id' ") or die(mysqli_error($conn));
                $cart_rows_number = mysqli_num_rows($select_cart_number);


            ?>
                <a href="cart.php" style="color: #050000;"> <i class="fas fa-shopping-cart"></i>

                    <span style="font-size: 2rem;margin-right: 2rem;color: var(--black);cursor: pointer;">(<?php echo $cart_rows_number; ?>)</span> </a>




            <?php
            }
            ?> <?php
            if (isset($_SESSION['user_id'])) {
                $select_cart_number = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = '$user_id' AND payment_status = 'complete'") or die(mysqli_error($conn));
                $cart_rows_number = mysqli_num_rows($select_cart_number);
            
                // Check if the count has been displayed before
                if (!isset($_SESSION['cart_count_displayed'])) {
                    echo '<a href="order.php" style="color: #050000;"><i class="fas fa-bell"></i></i>';
                    echo '<span style="font-size: 2rem;margin-right: 2rem;color: var(--black);cursor: pointer;">(' . $cart_rows_number . ')</span></a>';
                    
                    // Mark it as displayed
                    $_SESSION['cart_count_displayed'] = true;
                }
            }
            ?>
            

           <!-- <i class="fas fa-search" id="search"></i>
            <i class="fas fa-bars" id="menu-bar"></i>
        </div>-->

        <!--<div class="search">
            <input type="search" placeholder="search...">
        </div>-->

    </header>

    <!-- header section end here  -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
</body>









































































<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<!-- custom js file  -->
<script src="../js/index.js"></script>