<footer class="site-footer">
    <div class="container-footer">

        <!-- Modale de contact -->
        <?php get_template_part('template_parts/modal-contact'); ?>

        <!-- Contenu du pied de page -->
        <div class="footer-links">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'menu-footer', // Emplacement du menu défini dans functions.php
                'menu_id' => 'footer-menu',
            ));
            ?>
        </div>
    </div><!-- .container -->
</footer><!-- .site-footer -->

<!-- Inclusion de la lightbox -->
<?php get_template_part('template_parts/lightbox'); ?>

<?php wp_footer(); ?>
</body>
</html>