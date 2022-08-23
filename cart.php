<?php

// If the user clicked the add to cart button on the product page we can check for the form data
// If the user clicked the add to cart button on the product page we can check for the form data
if (isset($_POST['product_id'], $_POST['quantity']) && is_numeric($_POST['product_id']) && is_numeric($_POST['quantity'])) {
    // Set the post variables so we easily identify them, also make sure they are integer
    $product_id = (int)$_POST['product_id'];
    // abs() function will prevent minus quantity and (int) will make sure the value is an integer
    $quantity = abs((int)$_POST['quantity']);
    // Get product options
    $options = '';
    $product_name = "";
    $product_img = "";
    $product_price = '0.00';
    foreach ($_POST as $k => $v) {
        if (strpos($k, 'option-') !== false) {
            $options .= str_replace('option-', '', $k) . '-' . $v . ',';
            $stmt = $pdo->prepare('SELECT * FROM product_options WHERE option_type = ? AND option_name = ? AND product_id = ?');
            $stmt->execute([ str_replace('option-', '', $k), $v, $product_id ]);
            $option = $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }
    $options = rtrim($options, ',');
    // Prepare the SQL statement, we basically are checking if the product exists in our database
    $stmt = $pdo->prepare('SELECT * FROM products WHERE productID = ?');
    $stmt->execute([ $_POST['product_id'] ]);
    // Fetch the product from the database and return the result as an Array
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    foreach ($product as $item) {
      // code...
      $product_img = $item['image'];
      $product_name = $item['productName'];
      $product_price = $item['price'];
    }
    // Check if the product exists (array is not empty)
    if ($product && $quantity > 0) {
        // Product exists in database, now we can create/update the session variable for the cart
        if (!isset($_SESSION['cart'])) {
            // Shopping cart session variable doesnt exist, create it
            $_SESSION['cart'] = [];
        }
        $cart_product = &get_cart_product($product_id, $options);
        if ($cart_product) {
            // Product exists in cart, update the quanity
            $cart_product['quantity'] += $quantity;
        } else {
            // Product is not in cart, add it
            $_SESSION['cart'][] = [
                'id' => $product_id,
                'quantity' => $quantity,
                'options' => $options,
                'image' => $product_img,
                'name' => $product_name,
                'price' => $product_price
            ];
        }
    }
    // Prevent form resubmission...
    header('location: route.php?page=cart');
    exit;
}
// Remove product from cart, check for the URL param "remove", this is the product id, make sure it's a number and check if it's in the cart
if (isset($_GET['remove']) && is_numeric($_GET['remove']) && isset($_SESSION['cart']) && isset($_SESSION['cart'][$_GET['remove']])) {
    // Remove the product from the shopping cart
    unset($_SESSION['cart'][$_GET['remove']]);
    header('location: route.php?page=cart');
    exit;
}
// Update product quantities in cart if the user clicks the "Update" button on the shopping cart page
if (isset($_POST['update']) && isset($_SESSION['cart'])) {
    // Loop through the post data so we can update the quantities for every product in cart
    foreach ($_POST as $k => $v) {
        if (strpos($k, 'quantity') !== false && is_numeric($v)) {
            $id = str_replace('quantity-', '', $k);
            // abs() function will prevent minus quantity and (int) will make sure the number is an integer
            $quantity = abs((int)$v);
            // Always do checks and validation
            if (is_numeric($id) && isset($_SESSION['cart'][$id]) && $quantity > 0) {
                // Update new quantity
                $_SESSION['cart'][$id]['quantity'] = $quantity;
            }
        }
    }
    // Prevent form resubmission...
    header('location: route.php?page=cart');
    exit;
}
// Send the user to the place order page if they click the Place Order button, also the cart should not be empty
if (isset($_POST['checkout']) && isset($_SESSION['cart']) && !empty($_SESSION['cart'])&&!isset($_SESSION['account_loggedin'])) {
    header('Location: route.php?page=loginform');
    exit;
}
if (isset($_POST['checkout']) && isset($_SESSION['cart']) && !empty($_SESSION['cart']) &&isset($_SESSION['account_loggedin'])) {
    header('Location: route.php?page=orderForm');
    exit;
}
if (isset($_POST['empty'])&&isset($_SESSION['cart'])){
  unset($_SESSION['cart']);
  header('location: route.php?page=cart');
  exit;
}
// Check the session variable for products in cart
$products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$subtotal = 0.00;
$vat = 0.15;
$totalVat = 0.00;
$total = 0.00;
$shipping = 0.00;
// If there are products in cart
if ($products_in_cart) {
    // There are products in the cart so we need to select those products from the database
    // Products in cart array to question mark string array, we need the SQL statement to include IN (?,?,?,...etc)
    $array_to_question_marks = implode(',', array_fill(0, count($products_in_cart), '?'));
    $stmt = $pdo->prepare('SELECT * FROM products WHERE productID IN (' . $array_to_question_marks . ')');
    // We only need the array keys, not the values, the keys are the id's of the products
    $stmt->execute(array_column($products_in_cart,'id'));
    // Fetch the products from the database and return the result as an Array
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Calculate the subtotal
    foreach ($products_in_cart as &$cart_product) {
      // code...
      foreach ($products as $product) {
        if ($cart_product['id'] == $product['productID']) {
          $cart_product['productName']=$product['productName'];
          $cart_product['image'] = $product['image'];
          $cart_product['productDescription'] = $product['productDescription'];
          $cart_product['productCategory'] = $product['productCategory'];
          $cart_product['price'] = $product['price'];
          $cart_product['maxQuantity'] = $product['quantity'];
          $product_price = (float)$product['price'];
          $subtotal += $product_price * (int)$cart_product['quantity'];
        }
        }
      if ($subtotal>300) {
        // code...
        $shipping = 0;
      }else{
        $shipping=60;
      }

    }
    $totalVat += $subtotal * ($vat);
    $total += $subtotal+$shipping+$totalVat;
}
if (isset($_POST['back']) &&isset($_SESSION['cart'])) {
  // code...
  header('location: route.php?page=shop');
  exit;
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cart</title>
    <!--Custom stylesheet-->
    <link rel="stylesheet" href="cart.css">
    <!--Custom script-->
    <script type="text/javascript" src="main.js"></script>
    <!--Custom Google Font-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200&display=swap" rel="stylesheet">
    <!--Font 5 Awesome Icons-->
    <script src="https://kit.fontawesome.com/9d05bacffb.js" crossorigin="anonymous"></script>
  </head>
  <body>
    <section class="info-bar">
      <div class="info-content">
        <p>Free Shipping for All Orders Over R300!</p>
      </div>
    </section>
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
      <h1>CART</h1>
    </section>
    <section class="cart">
      <div class="cart-container">
        <h1>SHOPPING CART</h1>
        <form action="route.php?page=cart" method="post">
        <table>
          <thead>
            <tr>
              <td colspan="2">Product</td>
              <td></td>
              <td>Price</td>
              <td>Quantity</td>
              <td>Total</td>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($products_in_cart)): ?>
            <tr>
                <td colspan="6" style="text-align:center;">You have no products added in your Shopping Cart</td>
            </tr>
            <?php else: ?>
            <?php foreach ($products_in_cart as $num => $product): ?>
            <tr>
                <td class="img">
                  <img src="<?=$product['image']?>" width="80" height="80" alt="<?=$product['productName']?>">
                </td>
                <td>
                  <h2><?=$product['productName']?></h2>
                    <br>
                    <a href="route.php?page=cart&remove=<?=$num?>" class="remove">Remove</a>
                </td>
                <td class = "options">
                  <?=$product['options']?>
                  <input type="hidden" name="options" value="<?=$product['options']?>">
                </td>
                <td class="price">
                  <p>R <?=$product['price']?></p>
                </td>
                <td class="quantity">
                    <input type="number" name="quantity-<?=$num?>" value="<?=$product['quantity']?>" min="1" <?php if ($product['maxQuantity'] != -1): ?>max="<?=$product['maxQuantity']?>"<?php endif; ?> placeholder="Quantity" required>
                </td>
                <td class="price"><p>R <?=($product['price'] * $product['quantity'])?></p></td>
            </tr>
            <?php endforeach; ?>
          <?php endif; ?>
          </tbody>
        </table>
        <div class="priceBox">
            <span class="text">Subtotal: R <?=$subtotal?></span>
            <span class="text">Shipping: R <?=$shipping?></span>
            <span class="text">Vat: R <?=$totalVat?></span>
            <span class="text">Total: R <?=$total?></span>
        </div>
        <div class="buttons">
            <input type="submit" value="Update" name="update">
              <input type="submit" name="empty" value="Empty Cart">
            <input type="submit" name="back" value="Back to shop">
            <input type="submit" value="Checkout" name="checkout">
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
