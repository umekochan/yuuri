<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body>
    <p>ログアウトしました</p>
    <p><a href="<?= esc_url( home_url('/') ); ?>">TOPに戻る</a></p>
</body>
</html>