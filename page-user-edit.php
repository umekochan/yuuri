<?php 
    $edit_user = wp_get_current_user();
    global $user_update_result;

    get_header();
?>
<main>
    <?php if( empty($user_update_result) ): ?>
    <h1>会員情報変更</h1>
    <form action="<?php the_permalink(); ?>" method="post">
        <input type="hidden" name="user_id" value="<?= $edit_user->ID; ?>">
        <div class="wrap">
            <label for="update_name">ユーザー名（表示名）</label>
            <input type="text" name="update_name" id="update_name" value="<?= $edit_user->display_name; ?>">
        </div>
        <div class="wrap">
            <p>※現在のパスワードは表示されません</p>
            <label for="update_pass">パスワード</label>
            <input type="password" name="update_pass" id="update_pass">
        </div>
        <div class="wrap">
            <label for="update_email">メールアドレス</label>
            <input type="email" name="update_email" id="update_email" value="<?= $edit_user->user_email; ?>">
            <p>dev-email@wpengine.local</p>
        </div>
        <div class="wrap">
            <label for="update_school_name">学校名</label>
            <input type="text" name="update_school_name" id="update_school_name" value="<?= get_user_meta($edit_user->ID, 'school_name', true); ?>" required>
        </div>
        <button type="submit">変更</button>
    </form>
    <?php elseif( is_numeric($user_update_result) ): $user_update_result = null; ?>
        <p><strong>ユーザー情報を更新しました</strong></p>
        <p><a href="<?= home_url(); ?>">TOPに戻る</a></p>
    <?php elseif( is_wp_error( $user_update_result ) ): $user_update_result = null; ?>
        <p>更新エラーが発生しました</p>
    <?php endif; ?>
</main>
<?php get_footer(); ?>