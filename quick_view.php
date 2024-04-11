<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
} else {
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
   <title>Quick View</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

   <style>
      <style>
/* Modal styles */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 9999; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
}

/* Modal content */
.modal-content {
  background-color: #fefefe;
  margin: 5% auto; /* 15% from the top and centered */
  padding: 15px;
  border: 1px solid #888;
  width: 100%; /* Could be more or less, depending on screen size */
  border-radius: 10px;
}

#event-opt {
  margin-left: 90px;
}

/* Close button */
.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}
</style>
   </style>

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="quick-view">

   <h1 class="title">quick view</h1>

   <?php
   $pid = $_GET['pid'];
   $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
   $select_products->execute([$pid]);
   if($select_products->rowCount() > 0){
      while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>
   <form action="" method="post" class="box">
      <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
      <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
      
      <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
      
      <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
      <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
      <a href="category.php?category=<?= $fetch_products['category']; ?>" class="cat"><?= $fetch_products['category']; ?></a>
      <div style="font-size: 3rem; color: #5700FF; font-weight: bold;" class="name"><?= $fetch_products['name']; ?></div>
      <div class="flex">
      <?php 
      $jointPID = $fetch_products['single_joint_event_id'];
      if ($fetch_products['price'] == '') { ?>
          <div class="name"><a class="btn" href="quick_view.php?pid=<?= $jointPID; ?>">See Group Events</a></div>
      <?php } else { ?>
         <div class="price"><span>₹</span><?= $fetch_products['price']; ?></div>
      <?php } ?>
         <!-- <input type="number" name="qty" class="qty" min="1" max="99" value="1" maxlength="2"> -->

      </div>

      <?php if ($fetch_products['category'] == 'Package Events') {} else { ?>
        <div class="flex">
        <div class="name">Participant Type: </div>
      <?php
        if ($fetch_products['max_members'] == 0) {
          echo '<div class="cat">Individual Participant</div>';
        } else {
          // echo '<div class="cat">Min Members: '.$fetch_products['min_members'].'</div>';
          echo '<div class="cat">Team of: '.$fetch_products['max_members'].'</div>';
        }
      
      ?>
        </div>
        <?php } ?>

        <div class="flex">
         <div class="name">Dept: <span class="cat"><?php echo $fetch_products['department'] ?></span></div>
            </div>

      <div class="flex">
         
      </div>
      <?php if ($fetch_products['category'] == 'Package Events') {} else { ?>
      <div class="flex">
         <div class="name">Location: <p class="cat"><?= $fetch_products['location']; ?></p></div>
         <div class="name">Timing: <p class="cat"><?= $fetch_products['timing']; ?></p></div>
      </div>
      <?php } ?>

      <?php if ($fetch_products['category'] == 'Package Events') {} else { ?>
      <div class="flex">
        <div class="name">Staff Coordinator: <p class="cat"><?php echo $fetch_products['staff_co_name'] ?></p></div>
      </div>

      <div class="flex">
        <div class="name">Student Coordinator - 1: <p class="cat"><?php echo $fetch_products['student_co_name_1'] ?> - <a href="tel:<?php echo $fetch_products['student_co_number_1'] ?>"><?php echo $fetch_products['student_co_number_1'] ?></a></p></div>
      </div>
      <div class="flex">
        <div class="name">Student Coordinator - 2: <p class="cat"><?php echo $fetch_products['student_co_name_2'] ?> - <a href="tel:<?php echo $fetch_products['student_co_number_2'] ?>"><?php echo $fetch_products['student_co_number_2'] ?></a></p></div>
      </div>
      <?php } ?>

      <div class="">
         <div class="name">Description:</div>
         <div class="flex"><p class="cat"><?= $fetch_products['description']; ?></p></div>
      </div>
      <div class="name">
      <?php
// Your PHP code to fetch data from the database goes here
      $rulesAndRegulations = $fetch_products['rules'];

      // Split the rules and regulations by the period '.'
      $points = explode('. ', $rulesAndRegulations);
      ?>
        <?php if ($fetch_products['category'] == 'Package Events') {} else { ?>
         <div class="name">Rules & Regulations:</div>
         <!-- <div class="flex"><p class="cat"><?= $fetch_products['rules']; ?></p></div> -->
         <ol type="1">
      <?php foreach ($points as $point): ?>
         <li class="cat" style="margin-left: 20px;"><?php echo $point; ?></li>
      <?php endforeach; ?>
   </ol>
      <?php } ?>
      </div>


      <?php
      if (!empty($fetch_products['event_options'])) {
// Your PHP code to fetch data from the database goes here
$group_events_list = $fetch_products['group_events_list'];
// Split the rules and regulations by the period '. '
$lists = explode('. ', $group_events_list);

$individualPID = $fetch_products['joint_event_id'];
$indPID = explode('. ', $individualPID);
?>
      <!-- Add a modal pop-up window -->
<div id="myModal" class="modal">
  <div class="modal-content">
    <div class="name" id="event-opt">Select '<?php echo $fetch_products['event_options'] ?>' events</div>
    <?php 
        // Loop over both lists simultaneously
        foreach ($lists as $index => $list): ?>
        <label><div class="name">
            <input type="checkbox" name="group_events[]" value="<?php echo $list; ?>" class="groupEventsCheckbox">
            <?php echo $list; ?> <a class="btn" href="quick_view.php?pid=<?= $indPID[$index]; ?>">View</a></div>
        </label><br>
        <?php endforeach; ?>
  </div>
</div>
   <?php } else {} ?>
      
      <?php if ($fetch_products['price'] == '') { ?>
        <button type="button" class="cart-btn" onclick="goBack()">Back</button>
        <script>
function goBack() {
  window.history.back();
}
</script>
      <?php } else { ?>
        <!-- <button type="submit" name="add_to_cart" class="cart-btn">add to cart</button> -->
        <button style="color: red;" class="cart-btn">Registration opens soon</button>
      <?php } ?>
   </form>

   <?php $event_options = $fetch_products['event_options']; ?>
   <script>
// JavaScript to limit checkbox selections
var checkboxes = document.querySelectorAll('.groupEventsCheckbox');
var limit = <?php echo json_encode($event_options); ?>; // Maximum number of checkboxes allowed to be selected
var checkboxesSelected = 0;

checkboxes.forEach(function(checkbox) {
  checkbox.addEventListener('change', function() {
    if (this.checked) {
      checkboxesSelected++;
      if (checkboxesSelected > limit) {
        this.checked = false;
        checkboxesSelected--;
      }
    } else {
      checkboxesSelected--;
    }
  });
});

</script>


<!-- <script>
// Get the modal
var modal = document.getElementById("myModal");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// Get all checkboxes
var checkboxes = document.querySelectorAll('input[type="checkbox"]');

// Variable to track the number of checkboxes selected
var checkboxesSelected = 0;

// When the user clicks the button, open the modal 
var addToCartBtn = document.getElementsByClassName("cart-btn")[0];
addToCartBtn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

// Event listener for checkboxes
checkboxes.forEach(function(checkbox) {
  checkbox.addEventListener('change', function() {
    if (this.checked) {
      // Increment count if checkbox is checked
      checkboxesSelected++;
      // Check if maximum allowed checkboxes are selected
      if (checkboxesSelected > 2) {
        // If more than 2 checkboxes are selected, uncheck this checkbox
        this.checked = false;
        checkboxesSelected--;
      }
    } else {
      // Decrement count if checkbox is unchecked
      checkboxesSelected--;
    }
  });
});

// Submit form when checkboxes are selected
document.getElementById("cartForm").onsubmit = function() {
  modal.style.display = "none";
}
</script> -->

   <?php
      }
   } else {
      echo '<p class="empty">no products added yet!</p>';
   }
   ?>

</section>














<?php include 'components/footer.php'; ?>


<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>


</body>
</html>