<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/add_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Home</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="hero.css" />

</head>
<body>

<?php include 'components/user_header.php'; ?>



<!-- <section class="hero">

   <div class="swiper hero-slider">

      <div class="swiper-wrapper">

         <div class="swiper-slide slide">
            <div class="content">
               <span>Kalam - 2k24</span>
               <h3>Technical Events</h3>
               <a href="menu.html" class="btn">More</a>
            </div>
            <div class="image">
               <img src="images/001.mp4" alt="">
            </div>
         </div>

         <div class="swiper-slide slide">
            <div class="content">
               <span>Kalam - 2k24</span>
               <h3>Non - Tech Events</h3>
               <a href="menu.html" class="btn">More</a>
            </div>
            <div class="image">
               <img src="images/Dev.png" alt="">
            </div>
         </div>

         <div class="swiper-slide slide">
            <div class="content">
               <span>Kalam - 2k24</span>
               <h3>Cultural Events</h3>
               <a href="menu.html" class="btn">More</a>
            </div>
            <div class="image">
               <img src="images/Dev.png" alt="">
            </div>
         </div>

      </div>

      <div class="swiper-pagination"></div>

   </div>

</section> -->
<div class="">
<div class="carousell">
      <!-- list item -->
      <div class="listt">
        <div class="itemm">
          <img src="image/img1111.jpg" />
          <div class="contentt">
            <div class="authorr">KALAM-24</div>
            <div class="titlee">TECHNICAL</div>
            <div class="topicc">EVENTS</div>
            <div class="dess">
              <!-- lorem 50 -->
              Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut
              sequi, rem magnam nesciunt minima placeat, itaque eum neque
              officiis unde, eaque optio ratione aliquid assumenda facere ab et
              quasi ducimus aut doloribus non numquam. Explicabo, laboriosam
              nisi reprehenderit tempora at laborum natus unde. Ut,
              exercitationem eum aperiam illo illum laudantium?
            </div>
            <div class="buttonss">
              <button>SEE MORE</button>
            </div>
          </div>
        </div>
        <div class="itemm">
          <img src="image/img22.jpeg" />
          <div class="contentt">
            <div class="authorr">KALAM-24</div>
            <div class="titlee">NON - TECH</div>
            <div class="topicc">EVENTS</div>
            <div class="dess">
              Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut
              sequi, rem magnam nesciunt minima placeat, itaque eum neque
              officiis unde, eaque optio ratione aliquid assumenda facere ab et
              quasi ducimus aut doloribus non numquam. Explicabo, laboriosam
              nisi reprehenderit tempora at laborum natus unde. Ut,
              exercitationem eum aperiam illo illum laudantium?
            </div>
            <div class="buttonss">
              <button>SEE MORE</button>
            </div>
          </div>
        </div>
        <div class="itemm">
          <img src="image/img33.jpg" />
          <div class="contentt">
            <div class="authorr">KALAM-24</div>
            <div class="titlee">CULTURAL</div>
            <div class="topicc">EVENTS</div>
            <div class="dess">
              Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut
              sequi, rem magnam nesciunt minima placeat, itaque eum neque
              officiis unde, eaque optio ratione aliquid assumenda facere ab et
              quasi ducimus aut doloribus non numquam. Explicabo, laboriosam
              nisi reprehenderit tempora at laborum natus unde. Ut,
              exercitationem eum aperiam illo illum laudantium?
            </div>
            <div class="buttonss">
              <button>SEE MORE</button>
            </div>
          </div>
        </div>
        
      </div>
      <!-- list thumnail -->
      <div class="thumbnaill">
        <div class="itemm">
          <img src="image/img1111.jpg" />
          <div class="contentt">
            <div class="titlee">TECHNICAL EVENTS</div>
            <div class="descriptionn">KALAM - 24</div>
          </div>
        </div>
        <div class="itemm">
          <img src="image/img22.jpeg" />
          <div class="contentt">
            <div class="titlee">NON - TECH EVENTS</div>
            <div class="descriptionn">KALAM - 24</div>
          </div>
        </div>
        <div class="itemm">
          <img src="image/img33.jpg" />
          <div class="contentt">
            <div class="titlee">CULTURAL EVENTS</div>
            <div class="descriptionn">KALAM - 24</div>
          </div>
        </div>
        
      </div>
      <!-- next prev -->

      <div class="arrowss">
        <button id="prevv"><</button>
        <button id="nextt">></button>
      </div>
      <!-- time running -->
    </div>
    <script src="app.js"></script>

</div>


    <section class="category">

   <h1 class="title">Event Category</h1>

   <div class="box-container">

      <a href="category.php?category=Technical Event" class="box">
         <img src="image/OIP1.jpeg" alt="">
         <h3>Technical Events</h3>
      </a>

      <a href="category.php?category=Non - Technical Event" class="box">
         <img src="image/OIP2.jpeg" alt="">
         <h3>Non - Tech Events</h3>
      </a>

      <a href="category.php?category=Cultural Events" class="box">
         <img src="image/OIP3.jpg" alt="">
         <h3>Cultural Events</h3>
      </a>

      <!-- <a href="category.php?category=desserts" class="box">
         <img src="images/cat-4.png" alt="">
         <h3>desserts</h3>
      </a> -->

   </div>

</section>




<section class="products">

   <h1 class="title">Top Events</h1>

   <div class="box-container">

      <?php
         $select_products = $conn->prepare("SELECT * FROM `products` LIMIT 6");
         $select_products->execute();
         if($select_products->rowCount() > 0){
            while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
      ?>
      <form action="" method="post" class="box">
         <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
         <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
         <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
         <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
         <a href="quick_view.php?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a>
         <!-- <button type="submit" class="fas fa-shopping-cart" name="add_to_cart"></button> -->
         <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
         <a href="category.php?category=<?= $fetch_products['category']; ?>" class="cat"><?= $fetch_products['category']; ?></a>
         <div class="name"><?= $fetch_products['name']; ?></div>
         <div class="flex">
            <div class="price"><span>₹ </span><?= $fetch_products['price']; ?></div>
            <a class="btn" href="quick_view.php?pid=<?= $fetch_products['id']; ?>">View Event</a>
            <!-- <input type="number" name="qty" class="qty" min="1" max="99" value="1" maxlength="2"> -->
         </div>
      </form>
            </a>
      <?php
            }
         }else{
            echo '<p class="empty">no products added yet!</p>';
         }
      ?>

   </div>

   <div class="more-btn">
      <a href="menu.php" class="btn">veiw all</a>
   </div>

</section>


















<?php include 'components/footer.php'; ?>


<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<!-- <script>

var swiper = new Swiper(".hero-slider", {
   loop:true,
   grabCursor: true,
   effect: "flip",
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
});



</script> -->

<script>
var swiper = new Swiper(".hero-slider", {
   loop: true,
   grabCursor: true,
   effect: "flip",
   speed: 2000,
   pagination: {
      el: ".swiper-pagination",
      clickable: true,
   },
   autoplay: {
      delay: 5000,
      pauseOnMouseEnter: false
   }
});
</script>


</body>
</html>