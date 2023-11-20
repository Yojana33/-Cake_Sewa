<?php
session_start();
include 'header.php'; ?>


<!-- home section start here  -->
<section class="home" id="home">
    <div class="homeContent">
        <h2>Delicious Cake for Everyone </h2>
        <p>Where Tradition Meets Taste.</p>
    </div>
</section>

<?php if (isset($message)) {
    foreach ($message as $message) {
        echo '
    <div class="message">
        <span>' . $message . '</span>
        <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
    </div>
    ';
    }
} ?>

<!-- home section end here  -->

<!-- product section start here  -->
<section class="product" id="product">
    <div class="heading">
        <h2>Our Exclusive Products</h2>
    </div>
    <input type="text" id="search-input" placeholder="Search..." style="width: 400px; border-radius: 10px;padding: 20px 20px ; margin-bottom: 20px ;">
    <div class="swiper product-row" style="font-size: 250%;">
        <div class="swiper-wrapper" id="div-container">
            <?php
            $select_products = mysqli_query($conn, "SELECT * FROM `products`  ORDER BY name DESC") or die('query failed');
            if (mysqli_num_rows($select_products) > 0) {
                while ($fetch_products = mysqli_fetch_assoc($select_products)) {
            ?>
                    <div class="div-element swiper-slide box">

                        <form action="" method="post" class="swiper-slide slide">
                            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($fetch_products['id']); ?>">
                            <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($fetch_products['name']); ?>">
                            <input type="hidden" name="price" value="<?php echo htmlspecialchars($fetch_products['price']); ?>">
                            <input type="hidden" name="product_image" value="<?php echo htmlspecialchars($fetch_products['image']); ?>">
                            <img src="../uploaded_img/<?php echo htmlspecialchars($fetch_products['image']); ?>" alt="" class="img" style="width: 100%; padding: inherit;">
                            <div class="name"><?php echo htmlspecialchars($fetch_products['name']); ?></div>
                            <?php if ($fetch_products['stock'] > 9) : ?>
                                <span class="stock" style="color: green;"><i class="fas fa-check"></i> In stock</span>
                            <?php elseif ($fetch_products['stock'] == 0) : ?>
                                <span class="stock" style="color: red;"><i class="fas fa-times"></i> Out of stock</span>
                            <?php else : ?>
                                <span class="stock" style="color: red;">Hurry, only <?= htmlspecialchars($fetch_products['stock']); ?> left</span>
                            <?php endif; ?>
                            <div class="flex">
                                <div class="price"><span>Rs</span><?= htmlspecialchars($fetch_products['price']); ?><span>/-</span></div>
                            </div>
                            <?php if (isset($_SESSION['user_id']) && $fetch_products['stock'] != 0) : ?>

                                <input type="number" name="quantity" min="1" value="1" max="<?= htmlspecialchars($fetch_products['stock']); ?>" class="qtn">


                                <input type="submit" value="Add to Cart" name="add_to_cart" class="btn">
                            <?php endif; ?>
                            <br>
                        </form>
                    </div>
            <?php
                }
            } else {
                echo '<p class="empty">no products added yet!</p>';
            }
            ?>


        </div>
        <div class="swiper-pagination"></div>

    </div>

            <div class="swiper-pagination"></div>
        </div>
</section>

<!-- product section end here  -->





<!-- footer section start here  -->

<footer class="footer" id="contact">
    <div class="box-container">
        <div class="mainBox">
            <div class="content">
                <a href="#"><img src="images/logo.png" alt=""></a>
                <h1 class="logoName"> BakerySewa </h1>
            </div>

            <p>
            <p>Where Tradition Meets Taste.</p>
            </p>

        </div>
        <div class="box">
            <h3>Quick link</h3>
            <a href="#"> <i class="fas fa-arrow-right"></i>Home</a>
            <a href="#"> <i class="fas fa-arrow-right"></i>product</a>

        </div>

        <div class="box">
            <h3>Contact Info</h3>
            <a href="#"> <i class="fas fa-phone"></i>9812362818</a>
            <a href="#"> <i class="fas fa-envelope"></i>yojana@gmail.com</a>

        </div>

    </div>
    <div class="share">
        <a href="#" class="fab fa-facebook-f"></a>
        <a href="#" class="fab fa-twitter"></a>
        <a href="#" class="fab fa-instagram"></a>
        <a href="#" class="fab fa-linkedin"></a>
        <a href="#" class="fab fa-pinterest"></a>
    </div>
    <div class="credit">
        created by <span>Ms. Yojana Subedi </span> |all rights reserved !
    </div>
</footer>



<script>
      // Search ||linear algorith
const searchInput = document.getElementById('search-input');
const divElements = document.querySelectorAll('.div-element');
  
searchInput.addEventListener('input', function () {
    const query = searchInput.value.toLowerCase();

    divElements.forEach(function (divElement) {
        const textContent = divElement.textContent.toLowerCase();

        if (textContent.includes(query)) {
            divElement.style.display = 'block';
        } else {
            divElement.style.display = 'none';
        }
    });
});


  function filterNumbers() {
    let rangeInput = document.getElementById("rangeInput").value;
    let range = rangeInput.split("-");
    let min = parseInt(range[0]);
    let max = parseInt(range[1]);
    let numberList = document.getElementById("numberList");
    let numbers = numberList.getElementsByClassName("number");
    for (let i = 0; i < numbers.length; i++) {
      let number = parseInt(numbers[i].innerText);
      if (number >= min && number <= max) {
        numbers[i].style.display = "inline-block";
      } else {
        numbers[i].style.display = "none";
      }
    }
  }
</script>

<!-- swiper js link  -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<!-- Include the Swiper library -->
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>



<!-- <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
  // Initialize Swiper sliders
  var productSwiper = new Swiper('.product-row', {
    // Customize Swiper options here
    slidesPerView: 'auto',
    spaceBetween: 20,
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
  });
</script> -->


</body>

</html>