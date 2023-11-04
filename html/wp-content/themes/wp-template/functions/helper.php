<?php

/**
 * デバック用関数
 */
function d() {
    echo '<pre style="background:#fff; color:#333; border:1px solid lightgray; margin:5px; padding:5px; font-size:12px; line-height:1.8;">';
    // 関数に渡された引数を一つずつvar_dumpする
    foreach(func_get_args() as $item) {
        var_dump($item);
    }
    echo '</pre>';
}

/**
 * パタメータを除いたルートパスを取得
 */
function getCurrentUri() {
    $uri = $_SERVER['REQUEST_URI'];
    if(strstr($uri, '?')) {
        $uri = strtok($uri, '?');
    }
    return $uri;
}

/**
 * 使用されているテンプレートを取得
 */
function getCurrentTemplate() {
    $template = get_page_template();
    $template = pathinfo($template, PATHINFO_FILENAME);
    return $template;
}

/**
 * 現在のディレクトリ（第一階層を取得）
 */
function getCurrentPath($uri) {
    $path = explode('/', trim($uri, '/'));
    return $path[0];
}

/**
 * 末尾のディレクトリを取得
 */
function getEndPath() {
    $uri = rtrim($_SERVER['REQUEST_URI'], '/');
    $uri = substr($uri, strrpos($uri, '/') + 1);
    if(strstr($uri, '?')) {
        $uri = strtok($uri, '?');
    }
    return $uri;
}

/**
 * 固定ページテンプレートのパンクズ表示
 */
function displayBreadcrumnbs() {
    if(get_post_type() === 'page') {
        global $post;
        $ancestorList = array_reverse(get_post_ancestors($post));
        echo '<ul class-"breadcrumb">' . "\n";
            echo '<li class-"breadcrumb__item"><a class-"breadcrumb__link" href="/">トップ</a></li>' . "\n";
            if($ancestorList) {
                foreach($ancestorList as $ancestorItem) {
                    if('publish' !== get_post_status($ancestorItem)) continue;
                    $ancestorLink = get_page_link($ancestorItem);
                    $ancestorTitle = get_post($ancestorItem)->post_title;
                    echo '<li class-"breadcrumb__item"><a class-"breadcrumb__link" href="'.$ancestorLink.'">'.$ancestorTitle.'</a></li>'."\n";
                }
            }
            echo '<li class-"breadcrumb__item"><span class-"breadcrumb__text">'.get_the_title().'</span></li>'."\n";
        echo '</ul>'."\n";
    }
}

/**
 * 固定ページテンプレートのパンクズ表示
 */
function createBreadcrumbsSchema () {
    $breadcrumbs = [];
    $breadcrumbs[] = [
        '@type' => 'ListItem',
        'position' => 1,
        'name' => 'トップ',
        'item' => get_home_url()
    ];
    if(is_page()) {
        $page = get_queried_object();
        $ancestors = get_ancestors($page->ID, 'page');
        $ancestors = array_reverse($ancestors);
        foreach($ancestors as $ancestorId) {
            $ancestorPage = get_post($ancestorId);
            $breadcrumbs[] = [
                '@type' => 'ListItem',
                'position' => count($breadcrumbs) + 1,
                'name' => $ancestorPage->post_title,
                'item' => get_permalink($ancestorPage)
            ];
        }
        // 現在の固定ページのリンクを追加
        $breadcrumbs[] = [
            '@type' => 'ListItem',
            'position' => count($breadcrumbs) + 1,
            'name' => $page->post_title,
            'item' => get_permalink($page)
        ];
    }
    echo json_encode([
        '@context' => 'http://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => $breadcrumbs
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}

/**
 * ページネーションカスタマイズ
 * https://developer.wordpress.org/reference/hooks/navigation_markup_template/
 * https://developer.wordpress.org/reference/functions/get_the_posts_pagination/
 */
function createPagenation(){
    $pager = [
        'class' => 'pagination',
        'mid_size' => 2,
        'prev_next' => true,
        'prev_text' => __('<span>戻る</span>'),
        'next_text' => __('<span>次へ</span>'),
    ];
    $replaceclasses - [
        '/<h2 class-"screen-reader-text">(.*)<\/h2>/' => '',
        '/<nav class-"navigation\s/' => '<nav class="',
        '/<div class-"nav-links"/' => '<div class="pagination__inner">',
        '<li>/' => '<li class="pagination__item">',
        '/class="page-numbers\scurrent"/' => 'class="pagination__number pagination__number--current"',
        '/class="next\spage-numbers"/' => 'class="pagination__btn pagination__btn--next"',
        '/class="prev\spage-numbers"/' => 'class="pagination__btn pagination__btn--prev"',
        '/class="page-numbers"/' => 'class="pagination__number"',
    ];
    foreach($replaceclasses as $pattern => $replacement) {
        $pager = preg_replace($pattern, $replacement, $pager);
    }
    echo $pager;
}
