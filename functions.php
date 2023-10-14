<?php 

//Titleタグの有効化
function setup_my_theme() {
    add_theme_support( 'title-tag' );
}
add_action( 'after_setup_theme', 'setup_my_theme');

//ログイン関数
function login_init() {
    //ログインページからのアクセスでなければ関数を終了する
    if ( !is_page( 'login' ) ) {
        return;
    }

    //変数$errorのグローバル宣言
    global $error;
    $error = "";
    $br ="<br/>";

    //メールアドレスのチェック
    if ( !empty( $_POST['user_email'] ) ) {
        $email = $_POST['user_email'];
    } else {
        $error .= "メールアドレスを入力してください{$br}";
    }

    //パスワードのチェック
    if ( !empty( $_POST['user_pass'] ) ) {
        $password = $_POST['user_pass'];
    } else {
        $error .= "パスワードを入力してください{$br}";
    }

    //エラーが無ければログイン処理へ進む
    if ( !$error ) {
        //ユーザー情報の取得
        $user = get_user_by( 'email', $email );

        //存在しないメールアドレスの場合
        if ( false === $user ) {
            $error .= "メールアドレスが間違っています。{$br}";

        } else {
            //ユーザー情報を配列に定義
            $login = array();
            $login['user_login'] = $user->data->user_login;
            $login['user_password'] = $password;
            $login['remember'] = true;

            //ログインの実行
            $user = wp_signon( $login, false );
            
            //ログイン失敗時の処理
            if ( is_wp_error( $user ) ) {
                if ( array_key_exists( 'incorrect_password', $user->errors ) ) {
                    $error .= "パスワードが間違っています。{$br}";
                } else {
                    $error .= "ログインに失敗しました。{$br}";
                }
            
            //ログイン成功時の処理
            } else {
                //ホーム画面へリダイレクト
                echo "ログインしました。";
                wp_safe_redirect( home_url() );
            }
        }
    }
}
add_action( 'template_redirect', 'login_init' );

function logout_init() {

    //ログアウトページでなければ終了
    if( !is_page('logout') ){
        return;
    }

    //ログインしていないならログインページに遷移
    if( !is_user_logged_in() ){
        wp_safe_redirect('/login');
        exit;
    }

    //GET['action']にlogoutが登録されていればログアウトする
    if( isset($_GET['action']) and $_GET['action'] === 'logout' ) {
        
        //グローバル変数宣言
        global $logged_user_id;

        //ログアウトしたユーザーを取得（ログアウトした直後であることを示すフラグとする）
        $logged_user_id = get_current_user_id();
        
        //ログアウト実行
        wp_logout();
    }

}
add_action( 'template_redirect', 'logout_init' );

function logged_out_event($template) {

    //ログアウトページでなければ終了
    if( is_page( '/logout' ) ){
        return $template;
    }

    
    //GET['action']にlogoutが登録されている
    if( isset($_GET['action']) and $_GET['action'] === 'logout' ){
    }

    //グローバル変数宣言
    global $logged_user_id;
    
    //ログアウトユーザーの値がある
    if( isset($logged_user_id) ){
        //読み込むテンプレートを確認
        $after_template = locate_template( array('page-logout_after.php') ); 
        
        if( isset($after_template) ) {
            //読み込むテンプレートを変更
            $template = $after_template;
            //ログアウトフラグを解除
            $logged_user_id = null;
        }

    }
    return $template;
}
add_action( 'template_include', 'logged_out_event' );

//投稿処理の関数
function post_init() {
    //投稿ページでないなら実行を終える
    if( !is_page('post') ){
        return;
    }

    global $post_error;
    $post_error = "";
    $br ="<br/>";

    //入力チェック
    if( empty( $_POST['title'] ) ){
        $post_error .= "タイトルが入力されていません{$br}";
    }
    if( empty( $_POST['content'] ) ){
        $post_error .= "本文が入力されていません{$br}";
    }

    //問題があれば終了
    if( !empty($post_error) ){
        return;    
    }

    //投稿データの作成
    $new_post = array(
        'post_title' => $_POST['title'],
        'post_content' => $_POST['content'],
        'post_status' => 'publish',
        'post_date' => date('Y-m-d h:m:s'),
        'post_author' => get_current_user_id(),
        'post_type' => 'post',
    );

    //投稿を実行
    $post_id = wp_insert_post($new_post, true);

    //エラー処理
    if( is_wp_error($post_id) ){
        $post_error = $post_id->errors;
    }
}
add_action( 'template_redirect', 'post_init' );

function user_register_init() {
    //投稿ページでないなら実行を終える
    if( !is_page('register') ){
        return;
    }

    //既ログイン状態で新規登録はさせない
    if( is_user_logged_in() ){
        return;
    }

    //POSTが無いなら実行しない
    if( empty($_POST) ){
        return;
    }

    //エラーメッセージを定義
    global $register_error;
    $register_error = "";
    $br = "<br>";

    //未入力チェック
    if( empty($_POST['register_id']) ){
        $register_error .= "ユーザーIDが入力されていません{$br}";
    }
    if( empty($_POST['register_name']) ){
        $register_error .= "ユーザー名が入力されていません{$br}";
    }
    if( empty($_POST['register_pass']) ){
        $register_error .= "パスワードが入力されていません{$br}";
    }
    if( empty($_POST['register_email']) ){
        $register_error .= "メールアドレスが入力されていません{$br}";
    }

    //未入力があれば処理を終了
    if( !empty($register_error) ){
        return;
    }

    //重複チェック　…ここではユーザーIDとメールアドレスは重複を認めない
    //指定されたユーザーIDを持つユーザーが存在する
    if( get_user_by('login', $_POST['register_id']) ){
        $register_error .= "そのユーザーIDは既に使われています{$br}";
    }
    if( get_user_by('email', $_POST['register_email']) ){
        $register_error .= "そのメールアドレスは既に登録されています{$br}";
    }

    //重複があれば処理を終了
    if( !empty($register_error) ){
        return;
    }

    //新規ユーザー情報を配列に格納
    $new_user = array(
        'user_login' => $_POST['register_id'],      //ログインid
        'user_pass' => $_POST['register_pass'],     //パスワード
        'user_nicename' => $_POST['register_id'],   //URL用のユーザー名
        'display_name' => $_POST['register_name'],  //表示名
        'user_email' => $_POST['register_email'],   //メールアドレス
        'user_registered' => date('Y-m-d H:i:s'),   //登録日
        'role' => 'contributor',                    //権限
        'meta_input' => array('school_name' => $_POST['school_name']),
    );
    
    //ユーザー登録
    $registed = wp_insert_user( $new_user );

    //エラーが発生した場合
    if( is_wp_error($registed) ){
        $register_error .= "登録時にエラーが発生しました{$br}";
        $register_error .= $registed->get_error_messages();
        return;
    }

    //登録したユーザーでログイン状態にする
    //ログイン情報を定義
    $login_user = array(
        'user_login' => $new_user['user_login'],
        'user_password' => $new_user['user_pass'],
        'remember' => true,
    );
    //ログイン実行
    wp_signon( $login_user, false );

    //トップに移動させる
    wp_safe_redirect( home_url() );
    exit;
}
add_action( 'template_redirect', 'user_register_init' );

function user_edit_init() {
    //ユーザー情報編集ページでなければ実行を終える
    if( !is_page('user-edit') ){
        return;
    }
    
    //ログインしていなければログインにリダイレクト
    if( !is_user_logged_in() ){
        wp_safe_redirect( '/login' );
        exit;
    }

    //何もPOSTされていなければ終了
    if( empty($_POST['user_id']) ){
        return;
    }

    //指定されたユーザーIDと現在ログインしているユーザーのIDが一致しなければ終了
    if( (int)$_POST['user_id'] !== get_current_user_id() ){

        //必要であればエラーメッセージ等を出力する

        return;
    }

    //現在ログインしているユーザー情報を変数に保存
    $user = wp_get_current_user();

    //入力があった項目の値を変更する
    if( !empty($_POST['update_name']) ){
        $user->display_name = $_POST['update_name'];
    }
    if( !empty($_POST['update_pass']) ){
        $user->user_pass = $_POST['update_pass'];
    }
    if( !empty($_POST['update_email']) ){
        $user->user_email = $_POST['update_email'];
    }
    if( !empty($_POST['update_school_name']) ){
        $user->meta_input = array('school_name' => $_POST['update_school_name']);
    }

    global $user_update_result;
    $user_update_result = wp_update_user( $user );

}
add_action( 'template_redirect', 'user_edit_init' );

function post_delete() {
    //削除ページでなければ終了
    if( !is_page('post-delete') ){
        return;
    }
    //ログインしていなければ終了
    if( !is_user_logged_in() ){
        return;
    }
    //削除する投稿のIDがなければ終了
    if( empty($_GET['del']) ){
        return;
    }

    $post_id = (int)$_GET['del'];
    //削除を実行
    $result = wp_delete_post( $post_id );
    
    global $message;
    $message = "";
    //投稿が存在しない
    if( $result === null ){
        $message .= "指定された投稿IDがありません";
    //削除失敗
    }elseif( $result === false ){
        $message .= "削除できませんでした";

    //削除成功
    }elseif( $result->ID === $post_id ){
        wp_safe_redirect( home_url() );
        exit;
    }
}
add_action( 'template_redirect', 'post_delete' );

?>