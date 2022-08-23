<?php
$id=0;
$productName="";
// Check to make sure the id parameter is specified in the URL
if (isset($_GET['id'])&&isset($_GET['category'])) {
    $id=$_GET['id'];
    $productCategory=$_GET['category'];
    // Prepare statement and execute, prevents SQL injection
    $stmt = $pdo->prepare('SELECT * FROM products WHERE productID = ? and productCategory=?');
    $stmt->execute([$id,$productCategory]);
    // Fetch the product from the database and return the result as an Array
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt = $pdo->prepare('SELECT option_type, GROUP_CONCAT(option_name) AS options FROM product_options WHERE product_id = ? GROUP BY option_type');
    $stmt->execute([ $product['productID'] ]);
      // Fetch the product options from the database and return the result as an Array
      $product_options = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Check if the product exists (array is not empty)
    if (!$product) {
        // Simple error to display if the id for the product doesn't exists (array is empty)
        exit('Product does not exist!');
    }
} else {
    // Simple error to display if the id wasn't specified
    exit('Product does not exist!');
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product</title>
    <!--Custom stylesheet-->
    <link rel="stylesheet" href="fragranceProduct.css">
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
      <h1>SHOP PRODUCT</h1>
    </section>
    <section class="product">
      <img src="<?=$product['image']?>" width="300" height="300" alt="<?=$product['productName']?>">
      <div class="product-container">
        <h1 class="name"><?=$product['productName']?></h1>
        <span class="price">
            <p>R <?=$product['price']?></p>
        </span>
        <form action="route.php?page=cart" method="post">
          <?php foreach ($product_options as $option): ?>
          <select class="fragrance" name="option-<?=$option['option_type']?>">
            <option value="" selected disabled style="display:none"><?=$option['option_type']?></option>
            <?php
            $options_names = explode(',', $option['options']);
            ?>
            <?php foreach ($options_names as $k => $name): ?>
            <option value="<?=$name?>"><?=$name?></option>
            <?php endforeach; ?>
          </select><br>
          <?php endforeach; ?>
            <input type="number" name="quantity" value="1" min="1" <?php if ($product['quantity'] != -1): ?>max="<?=$product['quantity']?>"<?php endif; ?> placeholder="Quantity" required>
            <input type="hidden" name="product_id" value="<?=$product['productID']?>">
            <?php if ($product['quantity'] == 0): ?>
            <input type="submit" value="Out of Stock" disabled>
            <?php else: ?>
            <input type="submit" value="Add To Cart">
            <?php endif; ?>
        </form>
        <div class="description">
            <?=$product['productDescription']?>
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
