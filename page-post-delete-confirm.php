<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body>
    <main>
        <p>削除しますか？</p>
        <p><a href="<?= home_url( '/post-delete' ) . "?del=" . $_GET['del']; ?>">はい</a></p>
        <p><a href="<?= home_url(); ?>">いいえ</a></p>
    </main>
    <?php wp_footer(); ?>
</body>
</html>