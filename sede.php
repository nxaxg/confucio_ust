<?php
    /*
    Template Name: Single Sede
    */
    $ancestor_id = get_super_parent( $post );
    get_header();
    the_post();
?>

<main id="main-content" class="main-content" role="main">
    <div class="container">
        <?php echo generate_breadcrumbs(); ?>

        <div class="mobile-page-nav-holder" >
            <a id="mobile-nav-expander" class="section-title-expander small icon arrow" href="#" title="Ir a Instituto confucio" rel="section" data-func="toggleTarget" data-target="#mobile-nav-expander, #page-navigation">
                <span class="bg-neutral" ><?php echo get_the_title($ancestor_id); ?></span>
            </a>
            
            <nav id="page-navigation" class="page-navigation" data-mutable="vertical-tablet-down" data-mobile-area="mobile-page-nav" data-desktop-area="desktop-page-nav" data-order="1" >
                <?php echo get_sub_page_navigation( get_super_parent( $post ) ); ?>
            </nav>
        </div>

        <section class="page-header">
            <h1 class="section-title big icon always-visible">
                <span class="bg-neutral" ><?php the_title(); ?></span>
            </h1>
            <div class="parent page-content font-bigger bg-blanco">
                <div class="grid-8 grid-smalltablet-12">
                    <?php echo apply_filters('the_content', get_field('texto_intro') ); ?>
                </div>
                <div class="grid-4 grid-smalltablet-12">
                    <div class="highlighted-box full">
                        <?php
                            if( $meta = get_field('direccion_exacta') ){
                                echo '<p class="icon-paragraph icon map">'. $meta .'</p>';
                            }

                            if( $meta = get_field('telefono') ){
                                echo '<p class="icon-paragraph icon phone">'. $meta .'</p>';
                            }

                            if( $meta = get_field('email') ){
                                echo '<p class="icon-paragraph icon mail">'. $meta .'</p>';
                            }
                        ?>
                    </div>
                </div>
            </div>
        </section>

        <section class="page-map-holder">
            <?php echo generate_map_box( get_field('mapa') ); ?>
        </section>

        <section class="page-additionals parent">
            <div class="grid-8 grid-tablet-12 no-gutter-tablet no-gutter-left titled-box">
                <h2 class="section-title small icon plus">
                    <a class="bg-neutral" href="<?php echo get_term_link( $post->post_name, 'sede' ); ?>" title="Ir a Agenda" rel="section">Agenda</a>
                </h2>

                <div class="grid-6 grid-smalltablet-12 no-gutter-smalltablet no-gutter-left">
                    <?php 
                        echo get_eventos(array(
                            'posts_per_page' => 3,
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'sede',
                                    'field'    => 'slug',
                                    'terms'    => $post->post_name
                                )
                            )
                        ));
                    ?>
                </div>
                <div class="grid-6 no-gutter-right hide-on-vertical-tablet-down">
                    <?php 
                        echo get_eventos(array(
                            'posts_per_page' => 3,
                            'offset' => 3 ,
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'sede',
                                    'field'    => 'slug',
                                    'terms'    => $post->post_name
                                )
                            )
                        ));
                    ?>
                </div>
            </div>
            <div class="responsive-section grid-4 grid-tablet-12 no-gutter-tablet no-gutter-right">
                <?php echo get_noticias(); ?>
            </div>
        </section>
    </div>
</main>

<?php get_footer(); ?>