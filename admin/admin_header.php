<?php
include '../conect.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location: ../login/login.php');
}


if(isset($_SESSION['role'])){
   if($_SESSION['role'] == 'user'){
      header("Location: ../customer/");
   }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>admin panel</title>

  <!-- font awesome cdn link  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
  <script src="https://kit.fontawesome.com/c9c55a2f37.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="../css/admins.css">



</head>


<body>


  <div class="container">
    <nav>
      <ul>
        <li><a href="#" class="logo">
            <img src="../images/logo.png">
            <!-- <span class="nav-item">Admin<br><?php echo $_SESSION['adminusername']; ?></span> -->
          </a></li>
        <li><a href="index.php">
            <i class="fas fa-menorah"></i>
            <span class="nav-item">Dashboard</span>
          </a></li>
        <!-- <li><a href="#">
          <i class="fas fa-comment"></i>
          <span class="nav-item">Message</span>
        </a></li> -->
        <li><a href="admin_products.php">
            <i class="fas fa-list" style="font-size:30px;"></i>
            <span class="nav-item"> Products</span>
          </a></li>

        <li><a href="admin_show_products.php">
            <i class="fas fa-list" style="font-size:30px;"></i>
            <span class="nav-item">Show Products</span>
          </a></li>

        <li><a href="admin_category.php">
            <i class="fas fa-list" style="font-size:30px;"></i>
            <span class="nav-item">Category</span>
          </a></li>

        <li><a href="admin_show_category.php">
            <i class="fas fa-list" style="font-size:30px;"></i>
            <span class="nav-item"> Show Category</span>
          </a></li>


        <li><a href="admin_flavors.php">
            <i class="fas fa-list" style="font-size:30px;"></i>
            <span class="nav-item">Flavors</span>
          </a></li>

        <li><a href="admin_show_flavors.php">
            <i class="fas fa-list" style="font-size:30px;"></i>
            <span class="nav-item">Show Flavors</span>
          </a></li>

        <li><a href="admin_orders.php">
            <i class="fas fa-list" style="font-size:30px;"></i>
            <span class="nav-item">order</span>
          </a></li>

        <li><a href="admin_users.php">
            <i class="fas fa-list" style="font-size:30px;"></i>
            <span class="nav-item">user</span>
          </a></li>

        <li><a href="../logout.php" class="logout">
            <i class="fas fa-sign-out-alt"></i>
            <span class="nav-item">Log out</span>
          </a></li>
      </ul>
    </nav>


    <!-- <header class="header">

   <div class="flex">
      <div  class="hello">
      <i class="bx bxs-smile" style="/*! min-width: 60px; *//*! display: flex; *//*! justify-content: center; */font-size: 30px;/*! font-weight: 700; *//*! display: flex; *//*! align-items: center; */color: var(--yellow);/*! position: sticky; *//*! top: 0; *//*! left: 0; *//*! background: var(--light); */z-index: 500;/*! padding-bottom: 20px; *//*! box-sizing: content-box; */"></i>
      </div>


    

      <a href="admin_page.php" class="logo" style="width: 50%;font-family: 'Rubik', sans-serif;">AdminDasboard</a>
      
	 

      <nav class="navbar">
         <a href="index.php">home</a>
         <a href="admin_products.php">products</a>
       
         <a href="admin_orders.php">orders</a>
         <a href="admin_users.php">users</a>
         <a href="../logout.php">logout</a>
     
      </nav>

     
     
      

   </div> -->


    </header>