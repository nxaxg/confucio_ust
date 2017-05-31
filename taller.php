<?php
    /*
    Template Name: Single Taller
    */
   
    $ancestor_id = get_super_parent( $post );
    $agenda_term = get_term_by('slug', $post->post_name, 'tipo_actividad');

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

            <div class="parent" data-equalize="children" data-mq="tablet-down">
                <?php if( has_post_thumbnail() ) : ?>
                    <div class="grid-7 grid-tablet-12 no-gutter" data-area-name="page-header-intro-text" >
                        <div class="page-header-intro bg-neutralalt pattern" data-mutable="tablet-down" data-mobile-area="page-header-intro-img" data-desktop-area="page-header-intro-text" data-order="1">
                            <?php echo apply_filters('the_content', get_field('texto_intro') ); ?>
                            <div class="island righted-text">
                                <?php
                                    $inscripcion_id = get_child_by_slug( $ancestor_id, 'pre-inscripcion' );
                                ?>
                                <a class="button secundario full-vertical-tablet-down" href="<?php echo get_permalink($inscripcion_id); ?>" title="Ir a formulario de inscripción">Inscríbete</a>
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
                        <div class="island righted-text">
                            <?php
                                $inscripcion_id = get_child_by_slug( $ancestor_id, 'pre-inscripcion' );
                            ?>
                            <a class="button secundario full-vertical-tablet-down" href="<?php echo get_permalink($inscripcion_id); ?>" title="Ir a formulario de inscripción">Inscribirme</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </section>
          
        <section class="parent page-body">
            <aside class="grid-3 no-gutter-left grid-smalltablet-12 no-gutter-smalltablet" data-area-name="desktop-page-nav">
                <?php get_sidebar(); ?>
            </aside>
            <section class="grid-9 no-gutter-right grid-smalltablet-12 no-gutter-smalltablet">
                <div class="page-content bg-blanco">
                    <h1><?php the_title(); ?></h1>
                    <?php echo generate_article_actions_box( $post ); ?>
                    <?php 
                        $sedes_asociadas = get_field('sedes_asociadas');
                        if( !empty( $sedes_asociadas ) ){
                            $nombres = array();
                            foreach( $sedes_asociadas as $sede ){
                                $nombres[] = $sede->name;
                            }
                            echo '<h3>Sedes: '. implode(', ', $nombres) .'</h3>';
                        }

                        the_content();
                    ?>
                </div>
            </section>
        </section>
        
        <?php
            // prevencion de error php en caso de que el termino 
            // de la tax tipo_actividad no exista
            if( !!$agenda_term ):
        ?>

        <section class="page-additionals parent">
            <div class="responsive-section grid-4 grid-tablet-12 no-gutter-tablet no-gutter-left">
                <h2 class="section-title small icon plus">
                    <a class="bg-neutral" href="<?php echo get_term_link($agenda_term); ?>" title="Ir a Agenda" rel="section">Agenda <?php the_title(); ?></a>
                </h2>

                
                <div class="titled-box">
                    <?php 
                        echo get_eventos(array(
                            'posts_per_page' => 3,
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'tipo_actividad',
                                    'field' => 'slug',
                                    'terms' => $agenda_term->slug
                                )
                            )
                        )); 
                    ?>
                </div>
            </div>
            <div class="responsive-section grid-4 grid-tablet-12 no-gutter-tablet">
                <h2 class="section-title small icon plus">
                    <a class="bg-neutral" href="<?php echo get_term_link( 'agenda-academica', 'tipo_agenda' ); ?>" title="Ir a Agenda" rel="section">Agenda académica</a>
                </h2>
                
                <div class="titled-box">
                    <?php 
                        echo get_eventos(array(
                            'posts_per_page' => 3,
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'tipo_agenda',
                                    'field' => 'slug',
                                    'terms' => 'agenda-academica'
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

        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>