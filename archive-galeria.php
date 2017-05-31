<?php 
get_header();
?>
<main id="main-content" class="main-content" role="main">
    <div class="container">
        <section class="breadcrumbs hide-on-vertical-tablet-down">
            <?php echo generate_breadcrumbs(); ?>
        </section>
        <section class="page-header">
            <h1 class="section-title big icon">
                <span class="bg-neutral">Galerías</span>
            </h1>
            <div class="page-header-intro standalone bg-blanco">
                <p>Galerías de confucio.</p>
            </div>
        </section>
        <section class="parent separated-section" data-equalize="children" data-mq="tablet-down">
            <?php
                if( have_posts() ){
                    while( have_posts() ){
                        the_post();
                        echo '<div class="gallery-item-box grid-3 grid-tablet-4 grid-smalltablet-6 grid-mobile-4">';
                        echo generate_gallery_module( $post );
                        echo '</div>';
                    }
                }
                wp_reset_query();
            ?>
        </section>

        <section class="parent">
            <?php echo get_pagination(); ?>
        </section>
    </div>
</main>
<?php get_footer(); ?>