<?php
include 'admin_header.php';



if (isset($_POST['update_order'])) {

  $order_update_id = $_POST['order_id'];
  $update_payment = $_POST['update_payment'];
  mysqli_query($conn, "UPDATE `orders` SET payment_status = '$update_payment' WHERE id = '$order_update_id'") or die('query failed');
  $message[] = 'payment status has been updated!';
}

if (isset($_GET['delete'])) {
  $delete_id = $_GET['delete'];
  mysqli_query($conn, "DELETE FROM `orders` WHERE id = '$delete_id'") or die('query failed');
  header('location:admin_orders.php');
}




?>
<section class="attendance" style="padding-left: 3rem;">
   <?php
   if (isset($message)) {
      foreach ($message as $message) {
         echo '
               <div class="message">
                  <span>' . $message . '</span>
                  <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
               </div>
               ';
      }
   }

   if (isset($message_1)) {
      foreach ($message_1 as $message_1) {
         echo '
            <div class="message_1">
               <span>' . $message_1 . '</span>
               <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
            </div>
              ';
      }
   }
   ?>
   <div class="attendance-list">
      <h1>products List</h1>
 
 
      <table class="table">
         <thead>

            <tr>
              <th style="width:1%;">S No.</th>
            <th style="width:1%;">date</th>
            <th style="width:1%;">User<br>name</th>
       
          
            <th style="width:5%;"><br>products type</th>
            <th style="width:5%;"><br>total price</th>
            <th style="width:19%;"><br>payment status</th>

            <th>Action</th>
            </tr>
         </thead>
         <?php
      $select_orders_query = mysqli_query($conn, "SELECT o.*, u.username, u.email, u.number, u.address, p.name AS product_name, p.status, p.image, li.quantity, li.product_price
          FROM `orders` o
          JOIN `line_items` li ON o.id = li.order_id
          JOIN `products` p ON li.product_id = p.id
          JOIN `users` u ON o.user_id = u.id
        ") or die(mysqli_error($conn));

      if (mysqli_num_rows($select_orders_query) > 0) {
          while ($fetch_orders = mysqli_fetch_assoc($select_orders_query)) {
      ?>
               <tr>

                  <td>   <?php echo htmlspecialchars($fetch_orders['product_name']); ?></td>
                  <td>     <?= $fetch_orders['created_at']; ?></td>
                  <td>    <?php echo $fetch_orders['username']; ?></td>
                  <td>    <?php echo $fetch_orders['status']; ?></td>
                  <td>rs <?php echo $fetch_orders['quantity'] * $fetch_orders['product_price']; ?>/-</td>
                  <td><?= $fetch_orders['method']; ?></td>
                 
               

               
                  <td>

                        <form action="" method="post">
                    <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id']; ?>">
                    <select name="update_payment">
                    <option value="" ><?php echo $fetch_orders['payment_status']; ?></option>
                    <option value="pending">pending</option>
                    <option value="complete">completed</option><br>
                    <!-- <option value="cancel">cancel</option><br> -->
                    </select>   <br>
                    
                    <input type="submit" value="update" name="update_order" class="option-btn">     
                    <a1 href="admin_orders.php?delete=<?php echo $fetch_orders['id']; ?>" onclick="return confirm('delete this order?');" class="delete-btn">delete</a>

                                                
                    </form>
                  </td>

                   

               </tr>
         <?php
            }
         } else {
            echo '<p class="empty">no order!</p>';
         }
         ?>

         </tbody>
      </table>
   </div>
</section>
</section>
</div>









<!-- custom admin js file link  -->
<script src="../js/admin_script.js"></script>

</body>

</html>