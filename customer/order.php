<?php
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
    header('location:index.php');
};
include 'header.php';
?>

<div class="home-products" style="padding-top: 10%;">
    <h1  style="font-size: 24px; text-align: center;">Custom Order</h1>
    <div class="swiper products-slider" style="width: 100%; overflow: hidden;">
        <div class="swiper-wrapper">
            <?php
            $select_orders_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id='$user_id'") or die(mysqli_error($conn));
            if (mysqli_num_rows($select_orders_query) > 0) {
                while ($fetch_orders = mysqli_fetch_assoc($select_orders_query)) {
                    $order_id = $fetch_orders['id'];
                    $select_line_items = mysqli_query($conn, "SELECT * FROM `line_items` WHERE order_id = '$order_id'") or die(mysqli_error($conn));
                    if (mysqli_num_rows($select_line_items) > 0) {
                        while ($fetch_line_items = mysqli_fetch_assoc($select_line_items)) {
                            $line_items_id = $fetch_line_items['id'];
                            $product_id = $fetch_line_items['product_id'];
                            $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$product_id' AND status = 'custom'") or die('Query failed');
                            if (mysqli_num_rows($select_products) > 0) {
                                while ($fetch_products = mysqli_fetch_assoc($select_products)) {
            ?>
                                    <form action="" method="post" class="swiper-slide slide" style="display: flex; flex-direction: column; align-items: center; text-align: center; padding: 10px; border: 1px solid #ccc; margin: 10px;">
                                        <img src="../uploaded_img/<?php echo htmlspecialchars($fetch_products['image']); ?>" alt="" style="width: 100%; max-width: 200px;">
                                        <div class="name" style="margin-top: 10px; font-weight: bold;">
                                            <?php echo htmlspecialchars($fetch_products['name']); ?>
                                        </div>
                                        <p>total price: <span style="font-weight: bold; color: #333;">RS
                                                <?php echo $fetch_line_items['quantity'] * $fetch_line_items['product_price']; ?>/-
                                            </span></p>
                                        <p>product name: <span style="font-weight: bold;">
                                                <?= $fetch_products['name']; ?>
                                            </span></p>
                                        <p>quantity: <span style="font-weight: bold;">
                                                <?= $fetch_line_items['quantity']; ?>
                                            </span></p>
                                        <p>price: <span style="font-weight: bold;">Rs
                                                <?= $fetch_line_items['product_price']; ?>/-
                                            </span></p>
                                        <p>created at: <span style="font-weight: bold;">
                                                <?= $fetch_orders['created_at']; ?>
                                            </span></p>
                                        <?php
                                        $user_id = $_SESSION['user_id'];
                                        $select_users_query = mysqli_query($conn, "SELECT * FROM `users` WHERE id= '$user_id'  ") or die(mysqli_error($conn));
                                        if (mysqli_num_rows($select_users_query) > 0) {
                                            while ($fetch_users = mysqli_fetch_assoc($select_users_query)) { ?>
                                                <p>name: <span style="font-weight: bold;">
                                                        <?php echo $fetch_users['username']; ?>
                                                    </span></p>
                                                <p>email: <span style="font-weight: bold;">
                                                        <?= $fetch_users['email']; ?>
                                                    </span></p>
                                                <p>number: <span style="font-weight: bold;">
                                                        <?= $fetch_users['number']; ?>
                                                    </span></p>
                                                <p>address: <span style="font-weight: bold;">
                                                        <?= $fetch_users['address']; ?>
                                                    </span></p>
                                        <?php }
                                        } ?>
                                       <p>Order status: <span style="font-weight: bold; color: <?php echo ($fetch_orders['payment_status'] == 'pending') ? 'red' : 'green'; ?>">
                                                        <?= $fetch_orders['payment_status']; ?> 
                                                    </span></p>

                                                    <?php
                                                    if ($fetch_orders['payment_status'] == 'complete') {
                                                        echo "<p>Your order has been prepared and is ready for delivery.</p>";
                                                    }else{
                                                        echo "<p>plz wait for admin reply.</p>";
                                                    }
                                                    ?>

                                    </form>
            <?php
                                }
                            }
                        }
                    }
                }
            } else {
                echo '<p class="empty" style="text-align: center; font-weight: bold;">No orders placed yet!</p>';
            }
            ?>
        </div>
        <div class="swiper-pagination"></div>
    </div>
</div>

    <!-- Include the Swiper library -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <!-- Initialize Swiper -->
    <script>
        var swiper = new Swiper('.products-slider', {
            slidesPerView: 4,
            spaceBetween: 10,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });
    </script>

<div class="home-products" style="padding-top: 10%;">
    <h1  style="font-size: 24px; text-align: center;">normal Order</h1>
    <div class="swiper products-slider" style="width: 100%; overflow: hidden;">
        <div class="swiper-wrapper">
            <?php
            $select_orders_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id='$user_id'") or die(mysqli_error($conn));
            if (mysqli_num_rows($select_orders_query) > 0) {
                while ($fetch_orders = mysqli_fetch_assoc($select_orders_query)) {
                    $order_id = $fetch_orders['id'];
                    $select_line_items = mysqli_query($conn, "SELECT * FROM `line_items` WHERE order_id = '$order_id'") or die(mysqli_error($conn));
                    if (mysqli_num_rows($select_line_items) > 0) {
                        while ($fetch_line_items = mysqli_fetch_assoc($select_line_items)) {
                            $line_items_id = $fetch_line_items['id'];
                            $product_id = $fetch_line_items['product_id'];
                            $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$product_id' AND status = 'normal'") or die('Query failed');
                            if (mysqli_num_rows($select_products) > 0) {
                                while ($fetch_products = mysqli_fetch_assoc($select_products)) {
            ?>
                                    <form action="" method="post" class="swiper-slide slide" style="display: flex; flex-direction: column; align-items: center; text-align: center; padding: 10px; border: 1px solid #ccc; margin: 10px;">
                                        <img src="../uploaded_img/<?php echo htmlspecialchars($fetch_products['image']); ?>" alt="" style="width: 100%; max-width: 200px;">
                                        <div class="name" style="margin-top: 10px; font-weight: bold;">
                                            <?php echo htmlspecialchars($fetch_products['name']); ?>
                                        </div>
                                        <p>total price: <span style="font-weight: bold; color: #333;">RS
                                                <?php echo $fetch_line_items['quantity'] * $fetch_line_items['product_price']; ?>/-
                                            </span></p>
                                        <p>product name: <span style="font-weight: bold;">
                                                <?= $fetch_products['name']; ?>
                                            </span></p>
                                        <p>quantity: <span style="font-weight: bold;">
                                                <?= $fetch_line_items['quantity']; ?>
                                            </span></p>
                                        <p>price: <span style="font-weight: bold;">Rs
                                                <?= $fetch_line_items['product_price']; ?>/-
                                            </span></p>
                                        <p>created at: <span style="font-weight: bold;">
                                                <?= $fetch_orders['created_at']; ?>
                                            </span></p>
                                        <?php
                                        $user_id = $_SESSION['user_id'];
                                        $select_users_query = mysqli_query($conn, "SELECT * FROM `users` WHERE id= '$user_id'  ") or die(mysqli_error($conn));
                                        if (mysqli_num_rows($select_users_query) > 0) {
                                            while ($fetch_users = mysqli_fetch_assoc($select_users_query)) { ?>
                                                <p>name: <span style="font-weight: bold;">
                                                        <?php echo $fetch_users['username']; ?>
                                                    </span></p>
                                                <p>email: <span style="font-weight: bold;">
                                                        <?= $fetch_users['email']; ?>
                                                    </span></p>
                                                <p>number: <span style="font-weight: bold;">
                                                        <?= $fetch_users['number']; ?>
                                                    </span></p>
                                                <p>address: <span style="font-weight: bold;">
                                                        <?= $fetch_users['address']; ?>
                                                    </span></p>
                                        <?php }
                                        } ?>
                                        <p>payment status: <span style="font-weight: bold; color: <?php echo ($fetch_orders['payment_status'] == 'pending') ? 'red' : 'green'; ?>;">
                                                <?= $fetch_orders['payment_status']; ?>
                                            </span></p>
                                    </form>
            <?php
                                }
                            }
                        }
                    }
                }
            } else {
                echo '<p class="empty" style="text-align: center; font-weight: bold;">No orders placed yet!</p>';
            }
            ?>
        </div>
        <div class="swiper-pagination"></div>
    </div>
</div>

        <!-- Include the Swiper library -->
        <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
        <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

        <!-- Initialize Swiper -->
        <script>
            var swiper = new Swiper('.products-slider', {
                slidesPerView: 4,
                spaceBetween: 10,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
            });
        </script>