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

function getTodos($pdo) 
{
  $stmt = $pdo->query("SELECT * FROM todos ORDER BY id DESC");
  $todos = $stmt->fetchAll();
  return $todos;
}

$todos = getTodos($pdo);

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
  
</head>
<body class>
  <header>
    <nav>
      <a href="index.php">商品管理アプリ</a>
    </nav>
  </header>
  <main>
    <article class="home">
      <h1>商品管理アプリ</h1>
      <p>『PHPとデータベースを連携しよう』成果物</p>
      <a href="read.php" class="btn">商品一覧</a>
    </article>
  </main>
  <footer>
    <p class="copyright">$copy; 商品管理アプリ All rights reserved. </p>
  </footer>
</body>
</html>