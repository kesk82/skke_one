<?php
  get_header();
?>

<main>

<?php

while (have_posts()) {
  the_post(); ?>
  
  <article>
  <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

  <div><?php the_content(); ?></div>
  </article>
  
  <?php } // while have_posts()

?>

</main>

<?php
  get_footer();
