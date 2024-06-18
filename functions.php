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

// Fonction pour charger les styles CSS générés à partir de Sass
function mota_custom_styles()
{
    // Déclarer le fichier CSS généré à partir de Sass
    wp_enqueue_style(
        'mota-custom-css',
        get_template_directory_uri() . '/sass/style.css', 
        array(),
        '1.0'
    );
}
add_action('wp_enqueue_scripts', 'mota_custom_styles');



function mota_enqueue_scripts() {
    wp_enqueue_script('load-more-photos', get_template_directory_uri() . '/js/load-more-photos.js', array('jquery'), null, true);

    wp_localize_script('load-more-photos', 'mota_params', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'mota_enqueue_scripts');


//REQUETE AJAX pour charger les photos"

function load_more_photos() {
    // Validation des entrées POST
    $paged = isset($_POST['page']) ? intval($_POST['page']) : 2;
    $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;

    // Vérification que les valeurs POST sont valides
    if ($paged < 1 || $post_id < 1) {
        wp_send_json_error('Invalid POST data');
    }

    // Récupération des formats
    $formats = wp_get_post_terms($post_id, 'format');
    $format_ids = wp_list_pluck($formats, 'term_id');

    // Récupération des catégories
    $categories = wp_get_post_terms($post_id, 'categorie');
    $category_ids = wp_list_pluck($categories, 'term_id');

    // Arguments de la requête
    $related_args = array(
        'post_type' => 'photographie',
        'tax_query' => array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'format',
                'field' => 'id',
                'terms' => $format_ids,
            ),
            array(
                'taxonomy' => 'categorie',
                'field' => 'id',
                'terms' => $category_ids,
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
            get_template_part('template_parts/photo_block');
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

//Ajout de la bibliotheque JS "Select2" à partir d'un CDN (réseau de diffusion de contenu)
function mota_enqueue_select2() {
    wp_enqueue_style('select2-css', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css');
    wp_enqueue_script('select2-js', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'mota_enqueue_select2');


function filter_photos() {
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
    $format = isset($_POST['format']) ? sanitize_text_field($_POST['format']) : '';
    $order = isset($_POST['order']) ? sanitize_text_field($_POST['order']) : 'DESC';
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;

    error_log("Received filters: category=$category, format=$format, order=$order, page=$page");

    $args = array(
        'post_type' => 'photographie',
        'posts_per_page' => 8,
        'orderby' => 'date',
        'order' => $order,
        'paged' => $page,
    );

    $tax_query = array();

    if ($category) {
        error_log("Applying category filter: $category");
        $tax_query[] = array(
            'taxonomy' => 'categorie',
            'field'    => 'slug',
            'terms'    => $category,
        );
    }

    if ($format) {
        error_log("Applying format filter: $format");
        $tax_query[] = array(
            'taxonomy' => 'format',
            'field'    => 'slug',
            'terms'    => $format,
        );
    }

    if (!empty($tax_query)) {
        $args['tax_query'] = $tax_query;
    }

    // Débogage des arguments de requête
    error_log(print_r($args, true));

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        ob_start();
        while ($query->have_posts()) {
            $query->the_post();
            get_template_part('template_parts/photo_block'); 
        }
        $photos = ob_get_clean();
        wp_send_json_success($photos);
    } else {
        wp_send_json_error('No photos found');
    }
    wp_die();
}

add_action('wp_ajax_filter_photos', 'filter_photos');
add_action('wp_ajax_nopriv_filter_photos', 'filter_photos');


function enqueue_lightbox_assets() {
    // Enqueue le style principal de votre thème
    wp_enqueue_style('main-style', get_stylesheet_uri());

    // Enqueue le fichier lightbox.js
    wp_enqueue_script(
        'lightbox-script',
        get_template_directory_uri() . '/js/lightbox.js',
        array('jquery'), 
        null, 
        true // Charger dans le footer
    );
}
add_action('wp_enqueue_scripts', 'enqueue_lightbox_assets');