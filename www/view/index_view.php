<?php

header('X-FRAME-OPTIONS: DENY');

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>商品一覧</title>
  <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'index.css'); ?>">
</head>
<body>
  <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
  

  <div class="container">
    <h1>商品一覧</h1>
    <?php include VIEW_PATH . 'templates/messages.php'; ?>

    <div class="card-deck">
      <div class="row">
      <!-- $itemsはindex.phpで定義づけされている変数 -->
      <!-- 10/21プルリクエストのテストのため追記したメモ -->
      <?php foreach($items as $item){ ?>
        <div class="col-6 item">
          <div class="card h-100 text-center">
            <div class="card-header">
              <?php print htmlspecialchars(($item['name']), ENT_QUOTES, 'UTF-8'); ?>
            </div>
            <figure class="card-body">
              <img class="card-img" src="<?php print(IMAGE_PATH . $item['image']); ?>">
              <figcaption>
              <!-- figcaptionは図表のキャプションを示す -->
                <?php print(number_format($item['price'])); ?>円
                <?php if($item['stock'] > 0){ ?>
                  <form action="index_add_cart.php" method="post">
                    <!-- 10/30更新 -->
                    <input type='hidden' name='csrf_token' value='<?php print $token;?>'>
                    <input type="submit" value="カートに追加" class="btn btn-primary btn-block">
                    <input type="hidden" name="item_id" value="<?php print($item['item_id']); ?>">
                  </form>
                <?php } else { ?>
                  <p class="text-danger">現在売り切れです。</p>
                <?php } ?>
              </figcaption>
            </figure>
          </div>
        </div>
      <?php } ?>
      </div>
    </div>
  </div>
  <table class="table table-bordered">
      <!-- <thead>で、テーブル（表）のヘッダ部分を定義することができる -->
      <thead class="thead-light">
          <tr>
            <th>購入ランキング</th>
            <th>商品名</th>
          </tr>
        </thead>
        <tbody>
        <!-- 11/17のレッスン -->
        <?php foreach($item_ranking as $key => $ranking) { ?>
          <tr>
            <td><?php print $key + 1; ?></td>
            <td><?php print htmlspecialchars(($ranking['name']), ENT_QUOTES, 'UTF-8'); ?></td>
          </tr>
        <?php } ?>
        </tbody>
  </table>
</body>
</html>