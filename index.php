<?php get_header(); ?>
<main>
    <h1>投稿一覧</h1>
    <?php if( have_posts() ): ?>
        <?php while( have_posts() ): the_post(); ?>
            <hr>
            <article>
                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <p>投稿日：<time datetime="<?php the_time('Y-m-j'); ?>"><?php the_time('Y年n月j日'); ?></time></p>
            </article>
        <?php endwhile; ?>
    <?php endif; ?>
</main>
<?php get_footer(); ?>