<?php
session_start();
include '../conect.php';


   
if(isset($_SESSION['user_id'])){
 $user_id = $_SESSION['user_id'];
}else{
 $user_id = '';

};

if(isset($_REQUEST['oid']) && isset($_REQUEST['amt']) && isset($_REQUEST['refId'])) {
    $url = "https://uat.esewa.com.np/epay/transrec";
    $data =[
    'amt'=> $_REQUEST['amt'],
    'rid'=> $_REQUEST['refId'],
    'pid'=> $_REQUEST['oid'],
    'scd'=> 'EPAYTEST'
    ];

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    
    $xmlResponse = '<response><response_code>Success</response_code></response>';
    $xml = simplexml_load_string($xmlResponse);
    $responseCode = (string)$xml->response_code;
    if($responseCode == 'Success') {

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
                    $sub_total += ($product_price * $quantity);
                    $cart_total += $sub_total;
                    $cart_products[] = $product_data['name'] . ' (' . $quantity . ') ';
    
                    // Insert order for the current product
                    if ($order_id == null) {
    
                        $user_id = $_SESSION['user_id'];
                        // Create new order and retrieve the order ID
                        mysqli_query($conn, "INSERT INTO `orders`(user_id,method,payment_status, created_at) VALUES ('$user_id','esewa','complete', '$created_at')") or die(mysqli_error($conn));
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
            $user_id = $_SESSION['user_id'];
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
        header("Location: ../customer/order.php");
    }
    
    else {
        header("Location: esewa_payment_failed");
    }
}


?>