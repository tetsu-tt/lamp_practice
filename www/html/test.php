<?php

function test($name = '田中') {
    print $name. 'さん、こんにちは'; 
}

test();

$name_test = 'おはよう';
$name_test_test = $name_test. '田中さん';

// .=で文字を変数に追加できる
$name_test_test .= 'がんばろう';


?>
<!DOCTYPE HTML>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>test</title>
</head>
<body>
    <p><?php print $name_test_test; ?></p>
</body>

