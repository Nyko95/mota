<!--BLOC D'AFFICHAGE PHOTO -->


<?php
/**
 * Template part for displaying a single photo block.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

// Afficher le titre de la photographie
the_title( '<h2 class="photo-title">', '</h2>' );

// Afficher le contenu de la photographie (facultatif)
// Si tu veux afficher le contenu de la photographie, tu peux utiliser :
// the_content();

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