<?php

$current_category = get_queried_object();
$posts_per_page = 10;

get_header();

echo '<nav>';
skke_print_breadcrumb();
echo '</nav>';

$child_categories = get_terms(array(
  'taxonomy' => 'category',
  'hide_empty' => true,
  'parent' => $current_category->term_id
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

$current_page = intval(get_query_var('seite', 1));

$args = array(
  'cat' => $current_category->term_id,
  'posts_per_page' => $posts_per_page,
  'paged' => $current_page
);

$the_query = new WP_Query( $args );
$max_pages = $the_query->max_num_pages;

while ($the_query->have_posts()) {
  $the_query->the_post();
  
  $post_cats = get_the_category();
  $imgID = get_post_thumbnail_id($post->ID);
  ?>
  
  <?php if($imgID) { ?>
    <div class="artikel-bild"><?php echo get_the_post_thumbnail(); ?></div>
  <?php } ?>
  <article id="post-<?php echo get_the_ID(); ?>" <?php post_class('artikel'); ?>>
  <h2 class="artikel-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

  <?php the_content('alles lesen ...'); ?>
  </article>
  <div class="artikel-meta">
    <?php if($imgID) { ?>
      <div class="artikel-bild-unten"><?php echo get_the_post_thumbnail(); ?></div>
    <?php } ?>
    <div class="artikel-meta-inhalt"><?php skke_print_loop_item_cat_breadcrumb(); ?></div>
  </div>
  
<?php } // while have_posts()

if ($current_page < $max_pages) {
  $next_page = $current_page + 1;
  echo '<div class="nav-previous alignleft">';
  echo '<a href="' . add_query_arg( 'seite', $next_page, get_category_link($current_category->term_id)) . '">&laquo; Ältere Beiträge</a>';
  echo '</div>';
}

if ($current_page > 1) {
  $prev_page = $current_page - 1;
  echo '<div class="nav-next alignright">';
  echo '<a href="' . add_query_arg( 'seite', $prev_page, get_category_link($current_category->term_id)) . '">Neuere Beiträge &raquo;</a>';
  echo '</div>';
}

get_footer();
