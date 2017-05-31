<?php
    /*
    Template Name: Single curso
    */
    get_header();
    the_post();

    $ancestor_id = get_super_parent( $post );
    $inscripcion_id = get_child_by_slug( $ancestor_id, 'proceso-de-inscripcion' );
?>

<main id="main-content" class="main-content" role="main">
    <div class="container">
        <?php echo generate_breadcrumbs(); ?>

        <div class="mobile-page-nav-holder" data-area-name="mobile-page-nav" >
            <a id="mobile-nav-expander" class="section-title-expander small icon arrow" href="#" title="Ir a Instituto confucio" rel="section" data-func="toggleTarget" data-target="#mobile-nav-expander, #page-navigation">
                <span class="bg-neutral" ><?php echo get_the_title( $ancestor_id ); ?></span>
            </a>
        </div>

        <section class="page-header">
            <h1 class="section-title big icon">
                <span class="bg-neutral" ><?php the_title(); ?></span>
            </h1>

            <div class="parent" data-equalize="children" data-mq="tablet-down">
                <?php if( has_post_thumbnail() ) : ?>
                    <div class="grid-7 grid-tablet-12 no-gutter" data-area-name="page-header-intro-text" >
                        <div class="page-header-intro bg-corporativo pattern" data-mutable="tablet-down" data-mobile-area="page-header-intro-img" data-desktop-area="page-header-intro-text" data-order="1">
                            <?php echo apply_filters('the_content', get_field('texto_intro') ); ?>
                            <div class="island righted-text centered-text-vertical-tablet-down">
                                
                                <a class="button secundario full-vertical-tablet-down" href="<?php echo get_permalink($inscripcion_id); ?>" title="Ir a formulario de inscripción">Inscribirme</a>
                            </div>
                        </div>
                    </div>      
                    <div class="grid-5 grid-tablet-12 no-gutter" data-area-name="page-header-intro-img">
                        <?php
                            the_post_thumbnail('regular-big', array(
                                'class' => 'elastic-img cover',
                                'data-mutable' => 'tablet-down',
                                'data-mobile-area' => 'page-header-intro-text',
                                'data-desktop-area' => 'page-header-intro-img',
                                'data-order' => '1'
                            ));
                        ?>
                    </div>
                <?php else : ?>
                    <div class="page-header-intro bg-neutralalt pattern">
                        <?php echo apply_filters('the_content', get_field('texto_intro') ); ?>
                        <div class="island righted-text centered-text-vertical-tablet-down">
                            <a class="button secundario full-vertical-tablet-down" href="<?php echo get_permalink($inscripcion_id); ?>" title="Ir a formulario de inscripción">Inscribirme</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </section>
          
        <section class="parent page-body">
            <aside class="grid-3 no-gutter-left grid-smalltablet-12 no-gutter-smalltablet" data-area-name="desktop-page-nav">
                <?php get_sidebar('cursos'); ?>
            </aside>
            <section class="grid-9 no-gutter-right grid-smalltablet-12 no-gutter-smalltablet">
                <?php echo get_cursos_tabs( get_field('cursos') ); ?>

                <div class="page-section-footer">
                    <ul class="page-section-footer-nav">
                        <li>Podría interesarte</li>
                        <?php
                            wp_nav_menu(array(
                                'theme_location' => 'cursos_conocemas',
                                'items_wrap' => '%3$s'
                            ));
                        ?>
                    </ul>
                </div>
            </section>
        </section>
    </div>
</main>

<?php get_footer(); ?>