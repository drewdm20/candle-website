<?php
$error ='';
if (isset($_POST['login'], $_POST['email'], $_POST['password']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    // Check if the account exists
    $stmt = $pdo->prepare('SELECT * FROM customers WHERE email = ?');
    $stmt->execute([ $_POST['email'] ]);
    $account = $stmt->fetch(PDO::FETCH_ASSOC);
    // If account exists verify password
    if ($account && ($_POST['password']==$account['password'])) {
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
            // Redirect the user back to the same page, they can then see their order history
            header('Location: route.php?page=viewOrder');
        }
        exit;
    } else {
        $error = 'Incorrect Email/Password!';
    }
}
// Variable that will output registration errors
$register_error = '';
// User clicked the "Register" button, proceed with the registration process... check POST data and validate email
if (isset($_POST['register'], $_POST['email'], $_POST['password'], $_POST['cpassword']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    // Check if the account exists
    $stmt = $pdo->prepare('SELECT * FROM customers WHERE email = ?');
    $stmt->execute([ $_POST['email'] ]);
    $account = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($account) {
        // Account exists!
        $register_error = 'Account already exists with this email!';
    } else if ($_POST['cpassword'] != $_POST['password']) {
        $register_error = 'Passwords do not match!';
    } else if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
        // Password must be between 5 and 20 characters long.
        $register_error = 'Password must be between 5 and 20 characters long!';
    } else {
        // Account doesnt exist, create new account
        $stmt = $pdo->prepare('INSERT INTO customers (fullName,cellNo,email,password,shippingAddress) VALUES ("","",?,?,"")');
        // Hash the password
        $password = ($_POST['password']);
        $stmt->execute([ $_POST['email'], $password ]);
        $customerID = $pdo->lastInsertId();
        // Automatically login the user
        session_regenerate_id();
        $_SESSION['account_loggedin'] = TRUE;
        $_SESSION['account_id'] = $customerID;
        $_SESSION['account_admin'] = 0;
        $products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
        if ($products_in_cart) {
            // User has products in cart, redirect them to the checkout page
            header('Location: route.php?page=orderForm');
        } else {
            // Redirect the user back to the same page, they can then see their order history
            header('Location: route.php?page=viewOrder');
        }
        exit;
    }
}
if (isset($_SESSION['account_loggedin'])) {
  header('Location: route.php?page=viewOrder');
  exit;
}
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Account</title>
  <!--Custom stylesheet-->
  <link rel="stylesheet" href="account.css">
  <!--Custom script-->
  <script type="text/javascript" src="main.js"></script>
  <!--Custom Google Font-->
  <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200&display=swap" rel="stylesheet">
<!--Font 5 Awesome Icons-->
  <script src="https://kit.fontawesome.com/9d05bacffb.js" crossorigin="anonymous"></script>
</head>
<body>
  <!--Header section-->
  <section class="header">
    <nav>
      <div class="content">
        <a href="route.php"><img src="logo.jpeg" alt="logo" width="200px" height= "100px"></a>
      <div class="nav-links" id="navLinks">
        <a href="#" class="toggle" onclick="closeMenu()"><i class="fas fa-times fa-1x" onclick='closeMenu()'></i></a>
        <ul>
          <li><a href="route.php">Home</a></li>
          <li><a href="route.php?page=shop">Shop</a></li>
          <li> <a href="route.php?page=story">About Us</a> </li>
        </ul>
        </div>
      <div class="link-icons">
      <a href="route.php?page=account"><i class="fas fa-user-circle"></i></a>
      <a href="route.php?page=cart"><i class="fas fa-shopping-cart"></i>
      </a>
      <span><?=$num_items_in_cart?></span>
      <?php if (isset($_SESSION['account_loggedin'])):?>
      <a href="route.php?page=logout"><i class="fas fa-sign-out-alt"></i></a>
      <?php endif; ?>
      <a href="#" class="toggle" onclick="openMenu()"><i class="fas fa-bars"></i></a>
      </div>
      </div>
    </nav>
        <h1>MY ACCOUNT</h1>
  </section>
  <section class="account">
      <?php if (!isset($_SESSION['account_loggedin'])): ?>
    <div class="login-register">
      <div class="login">

          <h1>Login</h1>

          <form action="" method="post" name="form1" onsubmit="return validateLogin()">
              <label for="email">Email</label>
              <input type="email" name="email" id="email" placeholder="john@example.com"><br>
              <label for="password">Password</label>
              <input type="password" name="password" id="password" placeholder="Password" ><br><br>
              <input name="login" type="submit" value="Login">
          </form>

          <?php if ($error): ?>
          <p class="error"><?=$error?></p>
          <?php endif; ?>

      </div>

      <div class="register">

          <h1>Register</h1>

          <form action="" method="post" name="registerForm" onsubmit="return validateRegister()">
              <label for="email">Email</label>
              <input type="email" name="email" id="email" placeholder="john@example.com" ><br>
              <label for="password">Password</label>
              <input type="password" name="password" id="password" placeholder="Password" ><br>
              <label for="cpassword">Confirm Password</label>
              <input type="password" name="cpassword" id="cpassword" placeholder="Confirm Password"><br><br>
              <input name="register" type="submit" value="Register">
          </form>

          <?php if ($register_error): ?>
          <p class="error"><?=$register_error?></p>
          <?php endif; ?>

      </div>
    </div>
      <?php endif; ?>
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
