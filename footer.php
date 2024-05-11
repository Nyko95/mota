  <!-- Début du pied de page du site -->
  <footer class="site-footer">
        <div class="container">
            <!-- Contenu du pied de page -->
            <div class="footer-links">
                <a href="<?php echo esc_url(home_url('/mentions-legales')); ?>">Mentions légales</a>
                <a href="<?php echo esc_url(home_url('/vie-privee')); ?>">Vie privée</a>
                <p>© <?php echo date('Y'); ?> MOTA. Tous droits réservés.</p>
            </div>
        </div><!-- .container -->
    </footer><!-- .site-footer -->

    <?php wp_footer(); ?>
</body>
</html>