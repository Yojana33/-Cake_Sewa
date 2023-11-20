<?php
session_start();

include 'header.php';




if (isset($massage_1)) {
   foreach ($massage_1 as $massage_1) {
      echo '<script>swal("' . $massage_1 . '", "", "success");</script>';
   }
}






?>
<!-- product CRUD section starts  -->




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
<section class="form-container" style="min-height: calc(100vh - 19rem);padding-top: 10%;">
   <form class="register" action="" method="post" enctype="multipart/form-data">
      <h1 class="heading">Customize Products</h1>

      <div class="flex">
         <div class="col">
            <input type="text" name="name" class="box" placeholder="Enter product name" required>



            <input type="number" min="0" name="stock" class="box" placeholder="Enter product quantity" required>


            <select name="category_id" class="box">
               <option value="" selected disabled>Select category</option>
               <?php
               $select_category = mysqli_query($conn, "SELECT * FROM `category`") or die('Query failed');
               if (mysqli_num_rows($select_category) > 0) {
                  while ($fetch_category = mysqli_fetch_assoc($select_category)) {
               ?>
                     <option value="<?php echo $fetch_category['id']; ?>">
                        <?php echo $fetch_category['name']; ?>
                     </option>
               <?php
                  }
               } else {
                  echo '<p class="empty">No product!</p>';
               }
               ?>
            </select>
         </div>
         <div class="col">
            <div class="input">
               <div class="input">
                  <select name="details" class="box">
                     <option value="" selected disabled>Select level</option>
                     <option value="level_1">level 1</option>
                     <option value="level_2">level 2</option>
                     <option value="level_3">level 3</option>
                  </select>
               </div>


               <select name="flavor_id" class="box">
                  <option value="" selected disabled>Select flavors</option>
                  <?php
                  $select_category = mysqli_query($conn, "SELECT * FROM `flavors`") or die('Query failed');
                  if (mysqli_num_rows($select_category) > 0) {
                     while ($fetch_category = mysqli_fetch_assoc($select_category)) {
                  ?>
                        <option value="<?php echo $fetch_category['ID']; ?>">
                           <?php echo $fetch_category['Name']; ?>

                        </option>
                  <?php
                     }
                  } else {
                     echo '<p class="empty">No product!</p>';
                  }
                  ?>
               </select>

            </div>
         </div>
      </div>


      <div class="inputBox">
         <p>any design you can provide</p>
         <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box">
      </div>



      <input type="submit" value="Customize Product" name="add_product" class="btn" style="width: 100%; padding: 10px; background-color: #432109; color: #fff;
			border: none;
			border-radius: 3px;
			cursor: pointer;">
   </form>
</section>



<!-- product CRUD section ends -->
<!-- !-- show products  --> -











<!-- custom admin js file link  -->
<script src="../js/admin_script.js"></script>

</body>

</html>