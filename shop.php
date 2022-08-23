
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shop</title>
    <!--Custom stylesheet-->
    <link rel="stylesheet" href="shop.css">
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
      <h1>SHOP</h1>
    </section>
    <section class="candles">
      <img src="ex1.jpg" alt="scented candle" width="350px" height="280px">
      <div class="candle-container">
        <h1>NATURAL <br> SUSTAINABLE <br> SCENTED <br> CANDLES</h1>
        <p>Brighten up the mood by shopping our latest range of environmentally-friendly <br> and sustainable scented candles</p>
        <a href="route.php?page=candles" class="hero-btn">SHOP NOW</a>
      </div>
    </section>
    <section class="wax-products">
      <img src="ex2.jpg" alt="wax" width="300px" height="300px">
      <div class="wax-container">
        <h1>NATURAL <br> SUSTAINABLE <br> CARBON NEUTRAL <br> WAX MELTS</h1>
        <p>Inject a purified and elegant smell into your home <br> with our range of eco-friendly scented wax melts and diffusers</p>
        <a href="route.php?page=waxMelts" class="hero-btn">SHOP NOW</a>
      </div>
    </section>
    <section class="car-fragrances">
      <img src="ex4.jpg" alt="fragrance" width="300px" height="300px">
      <div class="fragrance-container">
        <h1>NATURAL <br> SUSTAINABLE <br> SCENTED <br> CAR <br> FRAGRANCES</h1>
        <p>Breath new life into your car by <br> shopping our range of scented car fragrances</p>
        <a href="route.php?page=fragrances" class="hero-btn">SHOP NOW</a>
      </div>
    </section>
    <section class="diffusers">
      <img src="ex3.jpeg" alt="diffuser" width="300px" height="300px">
      <div class="diffuser-container">
        <h1>ESSENTIAL <br> OIL <br> DIFFUSERS</h1>
        <p>Give your health a beauty treament <br> by shopping our range of essential oil diffusers</p>
        <a href="route.php?page=diffusers" class="hero-btn">SHOP NOW</a>
      </div>
    </section>
    <section class="sprays">
        <img src="ex5.jpg" alt="spray" width="300px" height="300px">
      <div class="spray-container">
        <h1>NATURAL <br> SUSTAINABLE <br> SCENTED <br> SPRAYS</h1>
        <p>Give your rooms a elegant and fresh smell <br>by shopping our range of linen and room mist sprays</p>
        <a href="route.php?page=sprays" class="hero-btn">SHOP NOW</a>
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
