<!--BLOC D'AFFICHAGE PHOTO DE LA LISTE-->

<?php
// Récupère les catégories de la photo courante.
$categories = get_the_terms(get_the_ID(), 'categorie');

// Récupère la référence de la photo courante.
$reference = get_field('reference', get_the_ID());
if (!$reference) {
    $reference = get_field('référence', get_the_ID());
    if (!$reference) {
        $reference = get_field('reference', 'info_photographie_' . get_the_ID());
    }
}

// Récupère l'URL de la miniature de la photo courante.
$thumbnail_url = get_field('thumbnail_image', get_the_ID());
?>

<div class="photo">
    <?php if ($thumbnail_url) : ?>
        <img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
    <?php else : ?>
        <?php echo get_the_post_thumbnail(); ?>
    <?php endif; ?>

    <div class="hover_photo">
        <a href="<?php the_permalink(); ?>" class="eye-link">
            <img class="eye" src="<?php echo get_template_directory_uri(); ?>/assets/images/eye-icon.png" alt="icone oeil pour voir la photo">
        </a>

        <?php if (!empty($categories) && !is_wp_error($categories)) : ?>
            <?php foreach ($categories as $category) : ?>
                <span class="fullscreen-container" 
                      data-image-url="<?php echo esc_url($thumbnail_url); ?>" 
                      data-reference="<?php echo esc_attr($reference); ?>" 
                      data-category="<?php echo esc_attr($category->name); ?>">
                    <img class="fullscreen" src="<?php echo get_template_directory_uri(); ?>/assets/images/fullscreen-icon.png" alt="icon pour agrandir la photo">
                </span>
                <p class="categorie">Catégorie : <?php echo esc_html($category->name); ?></p>
            <?php endforeach; ?>
        <?php endif; ?>
        <p class="reference">Référence : <?php echo esc_attr($reference); ?></p>
    </div>
</div>