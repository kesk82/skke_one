<?php
  get_header();
?>

<?php

while (have_posts()) {
  the_post();
  $post_cats = get_the_category(); ?>
  
  <article id="post-<?php echo get_the_ID(); ?>" <?php post_class(); ?>>
  <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

  <?php the_content(); ?>
  </article>
  
  <?php } // while have_posts()

?>

  <div class="nav-previous alignleft"><?php next_posts_link( 'Older posts' ); ?></div>
  <div class="nav-next alignright"><?php previous_posts_link( 'Newer posts' ); ?></div>


<?php
  get_footer();
