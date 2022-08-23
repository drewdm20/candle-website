<?php
// The amounts of products to show on each page
$num_products_on_each_page = 5;
//The product category
$category = "Spray";
// The current page, in the URL this will appear as index.php?page=products&p=1, index.php?page=products&p=2, etc...
$current_page = isset($_GET['p']) && is_numeric($_GET['p']) ? (int)$_GET['p'] : 1;
// Select products ordered by the date added
$stmt = $pdo->prepare('SELECT * FROM products WHERE productCategory=? ORDER BY dateAdded DESC LIMIT ?,?');
// bindValue will allow us to use integer in the SQL statement, we need to use for LIMIT
$stmt->bindValue(1,$category, PDO::PARAM_STR);
$stmt->bindValue(2, ($current_page - 1) * $num_products_on_each_page, PDO::PARAM_INT);
$stmt->bindValue(3, $num_products_on_each_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the products from the database and return the result as an Array
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total_products = $pdo->query("SELECT * FROM products WHERE productCategory='Spray'")->rowCount();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shop Spray</title>
    <!--Custom stylesheet-->
    <link rel="stylesheet" href="sprays.css">
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
      <h1>SHOP SCENTED LINEN AND ROOM MIST SPRAYS</h1>
    </section>
    <section class="featured">
      <div class="featured-content">
        <h2>FRAGRANCED LINEN AND ROOM MIST SPRAYS</h2>
          <p>Give your rooms a elegant and fresh smell <br>by shopping our range of linen and room mist sprays</p>
      </div>
    </section>
    <section class="products">
      <div class="product-contents">
        <h1>PRODUCTS</h1>
        <p><?=$total_products?> Products</p>
        <div class="product-info">
            <?php foreach ($products as $product): ?>
            <a href="route.php?page=sprayProduct&id=<?=$product['productID']?>&category=<?=$product['productCategory']?>&name=<?=$product['productName']?>" class="product">
                <img src="<?=$product['image']?>" width="200" height="200" alt="<?=$product['productName']?>">
                <span class="name"><?=$product['productName']?></span>
                <span class="price">
                    <p>R.<?=$product['price']?></p>
                </span>
            </a>
            <?php endforeach; ?>
        </div>
        <div class="buttons">
            <?php if ($current_page > 1): ?>
            <a href="route.php?page=sprays&p=<?=$current_page-1?>">Prev</a>
            <?php endif; ?>
            <?php if ($total_products > ($current_page * $num_products_on_each_page) - $num_products_on_each_page + count($products)): ?>
            <a href="route.php?page=sprays&p=<?=$current_page+1?>">Next</a>
            <?php endif; ?>
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
