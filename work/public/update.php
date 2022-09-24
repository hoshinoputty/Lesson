<?php

define('DSN', 'mysql:host=db;dbname=myapp;charset=utf8mb4');
define('DB_USER', 'myappuser');
define('DB_PASS', 'myapppass');

if (isset($_POST['submit'])) {
  try {
    $pdo = new PDO(
      DSN,
      DB_USER,
      DB_PASS,
      [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_EMULATE_PREPARES => false,
      ]
    );

    $stmt = $pdo->prepare("UPDATE products SET 
    product_code = :product_code,
    product_name = :product_name,
    price = :price,
    stock_quantity = :stock_quantity,
    vendor_code = :vendor_code
    WHERE id = :id");

    $stmt->bindValue(':product_code', $_POST['product_code'], PDO::PARAM_INT);
    $stmt->bindValue(':product_name', $_POST['product_name'], PDO::PARAM_STR);
    $stmt->bindValue(':price', $_POST['price'], PDO::PARAM_INT);
    $stmt->bindValue(':stock_quantity', $_POST['stock_quantity'], PDO::PARAM_INT);
    $stmt->bindValue(':vendor_code', $_POST['vendor_code'], PDO::PARAM_INT);
    $stmt->bindValue(':id', $_GET['id'], PDO::PARAM_INT);

    $stmt->execute();
    $count = $stmt->rowCount();
    $message = "商品を{$count}件編集しました。";

    header("Location: read.php?message={$message}");

  } catch (PDOException $e) {
    echo $e->getMessage();
    exit;
  }

}


if (isset($_GET['id'])) {

  try {
    $pdo = new PDO(
      DSN,
      DB_USER,
      DB_PASS,
      [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_EMULATE_PREPARES => false,
      ]
    );

    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");

    $stmt->bindValue(':id', $_GET['id'], PDO::PARAM_INT);

    $stmt->execute();

    $product = $stmt->fetch();

    if ($product === FALSE) {
      exit("idパラメーターの値が不正です。");
    }

    $stmt_vendors = $pdo->query("SELECT vendor_code FROM vendors");
    $vendor_codes = $stmt_vendors->fetchAll();

  } catch (PDOException $e) {
    echo $e->getMessage();
    exit;
  }

} else {
  exit('idパラメーターの値が存在しません');
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="format-detection" content="telephome=no">
  <title>商品登録</title>
  <meta name="description" content="商品の管理を行います">
  <link rel="canonical" href="">
  <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
  <link rel="stylesheet" href="css/styles.css">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
  
</head>
<body class>
  <header>
    <nav>
      <a href="index.php">商品管理アプリ</a>
    </nav>
  </header>
  <main>
    <article class="registration">
      <h1>商品編集</h1>
      <div class="back">
        <a href="read.php" class="btn">&lt; 戻る</a>
      </div>
      <form action="update.php?id=<?= $_GET['id'] ?>" method="post" class="registration-form">
        <div>
          <label for="product_code">商品コード</label>
          <input type="number" name="product_code" value="<?= $product->product_code; ?>" min="0" max="100000000" required>
          <label for="product_name">商品名</label>
          <input type="text" name="product_name" value="<?= $product->product_name; ?>" maxlength="50" required>
          <label for="price">単価</label>
          <input type="number" name="price" value="<?= $product->price; ?>" min="0" max="100000000" required>
          <label for="stock_quantity">在庫数</label>
          <input type="number" name="stock_quantity" value="<?= $product->stock_quantity; ?>" min="0" max="100000000" required>
          <label for="vendor_code">仕入先コード</label>
          <select name="vendor_code" required>
            <option disabled selected value>選択してください</option>
            <?php foreach($vendor_codes as $vendor_code): ?>
              <?php if($vendor_code->vendor_code === $product->vendor_code): ?>
                <option value="<?= $vendor_code->vendor_code ?>" selected><?= $vendor_code->vendor_code ?></option>
              <?php else: ?>
                <option value="<?= $vendor_code->vendor_code ?>"><?= $vendor_code->vendor_code ?></option>
              <?php endif; ?>
            <?php endforeach; ?>
          </select>
        </div>
        <button type="submit" class="submit-btn" name="submit" value="update">更新</button>
      </form>
    </article>
  </main>
  <footer>
    <p class="copyright">$copy; 商品管理アプリ All rights reserved. </p>
  </footer>
</body>
</html>