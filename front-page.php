<?php get_header();
?>

<?php get_template_part( 'template_parts/hero-header' ); ?>
<?php

//Bouton "Charger plus"
echo '<div id="load-more" class="load-more">';
echo '<a href="#" class="load-more-button" data-post-id="' . esc_attr($post_id) . '">Charger plus</a>';
echo '</div>';
?>

<?php get_footer(); ?>