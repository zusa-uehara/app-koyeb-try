<?php
// -------------------------
// DB接続
// -------------------------
$host = "db";
$port = "5432";       // PostgreSQL デフォルトポート
$dbname = "my_database";
$user = "user";
$pass = "password";

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // テーブル作成（初回のみ）
    $sql = "CREATE TABLE IF NOT EXISTS my_expenses (
        id SERIAL PRIMARY KEY,
        date DATE NOT NULL,
        cost INT NOT NULL,
        category TEXT NOT NULL,
        memo TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );";
    $pdo->exec($sql);

} catch (PDOException $e) {
    die("DB接続失敗: " . $e->getMessage());
}
