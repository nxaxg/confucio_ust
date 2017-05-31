<?php get_header(); ?>

<main id="main-content" class="main-content" role="main">
    <div class="container">
        <?php echo generate_breadcrumbs(); ?>

        <section class="page-header">
            <h1 class="section-title big icon hide-on-vertical-tablet-down">
                <span class="bg-neutral" ><?php pll_e('Publicaciones'); ?></span>
            </h1>

            <div class="parent" data-equalize="children" data-mq="tablet-down">
                <div class="grid-7 grid-tablet-12 no-gutter" data-area-name="page-header-intro-text" >
                    <div class="page-header-intro bg-neutralalt pattern" data-mutable="tablet-down" data-mobile-area="page-header-intro-img" data-desktop-area="page-header-intro-text" data-order="1">
                        <?php the_field('texto_portada_publicaciones', 'options'); ?>
                    </div>
                </div>
                <div class="grid-5 grid-tablet-12 no-gutter" data-area-name="page-header-intro-img">
                    <?php
                        echo wp_get_attachment_image( get_field('imagen_publicaciones', 'options'), 'regular-big', false, array(
                            'class' => 'elastic-img cover',
                            'data-mutable' => 'tablet-down',
                            'data-mobile-area' => 'page-header-intro-text',
                            'data-desktop-area' => 'page-header-intro-img',
                            'data-order' => '1'
                        ));
                    ?>
                </div>
            </div>
        </section>
          
        <section class="page-body parent">
            <?php
                if( have_posts() ){
                    while( have_posts() ){
                        the_post();
                        echo '<div class="grid-4 grid-tablet-6 grid-mobile-4" >';
                        echo generate_pub_module( $post );
                        echo '</div>';
                    }
                }
            ?>
        </section>
        <section class="page-body" >
            <?php echo get_pagination(); ?>
        </section>
    </div>
</main>

<?php get_footer(); ?>