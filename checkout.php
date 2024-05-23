<?php
include 'components/connect.php';
session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
   header('location:home.php');
}

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

   $group_events_options = $_POST['group_events_options'];
   // Convert the array to a string
   $group_events_options_str = is_array($group_events_options) ? implode(', ', $group_events_options) : '';

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
  $random_string = generateRandomString(7);
  // Construct the unique order ID by combining the prefix and the random string
  $order_id = 'BOOK-ID-' . $random_string;

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
    $message[] = 'Please add your college details!';
 }else{
    // Create a new order in the database
    $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, group_events_options_str, number, email, method, address, total_products, total_price, order_id) VALUES(?,?,?,?,?,?,?,?,?,?)");
    $insert_order->execute([$user_id, $name, $group_events_options_str, $number, $email, $method, $address, $total_products, $total_price, $order_id]);

    if($insert_order->errorCode() !== '00000') {
      $errorInfo = $insert_order->errorInfo();
      echo "Error inserting data into database: " . $errorInfo[2];
  }
   //  Clear the user's cart after placing the order
    $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
    $delete_cart->execute([$user_id]);

    $message[] = 'Event registered successfully!';
 }


   // PhonePe API integration code

   $merchantId = ''; // sandbox or test merchantId
   $apiKey = ""; // sandbox or test APIKEY
   $redirectUrl = 'home.php';

   $order_id = uniqid();
   $paymentData = array(
      'merchantId' => $merchantId,
      'merchantTransactionId' => $order_id,
      'merchantUserId' => $user_id,
      'amount' => $total_price * 100, // amount in INR
      'redirectUrl' => $redirectUrl,
      'redirectMode' => "POST",
      'callbackUrl' => $redirectUrl,
      'merchantOrderId' => $order_id,
      'mobileNumber' => $number,
      'message' => $total_products,
      'email' => $email,
      'shortName' => $name,
      'paymentInstrument' => array(
         'type' => 'PAY_PAGE',
      )
   );

   $jsonencode = json_encode($paymentData);
   $payloadMain = base64_encode($jsonencode);
   $salt_index = 1; // key index 1
   $payload = $payloadMain . "/pg/v1/pay" . $apiKey;
   $sha256 = hash("sha256", $payload);
   $final_x_header = $sha256 . '###' . $salt_index;
   $request = json_encode(array('request' => $payloadMain));

   $curl = curl_init();
   curl_setopt_array($curl, [
      CURLOPT_URL => "https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => $request,
      CURLOPT_HTTPHEADER => [
         "Content-Type: application/json",
         "X-VERIFY: " . $final_x_header,
         "accept: application/json"
      ],
   ]);

   $response = curl_exec($curl);
   $err = curl_error($curl);

   curl_close($curl);

   if ($err) {
      echo "cURL Error #:" . $err;
   } else {
      $res = json_decode($response);

      if (isset($res->success) && $res->success == '1') {
         $paymentCode = $res->code;
         $paymentMsg = $res->message;
         $payUrl = $res->data->instrumentResponse->redirectInfo->url;

         header('Location:' . $payUrl);
         exit;
        } else {
            // Payment failed, update payment status to "pending"
            $update_order = $conn->prepare("UPDATE `orders` SET payment_status = 'pending' WHERE user_id = ?");
            $update_order->execute([$user_id]);
         }
   }
}

// Check if the payment was successful and user is redirected back to your site
if (isset($_GET['payment_status']) && $_GET['payment_status'] == 'success') {
    // Update payment status in the database
    $update_order = $conn->prepare("UPDATE `orders` SET payment_status = 'completed' WHERE user_id = ?");
    $update_order->execute([$user_id]);
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

   <h1 class="title">Order Summary</h1>

<form action="" method="post">

   <div class="cart-items">
      <h3>Cart Items</h3>
      <?php
         $grand_total = 0;
         $cart_items[] = '';
         $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $select_cart->execute([$user_id]);
         if ($select_cart->rowCount() > 0) {
            while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
               $cart_items[] = $fetch_cart['name'].' ('.$fetch_cart['price'].' x '. $fetch_cart['quantity'].') - ';
               $total_products = implode($cart_items);
               $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
      ?>
      <p>
    <span class="name"><?= $fetch_cart['name']; ?></span>
    <span class="price">₹‎<?= $fetch_cart['price']; ?> x <?= $fetch_cart['quantity']; ?></span>
    <!-- Display group_events_options -->
    <?php if ($fetch_cart['group_events_options'] == '') {} else { ?>
      
    <ol style="color: #D6D2D1; padding-left: 15px">
    <?php
    $group_events_options = $fetch_cart['group_events_options'];

    // Split the options by the period '.'
    $options = explode(', ', $group_events_options);
    foreach ($options as $option):
    ?>
    
    <li><?php echo $option; ?></li>
    
    <?php endforeach; ?>
</ol>
</span>
<?php } ?>
</p>

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

   <!-- Modify the input to store the array -->
   <input type="hidden" name="group_events_options[]" value="<?= $fetch_cart['group_events_options'] ?>">

   <div class="user-info">
      <h3>Your Info</h3>
      <p><i class="fas fa-user"></i><span><?= $fetch_profile['name'] ?></span></p>
      <p><i class="fas fa-phone"></i><span><?= $fetch_profile['number'] ?></span></p>
      <p><i class="fas fa-envelope"></i><span><?= $fetch_profile['email'] ?></span></p>
      <a href="update_profile.php" class="btn">Update your Info</a>
      <h3>Your college details</h3>
      <p><i class="fas fa-map-marker-alt"></i><span><?php if($fetch_profile['address'] == ''){echo 'please enter your address';}else{echo $fetch_profile['address'];} ?></span></p>
      <a href="update_address.php" class="btn">Update your college details</a>
      <select name="method" class="box" required>
         <option value="" disabled selected>select payment method --</option>
         <option value="upi">UPI - (Phonepe / GPay)</option>
         <!-- <option value="credit card">credit card</option>
         <option value="paytm">paytm</option>
         <option value="paypal">paypal</option> -->
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
