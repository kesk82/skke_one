<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="description" content="...">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php wp_title('|', true,'right'); ?><?php bloginfo('name'); ?></title>
  <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/main.css?<?php echo time(); ?>">
</head>
<body <?php body_class(); ?>>
  <header id="main-header">
      <h1 class="page-title"><a href="<?php echo site_url(); ?>"><?php bloginfo('name'); ?></a></h1>
  </header>
  <main id="main-content">
    <div class="page-width">
