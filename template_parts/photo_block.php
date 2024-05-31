<!--BLOC D'AFFICHAGE PHOTO DE LA LISTE-->

<?php
// Récupère les catégories de la photo courante.
$categories = get_the_terms(get_the_ID(), 'categorie');

// Récupère la référence de la photo courante.
$reference = get_field('reference', get_the_ID());

// Vérifie si la référence existe
if (!$reference) {
    // Si la référence n'est pas définie, essayez de récupérer la valeur du champ "référence"
    $reference = get_field('référence', get_the_ID());
}

// Si la référence n'est toujours pas définie, essayez de la récupérer en utilisant le nom de groupe de champs
if (!$reference) {
    $reference = get_field('reference', 'info_photographie_' . get_the_ID());
}

// Récupère l'URL de la miniature de la photo courante.
$thumbnail_url = get_field('thumbnail_image', get_the_ID());
?>

<!-- J'ouvre une div avec la classe "photo". Cette div contiendra la photo et ses informations. -->
<div class="photo">
    <?php
    // Affiche la miniature de la photo courante si elle est disponible.
    if ($thumbnail_url) {
        echo '<img src="' . esc_url($thumbnail_url) . '" alt="' . get_the_title() . '">';
    } else {
        echo get_the_post_thumbnail();
    }
    ?>

    <!-- J'ouvre une div avec la classe "hover_photo". Cette div contiendra les icônes qui apparaissent lorsque l'utilisateur survole la photo. -->
    <div class="hover_photo">

        <!-- J'ouvre un lien autour de l'icône "oeil" pour rediriger vers la page de la photo. -->
        <a href="<?php the_permalink(); ?>" class="eye-link">
            <!-- J'affiche une icône "oeil" qui indique que l'utilisateur peut cliquer pour voir la photo. -->
            <img class="eye" src="<?php echo get_template_directory_uri(); ?>/assets/images/eye-icon.png" alt="icone oeil pour voir la photo">
        </a>

        <!-- Vérifie si $categories contient au moins une catégorie avant d'afficher la catégorie -->
        <?php if (!empty($categories) && !is_wp_error($categories)) : ?>
            <?php foreach ($categories as $category) : ?>
                <!-- J'ouvre une balise span qui contient l'URL de la photo en taille réelle, la référence de la photo et la catégorie de la photo. -->
                <span data-image-url="<?php echo esc_url($thumbnail_url); ?>" data-reference="<?php echo esc_attr($reference); ?>" data-category="<?php echo esc_attr($category->name); ?>">
                    <!-- J'affiche une icône "fullscreen" qui indique que l'utilisateur peut cliquer pour voir la photo en plein écran. -->
                    <img class="fullscreen" src="<?php echo get_template_directory_uri(); ?>/assets/images/fullscreen-icon.png" alt="icon pour agrandir la photo">
                </span>

                <!-- J'affiche la catégorie de la photo. -->
                <p class="categorie">Catégorie : <?php echo esc_html($category->name); ?></p>
            <?php endforeach; ?>
        <?php endif; ?>

        <!-- J'affiche la référence de la photo. -->
        <p class="reference">Référence : <?php echo esc_attr($reference); ?></p>

        <!-- Je ferme la div "hover_photo". -->
    </div>

    <!-- Je ferme la div "photo". -->
</div>