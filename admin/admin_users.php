<?php
include 'admin_header.php';

if (isset($_POST['update_users'])) {

  $users_update_id = $_POST['users_id'];
  $update_user_type = $_POST['update_user_type'];
  mysqli_query($conn, "UPDATE `users` SET user_type = '$update_user_type' WHERE id = '$users_update_id'") or die('query failed');
  $message[] = ' status has been updated!';
}

if (isset($_GET['delete'])) {
  $delete_id = $_GET['delete'];
  mysqli_query($conn, "DELETE FROM `users` WHERE id = '$delete_id'") or die('query failed');
  header('location:admin_users.php');
}

?>

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
    <h1>user List</h1>
    <table class="table">
      <thead>
        <tr>

          <th> user id </th>
          <th>Username</th>
          <th> email </th>
          <th> user type </th>
          <th> Action</th>
        </tr>
        <?php
        $select_users = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed');
        while ($fetch_users = mysqli_fetch_assoc($select_users)) {
        ?>
      <tbody>

        <td> <?php echo $fetch_users['id']; ?></td>
        <td> <?php echo $fetch_users['username']; ?></td>
        <td> <?php echo $fetch_users['email']; ?></td>
        <td><?php echo $fetch_users['user_type']; ?></td>

        <td>
          <form action="" method="post">
            <input type="hidden" name="users_id" value="<?php echo $fetch_users['id']; ?>">
            <select name="update_user_type">
              <option value=""><?php echo $fetch_users['user_type']; ?></option>
              <option value="admin">admin</option>
              <option value="user">user</option><br>

            </select> <br>

            <input type="submit" value="update" name="update_users" class="option-btn">


          </form>
          <a href="admin_users.php?delete=<?php echo $fetch_users['id']; ?>" onclick="return confirm('delete this user?');" class="delete-btn">delete user</a>
        </td>
        </thead>
      <tbody>
      <?php
        };
      ?>

      </form>

      </tbody>
    </table>
  </div>
</section>
</section>
</div>










<!-- custom admin js file link  -->
<script src="../js/admin_script.js"></script>

</body>

</html>