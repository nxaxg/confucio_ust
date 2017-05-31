<?php
    /*
    Template Name: Indice medio
    */
   
    $ancestor_id = get_super_parent( $post );
    get_header();
    the_post();
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
            <h1 class="section-title big icon hide-on-vertical-tablet-down">
                <span class="bg-neutral" ><?php echo get_the_title( $ancestor_id ); ?></span>
            </h1>

            <?php get_template_part( 'partials/regular', 'page-header' ); ?>
        </section>
          
        <section class="parent page-body">
            <aside class="grid-3 no-gutter-left grid-smalltablet-12 no-gutter-smalltablet" data-area-name="desktop-page-nav">
                <?php get_sidebar(); ?>
            </aside>
            <section class="grid-9 no-gutter-right grid-smalltablet-12 no-gutter-smalltablet">
                <?php
                    // si la pagina tiene mensaje personalizado
                    if( get_field('activar_mensaje') ){
                        echo alerta(array( 'mensaje' => get_field('mensaje_porsonalizado') ));
                    }

                    $children = get_field('accesos');
                    foreach( $children as $child_id ) :
                ?>
                <div class="grid-6 grid-smalltablet-12 no-gutter-left no-gutter-smalltablet">
                    <div class="inner-access bg-corporativo">
                        <h3 class="section-title icon small full standalone">
                            <span class="bg-neutral" ><?php echo get_the_title($child_id); ?></span>
                        </h3>
                        <div class="inner-access-body">
                            <?php 
                                echo apply_filters('the_content', get_field('texto_intro', $child_id) );

                                // como esta plantilla es multiuso
                                // hago la diferencia con el ACF de las hijas seleccionadas
                                $niveles = get_field('niveles', $child_id);

                                if( !empty($niveles) ) {
                                    $permalink = get_permalink( $child_id );

                                    foreach( $niveles as $nivel ) {
                                        echo '<a class="pretty-link arrow" href="'. $permalink .'#'. sanitize_title( $nivel['nombre'] ) .'" title="Ver Nivel" rel="subsection">'. $nivel['nombre'] .'</a>';
                                    }
                                }
                                else {
                                    $nietas = get_child_by_slug( $child_id, false );
                                    if( !empty($nietas) ) {
                                        foreach( $nietas as $child ){
                                            echo '<a class="pretty-link arrow" href="'. get_permalink($child) .'" title="Ver Sede" rel="subsection">'. get_the_title($child) .'</a>';
                                        }
                                    }
                                }
                            ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            </section>
        </section>
    </div>
</main>

<?php get_footer(); ?>