<?php get_header(); ?>
<main>
    <h1>会員登録</h1>
    <?php if ( !empty( $regi_error ) ): ?>
        <!-- エラー発生時にメッセージを表示 -->
        <p><?php echo $regi_error; ?></p>
    <?php endif; ?>
    <form action="<?php the_permalink(); ?>" method="post">
        <div class="wrap">
            <label for="name">ユーザー名</label>
            <input type="text" name="name" id="name" required>
        </div>
        <div class="wrap">
            <label for="password">パスワード</label>
            <input type="password" name="password" id="password" required>
        </div>
        <div class="wrap">
            <label for="email">メールアドレス</label>
            <input type="email" name="email" id="email" required>
        </div>
        <button type="submit">登録</button>
    </form>
</main>
<?php get_footer(); ?>