<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>About Us</title>
  <link rel="stylesheet" href="story.css">
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
  <h1>ABOUT US</h1>
  </section>
  <section class="vision-mission">
    <div class="vm-content">
      <h2>VISION AND MISSION</h2>
      <div class="column">
        <h3>ABOUT US</h3>
        <p>Flickering Flame Candle Co is an online gift shop that produces beautifully scented candles, <br> wax melts, (Fragranced & aromatherapy) essential oil diffusers, car vent scents, linen & room sprays, <br> & also offer event gift favours. <br>
           We offer our clients a quality product & service that ensures capability, reliability & care <br>
           Enhance your mood, & fragrance the air in your car, office, or any room in your home <br> with our cosy home candle & other products
        </p>
      </div>
      <div class="column">
        <h3>VISION</h3>
        <p>At Flickering flame Candle Co. We aim to be at the forefront of the candle gifting market <br> alongside creating ample job opportunities and <br> outreaching to the community </p>
      </div>
      <div class="column">
        <h3>MISSION</h3>
        <p>Our main goal is to provide uniquely crafted and affordable products that every homowner should have</p>
      </div>
    </div>
  </section>
  <section class="core-values">
    <div class="value-content">
      <h2>CORE VALUES</h2>
      <p>At Flickering Flame Candle Co our core values are: </p> <br>
      <div class="row">
        <ul>
          <li>Using environmentally friendly & sustainable products & materials</li>
          <li>Being conscious on the carbon footprint we leave behind.</li>
          <li>Creating charity & giving back</li>
          <li>Creating job opportunities</li>
        </ul>
      </div>
    </div>
  </section>
  <section class="packaging">
    <div class="packaging-content">
      <h2>PACKAGING</h2>
      <div class="row">
        <p>At Flickering Flame Candle Co, we endeavour to ensure that all our products are sustainably packaged which is benificial to both our customers and the planet. <br>
          We will always make sure that we commit 150% of our efforts towards staying true to our values by making all forms of packaging for our products sustainable by using <br>
          only the most affordable and sustainable recycable materials such as glass, rubber, metal and paper. <br>
          97% of our products are packaged using recycable and sustainable materials.
         </p>
         <i class="fas fa-recycle fa-3x"></i>
      </div>
    </div>
  </section>
  <section class="events">
    <div class="events-content">
      <h2>EVENT OFFERINGS</h2>
      <div class="row">
        <p>At Flickering Flame Candle Co, we offer personalized gifting for events such as corporate events, weddings and babyshowers <br>
          if you would like to know more please drop us a email at hello@flickeringflame.com
         </p>
      </div>
    </div>
  </section>
  <section class="footer">
  <div class="footer-contents">
    <a href="route.php"><img src="logo.jpeg" alt="logo" width="200px" height="120px"></a>
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
