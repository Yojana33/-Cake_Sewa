<?php
include 'admin_header.php';

// 

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
    $message[] = 'Category deleted.';
    mysqli_query($conn, "DELETE FROM `flavors` WHERE ID = '$delete_id'") or die(mysqli_error($conn));
    exit; // Stop further execution
  }
}

?>



<section class="attendance" style="padding-left: 3rem;">
  <div class="attendance-list">
    <h1>Flavor List</h1>
    <?php
    if (isset($message)) {
      foreach ($message as $message) {
        echo '
      <div class="message">
         <span>' . $message. '</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
      }
    }
    ?>


    <table class="table">
      <thead>

        <tr>
          <th>Flavors name</th>
          <th>Flavors price</th>



          <th>action</th>
        </tr>
      </thead>
      <?php
      $select_category = mysqli_query($conn, "SELECT * FROM `flavors` order by id desc") or die('query failed');
      if (mysqli_num_rows($select_category) > 0) {
        while ($fetch_category = mysqli_fetch_assoc($select_category)) {
          // Extracting data from a database 
      ?>


          <tr>
            <td><?php echo $fetch_category['Name']; ?></td>

            <td> <?php echo $fetch_category['Price']; ?>






            <td> <a href="admin_show_flavors.php?update=<?php echo $fetch_category['ID']; ?>" class="option-btn">update</a>
            <td> <a href="admin_show_flavors.php?delete=<?php echo $fetch_category['ID']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>
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
</end>