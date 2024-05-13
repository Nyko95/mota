<?php
function mota_setup() {
    // Active la gestion des menus dans l'interface d'administration WordPress
    register_nav_menus(array(
        'menu-principal' => __('Menu Principal', 'mota'), // Pour le menu du header
        'menu-footer' => __('Menu Footer', 'mota'), // Pour le menu du footer
    ));
}
add_action('after_setup_theme', 'mota_setup');

// Fonction pour ajouter les scripts et styles CSS
function mota_scripts() {
    // Ajoute le fichier style.css de votre thème
    wp_enqueue_style('mota-style', get_stylesheet_uri());

    // Ajoute le fichier scripts.js de votre thème
    wp_enqueue_script('mota-scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'mota_scripts');
?>