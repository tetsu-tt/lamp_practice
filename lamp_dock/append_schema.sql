--   purchase_detailsのテーブル作成

CREATE TABLE purchase_details (
  order_id INT,
  item_id INT,
  amount INT,
  name VARCHAR(100),
  price INT DEFAULT 0
);


-- purchase_historyのテーブル作成
CREATE TABLE purchase_history (
  order_id INT AUTO_INCREMENT,
  user_id INT,
  purchase_date DATETIME,
  primary key(order_id)
);