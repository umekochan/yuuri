<?php 

//Titleタグの有効化
function setup_my_theme() {
    add_theme_support( 'title-tag' );
}
add_action( 'after_setup_theme', 'setup_my_theme');

//ログイン関数
function login_init() {
    //ログインページからのアクセスでなければ関数を終了する
    if ( ! is_page( 'login' ) ) {
        return;
    }

    //変数$errorのグローバル宣言
    global $error;
    $error = "";
    $br ="<br/>";

    //メールアドレスのチェック
    if ( ! empty( $_POST['user_email'] ) ) {
        $email = $_POST['user_email'];
    } else {
        $error .= "メールアドレスを入力してください{$br}";
    }

    //パスワードのチェック
    if ( ! empty( $_POST['user_pass'] ) ) {
        $password = $_POST['user_pass'];
    } else {
        $error .= "パスワードを入力してください{$br}";
    }

    //エラーが無ければログイン処理へ進む
    if ( ! $error ) {
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
                wp_safe_redirect( home_url() );
            }
        }
    }
}
add_action( 'template_redirect', 'login_init' );

?>