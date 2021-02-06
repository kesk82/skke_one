<?php

get_header();

/*
 * Der Inhalt der Seite mit dem slug 'startseite' wird hier ausgegeben.
 * 
 * */
$pages = get_posts(array(
  'fields' => 'ids',
  'post_type' => 'page',
  'name' => 'startseite',
  'posts_per_page' => 1,
  'paged' => 1
));

$current_page = intval(get_query_var('paged'));

if ($current_page < 2 && isset($pages[0])) {
  $start_page = get_post($pages[0]);
  echo '<article class="startseite-content">';
  echo apply_filters( 'the_content', $start_page->post_content );
  echo '</article>';
}

$child_categories = get_terms(array(
  'taxonomy' => 'category',
  'hide_empty' => true,
  'parent' => 0
));

if (is_array($child_categories) && count($child_categories) > 0) {
  echo '<nav class="child-categories">';
  foreach ($child_categories as $child_category) {
    echo '<div>';
    echo '<a href="' . get_category_link($child_category->term_id)  . '">' . $child_category->name . '</a>';
    echo '</div>';
  }
  echo '</nav>';
}

?>
<div class="artikel-liste">
<?php
while (have_posts()) {
  the_post();
  $post_cats = get_the_category(); ?>
  
  <article id="post-<?php echo get_the_ID(); ?>" <?php post_class('artikel'); ?>>
  <h2 class="artikel-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

  <?php the_content('alles lesen ...'); ?>
  </article>
  
  <?php } // while have_posts()

?>
</div>

<div class="nav-previous alignleft"><?php next_posts_link( '&laquo; Older posts' ); ?></div>
<div class="nav-next alignright"><?php previous_posts_link( 'Newer posts &raquo;' ); ?></div>

<?php

get_footer();
