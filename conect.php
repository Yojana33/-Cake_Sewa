
<?php


// Connect to the MySQL database using mysqli
    $servername = "localhost";
    $username_db = "root";
    $password_db = "";
    $dbname = "cake_shop";
    $conn = mysqli_connect($servername, $username_db, $password_db, $dbname);

    // Check the connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    ?>