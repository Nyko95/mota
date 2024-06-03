<?php
// Récupère une image aléatoire du type de post 'photographie' avec des arguments de la requete
$query = new WP_Query(array(
    'post_type' => 'photographie',
    'posts_per_page' => 1,
    'orderby' => 'rand',
    'tax_query' => array(
        array(
            'taxonomy' => 'format', //Pour filtrer et afficher uniquement les images avec le format "paysage"
            'field' => 'slug',
            'terms' => 'paysage' 
        )
    )
));

if ($query->have_posts()) :
    while ($query->have_posts()) : $query->the_post();
        $image = get_field('image'); // Utilise ACF pour obtenir le champ personnalisé 'image'
        if ($image) {
            $background_image = esc_url($image['url']);
        } else {
            // Fallback image URL
            $background_image = get_template_directory_uri() . '/assets/images/image-background.jpg';
        }
    endwhile;
    wp_reset_postdata();
endif;
?>

<div class="hero-header" style="background-image: url('<?php echo $background_image; ?>');">
    <div class="overlay-image">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/hero.png" alt="Hero Overlay">
    </div>
</div>