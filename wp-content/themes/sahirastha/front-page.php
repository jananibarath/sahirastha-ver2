<?php get_header(); ?>
<div class="container content-wrap">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <article <?php post_class('entry front-entry'); ?>>
            <?php the_content(); ?>
        </article>
    <?php endwhile; endif; ?>
</div>
<?php get_footer(); ?>
