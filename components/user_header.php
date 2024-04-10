<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css"></link>
    <title>Logout Modal</title>
    <!-- <style>
        /* CSS styles for the logout modal */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        /* Modal Content/Box */
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
        }

        /* Center the modal content */
        .modal-content.center {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
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

        /* Buttons */
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            margin: 5px;
        }

        button:hover {
            opacity: 0.8;
        }

        @media only screen and (max-width: 600px) {
            .modal-content {
                width: 90%; /* Adjust width for smaller screens */
            }
        }
    </style> -->
    <style>
        /* CSS styles for the logout modal */
        .modall {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1000; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        .p {
            text-align: center;
            font-size: 20px;
            color: #222;
        }

        .spacee {
            margin-top: 20px;
        }

        /* Modal Content/Box */
        .modal-contentt {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
            max-width: 400px; /* Set maximum width */
            box-sizing: border-box; /* Include padding and border in element's total width and height */
            position: relative; /* Position relative to the viewport */
            z-index: 1001; /* Ensure modal content appears above modal background */
        }

        /* Buttons */
        .button {
            margin-top: 10px;
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            margin: 5px;
            margin-right: 10px;
            border-radius: 40px;
            font-size: 20px;
        }

        .button-containerr {
            display: flex;
            justify-content: center;
            margin-top: 20px; /* Adjust spacing between buttons and text */
        }

        .button:hover {
            opacity: 0.8;
        }

        /* Responsive styles */
        @media only screen and (max-width: 600px) {
            .modal-contentt {
                width: 90%; /* Adjust width for smaller screens */
            }
        }
    </style>
</head>
<body>

    <header class="header">

        <section class="flex">
            <!-- <a href="home.php" class="logo">Kalam-2k24</a> -->
            
            <img src="https://i.ibb.co/D1rvjbj/Kalam.png" style="max-width: 200px; height: 30px; margin-top: -50px; margin-bottom: -50px; margin-left: -20px;">
            
        <!-- <img style="max-width: 100%; height: auto" src="kalam-2024.png" alt="Logo"> -->
        
    </a>


      <nav class="navbar">
         <a href="home.php">Home</a>
         <?php if(isset($_SESSION['user_id'])): ?>
         <a href="about.php">About</a>
         <a href="menu.php">Events</a>
         <a href="orders.php">Registered</a>
         <a href="contact.php">Contact</a>
         <?php endif; ?>
      </nav>

      <div class="icons">
         <?php
            $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $count_cart_items->execute([$user_id]);
            $total_cart_items = $count_cart_items->rowCount();
         ?>
         <a href="search.php"><i class="fas fa-search"></i></a>
         <?php if(isset($_SESSION['user_id'])): ?>
         <a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(<?= $total_cart_items; ?>)</span></a>
         <?php endif; ?>
         <div id="user-btn" class="fas fa-user"></div>
         <div id="menu-btn" class="fas fa-bars"></div>
      </div>

      <div class="profile">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if($select_profile->rowCount() > 0){
               $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <p class="name"><?= $fetch_profile['name']; ?></p>
         <!-- <div class="flex">
            <a href="profile.php" class="btn">profile</a>
            <a href="components/user_logout.php" onclick="return confirm('logout from this website?');" class="delete-btn">logout</a>
         </div> -->
         <div class="flex">
            <a href="profile.php" class="btn">profile</a>
            <a href="#" onclick="showLogoutModal();" class="delete-btn">logout</a>
         </div>

         <!-- Logout Modal -->
         <!-- <div id="logout-modal" class="modal">
            <div class="modal-content">
               <span class="close">&times;</span>
               <p>Are you sure you want to logout from this website?</p>
               <button id="confirm-logout">Yes</button>
               <button id="cancel-logout">No</button>
            </div>
         </div> -->
         <!-- <p class="account">
            <a href="login.php">login</a> or
         </p>  -->
         <?php
            }else{
               ?>
            <p class="name">please login first!</p>
            <a href="register.php" class='btn'>register</a>
            <a href="login.php" class="btn">login</a>
         <?php
          }
         ?>
      </div>

            </section>

            </header>


            <!-- Logout Modal -->
            <div id="logout-modal" class="modall">
                <div class="modal-contentt center">
                    <!-- <span class="close" onclick="hideLogoutModal();">&times;</span> -->
                    <p class="p">Are you sure you want to logout?</p>
                    <div class="button-containerr">
                    <button class="button" id="confirm-logout">Yes</button>
                    <button class="button" id="cancel-logout" onclick="hideLogoutModal();">&nbsp;No&nbsp;</button>
                    </div>
                </div>
            </div>

            <script>
                // Function to show the modal
                function showLogoutModal() {
                    var modal = document.getElementById('logout-modal');
                    modal.style.display = 'block';
                }

                // Function to hide the modal
                function hideLogoutModal() {
                    var modal = document.getElementById('logout-modal');
                    modal.style.display = 'none';
                }

                document.addEventListener("DOMContentLoaded", function () {
                    // Event listener for logout button
                    document.querySelector('#confirm-logout').addEventListener('click', function () {
                        // Add your logout logic here
                        window.location.href = 'components/user_logout.php';
                        // Redirect or perform logout actions
                    });
                });
            </script>
            <!-- <script>
                // Get the logout button and the modal
                var logoutBtn = document.getElementById("logout-btn");
                var modal = document.getElementById("logout-modal");

                // When the user clicks the logout button, display the modal
                logoutBtn.onclick = function() {
                    modal.style.display = "block";
                }

                // When the user clicks on <span> (x) or cancel, close the modal
                document.getElementsByClassName("close")[0].onclick = function() {
                    modal.style.display = "none";
                }

                document.getElementById("cancel-logout").onclick = function() {
                    modal.style.display = "none";
                }

                // When the user clicks on confirm logout, redirect to logout page
                document.getElementById("confirm-logout").onclick = function() {
                    window.location.href = "components/user_logout.php";
                }
            </script> -->


</body>
</html>