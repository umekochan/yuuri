<?php 
    get_header();
    global $edit_user;
    var_dump($edit_user);    
?>
<main>
    <h1>会員情報変更</h1>
    <form action="<?php the_permalink(); ?>" method="post">
        <div class="wrap">
            <label for="name">ユーザー名</label>
            <input type="text" name="name" id="name" value="<?= $edit_user->user_nicename; ?>" required>
        </div>
        <div class="wrap">
            <p>※現在のパスワードは表示されません</p>
            <label for="password">パスワード</label>
            <input type="password" name="password" id="password" required>
        </div>
        <div class="wrap">
            <label for="email">メールアドレス</label>
            <input type="email" name="email" id="email" value="<?= $edit_user->user_nicename; ?>" required>
        </div>
        <input type="hidden" name="display_name" value="<?= $edit_user->display_name; ?>" >
        <button type="submit">変更</button>
    </form>
</main>
<?php get_footer(); ?>