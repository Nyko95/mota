<?php get_header(); ?>

<div class="single-post-container">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <!-- Début de la boucle WordPress -->

        <div class="post-content">

            <!-- Afficher le titre de l'article -->
            <h1 class="post-title"><?php the_title(); ?></h1>

            <!-- Afficher l'image mise en avant de l'article -->
            <?php if (has_post_thumbnail()) : ?>
                <div class="post-thumbnail">
                    <?php the_post_thumbnail(); ?>
                </div>
            <?php endif; ?>

            <!-- Afficher le contenu de l'article -->
            <div class="post-text">
                <?php the_content(); ?>
            </div>

        </div>

    <?php endwhile; else: ?>

        <!-- Message si la page n'existe pas -->
        <p><?php esc_html_e('Désolé, cette page n\'existe pas.', 'mota'); ?></p>

    <?php endif; ?>
    <!-- Fin de la boucle WordPress -->

</div>

<?php get_footer(); ?>
