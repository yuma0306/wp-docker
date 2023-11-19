<?php

add_action( 'init', 'addCustomPostType' );

function addCustomPostType() {
	register_post_type('reptile', [
		'label' => '爬虫類',
		'hierarchical' => false,
		'public' => true,
		'has_archive' => true,
		'rewrite' => [
			'with_front' => false,
			'slug' => 'reptile'
		],
		'supports' => [
			'title',
			'revisions',
		],
		'menu_position' => 5,
	]);

	register_post_type('zoo', [
		'label' => '動物園',
		'hierarchical' => false,
		'public' => true,
		'has_archive' => true,
		'rewrite' => [
			'with_front' => false,
			'slug' => 'zoo'
		],
		'supports' => [
			'title',
			'revisions',
		],
		'menu_position' => 5,
	]);

	register_post_type('exotic', [
		'label' => 'エキゾチック',
		'hierarchical' => false,
		'public' => true,
		'has_archive' => true,
		'rewrite' => [
			'with_front' => false,
			'slug' => 'exotic'
		],
		'supports' => [
			'title',
			'revisions',
		],
		'menu_position' => 5,
	]);

	register_post_type('shop', [
		'label' => 'ショップ',
		'hierarchical' => false,
		'public' => true,
		'has_archive' => true,
		'rewrite' => [
			'with_front' => false,
			'slug' => 'shop'
		],
		'supports' => [
			'title',
			'revisions',
		],
		'menu_position' => 5,
	]);

	register_post_type('cook', [
		'label' => '昆虫食',
		'hierarchical' => false,
		'public' => true,
		'has_archive' => true,
		'rewrite' => [
			'with_front' => false,
			'slug' => 'cook'
		],
		'supports' => [
			'title',
			'revisions',
		],
		'menu_position' => 5,
	]);

	register_post_type('trivia', [
		'label' => '動物雑学',
		'hierarchical' => false,
		'public' => true,
		'has_archive' => true,
		'rewrite' => [
			'with_front' => false,
			'slug' => 'trivia'
		],
		'supports' => [
			'title',
			'revisions',
		],
		'menu_position' => 5,
	]);
}
