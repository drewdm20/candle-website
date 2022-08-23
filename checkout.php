<?php
if (isset($_SESSION['account_loggedin'])) {
    $stmt = $pdo->prepare('SELECT * FROM customers WHERE customerID = ?');
    $stmt->execute([ $_SESSION['account_id'] ]);
    // Fetch the account from the database and return the result as an Array
    $customer = $stmt->fetch(PDO::FETCH_ASSOC);
}
if(isset($_SESSION['cart'])){
  if (isset($_POST['fullName'],$_POST['cell'],$_POST['email'],$_POST['street'],$_POST['city'],$_POST['province'],$_POST['zip-code'],$_POST['method'],$_POST['cardHolder'],$_POST['cardNumber'],$_POST['expiryDate'],$_POST['cvv'])){
    $fullName = $_POST['fullName'];
    $cell = $_POST['cell'];
    $email = $_POST['email'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $province = $_POST['province'];
    $zipCode = $_POST['zip-code'];
    $shippingAddress = $street." ".$city." ".$province." ".$zipCode;
    $paymentMethod = $_POST['method'];
    $cardHolder = $_POST['cardHolder'];
    $cardNo = (int)$_POST['cardNumber'];
    $expiryDate = $_POST['expiryDate'];
    $cvv = (int)$_POST['cvv'];
    $date = date('Y-m-d');
    $status = "ordered";
    $shipmentDate = date('Y-m-d',strtotime(' +1 day'));
    $eta = date('Y-m-d',strtotime(' +3 day'));
    $customerID = null;
    if(isset($_SESSION['account_loggedin'])){
      $stmt = $pdo->prepare('UPDATE customers SET fullName=?,cellNo=?,email=?,shippingAddress=? WHERE customerID=?');
      $stmt->bindValue(1,$fullName,PDO::PARAM_STR);
      $stmt->bindValue(2,$cell,PDO::PARAM_STR);
      $stmt->bindValue(3,$email,PDO::PARAM_STR);
      $stmt->bindValue(4,$shippingAddress,PDO::PARAM_STR);
      $stmt->bindValue(5,$_SESSION['account_id'],PDO::PARAM_INT);
      $stmt->execute();
      $customerID= $_SESSION['account_id'];
    }
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
        foreach($products_in_cart as &$cart_product){
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
        // Calculate the subtotal
        $totalVat += $subtotal * ($vat);
        $total += $subtotal+$shipping+$totalVat;
    }
    if (isset($_POST['confirm'])&&!empty($products_in_cart)){
      $stmt2 = $pdo->prepare('INSERT INTO payment_details(customerID, paymentType, cardHolderName, cardNo, expiryDate, cvv) VALUES(?,?,?,?,?,?)');
      $stmt2->bindValue(1,$customerID,PDO::PARAM_INT);
      $stmt2->bindValue(2,$paymentMethod,PDO::PARAM_STR);
      $stmt2->bindValue(3,$cardHolder,PDO::PARAM_STR);
      $stmt2->bindValue(4,$cardNo,PDO::PARAM_INT);
      $stmt2->bindValue(5,$expiryDate,PDO::PARAM_STR);
      $stmt2->bindValue(6,$cvv,PDO::PARAM_INT);
      $stmt2->execute();
      $paymentID = $pdo->lastInsertId();
      $stmt3 = $pdo->prepare('INSERT INTO orders(customerID, paymentID, totalAmount,shippingAddress,orderEmail,orderDate,status) VALUES(?,?,?,?,?,?,?)');
      $stmt3->bindValue(1,$customerID,PDO::PARAM_INT);
      $stmt3->bindValue(2,$paymentID,PDO::PARAM_INT);
      $stmt3->bindValue(3,$total,PDO::PARAM_STR);
      $stmt3->bindValue(4,$shippingAddress,PDO::PARAM_STR);
      $stmt3->bindValue(5,$email,PDO::PARAM_STR);
      $stmt3->bindValue(6,$date,PDO::PARAM_STR);
      $stmt3->bindValue(7,$status,PDO::PARAM_STR);
      $stmt3->execute();
      $orderID = $pdo->lastInsertId();
      foreach ($products_in_cart as $product){
        $stmt4 = $pdo->prepare('INSERT INTO order_details(orderID, productID, name,product_options, price, quantity, orderDate,shipmentDate,ETA) VALUES(?,?,?,?,?,?,?,?,?)');
        $stmt4->bindValue(1,$orderID,PDO::PARAM_INT);
        $stmt4->bindValue(2,$product['id'],PDO::PARAM_INT);
        $stmt4->bindValue(3,$product['productName'],PDO::PARAM_STR);
        $stmt4->bindValue(4,$product['options'],PDO::PARAM_STR);
        $stmt4->bindValue(5,$product['price'],PDO::PARAM_STR);
        $stmt4->bindValue(6,$product['quantity'],PDO::PARAM_INT);
        $stmt4->bindValue(7,$date,PDO::PARAM_STR);
        $stmt4->bindValue(8,$shipmentDate,PDO::PARAM_STR);
        $stmt4->bindValue(9,$eta,PDO::PARAM_STR);
        $stmt4->execute();
        $stmt = $pdo->prepare('UPDATE products SET quantity = quantity - ? WHERE quantity > 0 AND id = ?');
        $stmt->execute([ $product['quantity'], $product['id'] ]);
      }
      if ($customerID != null) {
          // Log the user in with the details provided
          session_regenerate_id();
          $_SESSION['account_loggedin'] = TRUE;
          $_SESSION['account_id'] = $customerID;
          $_SESSION['account_admin'] = $customer ? $customer['admin'] : 0;
      }
      header('Location: route.php?page=viewOrder');
      exit;
    }
  }
}



if(isset($_POST['back'])&&isset($_SESSION['cart'])) {
  // code...
  header('location: route.php?page=cart');
  exit;
}
if (empty($_SESSION['cart'])) {
    header('Location: route.php?page=cart');
    exit;
}
 ?>
