<?php
// Fonction pour ajouter le support des menus
function mota_setup() {
    // Active la gestion des menus dans l'interface d'administration WordPress
    register_nav_menus(array(
        'menu-principal' => __('Menu Principal', 'mota'),
    ));
}
add_action('after_setup_theme', 'mota_setup');

// Fonction pour ajouter les scripts et styles CSS
function mota_scripts() {
    // Ajoute le fichier style.css de votre thème
    wp_enqueue_style('mota-style', get_stylesheet_uri());

    // Ajoute le fichier script.js de votre thème
    wp_enqueue_script('mota-script', get_template_directory_uri() . '/js/script.js', array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'mota_scripts');