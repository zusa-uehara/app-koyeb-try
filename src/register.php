
<?php
require_once "db_connect.php";

// -------------------------
// 支出登録処理（POST）
// -------------------------
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $date = $_POST['date'] ?? '';
    $cost = $_POST['cost'] ?? '';
    $category = $_POST['category'] ?? '';
    $memo = $_POST['memo'] ?? '';

    // 有効カテゴリ一覧（コード → 日本語ラベル）
    $valid_categories = [
        'rent' => '家賃',
        'utilities' => '光熱費',
        'living' => '生活費・雑費',
        'entertainment' => '交際費',
        'medical' => '医療費'
    ];

    // バリデーション
    if (!$date) {
	    $errors[] = "日付を入力してください。";
		}
    if (!is_numeric($cost) || $cost < 0) {
	    $errors[] = "金額は0以上の数字で入力してください。";
	  }
    if (!array_key_exists($category, $valid_categories)) {
	    $errors[] = "不正なカテゴリです。";
	  }
    if (strlen($memo) > 200) {
	    $errors[] = "メモは200文字以内で入力してください。";
    }

    // エラーがなければDBに登録
    if (empty($errors)) {
        $sql = "INSERT INTO my_expenses (date, cost, category, memo)
                VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
		    $stmt->execute([
		        $date,      // 1番目の ? に入る
		        $cost,      // 2番目の ? に入る
		        $category,  // 3番目の ? に入る
		        $memo       // 4番目の ? に入る
		    ]);
        $success_message = "支出を登録しました。";
    }
}

// -------------------------
// 支出一覧取得
// -------------------------
$stmt = $pdo->query("SELECT * FROM my_expenses ORDER BY date DESC");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// -------------------------
// カテゴリの対応表
// -------------------------
$category_labels = [
    'rent' => '家賃',
    'utilities' => '光熱費',
    'living' => '生活費・雑費',
    'entertainment' => '交際費',
    'medical' => '医療費'
];
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>今日の支出メモ</title>
</head>
<body>
    <h1><a href="/">今日の支出メモ</a></h1>

    <!-- エラーメッセージ表示 -->
    <?php if (!empty($errors)): ?>
        <div style="color:red;">
            <?php foreach ($errors as $err) echo "<p>$err</p>"; ?>
        </div>
    <?php endif; ?>

    <!-- 成功メッセージ表示 -->
    <?php if (!empty($success_message)): ?>
        <div style="color:green;">
            <p><?= htmlspecialchars($success_message) ?></p>
        </div>
    <?php endif; ?>

    <h2>支出を記録</h2>
    <form action="register.php" method="post">
        <label for="date">日付：
            <input type="date" id="date" name="date" required>
        </label>
        <br>
        <label for="cost">金額：
            <input type="number" id="cost" name="cost" min="0" required>
        </label>
        <br>
        <label for="category">カテゴリ：
            <select id="category" name="category">
                <?php foreach ($category_labels as $key => $label): ?>
                    <option value="<?= htmlspecialchars($key) ?>"><?= htmlspecialchars($label) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <br>
        <label for="memo">メモ：
            <input type="text" id="memo" name="memo" maxlength="200">
        </label>
        <br>
        <button type="submit">登録する</button>
    </form>

    <h2>支出の一覧</h2>
    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>日付</th>
            <th>金額</th>
            <th>カテゴリ</th>
            <th>メモ</th>
        </tr>
        <?php foreach ($rows as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row["id"]) ?></td>
                <td><?= htmlspecialchars($row["date"]) ?></td>
                <td><?= htmlspecialchars($row["cost"]) ?> 円</td>
                <td>
                    <?= htmlspecialchars($category_labels[$row["category"]] ?? $row["category"]) ?>
                </td>
                <td><?= htmlspecialchars($row["memo"]) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
     <footer>
        © 2025 azoosa uehara | This is a portfolio project.
    </footer>
</body>
</html>
