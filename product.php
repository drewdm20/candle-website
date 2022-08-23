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
    <link rel="stylesheet" href="product.css">
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
          </ul>
          </div>
        <div class="link-icons">
        <a href="index.php?page=cart">
        <a href="route.php?page=cart"<i class="fas fa-shopping-cart"></i></a>
        <span><?=$num_items_in_cart?></span>
        </a>
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
            <input type="number" name="quantity" value="1" min="1" max="<?=$product['quantity']?>" placeholder="Quantity" required>
            <input type="hidden" name="product_id" value="<?=$product['productID']?>">
            <input type="submit" value="Add To Cart">
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
