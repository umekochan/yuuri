<?php get_header(); ?>
    <p>ログアウトしますか？</p>
    <p><a href="<?php the_permalink(); ?>?action=logout" >ログアウトする</a></p>
    <p><a href="<?php esc_url( home_url('/') ); ?>" >ログアウトしない（TOPに戻る）</a></p>
<?php get_footer(); ?>