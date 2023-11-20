<?php
include 'admin_header.php'; 
if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   $delete_image_query = mysqli_query($conn, "SELECT image FROM `products` WHERE id = '$delete_id'") or die('query failed');
   $fetch_delete_image = mysqli_fetch_assoc($delete_image_query);
   // unlink('uploaded_img/'.$fetch_delete_image['image']);
   $message[] = 'deleted';
   mysqli_query($conn, "DELETE FROM `products` WHERE id = '$delete_id'") or die('query failed');
   // header('location:admin_show_products.php');
}?>

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
               <th>product image</th>
               <th>product name</th>
               <th>product price</th>
               <th>Quantity</th>
               <th>product details</th>
               <th></th>
               <th>action</th>
            </tr>
         </thead>
         <?php
         $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE status = 'normal' order by id desc") or die('query failed');
         if (mysqli_num_rows($select_products) > 0) {
            while ($fetch_products = mysqli_fetch_assoc($select_products)) {
               // Extracting data from a database 
         ?>
               <tr>
                  <td><img src="../uploaded_img/<?php echo $fetch_products['image']; ?>" height="100" alt=""></td>

                  <td> <?php echo $fetch_products['name']; ?>
                     <!-- <?php echo $fetch_products['category']; ?></td> -->
                  <td>rs<?php echo $fetch_products['price']; ?>/-</td>

                  <td><?php echo $fetch_products['stock']; ?></td>
                  <td> <?php echo $fetch_products['details']; ?>|




                  <td> <a href="admin_product_update.php?update=<?php echo $fetch_products['id']; ?>" class="option-btn">update</a>
                  <td> <a href="admin_show_products.php?delete=<?php echo $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>
                  <td>


                     </form>

               </tr>
         <?php
            }
         } else {
            echo '<p class="empty">no product!</p>';
         }
         ?>

         </tbody>
      </table>
   </div>
</section>
</section>
</div>