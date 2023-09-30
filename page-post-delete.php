<?php get_header(); ?>
<main>
    <h1>投稿削除</h1>
    <?php
        global $message;
        if( !empty($message) ):
    ?>
        <p><?= $message ?></p>
    <?php endif; ?>
    <p><a href="<?= home_url(); ?>">トップに戻る</a></p>
</main>
<?php get_footer(); ?>