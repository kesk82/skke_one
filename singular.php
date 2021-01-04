<?php
    get_header();
?>

<main>

<?php

while (have_posts()) {
    the_post(); ?>
  
    <article>
    <h2><?php the_title(); ?></h2>
  
    <div><?php the_content(); ?></div>
    </article>
  
  <?php } // while have_posts()

?>

</main>

<?php
    get_footer();
