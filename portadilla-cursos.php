<?php
    /*
    Template Name: Portadilla Cursos
    */
    get_header();
    the_post();
?>

<main id="main-content" class="main-content" role="main">
    <div class="container">
        <?php echo generate_breadcrumbs(); ?>

        <section class="page-header">
            <h1 class="section-title big icon">
                <span class="bg-neutral" ><?php the_title(); ?></span>
            </h1>

            <?php
                $testimonio = get_field('testimonio_destacado');
                if( !empty($testimonio) ) :
                    $testimonio = $testimonio[0];
            ?>

            <article class="featured-testimonial">
                <?php echo get_the_post_thumbnail($testimonio, 'regular-biggest', array('class' => 'elastic-img cover')); ?>
                <div class="testimonial-access">
                    <h2 class="testimonial-title"><?php echo get_field('texto_intro', $testimonio); ?></h2>
                    <a class="testimonial-link pretty-link arrow" href="<?php echo get_permalink($testimonio); ?>" title="Ver testimonio" rel="contents">Ver testimonio</a>
                </div>
            </article>

            <?php endif; ?>
        </section>
    </div>

    <section class="full-section bordered bg-blanco">
        <div class="container full-section-body minified centered-text">
            <h2 class="full-section-call">Inscríbete en nuestros cursos y aprende Chino Mandarín</h2>
            <?php $inscripcion = get_field('inscripcion')[0]; ?>
            <a class="button secundario" href="<?php echo get_permalink($inscripcion); ?>" rel="section help" title="Ir al proceso de inscripción">Inscribirme</a>
        </div>
    </section>

    <div class="container">
        <div class="page-content font-bigger bg-blanco parent">
            <div class="grid-8 grid-smalltablet-12 no-gutter-smalltablet no-gutter-left">
                <?php
                    echo apply_filters('the_content', get_field('texto_seccion_1'));
                ?>
            </div>
            <div class="grid-4 grid-smalltablet-12 no-gutter-smalltablet no-gutter-right relative-pos">
                <nav class="page-navigation attached" >
                    <p class="page-navigation-intro">Infórmate más sobre:</p>
                    <?php
                        $info_nav = get_field('navegacion_informacion');
                        if( !empty($info_nav) ){
                            foreach( $info_nav as $item_id ){
                                echo '<a href="'. get_permalink( $item_id ) .'" title="Ir a '. get_the_title($item_id) .'" rel="section">'. get_the_title($item_id) .'</a>';
                            }
                        }
                    ?>
                </nav>
            </div>
        </div>
 
        <section class="separated-section courses-intro-holder">
            <?php
                $cursos_nav = get_field('navegacion_cursos');
                foreach( $cursos_nav as $curso_id ) :
                    $title = get_the_title( $curso_id );
                    $lower_title = strtolower($title);
                    $tabs = get_field('cursos', $curso_id);

                    switch ( $lower_title ) {
                        case 'nivel básico' :
                            $type_class = 'basico bg-corporativo pattern';
                            $title_type_class = 'bg-corporativo';
                            break;

                        case 'nivel intermedio':
                            $type_class = 'intermedio bg-complementario pattern';    
                            $title_type_class = 'bg-complementario';
                            break;

                        case 'nivel avanzado':
                            $type_class = 'avanzado bg-primario pattern';    
                            $title_type_class = 'bg-primario';
                            break;
                        
                        default:
                            $type_class = 'bg-neutral pattern';  
                            $title_type_class = 'bg-neutral';
                            break;
                    }
            ?>
                <article class="course-intro <?php echo $type_class; ?>">
                    <h3 class="section-title small">
                        <span class="<?php echo $title_type_class; ?> light" ><?php echo $title; ?></span>
                    </h3>

                    <div class="course-levels">
                        <?php
                            if( !empty($tabs) ) :
                                foreach($tabs as $tab) :
                                    $tab_slug = sanitize_title( $tab['titulo'] );
                        ?>
                        <a class="course-level-link corporativo" href="<?php echo get_permalink( $curso_id ) . '#'. $tab_slug; ?>" title="Ver <?php echo $tab['titulo']; ?>"><?php echo $tab['titulo']; ?></a>

                        <?php
                            endforeach;
                            endif;
                        ?>
                    </div>
                </article>

            <?php endforeach; ?>
        </section>

        <div class="separated-section parent">
            <div class="page-content font-bigger grid-8 grid-smalltablet-12 no-gutter-smalltablet no-gutter-left bg-blanco">
                <?php
                    echo apply_filters('the_content', get_field('texto_seccion_2'));
                ?>
            </div>
            <div class="grid-4 grid-smalltablet-12 no-gutter-smalltablet no-gutter-right">
                <h2 class="section-title small icon plus">
                    <a class="bg-neutral" href="<?php echo get_term_link( 'agenda-academica', 'tipo_agenda' ); ?>" title="Ir a Agenda académica" rel="section">Agenda académica</a>
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
        </div>
    </div>
</main>

<?php get_footer(); ?>