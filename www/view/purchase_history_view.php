<?php

header('X-FRAME-OPTIONS: DENY');

?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <?php include VIEW_PATH . 'templates/head.php'; ?>
        <title>購入履歴</title>
        <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'purchase_history.css'); ?>">
    </head>
    <body>
        <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
        <h1>購入履歴</h1>
        <div class="container">
        <?php include VIEW_PATH . 'templates/messages.php'; ?>
        <table class="table table-bordered">
            <!-- <thead>で、テーブル（表）のヘッダ部分を定義することができる -->
            <thead class="thead-light">
            <tr>
                <th>注文番号</th>
                <th>購入日時</th>
                <th>合計金額</th>
                <th>購入明細画面</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($purchase_history as $history){ ?>
            <!-- purchase_history.order_id, purchase_date, SUM(price*amount) -->
            <tr>
                <td><?php print($history['order_id']); ?></td>
                <td><?php print($history['purchase_date']); ?></td>
                <td><?php print($history['SUM(price*amount)']); ?>円</td>
                <!-- 11/11の試み -->
                <form method="post" action="purchase_details.php">
                <td><a href="purchase_details.php"><input type = "submit" value = "購入明細画面へ"></a></td>
                <input type = "hidden" name="order_id" value="<?php print $history['order_id'] ?>">
                <input type='hidden' name='csrf_token' value='<?php print $token;?>'>
                </form>
            </tr>
            <?php } ?>
            </tbody>
        </table>
        </div>
    </body>
</html>