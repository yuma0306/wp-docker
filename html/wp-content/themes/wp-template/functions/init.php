<?php

function removeHeadAction() {
    // WordPressのバージョン情報を表示するためのリンクを削除
    remove_action('wp_head', 'wp_generator');
    // ショートリンク関連のリンクを削除
    remove_action('wp_head', 'wp_shortlink_wp_head');
    // Really Simple Discovery (RSD) リンクを削除
    remove_action('wp_head', 'rsd_link');
    // Windows Live Writer マニフェストリンクを削除
    remove_action('wp_head', 'wlwmanifest_link');
    // ショートリンク関連のリンクを削除（引数付きバージョン）
    remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
    // フィードリンクを削除
    remove_action('wp_head', 'feed_links', 2);
    remove_action('wp_head', 'feed_links_extra', 3);
    // インデックスリンクを削除
    remove_action('wp_head', 'index_rel_link');
    // 開始投稿リンクを削除
    remove_action('wp_head', 'start_post_rel_link', 10, 0);
    // 親投稿リンクを削除
    remove_action('wp_head', 'parent_post_rel_link', 10, 0);
    // 隣接投稿リンクを削除
    remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
    // 隣接投稿リンクを削除（引数付きバージョン）
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');
    // リソースヒントを削除
    remove_action('wp_head', 'wp_resource_hints', 2);
    // カノニカルリンクを削除
    remove_action('wp_head', 'rel_canonical');
    // 絵文字関連のスクリプトを削除
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    // 絵文字関連のスタイルを削除
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
}
add_action('init', 'removeHeadAction');

function removeJsonAction() {
    // REST API関連のリンクを削除
    remove_action('wp_head', 'rest_output_link_wp_head', 10);
    // oEmbedディスカバリーリンクを削除
    remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
    // REST APIのoEmbedルートを登録するアクションを削除
    remove_action('rest_api_init', 'wp_oembed_register_route');
    // oEmbedディスカバリーを無効化するフィルターを追加
    add_filter('embed_oembed_discover', '__return_false');
    // oEmbedデータのパースアクションを削除
    remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
    // oEmbedのホストJavaScriptを追加するアクションを削除
    remove_action('wp_head', 'wp_oembed_add_host_js');
}
add_action('after_setup_theme', 'removeJsonAction');

/**
 * 管理画面以外でjQueryを呼び出さない
 */
function disableJquery() {
    if (!is_admin()) {
        wp_deregister_script('jquery');
    }
}
add_action('wp_enqueue_scripts', 'disableJquery');

/**
 * 投稿者アーカイブによるユーザー名（ログインID）の露呈防止
 * https://ドメイン/?author=1
 */
function disableAuthorArchiveQuery() {
    if( preg_match('/author=([0-9]*)/i', $_SERVER['QUERY_STRING'])){
        wp_redirect(home_url());
        exit;
    }
}
add_action('init', 'disableAuthorArchiveQuery');

/**
 * WP REST APIからのユーザー名露呈防止
 * https://ドメイン/wp-json/wp/v2/users
 */
function filterRestEndpoints($endpoints) {
    if (isset($endpoints['/wp/v2/users'])) {
        unset($endpoints['/wp/v2/users']);
    }
    if (isset($endpoints['/wp/v2/users/(?P<id>[\d]+)'])) {
        unset($endpoints['/wp/v2/users/(?P<id>[\d]+)']);
    }
    return $endpoints;
}
add_filter('rest_endpoints', 'filterRestEndpoints', 10, 1);

/**
 * pingback機能の停止
 */
function disableSelfPingback(&$links) {
	$home = get_option('home');
	foreach($links as $l => $link) {
        if(0 === strpos($link, $home)) {
            unset($links[$l]);
        }
    }
}
add_action('pre_ping', 'disableSelfPingback');

/**
 * 不要なcssの削除
 */
function removeDefaultBlockLibraryStyle() {
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('dashicons');
    wp_dequeue_style('global-styles');
}
add_action ('wp_enqueue_scripts', 'removeDefaultBlockLibraryStyle');

/**
 * 不要なinline-css停止
 */
function removeCoreBlockSupports() {
    wp_dequeue_style('core-block-supports');
}
add_action('wp_footer', 'removeCoreBlockSupports');

/**
 * リライトルールをリフレッシュ
 */
function flushRules(){
    global $wp_rewrite;
    $wp_rewrite->flush_rules();
}
add_filter('init', 'flushRules');

/**
 * URLの自動補完リダイレクト停止
 */
add_filter('do_redirect_guess_404_permalink', '__return_false');

/**
 * 旧スラッグからの自動補完りダイレクト停止
 */
remove_action('template_redirect', 'wp_old_slug_redirect');
