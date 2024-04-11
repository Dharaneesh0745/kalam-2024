<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['update'])){

   $pid = $_POST['pid'];
   $pid = filter_var($pid, FILTER_SANITIZE_STRING);
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $caption = $_POST['caption'];
   $caption = filter_var($caption, FILTER_SANITIZE_STRING);
   $description = $_POST['description'];
   $description = filter_var($description, FILTER_SANITIZE_STRING);
   $rules = $_POST['rules'];
   $rules = filter_var($rules, FILTER_SANITIZE_STRING);
   $timing = $_POST['timing'];
   $timing = filter_var($timing, FILTER_SANITIZE_STRING);
   $location = $_POST['location'];
   $location = filter_var($location, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);
   $category = $_POST['category'];
   $category = filter_var($category, FILTER_SANITIZE_STRING);

   if(isset($_POST['team_event'])){
      $team_event = $_POST['team_event'];
      $team_event = filter_var($team_event, FILTER_SANITIZE_STRING);
   } else {
      // If not set, assign an empty string to $group_events or handle it according to your logic
      $team_event = ''; // You can change this to whatever default value you need
   }
   
   // $group_events = $_POST['group_events'];
   // $group_events = filter_var($group_events, FILTER_SANITIZE_STRING);
   if(isset($_POST['group_events'])){
      // If set, assign the value to the variable $group_events
      $group_events = $_POST['group_events'];
      $group_events = filter_var($group_events, FILTER_SANITIZE_STRING);
   } else {
      // If not set, assign an empty string to $group_events or handle it according to your logic
      $group_events = ''; // You can change this to whatever default value you need
   }
   $group_events_list = $_POST['group_events_list'];
   $group_events_list = filter_var($group_events_list, FILTER_SANITIZE_STRING);

   $department = $_POST['department'];
   $department = filter_var($department, FILTER_SANITIZE_STRING);

   $event_options = $_POST['event_options'];
   $event_options = filter_var($event_options, FILTER_SANITIZE_STRING);

   $joint_event_id = $_POST['joint_event_id'];
   $joint_event_id = filter_var($joint_event_id, FILTER_SANITIZE_STRING); 

   $single_joint_event_id = $_POST['single_joint_event_id'];
   $single_joint_event_id = filter_var($single_joint_event_id, FILTER_SANITIZE_STRING);

   $min_members = $_POST['min_members'];
   $min_members = filter_var($min_members, FILTER_SANITIZE_STRING);
   $max_members = $_POST['max_members'];
   $max_members = filter_var($max_members, FILTER_SANITIZE_STRING);

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

   $update_product = $conn->prepare("UPDATE `products` SET name = ?, single_joint_event_id = ?, joint_event_id = ?, event_options = ?, group_events_list = ?, group_events = ?, team_event = ?, department = ?, min_members = ?, max_members = ?, category = ?, price = ?, caption = ?, description = ?, rules = ?, timing = ?, location = ?, staff_co_name = ?, student_co_name_1 = ?, student_co_number_1 = ?, student_co_name_2 = ?, student_co_number_2 = ? WHERE id = ?");
   $update_product->execute([$name, $single_joint_event_id, $joint_event_id, $event_options, $group_events_list, $group_events, $team_event, $department, $min_members, $max_members, $category, $price, $caption, $description, $rules, $timing, $location, $staff_co_name, $student_co_name_1, $student_co_number_1, $student_co_name_2, $student_co_number_2, $pid]);

   $message[] = 'Event updated!';

   $old_image = $_POST['old_image'];
   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../uploaded_img/'.$image;

   if(!empty($image)){
      if($image_size > 2000000){
         $message[] = 'images size is too large!';
      }else{
         $update_image = $conn->prepare("UPDATE `products` SET image = ? WHERE id = ?");
         $update_image->execute([$image, $pid]);
         move_uploaded_file($image_tmp_name, $image_folder);
         unlink('../uploaded_img/'.$old_image);
         $message[] = 'image updated!';
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Update Event</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- update product section starts  -->

<section class="update-product">

   <h1 class="heading">Update Event</h1>

   <?php
      $update_id = $_GET['update'];
      $show_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
      $show_products->execute([$update_id]);
      if($show_products->rowCount() > 0){
         while($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)){  
   ?>
   <form action="" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
      <input type="hidden" name="old_image" value="<?= $fetch_products['image']; ?>">
      <img src="../uploaded_img/<?= $fetch_products['image']; ?>" alt="">
      <span>Update Name</span>
      <input type="text" placeholder="enter product name" name="name" maxlength="100" class="box" value="<?= $fetch_products['name']; ?>">
      <span>Update Price</span>
      <input type="number" min="0" max="9999999999" placeholder="enter product price" name="price" onkeypress="if(this.value.length == 10) return false;" class="box" value="<?= $fetch_products['price']; ?>">
      <span>Update Category</span>
      <select name="category" class="box">
         <option selected value="<?= $fetch_products['category']; ?>"><?= $fetch_products['category']; ?></option>
         <option value="Technical Event">Technical Event</option>
         <option value="Non - Technical Event">Non - Technical Event</option>
         <option value="Cultural Events">Cultural Event</option>
      </select>

      <span>Update Department</span>
      <select name="department" class="box">
         <option selected value="<?= $fetch_products['department']; ?>"><?= $fetch_products['department']; ?></option>
         <option value="Artificial Intelligence & Machine Learning">AIML</option>
         <option value="Electronics & Communication">ECE</option>
         <option value="Computer Science & Engineering">CSE</option>
         <option value="Cyber Security">Cyber Security</option>
         <option value="Bio-Medical">Bio-Medical</option>
         <option value="Information Technology">IT</option>
         <option value="Electrical & Electronics">EEE</option>
         <option value="Mechanical">MECH</option>
         <option value="Artificial Intelligence & Data Science">AIDS</option>
         <option value="Agriculture Engineering">AGRI</option>
         <option value="Bio-Technology">BT</option>
         <option value="Civil">CIVIL</option>
         <option value="Food Technology">FT</option>
      </select>

      <div id="range_input" class="hidden">
         <div class="box">
  <label for="min_value">Min Participants:</label>
  <input type="number" value="<?= $fetch_products['min_members'] ?>" id="min_value" name="min_members" class="box">
  </div>
  <div class="box">
  <label for="max_value">Max Participants:</label>
  <input type="number" id="max_value" value="<?= $fetch_products['max_members'] ?>" name="max_members" class="box">
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

      <span>Update Package events: </span>
      

      <div id="group_events_input" class="hiddenn">
      <div class="box">
      <label for="group_events_inp">Type events, which are comes under single package</label>
      <textarea type="text" id="group_events_inp" name="group_events_list" class="box" ><?php $fetch_products['group_events_list'] ?></textarea>
      <span>Update event options</span>
      <input type="number" value="<?php $fetch_products['event_options'] ?>" placeholder="event options (any 2 or 3 like that)" class="box" name="event_options" >
      <span>Update Joint event ID</span>
      <input type="text" value="<?php $fetch_products['joint_event_id'] ?>" placeholder="Joint Event ID" name="joint_event_id" maxlength="100" class="box">
      </div>
      </div>
      
      <span>Update Single event ID</span>
      <input type="text" placeholder="Enter single joint event ID" name="single_joint_event_id" maxlength="100" class="box">

      <span>Update Staff Coordinator Name</span>
      <input type="text" placeholder="enter product staff coordinator" name="staff_co_name" maxlength="100" class="box" value="<?= $fetch_products['staff_co_name']; ?>">
      <!-- <span>Update Staff Coordinator Number</span>
      <input type="number" placeholder="enter product staff coordinator number" name="staff_co_number" maxlength="100" class="box" value="<?= $fetch_products['staff_co_number']; ?>"> -->
      <span>Update Student Coordinator Name - 1</span>
      <input type="text" placeholder="enter product student coordinator - 1" name="student_co_name_1" maxlength="1000" class="box" value="<?= $fetch_products['student_co_name_1']; ?>">
      <span>Update Student Coordinator Number - 1</span>
      <input type="number" placeholder="enter product student coordinator number - 1" name="student_co_number_1" maxlength="100" class="box" value="<?= $fetch_products['student_co_number_1']; ?>">

      <span>Update Student Coordinator Name - 2</span>
      <input type="text" placeholder="enter product student coordinator - 2" name="student_co_name_2" maxlength="1000" class="box" value="<?= $fetch_products['student_co_name_2']; ?>">
      <span>Update Student Coordinator Number - 2</span>
      <input type="number" placeholder="enter product student coordinator number - 2" name="student_co_number_2" maxlength="100" class="box" value="<?= $fetch_products['student_co_number_2']; ?>">

      <span>Update Location</span>
      <input type="text" placeholder="enter location " name="location" maxlength="100" class="box" value="<?= $fetch_products['location']; ?>">
      <span>Update Timing</span>
      <input type="text" placeholder="enter timing" name="timing" maxlength="100" class="box" value="<?= $fetch_products['timing']; ?>">
      <span>Update Caption</span>
      <textarea type="text" placeholder="enter caption" name="caption" maxlength="1000" class="box"><?= $fetch_products['caption']; ?></textarea>
      <span>Update Description</span>
      <textarea type="text" placeholder="enter description" name="description" maxlength="5000" class="box"><?= $fetch_products['description']; ?></textarea>
      <span>Update Rules</span>
      <textarea type="text" placeholder="enter rules" name="rules" maxlength="5000" class="box"><?= $fetch_products['rules']; ?></textarea>
      <span>Update Image</span>
      <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp">
      <div class="flex-btn">
         <input type="submit" value="update" class="btn" name="update">
         <a href="products.php" class="option-btn">go back</a>
      </div>
   </form>
   <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
   ?>

</section>

<!-- update product section ends -->










<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>