<?php

header('X-FRAME-OPTIONS: DENY');

?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <?php include VIEW_PATH . 'templates/head.php'; ?>
        <title>購入明細</title>
        <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'purchase_details.css'); ?>">
    </head>
    <body>
        <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
        <h1>購入明細</h1>
        <div>
        <p>注文番号 <?php print $order_id; ?></p>
        <!-- 購入日時が表示されない -->
        <p>購入日時 <?php print $purchase_details[0]['purchase_date']; ?></p>
        <p>該当の注文の合計金額 <?php print $sum_details; ?></p>
        </div>
        <table class="table table-bordered">
      <!-- <thead>で、テーブル（表）のヘッダ部分を定義することができる -->
        <thead class="thead-light">
          <tr>
            <th>商品名</th>
            <th>購入時の商品価格</th>
            <th>購入数</th>
            <th>小計</th>
          </tr>
        </thead>
        <tbody>
        <!-- 11/16の試み -->
          <!-- $purchase_detailsが二次元配列、$purchase_detailが一次元配列 -->
          <?php foreach($purchase_details as $purchase_detail){ ?>
          <tr>
            <td><?php print htmlspecialchars(($purchase_detail['name']), ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php print(number_format($purchase_detail['price'])); ?>円</td>
            <td><?php print(number_format($purchase_detail['amount'])); ?>個</td>
            <!-- <td><?php print(number_format($purchase_detail['price']*$purchase_detail['amount'])); ?>円</td> -->
            <!-- 下記のコードではなぜだめなのか確認する -->
            <td><?php print(number_format($purchase_detail['price*amount'])); ?>円</td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </body>
</html>