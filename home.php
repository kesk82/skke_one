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

?>
<div class="artikel-liste">
<?php
while (have_posts()) {
  the_post();
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
    <div class="artikel-meta-inhalt"><?php skke_print_loop_item_cat_breadcrumb(); ?> <div class="post-date"><?php echo get_the_date(); ?></div></div>
  </div>
  
  <?php } // while have_posts()

?>
</div>

<div class="nav-previous alignleft"><?php next_posts_link( '&laquo; Ältere Beiträge' ); ?></div>
<div class="nav-next alignright"><?php previous_posts_link( 'Neuere Beiträge &raquo;' ); ?></div>

<?php

get_footer();
