<?php
include 'admin_header.php'; 


?>

<!-- show products  -->

 <div class="header_fixed"  style="border-bottom-width: 30px;border-left-width: 300px;border-right-width: 400px;border-top-width: 20px;" >


   <table id=product >
    <?php
   if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
  }

   if(isset($message_1)){
   foreach($message_1 as $message_1){
   echo '
   <div class="message_1">
      <span>'.$message_1.'</span>
      <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
   </div>
     ';
   }
    }?>
       <a class="option-btn" href="admin_products.php">Add product</a>
     
      <thead>

         <tr>
            <th >product image</th>
            <th style="width:1%;">product name</th>
            <th style="width:1%;">product price</th>
            <th style="width:1%;">Quantity</th>
            <th style="width:20%;">product details</th>
            <th style="width:10%;">action</th>
         </tr>
       </thead>
           <?php
          $select_products = mysqli_query($conn, "SELECT * FROM `products` order by id desc") or die('query failed');
           if(mysqli_num_rows($select_products) > 0){
          while($fetch_products = mysqli_fetch_assoc($select_products)){
         // Extracting data from a database 
         ?>
         <tr>
            <td><img src="../uploaded_img/<?php echo $fetch_products['image']; ?>" height="100" alt=""></td>
            
            <td> <?php echo $fetch_products['name']; ?>
               <?php echo $fetch_products['category']; ?></td>
            <td>$<?php echo $fetch_products['price']; ?>/-</td>
         
            <td><?php echo $fetch_products['quantity']; ?></td>
            <td> <?php echo $fetch_products['details']; ?>|
            
             <!-- storage -<?php echo $fetch_products['details_1']; ?><br>
             Display <?php echo $fetch_products['details_2']; ?> <br>
             battery<?php echo $fetch_products['details_3']; ?><br></td>/<br>
             -->
           
            <td>
             <a href="admin_products.php?update=<?php echo $fetch_products['id']; ?>" class="option-btn">update</a>
             <a href="admin_products.php?delete=<?php echo $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>
            </td>
         </tr>
         <?php
        }
        }else{
        echo '<p class="empty">no products added yet!</p>';
       }
      ?>
   </table>    
 
</div>
