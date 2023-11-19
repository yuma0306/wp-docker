<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WordPressテンプレート</title>
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/style.css">
    <?php wp_head(); ?>
</head>
<body>
    <?php get_template_part('include/header'); ?>
    <h1 style="color: white;">えいちわん</h1>
    <?php wp_footer(); ?>
</body>
</html>
