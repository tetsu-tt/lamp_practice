-- 画面ごとに表示する項目全てが含まれたテーブルを作成

SELECT
  *
FROM
  users
  INNER JOIN carts
  ON users.user_id = carts.user_id
  INNER JOIN items
  ON carts.item_id = items.item_id
  INNER JOIN purchase_details
  ON items.item_id = purchase_details.item_id
  INNER JOIN purchase_histry
  ON purchase_details.order_id = purchase_histry.order_id;

--   purchase_detailsのテーブル作成

CREATE TABLE purchase_details (
  order_id INT AUTO_INCREMENT,
  item_id INT,
  subtotal INT DEFAULT 0,
  primary key(order_id)
);

-- purchase_histryのテーブル作成
CREATE TABLE purchase_histry (
  order_id INT AUTO_INCREMENT,
  purchase_date DATETIME,
  total_fee INT DEFAULT 0,
  primary key(order_id)
);