<?php 
    global $register_error;
    get_header();
?>
<main>
    <h1>会員登録</h1>
    <?php if ( !empty( $register_error ) ): ?>
        <!-- エラー発生時にメッセージを表示 -->
        <p><?= $register_error; ?></p>
    <?php endif; ?>
    <p>全て入力必須</p>
    <form action="<?php the_permalink(); ?>" method="post">
        <div class="wrap">
            <label for="register_id">ユーザーID　※半角英数のみ</label>
            <input type="text" name="register_id" id="register_id" pattern="^[a-zA-Z0-9]+$" required>
        </div>
        <div class="wrap">
            <label for="register_name">ユーザー名（表示名）※全角可</label>
            <input type="text" name="register_name" id="register_name" required>
        </div>
        <div class="wrap">
            <label for="register_pass">パスワード</label>
            <input type="password" name="register_pass" id="register_pass" required>
        </div>
        <div class="wrap">
            <label for="register_email">メールアドレス</label>
            <input type="email" name="register_email" id="register_email" required>
        </div>
        <button type="submit">登録</button>
    </form>
</main>
<?php get_footer(); ?>