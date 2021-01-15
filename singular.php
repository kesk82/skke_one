<?php
  get_header();
?>

<?php

while (have_posts()) {
  the_post();
  $post_cats = get_the_category(); ?>

  <nav><?php skke_print_breadcrumb(); ?></nav>

  <article id="single-post-<?php echo get_the_ID(); ?>" <?php post_class('artikel-full'); ?>>
  <h1 class="artikel-title"><?php the_title(); ?></h1>

  <?php the_content(); ?>
  </article>
  
  <?php } // while have_posts()

  if ( comments_open() || get_comments_number() ) {
    comments_template();
  }

?>

<?php
  get_footer();
