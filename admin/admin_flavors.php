<?php
include 'admin_header.php';

if (isset($_POST['add_product'])) {
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $price = $_POST['price'];

   $select_product_name = mysqli_query($conn, "SELECT name FROM `flavors` WHERE name = '$name'") or die('Query failed');

   if (mysqli_num_rows($select_product_name) > 0) {
      $message_1[] = 'Flavors name already added';
   } else {
      $add_product_query = mysqli_query($conn, "INSERT INTO `flavors` (name, price) VALUES ('$name', '$price')") or die('Query failed');

      if ($add_product_query) {
         $message_1[] = 'Flavors added successfully!';
      } else {
         $message_1[] = 'Flavors could not be added!';
      }
   }
   header('location:admin_category.php');
}

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];

   // Check if there are products associated with the category
   $check_products_query = mysqli_query($conn, "SELECT COUNT(*) AS count FROM `products` WHERE category_id = '$delete_id'") or die(mysqli_error($conn));
   $fetch_products_count = mysqli_fetch_assoc($check_products_query);
   $products_count = $fetch_products_count['count'];

   if ($products_count > 0) {
      // Show error message that you can't delete the category
      $message[] = 'You cannot delete the category as there are products associated with it.';
   } else {
      // Delete the category
      $delete_image_query = mysqli_query($conn, "SELECT image FROM `flavors` WHERE id = '$delete_id'") or die(mysqli_error($conn));
      $fetch_delete_image = mysqli_fetch_assoc($delete_image_query);
      //   unlink('../uploaded_img/'.$fetch_delete_image['image']);
      $message[] = 'Category deleted.';
      mysqli_query($conn, "DELETE FROM `flavors` WHERE id = '$delete_id'") or die(mysqli_error($conn));
      header('location: admin_show_category.php');
      exit; // Stop further execution
   }
}








if (isset($_POST['update_product'])) {
   $update_p_id = $_POST['update_p_id'];
   $update_name = $_POST['update_name'];
   $update_price = $_POST['update_price'];

   mysqli_query($conn, "UPDATE `flavors` SET name = '$update_name', price = '$update_price' WHERE ID = '$update_p_id'") or die('Query failed');

   // header('location:admin_flavors.php');
}



?>

<!-- product CRUD section starts  -->






<!-- <h1 class="title">shop products</h1> -->
<section class="form-container">
   <form action="" method="post" enctype="multipart/form-data">
      <h3>Add Flavors</h3>


      <div class="flex">
         <div class="inputBox">
            <input type="text" name="name" class="box" placeholder="Enter flavors name" required>
         </div>
         <input type="number" name="price" class="box" placeholder="Enter price">
      </div>





      <input type="submit" value="add flavor" name="add_product" class="btn" style="background-color: #6157d0;">
   </form>


</section>
</div>
<!-- product CRUD section ends -->
<!-- !-- show products  --> -->





</div>

<!-- ........................update             -->
</end>
<section class="form-container1">

   <?php
   if (isset($_GET['update'])) {
      $update_id = $_GET['update'];
      $update_query = mysqli_query($conn, "SELECT * FROM `flavors` WHERE ID = '$update_id'") or die('query failed');
      if (mysqli_num_rows($update_query) > 0) {
         while ($fetch_update = mysqli_fetch_assoc($update_query)) {
   ?>
            <form action="" method="post" enctype="multipart/form-data">
               <h3>update product</h3>
               <div class="flex">
                  <div class="inputBox">
                     <input type="text" name="update_name" value="<?php echo $fetch_update['Name']; ?>" class="box" required placeholder="enter  category name">
                     <input type="number" name="update_price" value="<?php echo $fetch_update['Price']; ?>" class="box" required placeholder="enter  category name">

                  </div>

                  <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['ID']; ?>">





                  <!-- <span>     </span>
      <input type="file" class="box" name="update_image" accept="image/jpg, image/jpeg, image/png"> -->
                  <div class="flex">
                     <div class="inputBox">
                        <input type="submit" value="update" name="update_product" class="btn" style="background-color: #6157d0;">
                        <!-- <input type="reset" value="cancel" id="close-update" class="option-btn"> -->
                        <a href="admin_category.php" class="delete-btn" onclick="return confirm('cancel?');">cancel</a>


                     </div>

            </form>
   <?php
         }
      }
   } else {
      echo '<script>document.querySelector(".form-container1").style.display = "none";</script>';
   }
   ?>

</section>








<!-- custom admin js file link  -->
<script src="../js/admin_script.js"></script>

</body>

</html>