<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/main.css?<?php echo time(); ?>">
</head>
<body>
  <header>
    <h1><a href="<?php echo site_url(); ?>">Start Seite</a></h1>
    <nav>
      <ul>
        <li class="nav-link<?php echo is_page('seite1') ? ' nav-link-current' : ''; ?>">
          <a href="<?php echo site_url("/seite1"); ?>">Seite 1</a>
        </li>
        <li class="nav-link<?php echo is_category('cat1') ? ' nav-link-current' : ''; ?>">
          <a href="<?php echo get_category_link(get_category_by_slug('cat1')); ?>">Category 1</a>
        </li>
      </ul>
    </nav>
  </header>
