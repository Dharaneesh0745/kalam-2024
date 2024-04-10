<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['add_product'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);

   $department = $_POST['department'];
   $department = filter_var($department, FILTER_SANITIZE_STRING);

   $team_event = $_POST['team_event'];
   $team_event = filter_var($team_event, FILTER_SANITIZE_STRING);

   $min_members = $_POST['min_members'];
   $min_members = filter_var($min_members, FILTER_SANITIZE_STRING);
   $max_members = $_POST['max_members'];
   $max_members = filter_var($max_members, FILTER_SANITIZE_STRING);
   
   $group_events = $_POST['group_events'];
   $group_events = filter_var($group_events, FILTER_SANITIZE_STRING);
   $group_events_list = $_POST['group_events_list'];
   $group_events_list = filter_var($group_events_list, FILTER_SANITIZE_STRING);

   $description = $_POST['description'];
   $description = filter_var($description, FILTER_SANITIZE_STRING);
   $caption = $_POST['caption'];
   $caption = filter_var($caption, FILTER_SANITIZE_STRING);
   $timing = $_POST['timing'];
   $timing = filter_var($timing, FILTER_SANITIZE_STRING);
   $location = $_POST['location'];
   $location = filter_var($location, FILTER_SANITIZE_STRING);
   $category = $_POST['category'];
   $category = filter_var($category, FILTER_SANITIZE_STRING);
   $rules = $_POST['rules'];
   $rules = filter_var($rules, FILTER_SANITIZE_STRING);  

   $staff_co_name = $_POST['staff_co_name'];
   $staff_co_name = filter_var($staff_co_name, FILTER_SANITIZE_STRING); 

   $student_co_name_1 = $_POST['student_co_name_1'];
   $student_co_name_1 = filter_var($student_co_name_1, FILTER_SANITIZE_STRING);
   $student_co_number_1 = $_POST['student_co_number_1'];
   $student_co_number_1 = filter_var($student_co_number_1, FILTER_SANITIZE_STRING); 

   $student_co_name_2 = $_POST['student_co_name_2'];
   $student_co_name_2 = filter_var($student_co_name_2, FILTER_SANITIZE_STRING); 
   $student_co_number_2 = $_POST['student_co_number_2'];
   $student_co_number_2 = filter_var($student_co_number_2, FILTER_SANITIZE_STRING); 

   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../uploaded_img/'.$image;

   $select_products = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
   $select_products->execute([$name]);

   if($select_products->rowCount() > 0){
      $message[] = 'product name already exists!';
   }else{
      if($image_size > 2000000){
         $message[] = 'image size is too large';
      }else{
         move_uploaded_file($image_tmp_name, $image_folder);

         $insert_product = $conn->prepare("INSERT INTO `products`(name, department, group_events, group_events_list, team_event, min_members, max_members, category, caption, description, rules, timing, location, staff_co_name, student_co_name_1, student_co_number_1, student_co_name_2, student_co_number_2, price, image) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
         $insert_product->execute([$name, $department, $group_events, $group_events_list, $team_event, $min_members, $max_members, $category, $caption, $description, $rules, $timing, $location, $staff_co_name, $student_co_name_1, $student_co_number_1, $student_co_name_2, $student_co_number_2, $price, $image]);

         $message[] = 'New event added!';
      }

   }

}

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_product_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
   $delete_product_image->execute([$delete_id]);
   $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
   unlink('../uploaded_img/'.$fetch_delete_image['image']);
   $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
   $delete_product->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
   $delete_cart->execute([$delete_id]);
   header('location:products.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Events</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

   <style>
  .hidden {
    display: none;
  }
  .hiddenn {
    display: none;
  }
</style>

</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- add products section starts  -->

<section class="add-products">

   <form action="" method="POST" enctype="multipart/form-data">
      <h3>Add Events</h3>
      <input type="text" required placeholder="Enter event name" name="name" maxlength="100" class="box">
      <input type="number" min="0" max="9999999999" required placeholder="Enter event price" name="price" onkeypress="if(this.value.length == 10) return false;" class="box">
      <input type="text" required placeholder="Enter Department name" name="department" maxlength="500" class="box">

      <div class="box">
      <span>Team Event: </span><input type="checkbox" name="team_event" id="team_event_checkbox" value="yes" >
      </div>

      <div id="range_input" class="hidden">
         <div class="box">
  <label for="min_value">Min Participants:</label>
  <input type="number" id="min_value" name="min_members" class="box" required>
  </div>
  <div class="box">
  <label for="max_value">Max Participants:</label>
  <input type="number" id="max_value" name="max_members" class="box" required>
</div>
</div>

<script>
  const teamEventCheckbox = document.getElementById('team_event_checkbox');
  const rangeInput = document.getElementById('range_input');

  teamEventCheckbox.addEventListener('change', function() {
    if (this.checked) {
      rangeInput.classList.remove('hidden');
    } else {
      rangeInput.classList.add('hidden');
    }
  });
</script>

      <div class="box">
      <span>Package events: </span><input type="checkbox" name="group_events" id="group_events_checkbox" value="yes" >
      </div>

      <div id="group_events_input" class="hiddenn">
      <div class="box">
      <label for="group_events_inp">Type events, which are comes under single package</label>
      <textarea type="text" id="group_events_inp" name="group_events_list" class="box" required></textarea>
      </div>
      </div>

      <script>
      const groupEventCheckbox = document.getElementById('group_events_checkbox');
      const groupInput = document.getElementById('group_events_input');

      groupEventCheckbox.addEventListener('change', function() {
         if (this.checked) {
            groupInput.classList.remove('hiddenn');
         } else {
            groupInput.classList.add('hiddenn');
         }
      });
      </script>


      <textarea type="text" required placeholder="Enter event caption" name="caption" maxlength="1000" class="box"></textarea>
      <textarea type="text" required placeholder="Enter event description" name="description" maxlength="5000" class="box"></textarea>
      <textarea type="text" required placeholder="Enter event rules" name="rules" maxlength="5000" class="box"></textarea>
      <input type="text" required placeholder="Enter event timing" name="timing" maxlength="100" class="box">
      <input type="text" required placeholder="Enter event location" name="location" maxlength="100" class="box">

      <input type="text" required placeholder="Enter event staff coordinator" name="staff_co_name" maxlength="1000" class="box">
      <!-- <input type="number" required placeholder="Enter event staff coordinator number" name="staff_co_number" maxlength="100" class="box"> -->
      <input type="text" required placeholder="Enter event student coordinator - 1" name="student_co_name_1" maxlength="1000" class="box">
      <input type="number" placeholder="Enter event student coordinator number - 1" name="student_co_number_1" maxlength="100" class="box">

      <input type="text" required placeholder="Enter event student coordinator - 2" name="student_co_name_2" maxlength="1000" class="box">
      <input type="number" placeholder="Enter event student coordinator number - 2" name="student_co_number_2" maxlength="100" class="box">
      <select name="category" class="box" required>
         <option value="" disabled selected>select category --</option>
         <option value="Technical Event">Technical Event</option>
         <option value="Non - Technical Event">Non - Technical Event</option>
         <option value="Cultural Events">Cultural Event</option>
      </select>
      <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp" required>
      <input type="submit" value="add product" name="add_product" class="btn">
   </form>

</section>

<!-- add products section ends -->

<!-- show products section starts  -->

<section class="show-products" style="padding-top: 0;">

   <div class="box-container">

   <?php
      $show_products = $conn->prepare("SELECT * FROM `products`");
      $show_products->execute();
      if($show_products->rowCount() > 0){
         while($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)){  
   ?>
   <div class="box">
      <img src="../uploaded_img/<?= $fetch_products['image']; ?>" alt="">
      <div class="flex">
         <div class="price"><span>₹‎</span><?= $fetch_products['price']; ?><span>/-</span></div>
         <div class="category"><?= $fetch_products['category']; ?></div>
      </div>
      <div class="name"><?= $fetch_products['name']; ?></div>
      <div class="flex-btn">
         <a href="update_product.php?update=<?= $fetch_products['id']; ?>" class="option-btn">update</a>
         <a href="products.php?delete=<?= $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>
      </div>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
   ?>

   </div>

</section>

<!-- show products section ends -->










<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>