<?php
// 環境変数からデータベースの接続情報を取得
$host = getenv('DB_HOST');
$user = getenv('DB_USER');
$password = getenv('DB_PASSWORD');
$dbname = getenv('DB_NAME');

// DSN文字列を作成
$dsn = "pgsql:host=$host;dbname=$dbname;user=$user;password=$password";

try {
    // PDOインスタンスを作成して接続を確立
    $conn = new PDO($dsn);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully to PostgreSQL!";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
