<?php
$error="";
  if (isset($_POST['register'], $_POST['email'], $_POST['password'], $_POST['cpassword']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $stmt = $pdo->prepare('SELECT * FROM customers WHERE email = ?');
    $stmt->execute([ $_POST['email'] ]);
    $customer = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($customer){
      $error = "Account already exists!";
    }else{
      $stmt = $pdo->prepare('INSERT INTO customers (fullName,cellNo,email,password,shippingAddress,admin) VALUES ("","",?,?,"",0)');
      $stmt->execute([ $_POST['email'],$_POST['password']]);
      $customerID = $pdo->lastInsertId();
      session_regenerate_id();
      $_SESSION['account_loggedin'] = TRUE;
      $_SESSION['account_id'] = $customerID;
      $_SESSION['account_admin'] = 0;
      $products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
      if ($products_in_cart) {
          // User has products in cart, redirect them to the checkout page
          header('Location: route.php?page=orderForm');
      } else {
          // Redirect the user back to the home page, they can then see their order history
          header('Location: route.php');
      }
      exit;
    }
  }
   ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Register</title>
    <!--custom css file-->
    <link rel="stylesheet" href="register.css">
    <!--Custom script-->
    <script type="text/javascript" src="main.js"></script>
    <!--Custom Google Font-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200&display=swap" rel="stylesheet">
  <!--Font 5 Awesome Icons-->
<script src="https://kit.fontawesome.com/9d05bacffb.js" crossorigin="anonymous"></script>
  </head>
  <body>
    <section class="header">
      <nav>
        <div class="content">
          <a href="route.php"><img src="logo.jpeg" alt="logo" width="200px" height= "100px"></a>
        <div class="nav-links" id="navLinks">
          <ul>
            <li><a href="route.php">Home</a></li>
            <li><a href="route.php?page=shop">Shop</a></li>
            <li> <a href="route.php?page=story">About Us</a> </li>
          </ul>
          </div>
        <div class="link-icons">
        <a href="route.php?page=account"><i class="fas fa-user-circle"></i></a>
        <a href="route.php?page=cart"<i class="fas fa-shopping-cart"></i></a>
        <span><?=$num_items_in_cart?></span>
        <?php if (isset($_SESSION['account_loggedin'])):?>
        <a href="route.php?page=logout"><i class="fas fa-sign-out-alt"></i></a>
        <?php endif; ?>
        </div>
        </div>
      </nav>
      <h1>CHECKOUT</h1>
    </section>
    <section class="register-section">
      <div class="register">
        <h1>REGISTER</h1>
        <p>Please fill in your details on this form</p>
        <form action="" method="post" name="registerForm" onsubmit="return validateRegister()">
            <label for="email">Email:</label>
            <input type="text" name="email" placeholder="user@domain.com" id="email"><br>
            <label for="password">Password:</label>
            <input type="password" name="password" placeholder="Password" id="password"><br>
            <label for="cPassword">Confirm Password:</label>
            <input type="password" name="cpassword" placeholder="Confirm Password" id="cpassword"><br>
            <input type="submit" name="register" value="REGISTER">
        </form>
        <p>Existing User? <a href="route.php?page=loginform">Sign in</a></p>
      </div>
    </section>
  <section class="footer">
  <a href="route.php"><img src="logo.jpeg" alt="logo" width="200px" height="100px"></a>
  <div class="footer-contents">
    <ul>
      <li><a href="route.php?page=FAQ">FAQ</a></li>
      <li>Contact us for more information at:</li>
      <li>hello@flickeringflame.com</li>
    </ul>
    <div class="link-icons">
      <i class="fab fa-facebook fa-3x"></i>
      <i class="fab fa-instagram fa-3x"></i>
    </div>
  </div>
  </section>
  </body>
</html>
