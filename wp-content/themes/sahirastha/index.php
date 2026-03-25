<?php

declare(strict_types=1);

get_header();

if (have_posts()) {
    while (have_posts()) {
        the_post();
        ?>
        <article <?php post_class('page-content'); ?> id="post-<?php the_ID(); ?>">
            <h1><?php the_title(); ?></h1>
            <?php the_content(); ?>
        </article>
        <?php
    }
}

get_footer();
