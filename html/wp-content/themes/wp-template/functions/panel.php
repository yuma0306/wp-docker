<?php

/**
* ツールバー項目非表示
*/
function removeWpNodes($wp_admin_bar) {
    $wp_admin_bar->remove_node('comments');
    $wp_admin_bar->remove_menu( 'updates' ); //更新
    $wp_admin_bar->remove_menu( 'wp-logo' ); //ロゴ
    // $wp_admin_bar->remove_menu( 'about' ); //ロゴ / WordPressについて
    // $wp_admin_bar->remove_menu( 'wporg' ); //ロゴ / WordPress.org
    // $wp_admin_bar->remove_menu( 'documentation' ); //ロゴ / ドキュメンテーション
    // $wp_admin_bar->remove_menu( 'support-forums' ); //ロゴ / サポート
    // $wp_admin_bar->remove_menu( 'feedback' ); //ロゴ / フィードバック
    // $wp_admin_bar->remove_menu( 'site-name' ); //サイト名
    // $wp_admin_bar->remove_menu( 'view-site' ); //サイト名 / サイトを表示
    // $wp_admin_bar->remove_menu( 'comments' ); //コメント
    // $wp_admin_bar->remove_menu( 'new-content' ); //新規
    // $wp_admin_bar->remove_menu( 'new-post' ); //新規 / 投稿
    // $wp_admin_bar->remove_menu( 'new-media' ); //新規 / メディア
    // $wp_admin_bar->remove_menu( 'new-page' ); //新規 / 固定
    // $wp_admin_bar->remove_menu( 'new-user' ); //新規 / ユーザー
    // $wp_admin_bar->remove_menu( 'view' ); //投稿を表示
    // $wp_admin_bar->remove_menu( 'customize' ); //カスタマイズ
    // $wp_admin_bar->remove_menu( 'edit' );//〜を編集
    // $wp_admin_bar->remove_menu( 'my-account' ); //こんにちは、[ユーザー名]さん $wp_admin_bar->remove_menu( 'user-info' ); // ユーザー / [ユーザー名]
    // $wp_admin_bar->remove_menu( 'edit-profile' ); //ユーザー / プロフィールを編
    // $wp_admin_bar->remove_menu( 'logout' ); //ユーザー / ログアウト
    // $wp_admin_bar->remove_menu( 'menu-toggle' ); //メニュー
    // $wp_admin_bar->remove_menu( 'search' ); //検索
}
add_action('admin_bar_menu', 'removeWpNodes', 99);

/**
* ダッシュボード項目非表示
*/
function removeDashboardWidget() {
    remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' ); //概要
    remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' ); //クイックドラフト
    remove_meta_box( 'dashboard_primary', 'dashboard', 'side' ); //WordPressニュース
    remove_action( 'welcome_panel', 'wp_welcome_panel' ); //ようこそ
    // remove_meta_box( 'dashboard_site_health', 'dashboard', 'normal' ); //サイトヘルスステータス
    // remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' ); //アクティビティ
    // ▼もっと細かく制御するには
    global $wp_meta_boxes;
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']); // 最近のコメント表示を削除
}
add_action('wp_dashboard_setup', 'removeDashboardWidget');

/**
* メニューの非表示
*/
function removeMenus(){
    remove_menu_page('edit.php'); //投稿メニュー
    remove_menu_page('edit-comments.php'); //コメント
    // remove_menu_page('index.php'); //ダッシュボード
    // remove_menu_page('edit.php?post_type=memo'); //カスタム投稿タイプmemo
    // remove_menu_page('upload.php'); // メディア
    // remove_menu_page('edit.php?post_type=page'); //固定ページ
    // remove_menu_page('themes.php'); //外観
    // remove_menu_page('plugins.php'); //プラグイン
    // remove_menu_page('users.php'); //ユーザー
    // remove_menu_page('tools.php'); //ツールメニュー
    // remove_menu_page('options-general.php'); //設定
}
add_action('admin_menu', 'removeMenus');

/**
 * 更新通知を管理者権限のみに表示
 */
function updateNagAdminOnly() {
    if(!current_user_can('administrator')) {
        remove_action('admin_notices', 'update_nag', 3);
    }
}
add_action('admin_init', 'updateNagAdminonly');

function customMenuPos() {
	global $menu;
	$menu[19] = $menu[10];
	unset($menu[10]);
}
add_action('admin_menu', 'customMenuPos');
