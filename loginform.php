<?php
$loginError = "";
// User clicked the "Login" button, proceed with the login process... check POST data and validate email
if (isset($_POST['login'], $_POST['email'], $_POST['password']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    // Check if the account exists
    $stmt = $pdo->prepare('SELECT * FROM customers WHERE email = ?');
    $stmt->execute([ $_POST['email'] ]);
    $account = $stmt->fetch(PDO::FETCH_ASSOC);
    // If account exists verify password
    if ($account && ($_POST['password']== $account['password'])) {
        // User has logged in, create session data
        session_regenerate_id();
        $_SESSION['account_loggedin'] = TRUE;
        $_SESSION['account_id'] = $account['customerID'];
        $_SESSION['account_admin'] = $account['admin'];
        $products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        if ($products_in_cart) {
            // user has products in cart, redirect them to the checkout page
            header('Location: route.php?page=orderForm');
        } else {
            // Redirect the user back to the home page, they can then see their order history
            header('Location: route.php');
        }
        exit;
    } else {
        $loginError = 'Incorrect Email/Password!';
    }
    if (!$account){
      $loginError = 'No valid user exists!';
    }
}
 ?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login</title>
  <!--custom css file-->
  <link rel="stylesheet" href="login.css">
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
  <section class="login-section">
    <?php if (!isset($_SESSION['account_loggedin'])): ?>
    <div class="login">
      <h1>LOGIN</h1>
      <p>Please fill in your login details on this form</p>
      <form action="" method="post" name="form1" onsubmit="return validateLogin()">
        <label class="required" for="email">Email:</label>
        <input type="text" name="email" placeholder="user@domain.com" id="email">
        <br><label class="required" for="password">Password:</label>
        <input type="password" name="password" placeholder="Password" id="password"> <br><br>
        <label for="admin">Admin:</label>
        <input type="checkbox" name="admin" value="Admin">
        <input type="submit" value="Login" name="login">
      </form>
      <?php if ($loginError): ?>
      <p class="error"><?=$loginError?></p>
      <?php endif; ?>
      <p>New User? <a href="route.php?page=register">Register</a></p>
      <?php endif; ?>
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
