-- 購入履歴画面のSQL文（管理者ユーザーでログインしている場合）

SELECT purchase_history.order_id, purchase_date, SUM(price*amount)
FROM purchase_history
INNER JOIN purchase_details 
ON purchase_history.order_id = purchase_details.order_id
GROUP BY purchase_history.order_id


-- 購入履歴画面のSQL文

SELECT purchase_history.order_id, purchase_date, SUM(price*amount)
FROM purchase_history
INNER JOIN purchase_details 
ON purchase_history.order_id = purchase_details.order_id
WHERE purchase_history.user_id = ?
GROUP BY purchase_history.order_id;



-- 購入明細画面のSQL文「商品名」「購入時の商品価格」 「購入数」「小計」

SELECT name, price, amount, price*amount
FROM purchase_details
INNER JOIN purchase_history
ON purchase_details.order_id = purchase_history.order_id
WHERE purchase_history.order_id = ?;

-- 購入明細画面のSQL文「商品名」「購入時の商品価格」 「購入数」「小計」(管理者)

SELECT name, price, amount, price*amount
FROM purchase_details
INNER JOIN purchase_history
ON purchase_details.order_id = purchase_history.order_id;



-- 購入明細画面のSQL文「注文番号」「購入日時」「合計金額」自力で行ったSQl文
-- 「注文番号」が複数出てきてしまう(例：user_id = 1のものが２行表示される）。「合計金額」も出せていない。
-- SELECT purchase_history.order_id, purchase_date
-- FROM purchase_history
-- INNER JOIN purchase_details
-- ON purchase_details.order_id = purchase_history.order_id
-- WHERE purchase_history.order_id = ?
-- GROUP BY order_id;

-- 購入明細画面のSQL文「注文番号」「購入日時」「合計金額」（11/11レッスン内容）
SELECT purchase_history.order_id, purchase_date, SUM(amount*price)
FROM purchase_history
INNER JOIN purchase_details
ON purchase_details.order_id = purchase_history.order_id
WHERE purchase_history.order_id = ?
GROUP BY order_id;

-- 購入明細画面のSQL文「注文番号」「購入日時」「合計金額」（管理者）
SELECT purchase_history.order_id, purchase_date, SUM(amount*price)
FROM purchase_history
INNER JOIN purchase_details
ON purchase_details.order_id = purchase_history.order_id
GROUP BY order_id;


-- 課題３－３（レッスン）
SELECT purchase_details.item_id, items.name, SUM(amount)
FROM items
INNER JOIN purchase_details
ON items.item_id = purchase_details.item_id
GROUP BY item_id
ORDER BY SUM(amount) DESC LIMIT 3;