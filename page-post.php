<?php get_header(); ?>
<main>
    <h1>投稿フォーム</h1>
    <?php if ( !empty( $post_error ) ): ?>
        <!-- エラー発生時にメッセージを表示 -->
        <p><?php echo $post_error; ?></p>
    <?php endif; ?>
    <form action="<?php the_permalink(); ?>" method="post">
        <div class="title-wrap">
            <label for="title">タイトル</label>
            <input type="text" name="title" id="title">
        </div>
        <div class="content-wrap">
            <label for="content">本文</label>
            <textarea name="content" id="content" cols="30" rows="10"></textarea>    
        </div>
        <button type="submit">投稿</button>
    </form>
</main>
<?php get_footer(); ?>