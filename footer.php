<footer class="site-footer">
    <div class="container-footer">
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

<?php wp_footer(); ?>
</body>
</html>