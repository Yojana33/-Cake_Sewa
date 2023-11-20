<?php include 'admin_header.php';










?>


<section class="main">
  <div class="main-top">
    <h1>Dashboard</h1>
    <i class="fas fa-user-cog"></i>
  </div>
  <div class="users">
    <div class="card">
      <img src="../images/pending.jpg">
      <h4>total_pendings</h4>
      <!-- <p>Ui designer</p> -->
      <div class="per">
        <table>
          <tr>
          <?php
             $total_pendings = 0;
             $select_pending = mysqli_query($conn, "SELECT  li.product_price, li.quantity 
                                                    FROM `orders` AS o
                                                    JOIN `line_items` AS li ON o.id = li.order_id
                                                    WHERE o.payment_status = 'pending'")or die(mysqli_error($conn));
             
             if(mysqli_num_rows($select_pending) > 0){
                 while($fetch_pendings = mysqli_fetch_assoc($select_pending)){
                 
                     $product_price = $fetch_pendings['product_price'];
                     $quantity = $fetch_pendings['quantity'];
             
                     // Now you can work with $total_price, $product_price, and $quantity as needed
                     $total_pendings +=  $product_price *  $quantity ;
                 }
             }
             ?>

          </tr>
          <tr>
            <td><?php echo $total_pendings; ?>/-</td>
            <BR>
            <br>

          </tr>
        </table>
      </div>
      <button>View order</button>
    </div>
    <div class="card">
      <img src="../images/complete.jpg">
      <h4>$total completed</h4>

      <div class="per">
        <table>

          <tr>
          <?php
             $total_pendings = 0;
             $select_pending = mysqli_query($conn, "SELECT  li.product_price, li.quantity 
                                                    FROM `orders` AS o
                                                    JOIN `line_items` AS li ON o.id = li.order_id
                                                    WHERE o.payment_status = 'complete'")or die(mysqli_error($conn));
             
             if(mysqli_num_rows($select_pending) > 0){
                 while($fetch_pendings = mysqli_fetch_assoc($select_pending)){
                 
                     $product_price = $fetch_pendings['product_price'];
                     $quantity = $fetch_pendings['quantity'];
             
                     // Now you can work with $total_price, $product_price, and $quantity as needed
                     $total_pendings +=  $product_price * $quantity ;
                 }
             }
             ?>
            <td> 
            </td>
            <br>
            <br>
            <?php echo $total_pendings; ?>/-
          </tr>
        </table>
      </div>
      <button>view order</button>
    </div>
    <div class="card">
      <img src="../images/order.jpg">
      <h4>total_order</h4>

      <div class="per">
        <table>
          <?php
          $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
          $number_of_orders = mysqli_num_rows($select_orders);
          ?>
          <tr>

          </tr>
          <tr>
            <br>
            <br>
            <td><?php echo $number_of_orders; ?></td>

          </tr>
        </table>
      </div>
      <button>Profile</button>
    </div>
    <div class="card">
      <img src="../images/products.jpg">
      <h4>Total_products</h4>
      <br>
      <div class="per">
        <table>
          <tr>
            <br>
          </tr>
          <tr>
            <td> <?php
                  $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
                  $number_of_products = mysqli_num_rows($select_products);

                  echo $number_of_products; ?>
            </td>

          </tr>

        </table>
      </div>
      <button>Profile</button>
    </div>
  </div>


  <div class="users">
    <div class="card">
      <img src="../images/users.jpg">
      <h4>user</h4>
      <!-- <p>Ui designer</p> -->
      <div class="per">
        <table>
          <tr>
            <?php
            $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'user'") or die('query failed');
            $number_of_users = mysqli_num_rows($select_users);
            ?>
          </tr>
          <tr>
            <td><?php echo  $number_of_users; ?></td>
            <BR>
            <br>

          </tr>
        </table>
      </div>
      <button>View order</button>
    </div>
    <div class="card">
      <img src="../images/admin.png">
      <h4>total admin</h4>

      <div class="per">
        <table>

          <tr>
            <td> <?php
                  $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'admin'") or die('query failed');
                  $number_of_users = mysqli_num_rows($select_users);
                  ?>
            </td>
            <br>
            <br>
            <?php echo $number_of_users; ?>
          </tr>
        </table>
      </div>
      <button>view order</button>
    </div>
    <div class="card">
      <img src="../images/all.png">
      <h4>total_user</h4>

      <div class="per">
        <table>
          <?php
          $select_users = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed');
          $number_of_users = mysqli_num_rows($select_users);
          ?>
          <tr>

          </tr>
          <tr>
            <br>
            <br>
            <td><?php echo $number_of_users; ?></td>

          </tr>
        </table>
      </div>
      <button>Profile</button>
    </div>
    <div class="card">
      <img src="../images/com.jpg">
      <h4>comming soon</h4>
      <span> product</span>
      <br>
      <div class="per">
        <table>
          <tr>
            <br>
          </tr>
          <tr>
            <td>
              ?
            </td>

          </tr>

        </table>
      </div>
      <button>Profile</button>
    </div>
  </div>

 
</body>

</html>