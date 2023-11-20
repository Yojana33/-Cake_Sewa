<?php
include 'admin_header.php';


?>
<section class="attendance" style="padding-left: 3rem;">
  <div class="attendance-list">
    <h1>products List</h1>
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
    <table class="table">
      <thead>

        <tr>
          <th>product image</th>
          <th>product name</th>



          <th>action</th>
        </tr>
      </thead>
      <?php
      $select_category = mysqli_query($conn, "SELECT * FROM `category` order by id desc") or die('query failed');
      if (mysqli_num_rows($select_category) > 0) {
        while ($fetch_category = mysqli_fetch_assoc($select_category)) {
          // Extracting data from a database 
      ?>
          <tr>
            <td><img src="../uploaded_img/<?php echo $fetch_category['image']; ?>" height="100" alt=""></td>

            <td> <?php echo $fetch_category['name']; ?>






            <td> <a href="admin_category.php?update=<?php echo $fetch_category['id']; ?>" class="option-btn">update</a>
            <td> <a href="admin_category.php?delete=<?php echo $fetch_category['id']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>
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