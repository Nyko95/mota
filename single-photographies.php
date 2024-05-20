<!-- CREATION TYPE DE CONTENU PERSONNALISE -->

<?php
get_header();

// Start the Loop
while ( have_posts() ) :
    the_post();
?>

<!-- Affichage du contenu de l'article -->
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="content-wrapper">
        <div class="left-block">
            <header class="entry-header">
                <!-- Affichage du titre pour chaque article -->
                <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
            </header><!-- .entry-header -->

            <div class="entry-content">
                <?php
                    // Afficher le champ personnalisé "type" s'il existe
                    $type = get_field('type');
                    if ($type) {
                        echo '<p>Type : ' . esc_html($type) . '</p>';
                    }

                    // Afficher le champ personnalisé "référence" s'il existe
                    $reference = get_field('reference');
                    if ($reference) {
                        echo '<p>Référence : ' . esc_html($reference) . '</p>';
                    }

                    // Afficher les taxonomies (catégories, formats, années)
                    $taxonomies = array('categorie', 'format', 'annee');
                    foreach ($taxonomies as $taxonomy) {
                        $terms = get_the_terms(get_the_ID(), $taxonomy);
                        if ($terms && !is_wp_error($terms)) {
                            echo '<div class="entry-taxonomies">';
                            foreach ($terms as $term) {
                                echo '<span class="entry-taxonomy">' . esc_html($term->name) . '</span>';
                            }
                            echo '</div>';
                        }
                    }
                ?>
            </div>
        </div>

        <div class="right-block">
            <?php
                // Afficher le champ personnalisé "image" s'il existe
                $image = get_field('image');
                if ($image) {
                    echo '<div class="photo-image">';
                    echo wp_get_attachment_image($image, 'full', false, array('style' => 'object-fit: contain; width: 100%; height: 100%;'));
                    echo '</div>';
                }
            ?>
        </div>
    </div>

    <div class="bottom-block">
        <!-- Message d'appel à l'action -->
        <p>Cette photo vous intéresse ?</p>
        <!-- Bouton "contact" pour chaque photographie -->
        <button class="open-contact-modal" data-reference="<?php echo esc_attr($reference); ?>">Contact</button>
    </div>

    <!-- partie photo miniature -->
    <!-- Liens de navigation -->
    <div class="navigation-links">
        <?php
            // Récupère les photos précédente et suivante
            $prev_post = get_previous_post();
            $next_post = get_next_post();
        ?>
        <?php if (!empty($prev_post)) : ?>
            <!-- Lien pour la photo précédente -->
            <a href="<?php echo esc_url(get_permalink($prev_post->ID)); ?>" class="arrow-thumbnail custom-prev-link">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/arrow-left.png" class="arrow" data-direction="previous" alt="Previous">
                <?php echo get_the_post_thumbnail($prev_post->ID, 'thumbnail', array('class' => 'mini-thumbnail')); ?>
            </a>
        <?php endif; ?>

        <?php if (!empty($next_post)) : ?>
            <!-- Lien pour la photo suivante -->
            <a href="<?php echo esc_url(get_permalink($next_post->ID)); ?>" class="arrow-thumbnail custom-next-link">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/arrow-right.png" class="arrow" data-direction="next" alt="Next">
                <?php echo get_the_post_thumbnail($next_post->ID, 'thumbnail', array('class' => 'mini-thumbnail')); ?>
            </a>
        <?php endif; ?>
    </div>
</article><!-- #post-<?php the_ID(); ?> -->

<?php
endwhile;

get_footer();
?>