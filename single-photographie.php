<!-- CREATION TYPE DE CONTENU PERSONNALISE -->

<?php
get_header();

// Start the Loop
while (have_posts()) :
    the_post();
    // Récupération des champs personnalisés
    $reference = get_field('reference');
    $type = get_field('type');
    $year = get_field('annee');
    $image = get_field('image');

    // J'ouvre une section pour la photo avec une classe "section_photo".
    echo '<section class="section_photo">';
    // J'ouvre une div pour la description de la photo avec une classe "description_photo".
    echo '<div class="description_photo">';
    // J'affiche le titre de la photo.
    echo '<h1>' . get_the_title() . '</h1>';
    // Je récupère et affiche la référence de la photo.
    if ($reference) {
        echo '<p>Référence : ' . esc_html($reference) . '</p>';
    }
    // Je récupère et affiche le type de la photo.
    if ($type) {
        echo '<p>Type : ' . esc_html($type) . '</p>';
    }
    // Je récupère les termes de la taxonomie "format" et les affiche.
    $format_terms = get_the_terms(get_the_ID(), 'format');
    if (!empty($format_terms) && !is_wp_error($format_terms)) {
        foreach ($format_terms as $term) {
            echo '<p>Format : ' . esc_html($term->name) . '</p>';
        }
    }
    // Je récupère les termes de la taxonomie "categorie" et les affiche.
    $categorie_terms = get_the_terms(get_the_ID(), 'categorie');
    if (!empty($categorie_terms) && !is_wp_error($categorie_terms)) {
        foreach ($categorie_terms as $term) {
            echo '<p>Catégorie : ' . esc_html($term->name) . '</p>';
        }
    }
    // Je récupère et affiche l'année.
    if ($year) {
        echo '<p>Année : ' . esc_html($year) . '</p>';
    }
    // Je ferme la div "description_photo".
    echo '</div>';
    // J'affiche la photo dans une div avec une classe "single_photo".
    if ($image) {
        echo '<div class="photo-image">';
        echo wp_get_attachment_image($image, 'full', false, array('style' => 'object-fit: contain;width:100%;height:100%'));
        echo '</div>';
    }
    // Je ferme la section "section_photo".
    echo '</section>';

    // J'ouvre une section pour la navigation avec une classe "section_navigation".
    echo '<section class="section_navigation">';
    // J'intègre le bouton de contact avec la modal.
    echo '<div class="contact_photo">
    <p>Cette photo vous intéresse ?</p>
    <button id="contactButton" class="hover_button open-contact-modal" data-reference="' . esc_attr($reference) . '">Contact</button>
</div>';
    // J'ajoute la modal.
    echo '<div id="myModal" class="modal">';
    echo do_shortcode('[contact-form-7 id="04bac1f" title="Formulaire de contact 1"]');
    echo '</div>';
    // J'ouvre une div pour la navigation de la photo avec une classe "navigation_photo".
    echo '<div class="navigation_photo">';
    // Je récupère le post précédent et le post suivant.
    $prev_post = get_previous_post();
    $next_post = get_next_post();
    // Si le post précédent existe, j'affiche un lien vers lui avec une flèche gauche.
    if (!empty($prev_post)) {
        $prev_photo_id = $prev_post->ID;
        echo '<a href="' . get_permalink($prev_photo_id) . '" class="prev-photo-link" title="Photo précédente" data-thumb="' . get_the_post_thumbnail_url($prev_photo_id, 'thumbnail') . '">';
        echo '<img src="' . get_template_directory_uri() . './assets/images/arrow-left.png" alt="Flèche gauche">';
        echo '<div class="thumbnail"></div>';
        echo '</a>';
    }
    // Si le post suivant existe, j'affiche un lien vers lui avec une flèche droite.
    if (!empty($next_post)) {
        $next_photo_id = $next_post->ID;
        echo '<a href="' . get_permalink($next_photo_id) . '" class="next-photo-link" title="Photo suivante" data-thumb="' . get_the_post_thumbnail_url($next_photo_id, 'thumbnail') . '">';
        echo '<img src="' . get_template_directory_uri() . './assets/images/arrow-right.png" alt="Flèche droite">';
        echo '<div class="thumbnail"></div>';
        echo '</a>';
    }
    // Je ferme la div "navigation_photo".
    echo '</div>';
    // Je ferme la section "section_navigation".
    echo '</section>';
// Je termine la boucle.
endwhile;

// Section photos apparentées
$photos = null; // Initialisation de la variable
$categories_terms = get_the_terms(get_the_ID(), 'categories');
if (!empty($categories_terms) && !is_wp_error($categories_terms)) {
    $term_ids = array_map(function ($term) {
        return $term->term_id;
    }, $categories_terms);
    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 2,
        'orderby' => 'rand',
        'post__not_in' => array(get_the_ID()),
        'tax_query' => array(
            array(
                'taxonomy' => 'categories',
                'field'    => 'term_id',
                'terms'    => $term_ids,
            ),
        ),
    );
    $photos = new WP_Query($args);
}
if ($photos && $photos->have_posts()) {
    echo '<section class="section_suggestion">';
    echo '<h2>Vous aimerez aussi :</h2>';
    echo '<div class="block_photo">';
    while ($photos->have_posts()) {
        $photos->the_post();
        get_template_part('template-parts/photo_block');
    }
    wp_reset_postdata();
    echo '</div>';
    echo '</section>';
}

// J'inclus le pied de page de la page.
get_footer();
?>