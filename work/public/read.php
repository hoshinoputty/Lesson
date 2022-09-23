<?php

define('DSN', 'mysql:host=db;dbname=myapp;charset=utf8mb4');
define('DB_USER', 'myappuser');
define('DB_PASS', 'myapppass');

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
} catch (PDOException $e) {
  echo $e->getMessage();
  exit;
}

function h($str)
{
  return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function getProducts($pdo) 
{
  $stmt = $pdo->query("SELECT * FROM products");
  $products = $stmt->fetchAll();
  return $products;
}

function descProducts($pdo)
{
  $stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
  $products = $stmt->fetchAll();
  return $products;
}

function ascProducts($pdo)
{
  $stmt = $pdo->query("SELECT * FROM products ORDER BY id ASC");
  $products = $stmt->fetchAll();
  return $products;
}

function serachProducts($pdo, $keyword)
{
  $stmt = $pdo->prepare("SELECT * FROM products WHERE product_name LIKE :keyword");
  $keyword_match = "%{$keyword}%";
  $stmt->bindValue(':keyword', $keyword_match, PDO::PARAM_STR);
  $stmt->execute();
  $products = $stmt->fetchAll();
  return $products;
}

$products = getProducts($pdo);

if (isset($_GET['order'])) {
  $order = $_GET['order'];
} else {
  $order = NULL;
}

if ($order === 'desc') {
  $products = descProducts($pdo);
}

if ($order === 'asc') {
  $products = ascProducts($pdo);
}

if (isset($_GET['keyword'])) {
  $keyword = $_GET['keyword'];
  $products = serachProducts($pdo, $keyword);
} else {
  $keyword = NULL;
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="format-detection" content="telephome=no">
  <title>商品管理アプリ</title>
  <meta name="description" content="商品の管理を行います">
  <link rel="canonical" href="">
  <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
  <link rel="stylesheet" href="css/styles.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  
</head>
<body class>
  <header>
    <nav>
      <a href="index.php">商品管理アプリ</a>
    </nav>
  </header>
  <main>
    <article class="products">
      <h1>商品一覧</h1>
      <div class="products-ui">
          <div>
              <a href="read.php?order=desc">
                <img src="images/desc.png" alt="降順に並び替え" class="sort-img">
              </a>
              <a href="read.php?order=asc">
                <img src="images/asc.png" alt="昇順に並び替え" class="sort-img">
              </a>
              <form action="read.php" method="get" class="search-form">
                <input type="text" class="search-box" placeholder="商品名で検索" name="keyword" value="<?= $keyword; ?>">
              </form>
          </div>
          <a href="create.php" class="btn">商品登録</a>
      </div>
      <table class="products-table">
          <tr>
              <th>商品コード</th>
              <th>商品名</th>
              <th>単価</th>
              <th>在庫数</th>
              <th>仕入先コード</th>
          </tr>
          <?php foreach ($products as $product): ?>
            <tr>
              <td><?= $product->product_code; ?></td>
              <td><?= $product->product_name; ?></td>
              <td><?= $product->price; ?></td>
              <td><?= $product->stock_quantity; ?></td>
              <td><?= $product->vendor_code; ?></td>                 
            </tr>                    
          <?php endforeach; ?>
      </table>
    </article>
  </main>
  <footer>
    <p class="copyright">$copy; 商品管理アプリ All rights reserved. </p>
  </footer>
</body>
</html>