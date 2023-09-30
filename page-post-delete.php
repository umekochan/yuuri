<?php get_header(); ?>
<main>
    <h1>投稿削除</h1>
    <?php if ( !empty( $post_error ) ): ?>
        <!-- エラー発生時にメッセージを表示 -->
        <p><?php echo $post_error; ?></p>
    <?php endif; ?>
    <form action="<?php the_permalink(); ?>" method="post">

    </form>
</main>
<?php get_footer(); ?>