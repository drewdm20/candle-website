<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Form</title>
    <!--Custom stylesheet-->
    <link rel="stylesheet" href="orderForm.css">
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
          <a href="#" class="toggle" onclick="closeMenu()"><i class="fas fa-times fa-1x" onclick='closeMenu()'></i></a>
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
        <a href="#" class="toggle" onclick="openMenu()"><i class="fas fa-bars"></i></a>
        </div>
        </div>
      </nav>
      <h1>CHECKOUT</h1>
    </section>
    <section class="checkout">
      <div class="checkout-container">
        <form action="route.php?page=checkout" method="post" name = "formOrder" onsubmit="return validateOrderForm()">
          <h1>CUSTOMER ORDER FORM</h1>
          <p>Please complete the form. Mandatory fields are marked with a *</p>
          <div class="customer-info">
            <fieldset>
              <legend>CUSTOMER INFORMATION</legend>
              <label class="required" for="fullName">Full Name:</label>
              <input type="text" name="fullName" value=""><br>
              <label class="required" for="cell">Cellphone Number:</label>
              <input type="text" name="cell" value=""><br>
              <label class="required" for="email">Email:</label>
              <input type="text" name="email" value="user@domain.com"><br><br>
            </fieldset>
          </div>
          <br> <br>
          <div class="shipping-info">
            <fieldset>
              <legend>SHIPPING INFORMATION</legend>
              <label class="required" for="street">Street Address:</label>
              <input type="text" name="street" value=""><br><br>
              <input type="text" name="street" value=""><br>
              <label class="required" for="city">City/Town:</label>
              <input type="text" name="city" value=""><br><br>
              <label class="required" for="province">Province</label>
              <select class="province" name="province">
                <option value="Gauteng">Gauteng</option>
                <option value="Western Cape">Western Cape</option>
                <option value="Kwazulu-Natal">KwaZulu Natal</option>
                <option value="Eastern Cape">Eastern Cape</option>
                <option value="Free State">Free State</option>
                <option value="North West">North West</option>
                <option value="Mpumalanga">Mpumalanga</option>
                <option value="Limpopo">Limpopo</option>
                <option value="Northern Cape">Northern Cape</option>
              </select><br><br>
              <label class="required" for="zip-code">Zip Code:</label>
              <input type="text" name="zip-code" value=""><br><br>
            </fieldset>
          </div><br><br>
          <div class="payment-info">
            <fieldset>
              <legend>PAYMENT INFORMATION</legend>
              <label class="required" for="method">Payment Method:</label>
              <select class="payment-method" name="method">
                <option value="Credit Card">Credit/Debit Card</option>
                <option value="PayPal">PayPal</option>
              </select><br><br>
              <label class="required" for="cardHolder">Card Holder Name:</label>
              <input type="text" name="cardHolder" value=""><br><br>
              <label class="required" for="cardNumber">Card Number:</label>
              <input type="text" name="cardNumber" value=""><br><br>
              <label class="required" for="expiryDate">Expiry Date:</label>
              <input type="text" name="expiryDate" value=""><br><br>
              <label class="required" for="cvv">CVV</label>
              <input type="text" name="cvv" value=""><br><br>
            </fieldset>
          </div>
          <div class="buttons">
            <input type="submit" name="confirm" value="Confirm Order">
            <input type="submit" name="back" value="Back to Cart">
          </div>
        </form>
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
