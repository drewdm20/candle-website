<?php
unset($_SESSION['cart']);
 ?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <title>View Order</title>
     <!--Custom stylesheet-->
     <link rel="stylesheet" href="viewOrder.css">
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
       <h1>THANK YOU</h1>
     </section>
     <section class="message">
       <div class="message-contents">
         <h1>Your order has been placed and processed</h1>
         <p>Thank you for ordering with us, we'll be contacting you shortly.</p>
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
