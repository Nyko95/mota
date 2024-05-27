<!--BLOC D'AFFICHAGE PHOTO DE LA LISTE-->

<?php
// Récupération des champs personnalisés de la photo
$reference = get_field('reference');
$type = get_field('type');
$year = get_field('annee');
$image = get_field('image');
?>

<div class="photo-block">
    <h2><?php the_title(); ?></h2>
    <?php if ($reference) : ?>
        <p>Référence : <?php echo esc_html($reference); ?></p>
    <?php endif; ?>
    <?php if ($type) : ?>
        <p>Type : <?php echo esc_html($type); ?></p>
    <?php endif; ?>
    <?php if ($year) : ?>
        <p>Année : <?php echo esc_html($year); ?></p>
    <?php endif; ?>
    <?php if ($image) : ?>
        <div class="photo-thumbnail">
            <img src="<?php echo esc_url($image['url']); ?>" alt="<?php the_title(); ?>">
        </div>
    <?php endif; ?>
</div>