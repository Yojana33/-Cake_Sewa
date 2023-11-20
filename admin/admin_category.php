<?php
include 'admin_header.php'; 

if (isset($_POST['add_product'])) {
   $name = mysqli_real_escape_string($conn, $_POST['name']);

   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../uploaded_img/'.$image;

   $select_product_name = mysqli_query($conn, "SELECT name FROM `category` WHERE name = '$name'") or die('Query failed');

   if (mysqli_num_rows($select_product_name) > 0) {
      $message_1[] = 'Product name already added';
   } else {
      if ($image_size > 2000000) {
         $message_1[] = 'Image size is too large';
      } else {
         $add_product_query = mysqli_query($conn, "INSERT INTO `category` (name, image) VALUES ('$name', '$image')") or die('Query failed');

         if ($add_product_query) {
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'Product added successfully!';
         } else {
            $message_1[] = 'Product could not be added!';
         }
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
     $delete_image_query = mysqli_query($conn, "SELECT image FROM `category` WHERE id = '$delete_id'") or die(mysqli_error($conn));
     $fetch_delete_image = mysqli_fetch_assoc($delete_image_query);
   //   unlink('../uploaded_img/'.$fetch_delete_image['image']);
     $message[] = 'Category deleted.';
     mysqli_query($conn, "DELETE FROM `category` WHERE id = '$delete_id'") or die(mysqli_error($conn));
     header('location: admin_show_category.php');
     exit; // Stop further execution
   }
 }

if(isset($_POST['update_product'])){

   $update_p_id = $_POST['update_p_id'];
   $update_name = $_POST['update_name'];



  

   mysqli_query($conn, "UPDATE `category` SET name = '$update_name' WHERE id = '$update_p_id'") or die('query failed');

   $update_image = $_FILES['update_image']['name'];
   $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
   $update_image_size = $_FILES['update_image']['size'];
   $update_folder = '../uploaded_img/'.$update_image;
   $update_old_image = $_POST['update_old_image'];

   if(!empty($update_image)){
      if($update_image_size > 2000000){
         $message[] = 'image file size is too large';
      }else{
         mysqli_query($conn, "UPDATE `products` SET image = '$update_image' WHERE id = '$update_p_id'") or die('query failed');
         move_uploaded_file($update_image_tmp_name, $update_folder);
         unlink('../uploaded_img/'.$update_old_image);
      }
   }
   
   

   header('location:admin_category.php');

}

   






 ?>

<!-- product CRUD section starts  -->






   <!-- <h1 class="title">shop products</h1> -->
<section class="form-container">
   <form action="" method="post" enctype="multipart/form-data">
      <h3>add category</h3>
      
  
    <div class="flex">
    <div class="inputBox">     
      <input type="text" name="name" class="box" placeholder="enter category name" required>  </div>

    </div> 
   
   
 
      <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box" required>
       
      
    <input type="submit" value="add product" name="add_product" class="btn" style="background-color: #6157d0;">
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
      if(isset($_GET['update'])){
         $update_id = $_GET['update'];
         $update_query = mysqli_query($conn, "SELECT * FROM `category` WHERE id = '$update_id'") or die('query failed');
         if(mysqli_num_rows($update_query) > 0){
            while($fetch_update = mysqli_fetch_assoc($update_query)){
   ?>
 <form action="" method="post" enctype="multipart/form-data">
   <h3>update product</h3>
 <img src="../uploaded_img/<?php echo $fetch_update['image']; ?>" height="100" alt="">
   <div class="flex">
      <div class="inputBox">
      <input type="text" name="update_name" value="<?php echo $fetch_update['name']; ?>" class="box" required placeholder="enter  category name">
            
      </div>
     
      <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['id']; ?>">
      <input type="hidden" name="update_old_image" value="<?php echo $fetch_update['image']; ?> " >
   
   
 
  
      <input type="file" class="box" name="update_image1" accept="image/jpg, image/jpeg, image/png">
        <!-- <span>     </span>
      <input type="file" class="box" name="update_image" accept="image/jpg, image/jpeg, image/png"> -->
     
      <input type="submit" value="update" name="update_product" class="btn" style="background-color: #6157d0;">
      <!-- <input type="reset" value="cancel" id="close-update" class="option-btn"> -->
      <a href="admin_category.php" class="delete-btn" onclick="return confirm('cancel?');">cancel</a>

 </form>
   <?php
         }
      }
      }else{
         echo '<script>document.querySelector(".form-container1").style.display = "none";</script>';
      }
   ?>

</section>



            




<!-- custom admin js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>