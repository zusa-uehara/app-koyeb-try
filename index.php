<?php
// あなたの接続文字列から情報を抽出
$url = "postgres://user:npg_lTNujZLcI7q5@ep-rough-hall-a4ktsifc.us-east-1.pg.koyeb.app/koyebdb";

$url_parts = parse_url($url);
$host = $url_parts['host'];
$user = $url_parts['user'];
$password = $url_parts['pass'];
$dbname = ltrim($url_parts['path'], '/');

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
