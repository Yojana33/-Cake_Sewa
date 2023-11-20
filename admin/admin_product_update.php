<?php
include 'admin_header.php';


if (isset($_POST['update_product'])) {
   $update_p_id = $_POST['update_p_id'];
   $update_name = $_POST['update_name'];
   $update_stock = $_POST['update_stock'];
   $update_image = $_FILES['update_image']['name'];
   $update_price = $_POST['update_price'];
   $update_category_id = $_POST['update_category_id'];
   $update_details = $_POST['details'];
   $update_flavor_id = $_POST['flavor_id'];

   // Update the product details in the database
   mysqli_query($conn, "UPDATE `products` SET name = '$update_name', stock = '$update_stock', image = '$update_image', price = '$update_price', category_id = '$update_category_id', details = '$update_details', flavor_id = '$update_flavor_id' WHERE id = '$update_p_id'") or die('Query failed');

   // Handle product image updates
   $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
   $update_image_size = $_FILES['update_image']['size'];
   $update_folder = '../uploaded_img/' . $update_image;
   $update_old_image = $_POST['update_old_image'];

   if (!empty($update_image)) {
      if ($update_image_size > 2000000) {
         $message[] = 'Image file size is too large';
      } else {
         mysqli_query($conn, "UPDATE `products` SET image = '$update_image' WHERE id = '$update_p_id'") or die('Query failed');
         move_uploaded_file($update_image_tmp_name, $update_folder);
         //  unlink('../uploaded_img/'.$update_old_image);
      }
   }

   //  header('location: admin_products.php');
}


?>





<section class="form-container1">
   <?php
   if (isset($_GET['update'])) {
      $update_id = $_GET['update'];
      $update_query = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$update_id'") or die('Query failed');
      if (mysqli_num_rows($update_query) > 0) {
         while ($fetch_update = mysqli_fetch_assoc($update_query)) {
   ?>
            <form action="" method="post" enctype="multipart/form-data">
               <h3>Update Product</h3>
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
               ?>
               <img src="../uploaded_img/<?php echo $fetch_update['image']; ?>" height="100" alt="">
               <div class="flex">
                  <div class="inputBox">
                     <input type="text" name="update_name" value="<?php echo $fetch_update['name']; ?>" class="box" required placeholder="Enter product name">
                  </div>
                  <div class="inputBox">
                     <input type="number" name="update_stock" value="<?php echo $fetch_update['stock']; ?>" min="0" class="box" required placeholder="Enter product stock">
                  </div>
                  <div class="inputBox">
                     <input type="number" name="update_price" value="<?php echo $fetch_update['price']; ?>" class="box" required placeholder="Enter product price">
                  </div>
               </div>

               <div class="flex">
                  <div class="inputBox">
                     <select name="update_category_id" class="box">
                        <option value="" selected disabled>Select category</option>
                        <?php
                        $select_category = mysqli_query($conn, "SELECT * FROM `category` ORDER BY id DESC") or die('Query failed');
                        if (mysqli_num_rows($select_category) > 0) {
                           while ($fetch_category = mysqli_fetch_assoc($select_category)) {
                        ?>
                              <option value="<?php echo $fetch_category['id']; ?>"><?php echo $fetch_category['name']; ?></option>
                        <?php
                           }
                        } else {
                           echo '<p class="empty">No product!</p>';
                        }
                        ?>
                     </select>
                  </div>
               </div>

               <div class="flex">
                  <div class="inputBox">
                     <textarea name="details" placeholder="Enter product details" class="box"><?php echo $fetch_update['details']; ?></textarea>
                  </div>
               </div>

               <div class="flex">
                  <div class="inputBox">
                     <select name="flavor_id" class="box">
                        <option value="<?php echo $fetch_update['flavor_id']; ?>" selected disabled>Select flavors</option>
                        <?php
                        $select_category = mysqli_query($conn, "SELECT * FROM `flavors`") or die('Query failed');
                        if (mysqli_num_rows($select_category) > 0) {
                           while ($fetch_category = mysqli_fetch_assoc($select_category)) {
                              // Extracting data from a database 
                        ?>
                              <option value="<?php echo $fetch_category['ID']; ?>"><?php echo $fetch_category['Name']; ?></option>
                        <?php
                           }
                        } else {
                           echo '<p class="empty">No flavors !</p>';
                        }
                        ?>
                     </select>
                  </div>
               </div>  

               <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['id']; ?>">
               <input type="hidden" name="update_old_image" value="<?php echo $fetch_update['image']; ?>">

               <div class="flex">
                  <div class="inputBox">
                     <input type="file" class="box" name="update_image" accept="image/jpg, image/jpeg, image/png">
                  </div>
               </div>

               <input type="submit" value="Update" name="update_product" class="btn" style="background-color: #6157d0;">
               <a href="admin_products.php" class="delete-btn" onclick="return confirm('Cancel?');">Cancel</a>
            </form>
   <?php
         }
      }
   } else {
      echo '<script>document.querySelector(".form-container1").style.display = "none";</script>';
   }
   ?>
</section>