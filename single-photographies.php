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
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		
	<!--Affichage du titre pour chaques articles-->
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
			// Afficher le contenu de l'article
			the_content();

			// Afficher le champ personnalisé "type" s'il existe
			$type = get_field('type');
			if ($type) {
				echo '<p>Type : ' . $type . '</p>';
			}

			// Afficher le champ personnalisé "référence" s'il existe
			$reference = get_field('reference');
			if ($reference) {
				echo '<p>Référence : ' . $reference . '</p>';
			}

			// Afficher les taxonomies (catégories, formats, années)
			$categories = get_the_terms( get_the_ID(), 'categorie' );
			if ( $categories && ! is_wp_error( $categories ) ) {
				echo '<div class="entry-taxonomies">';
				foreach ( $categories as $category ) {
					echo '<span class="entry-taxonomy">' . esc_html( $category->name ) . '</span>';
				}
				echo '</div>';
			}

			$formats = get_the_terms( get_the_ID(), 'format' );
			if ( $formats && ! is_wp_error( $formats ) ) {
				echo '<div class="entry-taxonomies">';
				foreach ( $formats as $format ) {
					echo '<span class="entry-taxonomy">' . esc_html( $format->name ) . '</span>';
				}
				echo '</div>';
			}

			$annees = get_the_terms( get_the_ID(), 'annee' );
			if ( $annees && ! is_wp_error( $annees ) ) {
				echo '<div class="entry-taxonomies">';
				foreach ( $annees as $annee ) {
					echo '<span class="entry-taxonomy">' . esc_html( $annee->name ) . '</span>';
				}
				echo '</div>';
			}
		?>
	</div><!-- .entry-content -->

	<!--Bouton "contact" pour chaque photographie-->
	<button class="open-contact-modal">Contact</button>

</article><!-- #post-<?php the_ID(); ?> -->

<?php
endwhile; // End of the loop.

get_footer();
?>