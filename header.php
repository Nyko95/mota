<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Photographe Event</title>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="site-header">
    <div class="container">
        <div class="site-logo">
            <a href="<?php echo esc_url(home_url('/')); ?>">
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/Logo.png" alt="Logo">
            </a>
        </div>
        
        <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
            <div class="menu-toggle-icon">
                <span class="line"></span>
                <span class="line"></span>
                <span class="line"></span>
            </div>
        </button>
        <nav id="primary-menu" class="main-navigation">
        <ul>
                <li><a href="<?php echo esc_url(home_url('/')); ?>">Accueil</a></li>
               
            </ul>
            <?php
            wp_nav_menu(array(
                'theme_location' => 'menu-principal',
                'menu_id' => 'primary-menu',
            ));
            ?>
        </nav>
    </div>
</header>
<?php wp_footer(); ?>
</body>
</html>