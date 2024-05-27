<!-- CREATION TYPE DE CONTENU PERSONNALISE -->

<?php
get_header();

// Start the Loop
while (have_posts()) : the_post();
    // Récupération des champs personnalisés
    $reference = get_field('reference');
    $type = get_field('type');
    $year = get_field('annee');
    $image = get_field('image');
    $post_id = get_the_ID();

    // Affichage des informations de la photo
    echo '<section class="section_photo">';
    echo '<div class="description_photo">';
    echo '<h1>' . get_the_title() . '</h1>';
    if ($reference) {
        echo '<p>Référence : ' . esc_html($reference) . '</p>';
    }
    if ($type) {
        echo '<p>Type : ' . esc_html($type) . '</p>';
    }
    $format_terms = get_the_terms(get_the_ID(), 'format');
    if (!empty($format_terms) && !is_wp_error($format_terms)) {
        foreach ($format_terms as $term) {
            echo '<p>Format : ' . esc_html($term->name) . '</p>';
        }
    }
    $categorie_terms = get_the_terms(get_the_ID(), 'categorie');
    if (!empty($categorie_terms) && !is_wp_error($categorie_terms)) {
        foreach ($categorie_terms as $term) {
            echo '<p>Catégorie : ' . esc_html($term->name) . '</p>';
        }
    }
    if ($year) {
        echo '<p>Année : ' . esc_html($year) . '</p>';
    }
    echo '</div>';
    if ($image) {
        echo '<div class="photo-image">';
        echo '<img src="' . esc_url($image['url']) . '" alt="' . get_the_title() . '" class="photo-block-image">';
        echo '</div>';
    }
    echo '</section>';

    // Section navigation
    echo '<section class="section_navigation">';
    echo '<div class="contact_photo">';
    echo '<p>Cette photo vous intéresse ?</p>';
    echo '<button id="contactButton" class="hover_button open-contact-modal" data-reference="' . esc_attr($reference) . '">Contact</button>';
    echo '</div>';
    echo '<div id="myModal" class="modal">';
    echo do_shortcode('[contact-form-7 id="04bac1f" title="Formulaire de contact 1"]');
    echo '</div>';

    // partie photo miniature
    echo '<div class="navigation_photo">';
    $prev_post = get_previous_post();
    $next_post = get_next_post();
    if (!empty($prev_post)) {
        $prev_photo_id = $prev_post->ID;
        echo '<a href="' . get_permalink($prev_photo_id) . '" class="prev-photo-link" title="Photo précédente" data-thumb="' . get_the_post_thumbnail_url($prev_photo_id, 'thumbnail') . '">';
        echo '<img src="' . get_template_directory_uri() . '/assets/images/arrow-left.png" alt="Flèche gauche">';
        
        echo '<div class="thumbnail-preview">' . wp_get_attachment_image($prev_photo_id, 'thumbnail') . '</div>';
        echo '</a>';
    }
    if (!empty($next_post)) {
        $next_photo_id = $next_post->ID;
        echo '<a href="' . get_permalink($next_photo_id) . '" class="next-photo-link" title="Photo suivante" data-thumb="' . get_the_post_thumbnail_url($next_photo_id, 'thumbnail') . '">';
        echo '<img src="' . get_template_directory_uri() . '/assets/images/arrow-right.png" alt="Flèche droite">';
        
        echo '<div class="thumbnail-preview">' . wp_get_attachment_image($next_photo_id, 'thumbnail') . '</div>';
        echo '</a>';
    }
    echo '</div>';
    echo '</section>';

    // Photos apparentées
    echo '<section class="related-photos">';
    echo '<div class="photo-block">';
    echo '<div class="titre">';
    echo '<p>VOUS AIMEREZ AUSSI</p>';
    echo '</div>';
    echo '<div id="image-container" class="row gallery">';

    // Récupération des catégories et des formats
    $categorie_terms = get_the_terms(get_the_ID(), 'categorie');
    if (!empty($categorie_terms) && !is_wp_error($categorie_terms)) {
        $categories = wp_list_pluck($categorie_terms, 'slug');
    } else {
        $categories = array('mariage', 'concert', 'television', 'reception'); // Valeur par défaut si aucune catégorie n'est trouvée
    }

    $format_terms = get_the_terms(get_the_ID(), 'format');
    if (!empty($format_terms) && !is_wp_error($format_terms)) {
        $formats = wp_list_pluck($format_terms, 'slug');
    } else {
        $formats = array('portrait', 'paysage'); // Valeur par défaut si aucun format n'est trouvé
    }

    $query = new WP_Query([
        'post_type' => 'photographie',
        'posts_per_page' => '8',
        'order' => 'DESC',
        'orderby' => 'date',
        'post_status' => 'publish',
        'tax_query' => [
            'relation' => 'AND',
            [
                'taxonomy' => 'categorie',
                'field' => 'slug',
                'terms' => $categories,
            ],
            [
                'taxonomy' => 'format',
                'field' => 'slug',
                'terms' => $formats,
            ]
        ]
    ]);

    while ($query->have_posts()) : $query->the_post();
        get_template_part('template_parts/photo_block');
    endwhile;

    wp_reset_postdata();

    echo '</div>'; // Fermeture de la div #image-container

    // Bouton "Charger plus"
    echo '<div id="load-more" class="load-more">';
    echo '<a href="#" class="load-more-button" data-post-id="' . esc_attr($post_id) . '">Charger plus</a>';
    echo '</div>';

    echo '</div>'; // Fermeture de la div .photo-block
    echo '</section>'; // Fermeture de la section .related-photos

endwhile;

wp_reset_postdata();

get_footer();
?>