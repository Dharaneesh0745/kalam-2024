<?php

// require_once 'stripe-php/vendor/autoload.php';

// include 'components/connect.php';

// session_start();

// if(isset($_SESSION['user_id'])){
//    $user_id = $_SESSION['user_id'];
// }else{
//    $user_id = '';
//    header('location:home.php');
// };



// // Stripe API key
// \Stripe\Stripe::setApiKey('sk_test_51OwksmSGSLfv4tGChBb5vySffkh2LBGo9cjyYL10mIQr7mxPZRvuE3fFRZyVwq2uhTr4lBKM8RW3FDViEBfhckDX00qz2GZQuR');

// if(isset($_POST['submit'])){

//    $name = $_POST['name'];
//    $name = filter_var($name, FILTER_SANITIZE_STRING);
//    $number = $_POST['number'];
//    $number = filter_var($number, FILTER_SANITIZE_STRING);
//    $email = $_POST['email'];
//    $email = filter_var($email, FILTER_SANITIZE_STRING);
//    $method = $_POST['method'];
//    $method = filter_var($method, FILTER_SANITIZE_STRING);
//    $address = $_POST['address'];
//    $address = filter_var($address, FILTER_SANITIZE_STRING);
//    $total_products = $_POST['total_products'];
//    $total_price = $_POST['total_price'];

//    $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
//    $check_cart->execute([$user_id]);

//    $grand_total = 0;
//    if($check_cart->rowCount() > 0){

//       if($address == ''){
//          $message[] = 'please add your address!';
//       }else{
         
//          $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?)");
//          $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);

//          $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
//          $delete_cart->execute([$user_id]);

//          $message[] = 'order placed successfully!';
//       }
      
//    }else{
//       $message[] = 'your cart is empty';
//    }

//    var_dump($grand_total);
//    var_dump($fetch_cart['name']);


//    // Create a stripe checkout session
//    $checkout_session = \Stripe\Checkout\Session::create([
//       'payment_method_types' => ['card'],
//       'line_items' => [
//          [
//             'price_data' => [
//                'currency' => 'inr', // Change currency to INR
//                'product_data' => [
//                   'name' => 'Your Product Name',
//                ],
//                'unit_amount' => $grand_total * 100, // Convert to cents
//             ],
//             'quantity' => 1,
//          ],
//       ],
//       'customer_email' => $email, // Pass the user's email
//    'metadata' => [
//       'grand_total' => $grand_total, // Pass the grand total as metadata
//       'product_name' => $fetch_cart['name'], // Pass the product name as metadata
//    ],
//       'mode' => 'payment',
//       'success_url' => 'https://example.com/success', // Redirect URL after successful payment
//       'cancel_url' => 'https://example.com/cancel', // Redirect URL if payment is canceled
//       // 'payment_method_options' => [
//       //    'card' => [
//       //       'request_three_d_secure' => 'automatic',
//       //    ],
//       // ],
//    ]);


//    // Retrieve the payment intent ID from the checkout session
//    // $payment_intent_id = $checkout_session->payment_intent;

//    // // Retrieve the transaction ID from the payment intent
//    // $payment_intent = \Stripe\PaymentIntent::retrieve($payment_intent_id);
//    // $transaction_id = $payment_intent->charges->data[0]->id;

//    // // Update the database with the transaction ID and payment status
//    // $update_order = $conn->prepare("UPDATE `orders` SET transaction_id = ?, payment_status = 'paid' WHERE user_id = ?");
//    // $update_order->execute([$transaction_id, $user_id]);

//    // Assuming $checkout_session is already created and contains the payment intent ID
// if ($checkout_session && $checkout_session->payment_intent) {
//    $payment_intent_id = $checkout_session->payment_intent;

//    try {
//        // Retrieve the payment intent from Stripe
//        $payment_intent = \Stripe\PaymentIntent::retrieve($payment_intent_id);

//        // Extract the transaction ID from the payment intent
//        $transaction_id = $payment_intent->charges->data[0]->id;

//        // Update the database with the transaction ID and payment status
//        $update_order = $conn->prepare("UPDATE `orders` SET transaction_id = ?, payment_status = 'paid' WHERE user_id = ?");
//        $update_order->execute([$transaction_id, $user_id]);

//        // Redirect user to Stripe Checkout
//        header('Location: ' . $checkout_session->url);
//        exit; // Ensure script stops execution after redirect
//    } catch (Exception $e) {
//        // Handle any exceptions
//        echo 'Error: ' . $e->getMessage();
//    }
// } else {
//    echo 'Error: Invalid or missing payment intent ID';
// }


//    // Redirect user to Stripe Checkout
//    header('Location: ' . $checkout_session->url);
//    exit; // Ensure script stops execution after redirect

// }





// require 'stripe-php/vendor/autoload.php';

include 'components/connect.php';

// Include PHPMailer autoloader
// require 'PHPMailer/src/PHPMailer.php';
// require '/PHPMailer/src'

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:home.php');
};

// Stripe API key
// \Stripe\Stripe::setApiKey('sk_test_51OwksmSGSLfv4tGChBb5vySffkh2LBGo9cjyYL10mIQr7mxPZRvuE3fFRZyVwq2uhTr4lBKM8RW3FDViEBfhckDX00qz2GZQuR');

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $method = $_POST['method'];
   $method = filter_var($method, FILTER_SANITIZE_STRING);
   $address = $_POST['address'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $total_products = $_POST['total_products'];
   $total_price = $_POST['total_price'];

   // $random_number = mt_rand(10000, 99999);
   // $order_id = 'KALAM' . $random_number;

   // Function to generate a random string of specified length
   function generateRandomString($length = 5) {
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $charactersLength = strlen($characters);
      $randomString = '';
      for ($i = 0; $i < $length; $i++) {
          $randomString .= $characters[rand(0, $charactersLength - 1)];
      }
      return $randomString;
  }

  // Generate a random string of length 5
  $random_string = generateRandomString(5);

  // Construct the unique order ID by combining the prefix and the random string
  $order_id = 'KALAM' . $random_string;

  // Sending email to user
//   $mail = new PHPMailer;

  // Enable verbose debug output
  // $mail->SMTPDebug = 4;                                 

//   $mail->isSMTP();                                      
//   $mail->Host = 'localhost/ems';  
//   $mail->SMTPAuth = true;                               
//   $mail->Username = 'dharaneesh0745@gmail.com';                 
//   $mail->Password = 'Dhoni_007';                           
//   $mail->SMTPSecure = 'tls';                            
//   $mail->Port = 587;                                   

//   $mail->setFrom('dharaneesh0745@gmail.com', 'Kalam');
//   $mail->addAddress($email, $name);                    

//   $mail->isHTML(true);                                 

//   $mail->Subject = 'Your Order Confirmation';
//   $mail->Body    = 'Dear ' . $name . ',<br>Your order has been successfully placed with order ID: ' . $order_id . '. Thank you for shopping with us!<br>';
//   $mail->AltBody = 'Your order has been successfully placed with order ID: ' . $order_id . '. Thank you for shopping with us!';

//   if(!$mail->send()) {
//       echo 'Message could not be sent.';
//       echo 'Mailer Error: ' . $mail->ErrorInfo;
//   } else {
//       echo 'Message has been sent';
//   }

   $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $check_cart->execute([$user_id]);

   $grand_total = 0;
   $product_names = []; // Array to store product names
   if($check_cart->rowCount() > 0){
      while($fetch_cart = $check_cart->fetch(PDO::FETCH_ASSOC)){
         $product_names[] = $fetch_cart['name']; // Add product names to array
         $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
      }
   }

   if($address == ''){
      $message[] = 'Please add your Info!';
   }else{
      // Create a new order in the database
      $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, order_id) VALUES(?,?,?,?,?,?,?,?,?)");
      $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price, $order_id]);

      // Clear the user's cart after placing the order
      $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
      $delete_cart->execute([$user_id]);

      $message[] = 'Event registered successfully!';
   }
   
   // // Create a stripe checkout session
   // $checkout_session = \Stripe\Checkout\Session::create([
   //    'payment_method_types' => ['card'],
   //    'line_items' => [
   //       [
   //          'price_data' => [
   //             'currency' => 'inr', // Change currency to INR
   //             'product_data' => [
   //                'name' => implode(', ', $product_names), // Combine product names into a single string
   //             ],
   //             'unit_amount' => $grand_total * 100, // Convert to cents
   //          ],
   //          'quantity' => 1,
   //       ],
   //    ],
   //    'customer_email' => $email, // Pass the user's email
   //    'metadata' => [
   //       'grand_total' => $grand_total, // Pass the grand total as metadata
   //    ],
   //    'mode' => 'payment',
   //    'success_url' => 'https://example.com/success', // Redirect URL after successful payment
   //    'cancel_url' => 'https://example.com/cancel', // Redirect URL if payment is canceled
   // ]);

   ///////
//    $checkout_session = \Stripe\Checkout\Session::create([
//       'payment_method_types' => ['card'],
//       'line_items' => [
//          [
//             'price_data' => [
//                'currency' => 'inr', // Change currency to INR
//                // 'product_data' => [
//                //    'name' => implode(', ', $product_names), // Combine product names into a single string
//                // ],
//                'product_data' => [
//                   'name' => count($product_names) > 0 ? implode(', ', $product_names) : 'Products', // Combine product names into a single string if available, otherwise set a default value
//               ],
//                'unit_amount' => $grand_total * 100, // Convert to cents
//             ],
//             'quantity' => 1,
//          ],
//       ],
//       'customer_email' => $email, // Pass the user's email
//       'metadata' => [
//          'grand_total' => $grand_total, // Pass the grand total as metadata
//       ],
//       'mode' => 'payment',
//       'success_url' => 'https://example.com/success', // Redirect URL after successful payment
//       'cancel_url' => 'https://example.com/cancel', // Redirect URL if payment is canceled
//    ]);

//    // Redirect user to Stripe Checkout
//    header('Location: ' . $checkout_session->url);
//    exit; // Ensure script stops execution after redirect
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Checkout</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

   <!-- Include Stripe.js and initialize with your publishable key -->
   <!-- <script src="https://js.stripe.com/v3/"></script>
   <script>
       var stripe = Stripe('pk_test_51OwksmSGSLfv4tGCFjyGa09CxEnWtfc3YVtOkQj9gSAYw9cXnFRveibhM0mAD6ZxZ1FdpqQrDVGm3C5ln8NZWNEI00YJHDjxSv');
   </script> -->

</head>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<div class="heading">
   <h3>Checkout</h3>
   <p><a href="home.php">Home</a> <span> / Checkout</span></p>
</div>

<section class="checkout">

   <h1 class="title">Order summary</h1>

<form action="" method="post">

   <div class="cart-items">
      <h3>Cart Items</h3>
      <?php
         $grand_total = 0;
         $cart_items[] = '';
         $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $select_cart->execute([$user_id]);
         if($select_cart->rowCount() > 0){
            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
               $cart_items[] = $fetch_cart['name'].' ('.$fetch_cart['price'].' x '. $fetch_cart['quantity'].') - ';
               $total_products = implode($cart_items);
               $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
      ?>
      <p><span class="name"><?= $fetch_cart['name']; ?></span><span class="price">₹‎<?= $fetch_cart['price']; ?> x <?= $fetch_cart['quantity']; ?></span></p>
      <?php
            }
         }else{
            echo '<p class="empty">your cart is empty!</p>';
         }
      ?>
      <p class="grand-total"><span class="name">Grand Total :</span><span class="price">₹‎<?= $grand_total; ?></span></p>
      <a href="cart.php" class="btn">Veiw Cart</a>
   </div>

   <input type="hidden" name="total_products" value="<?= $total_products; ?>">
   <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
   <input type="hidden" name="name" value="<?= $fetch_profile['name'] ?>">
   <input type="hidden" name="number" value="<?= $fetch_profile['number'] ?>">
   <input type="hidden" name="email" value="<?= $fetch_profile['email'] ?>">
   <input type="hidden" name="address" value="<?= $fetch_profile['address'] ?>">

   <div class="user-info">
      <h3>Your Info</h3>
      <p><i class="fas fa-user"></i><span><?= $fetch_profile['name'] ?></span></p>
      <p><i class="fas fa-phone"></i><span><?= $fetch_profile['number'] ?></span></p>
      <p><i class="fas fa-envelope"></i><span><?= $fetch_profile['email'] ?></span></p>
      <a href="update_profile.php" class="btn">Update your Info</a>
      <h3>College Details</h3>
      <p><i class="fas fa-map-marker-alt"></i><span><?php if($fetch_profile['address'] == ''){echo 'please enter your address';}else{echo $fetch_profile['address'];} ?></span></p>
      <a href="update_address.php" class="btn">Update your College Details</a>
      <select name="method" class="box" required>
         <option value="" disabled selected>select payment method --</option>
         <option value="upi">UPI - Phonepe or GPay</option>
      </select>
      <input type="submit" value="place order" class="btn <?php if($fetch_profile['address'] == ''){echo 'disabled';} ?>" style="width:100%; background:var(--red); color:var(--white);" name="submit">
   </div>

</form>
   
</section>









<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->






<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>