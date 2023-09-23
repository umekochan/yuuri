<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body>
    <header>
        <menu>
            <ul style="display: flex; justify-content: space-evenly;">
                <li><a href="<?= home_url(); ?>">TOP</a></li>
                <li><a href="/login/">ログイン</a></li>
                <li><a href="/logout/">ログアウト</a></li>
                <li><a href="/register/">会員登録</a></li>
                <li><a href="/user-edit/">会員情報変更</a></li>
                <li><a href="/post/">投稿</a></li>
            </ul>
        </menu>
    </header>