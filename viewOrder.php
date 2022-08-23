<?php
if (isset($_SESSION['account_loggedin'])) {
    // Select all the users transations, this will appear under "My Orders"
    $stmt = $pdo->prepare('SELECT
        p.image,
        p.productName,
        o.orderID,
        od.orderDate AS transaction_date,
        od.shipmentDate AS shipment_date,
        od.ETA AS estimated_date,
        od.price AS price,
        od.quantity AS quantity
        FROM orders o
        JOIN order_details od ON od.orderID = o.orderID
        JOIN customers c ON c.customerID = o.customerID
        JOIN products p ON p.productID = od.productID
        WHERE o.customerID = ?
        ORDER BY o.orderDate DESC');
    $stmt->execute([ $_SESSION['account_id'] ]);
    $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

}
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
      <h1>ORDER SUMMARY</h1>
    </section>
    <section class="order-section">
      <?php if (isset($_SESSION['account_loggedin'])): ?>
      <div class="order-content">
        <h1>VIEW ORDER</h1>
        <table>
          <thead>
              <tr>
                  <td colspan="2">Product</td>
                  <td class="date">Date</td>
                  <td class="ship-date">Shipment Date</td>
                  <td class="eta">ETA</td>
                  <td class="price">Price</td>
                  <td>Quantity</td>
                  <td>Total</td>
              </tr>
          </thead>
          <tbody>
            <?php if (empty($transactions)): ?>
            <tr>
                <td colspan="8" style="text-align:center;">You have no recent orders</td>
            </tr>
            <?php else: ?>
            <?php foreach ($transactions as $transaction): ?>
            <tr>
                <td class="img">
                    <img src="<?=$transaction['image']?>" width="50" height="50" alt="<?=$transaction['productName']?>">
                </td>
                <td>
                  <p><?=$transaction['productName']?></p>
                </td>
                <td class="date"><?=$transaction['transaction_date']?></td>
                <td class="ship-date"><?=$transaction['shipment_date']?></td>
                  <td class="eta"><?=$transaction['estimated_date']?></td>
                <td class="price"><p>R <?=$transaction['price']?></p></td>
                <td class="quantity"><?=$transaction['quantity']?></td>
                <td class="price"><p>R <?=$transaction['price'] * $transaction['quantity']?></p></td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
        <div class="buttons">
          <a href="route.php?page=thankyou" class="hero-btn">CONFRIM</a>
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
