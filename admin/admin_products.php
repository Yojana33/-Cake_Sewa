<?php
include 'admin_header.php';
if (isset($_POST['add_product'])) {
   // Sanitize and retrieve the form data
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $stock = $_POST['stock'];
   $image = $_FILES['image']['name'];
   $price = $_POST['price'];
   $category_id = $_POST['category_id'];
   $details = mysqli_real_escape_string($conn, $_POST['details']);
   $flavor_id = $_POST['flavor_id'];

   // Process the image file
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../uploaded_img/' . $image;

   // Check if the product name already exists
   $select_product_name = mysqli_query($conn, "SELECT name FROM `products` WHERE name = '$name'") or die('Query failed');
   if (mysqli_num_rows($select_product_name) > 0) {
      $message_1[] = 'Product name already added';
   } else {
      // Insert the product data into the database
      $add_product_query = mysqli_query($conn, "INSERT INTO `products` (name, stock, image, price, category_id, details, flavor_id) VALUES ('$name', '$stock', '$image', '$price', '$category_id', '$details', '$flavor_id')") or die('Query failed');
      if ($add_product_query) {
         if ($image_size > 2000000) {
            $message_1[] = 'Image size is too large';
         } else {
            // Move the uploaded image to the desired folder
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'Product added successfully!';
         }
      } else {
         $message_1[] = 'Product could not be added!';
      }
   }
   // header('location: admin_products.php');
}



?>

<!-- product CRUD section starts  -->


<?php
if (isset($message_1)) {
   foreach ($message_1 as $message_1) {
      echo '
      <div class="message">
         <span>' . $message_1 . '</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>


<section class="form-container">
   <form action="" method="post" enctype="multipart/form-data">
      <h3>Add Product</h3>

      <div class="flex">
         <div class="inputBox">
            <input type="text" name="name" class="box" placeholder="Enter product name" required>
         </div>

         <div class="inputBox">
            <input type="number" min="0" name="price" class="box" placeholder="Enter product price" required>
         </div>


      </div>

      <div class="flex">
         <div class="inputBox">
            <select name="category_id" class="box">
               <option value="" selected disabled>Select category</option>
               <?php
               $select_category = mysqli_query($conn, "SELECT * FROM `category`") or die('Query failed');
               if (mysqli_num_rows($select_category) > 0) {
                  while ($fetch_category = mysqli_fetch_assoc($select_category)) {
                     // Extracting data from a database 
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
            <textarea name="details" placeholder="Enter product description" class="box"></textarea>
         </div>


         <div class="flex">
            <div class="inputBox">
               <input type="number" min="0" name="stock" class="box" placeholder="Enter product stock" required>
            </div>

            <div class="inputBox">
               <select name="flavor_id" class="box">
                  <option value="" selected disabled>Select flavors</option>
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

         <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box" required>

         <input type="submit" value="Add Product" name="add_product" class="btn" style="background-color: #6157d0;">
   </form>
</section>






</div>

<!-- ........................update             -->
</end>







<!-- custom admin js file link  -->
<script src="../js/admin_script.js"></script>

</body>

</html>