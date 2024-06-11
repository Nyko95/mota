<?php

// Je récupère la référence de la photo courante.
$reference = get_field('reference');

// Je récupère la catégorie de la photo courante.
$category = get_the_terms(get_the_ID(), 'categorie');
$category_name = $category ? $category[0]->name : 'Non classé';//Valeur par défaut si nul ou vide, condition ternaire "?"
?>

<!-- Lightbox -->
<div id="lightbox" class="lightbox-overlay">
    <div class="lightbox-content">
        <!-- Bouton pour fermer la lightbox -->
        <button class="cross lightbox-close">
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/close.png" alt="Fermer">
        </button>

        <!-- Image en plein écran -->
        <img class="lightbox-photo lightbox-image" src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID())); ?>" alt="Photo en plein écran">

        <!-- Informations de la lightbox -->
        <div class="lightbox-info">
            <p class="reference">Référence : <?php echo esc_html($reference); ?></p>
            <p class="category">Catégorie : <?php echo esc_html($category_name); ?></p>
        </div>

        <!-- Boutons de navigation -->
        <button class="prev">
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/prev.png" alt="Précédente">
        </button>
        <button class="next">
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/next.png" alt="Suivante">
        </button>
    </div>
</div>