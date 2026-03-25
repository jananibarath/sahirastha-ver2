<?php
get_header();
if (have_posts()) {
  while (have_posts()) {
    the_post();
    echo '<article class="sahirastha-service-page">';
    the_title('<h1>', '</h1>');
    the_content();
    echo '</article>';
  }
}
get_footer();
