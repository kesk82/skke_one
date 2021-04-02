<?php

function skke_log($obj) {
  $o = "";
  ob_start();
  var_dump($obj);
  $o = ob_get_contents();
  ob_end_clean();
  error_log($o);
}

// =============================================================================
// Aktiviere die notwendigen Themen Features die wir planen zu benutzen:
// =============================================================================
add_action( 'after_setup_theme', function() {
  add_theme_support('post-formats', array('aside', 'link', 'quote', 'video'));
  add_theme_support('post-thumbnails');
});

function skke_get_last_update_date() {
  $args = array(
    'numberposts' => 1,
    'fields' => 'ids'
  );

  if (is_category()) {
    $args['category'] = get_queried_object()->term_id;
  }

  $newst_posts = get_posts($args);

  return get_the_modified_date('', $newst_posts[0]);
}

function print_last_update_text() {
  $this_page_last_update = apply_filters('skke_current_post_last_update', false);

  if ($this_page_last_update) {
    echo '<p>Dieser beitrag wurde zuletzt am ' . $this_page_last_update . ' aktualisiert.</p>';
  } else {
    echo '<p>Die Seite wurde zuletzt am ' . skke_get_last_update_date() . ' aktualisiert.</p>';
  }
}

add_action('wp', function() {

  if (is_singular()) {
    add_filter('skke_current_post_last_update', function() {
      global $post;

      return get_the_modified_date('', $post->ID);
    });
  }
});

add_action('skke_footer_hook', function() {
  print_last_update_text();
});

// =============================================================================
// Um nicht standardisierte Query Parameter mit get_query_var() lesen zu koennen
// muessen diese in $qvars gelistet werden:
// =============================================================================

function skke_query_vars( $qvars ) {
  $qvars[] = 'seite';
  return $qvars;
}
add_filter( 'query_vars', 'skke_query_vars' );

// =============================================================================
// Disable searching.
// =============================================================================
add_action('pre_get_posts', function($query) {
  if ($query->is_search) {
    wp_redirect(site_url());
    die();
  }
});

// =============================================================================
// Komentar Author Links deaktivieren:
// =============================================================================
add_filter('get_comment_author_link', function($link, $author, $comment_ID) {
  return $author;
}, 3, 10);

add_filter('comment_form_default_fields', function($fields) {
  unset($fields["url"]);
  $fields["cookies"] = '<p class="comment-form-cookies-consent"><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes" /> <label for="wp-comment-cookies-consent">Meinen Namen und meine meine E-Mail-Adresse in diesem Browser speichern, bis ich wieder kommentiere.</label></p>';
  return $fields;
});

function skke_print_cat_tree($cat, $seperator='&raquo;') {
  $o = "";

  $parent_categories = [];
  $current_cat = $cat;

  while ($current_cat->parent !== 0) {
    $parent_cat = get_category($current_cat->parent);
    $parent_categories[] = $parent_cat;
    $current_cat = $parent_cat;
  }

  foreach (array_reverse($parent_categories) as $current_cat) {
    $o .= '<a href="' . get_category_link($current_cat->term_id) . '">' . $current_cat->name . '</a>';
    $o .= " {$seperator} ";
  }

  return $o;
}

function skke_print_loop_item_cat_breadcrumb($seperator='&raquo;') {
  global $post;

  if ($post && 'post' == get_post_type()) {

    $o = '<div class="post-cat-breadcrumb">';
    if ('post' == get_post_type()) {
      $post_cats = get_the_category($post->ID);
     
      if (isset($post_cats[0])) {
        if ($post_cats[0]->parent !== 0) {
          $o .= skke_print_cat_tree($post_cats[0]);
        }
        $o .= '<a href="' . get_category_link($post_cats[0]->term_id) . '">' . $post_cats[0]->name . '</a>';
      }
    }
    $o .= '</div>';

    echo $o;
  }
}

function skke_print_breadcrumb($seperator='&raquo;') {
  global $post;

  $o = '<div class="breadcrumb">';

  $o .= '<a href="' . site_url() . '">Startseite</a>';
  $o .= " {$seperator} ";

  if (is_page()) {
    $o .= '<span><strong>' . get_the_title() . '</strong></span>';
  }

  elseif ((is_single()) && 'post' == get_post_type()) {
    $post_cats = get_the_category($post->ID);
   
    if (isset($post_cats[0])) {
      if ($post_cats[0]->parent !== 0) {
        $o .= skke_print_cat_tree($post_cats[0]);
      }
      $o .= '<a href="' . get_category_link($post_cats[0]->term_id) . '">' . $post_cats[0]->name . '</a>';
      $o .= " {$seperator} ";
    }
    $o .= '<span><strong>' . get_the_title() . '</strong></span>';
  }

  elseif (is_category()) {
    $category = get_queried_object();

    if ($category->parent !== 0) {
      $o .= skke_print_cat_tree($category);
    }

    $o .= '<span><strong>' . $category->name . '</strong></span>';
  }

  $o .= '</div>';

  echo $o;
}

add_filter('the_content_more_link', function($link) {
  return '<div class="more-link-container">' . $link . '</div>';
});

/**
 * Filter the "read more" excerpt string link to the post.
 *
 * @param string $more "Read more" excerpt string.
 * @return string (Maybe) modified "read more" excerpt string.
 */
function wpdocs_excerpt_more( $more ) {
  if ( ! is_single() ) {
      $more = sprintf( '<div class="read-more-container"><a class="read-more" href="%1$s">%2$s</a></div>',
          get_permalink( get_the_ID() ),
          'Alles lesen'
      );
  }

  return $more;
}
add_filter( 'excerpt_more', 'wpdocs_excerpt_more' );