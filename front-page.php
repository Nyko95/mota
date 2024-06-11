<?php get_header(); ?>

<?php get_template_part('template_parts/hero-header'); ?>

<!-- section des filtres et du trie des photos -->
<section class="section_filter-photos filter-photos">
    <?php 
    // Récupération des termes des taxonomies
    $categories = get_terms('categorie', array('hide_empty' => false));
    $formats = get_terms('format', array('hide_empty' => false));
    ?>

    <div class="custom-select">
        <select id="category-filter" class="filter-select">
            <option value="">Catégories</option>
            <?php foreach ($categories as $category) : ?>
                <option value="<?= esc_attr($category->slug); ?>"><?= esc_html($category->name); ?></option>
            <?php endforeach; ?>
        </select>

        <select id="format-filter" class="filter-select">
            <option value="">Formats</option>
            <?php foreach ($formats as $format) : ?>
                <option value="<?= esc_attr($format->slug); ?>"><?= esc_html($format->name); ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="custom-select">
        <select id="order-filter" class="filter-select">
            <option value="">Trier par</option>
            <option value="DESC">La plus récente</option>
            <option value="ASC">La plus ancienne</option>
        </select>
    </div>
</section>

<!-- section liste photos -->
<section class="section_block-photo">
    <div id="photo-gallery" class="block_photo">
        <?php
        $args = array(
            'post_type' => 'photographie',
            'posts_per_page' => 8,
            'paged' => 1,
            );

           
            $photos = new WP_Query($args);
            
        if ($photos->have_posts()) {
            while ($photos->have_posts()) {
                $photos->the_post();
                // Définissez les variables que vous voulez passer au template
                set_query_var('reference', get_field('reference'));
                set_query_var('category', get_the_terms(get_the_ID(), 'categorie')[0]);
                get_template_part('template_parts/photo_block');
            }
        }
        ?>
    </div>
    <?php 
    // Bouton "Charger plus"
    echo '<div id="load-more" class="load-more">';
    echo '<a href="#" class="load-more-button" data-post-id="' . esc_attr($post_id) . '">Charger plus</a>';
    echo '</div>';
    ?>
</section>
<!-- Inclusion de la lightbox -->
<?php get_template_part('template_parts/lightbox'); ?>
<?php get_footer(); ?>