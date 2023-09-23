<?php get_header(); ?>
<main>
    <h1>ログイン</h1>
    <form action="<?php the_permalink(); ?>" method="post">
        <?php if ( !empty( $error ) ): ?>
            <!-- エラー発生時にメッセージを表示 -->
            <p><?php echo $error; ?></p>
        <?php endif; ?>
        <label for="Email">メールアドレス</label>
        <input id="Email" type="email" name="user_email" value="">
        <label for="Password">パスワード</label>
        <input id="Password" type="password" name="user_pass">
        <button type="submit">ログイン</button>
    </form>
</main>
<?php get_footer(); ?>