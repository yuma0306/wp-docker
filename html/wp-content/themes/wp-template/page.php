<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WordPressテンプレート</title>
    <?php wp_head(); ?>
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri() . '/gutenberg/gutenberg.css'; ?>">
</head>
<body>
    <h1>
        <?php the_title(); ?>
    </h1>
    <?php the_content(); ?>
    <?php wp_footer(); ?>
</body>
</html>