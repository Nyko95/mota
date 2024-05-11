<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <!-- Début de l'en-tête du site -->
    <header class="site-header">
        <div class="container">
            <!-- Logo du site -->
            <div class="site-logo">
                <a href="<?php echo esc_url(home_url('/')); ?>">
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/Logo.png" alt="Logo">
                </a>
            </div>
            <!-- Menu principal -->
            <nav id="site-navigation" class="main-navigation">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'menu-principal', // Emplacement du menu défini dans functions.php
                    'menu_id' => 'primary-menu',
                ));
                ?>
            </nav><!-- #site-navigation -->
        </div><!-- .container -->
    </header><!-- .site-header -->