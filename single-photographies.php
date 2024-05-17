<?php
/**
 * The template for displaying single photo post type
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header();

// Start the Loop
while ( have_posts() ) :
	the_post();
?>

<!-- Affichage du contenu de l'article -->
<article id="post-<?php the_ID(); ?>;" <?php post_class(); ?>>
	<header class="entry-header">
		<!-- Affichage du titre pour chaque article -->
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
			// Afficher le contenu de l'article
			the_content();

			// Afficher le champ personnalisé "type" s'il existe
			$type = get_field('type');
			if ($type) {
				echo '<p>Type : ' . esc_html($type) . '</p>';
			}

			// Afficher le champ personnalisé "référence" s'il existe
			$reference = get_field('reference');
			if ($reference) {
				echo '<p>;Référence : ' . esc_html($reference) . '</p>';
			}

			// Afficher le champ personnalisé "image" s'il existe
			$image = get_field('image');
			if ($image) {
				echo '<div class="photo-image">';
				echo wp_get_attachment_image($image, 'full', false, array('style' => 'object-fit: cover; width: 100%; height: auto;'));
				echo '</div>';
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
	</div><!-- .entry-content -->

	<!-- Bouton "contact" pour chaque photographie -->
	<button class="open-contact-modal">Contact</button>

		</article><!-- #post-<?php the_ID(); ?>; -->

<?php
endwhile; // End of the loop.

get_footer();
?>