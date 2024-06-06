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

    // Partie photo miniature
    echo '<div class="navigation_photo">';

    $prev_post = get_previous_post();
    $next_post = get_next_post();

    if (!empty($prev_post)) {
        $prev_photo_id = $prev_post->ID;
        $prev_thumb_url = get_field('thumbnail_image', $prev_photo_id);
        if ($prev_thumb_url) {
            echo '<a href="' . get_permalink($prev_photo_id) . '" class="prev-photo-link" title="Photo précédente" data-thumb="' . esc_url($prev_thumb_url) . '">';
            echo '<img src="' . get_template_directory_uri() . '/assets/images/arrow-left.png" alt="Flèche gauche">';
            echo '<div class="thumbnail-preview"><img src="' . esc_url($prev_thumb_url) . '" alt="Miniature"></div>';
            echo '</a>';
        } else {
            echo '<div class="prev-photo-link no-thumbnail">Aucune miniature disponible pour la photo précédente</div>';
        }
    }

    if (!empty($next_post)) {
        $next_photo_id = $next_post->ID;
        $next_thumb_url = get_field('thumbnail_image', $next_photo_id);
        if ($next_thumb_url) {
            echo '<a href="' . get_permalink($next_photo_id) . '" class="next-photo-link" title="Photo suivante" data-thumb="' . esc_url($next_thumb_url) . '">';
            echo '<img src="' . get_template_directory_uri() . '/assets/images/arrow-right.png" alt="Flèche droite">';
            echo '<div class="thumbnail-preview"><img src="' . esc_url($next_thumb_url) . '" alt="Miniature"></div>';
            echo '</a>';
        } else {
            echo '<div class="next-photo-link no-thumbnail">Aucune miniature disponible pour la photo suivante</div>';
        }
    }

    echo '</div>';
    echo '</section>';

 // Photos apparentées
 $categorie_terms = get_the_terms(get_the_ID(), 'categorie');
 if (!empty($categorie_terms) && !is_wp_error($categorie_terms)) {
     $term_ids = wp_list_pluck($categorie_terms, 'term_id');

     $args = [
         'post_type' => 'photographie',
         'posts_per_page' => 2,
         'orderby' => 'rand',
         'post__not_in' => [$post_id],
         'tax_query' => [
             [
                 'taxonomy' => 'categorie',
                 'field' => 'term_id',
                 'terms' => $term_ids,
             ],
         ],
     ];

     $photos = new WP_Query($args);
     //echo "<pre>";
     //var_dump($photos);
     //echo "</pre>";
 }

 if ($photos && $photos->have_posts()) {
     echo '<section class="section_suggestion">';
     echo '<h2>Vous aimerez aussi :</h2>';
     echo '<div class="photo-block">';
     while ($photos->have_posts()) {
         $photos->the_post();
         get_template_part('template_parts/photo_block');
     }
     wp_reset_postdata();
     echo '</div>';
     echo '</section>';
 }

endwhile;



get_footer();
?>