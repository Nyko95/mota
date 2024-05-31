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


function mota_enqueue_scripts() {
    wp_enqueue_script('load-more-photos', get_template_directory_uri() . '/js/load-more-photos.js', array('jquery'), null, true);

    wp_localize_script('load-more-photos', 'mota_params', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'mota_enqueue_scripts');

function load_more_photos() {
    // Validation des entrées POST
    $paged = isset($_POST['page']) ? intval($_POST['page']) : 2;
    $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;

    // Vérification que les valeurs POST sont valides
    if ($paged < 1 || $post_id < 1) {
        wp_send_json_error('Invalid POST data');
    }

    $formats = wp_get_post_terms($post_id, 'format');
    $format_ids = wp_list_pluck($formats, 'term_id');

    $related_args = array(
        'post_type' => 'photographie',
        'tax_query' => array(
            array(
                'taxonomy' => 'format',
                'field' => 'id',
                'terms' => $format_ids,
            ),
        ),
        'post__not_in' => array($post_id),
        'posts_per_page' => 2,
        'paged' => $paged,
    );

    $related_query = new WP_Query($related_args);

    // Vérification si la requête est réussie
    if ($related_query->have_posts()) {
        while ($related_query->have_posts()) {
            $related_query->the_post();
            $related_image = get_field('image');
            $related_title = get_the_title();
            $related_url = esc_url(get_permalink());

            // Inclure le template photo_block.php
            set_query_var('image_url', $related_image['url']);
            set_query_var('image_title', $related_title);
            set_query_var('photo_url', $related_url);
            get_template_part('template-parts/photo_block');
        }
    } else {
        // Si la requête ne renvoie aucun résultat, retourner un message d'erreur
        wp_send_json_error('No more photos found');
    }

    // Nettoyage des variables après utilisation
    wp_reset_postdata();
    wp_die();
}
add_action('wp_ajax_load_more_photos', 'load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');