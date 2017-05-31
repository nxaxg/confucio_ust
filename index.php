<?php get_header(); ?>

<?php
//Aca se obtendra la informacion destacada que se haya seleccionado en la administracion
$destacado_principal = get_field('destacado_principal', 'options');
if( !empty( $destacado_principal ) ) {
    if( $destacado_principal[0]['acf_fc_layout'] === 'noticia' ) {
        // se cambia de blog a "enlinea" (id = 2)
        switch_to_blog( 2 );
        $id_post    = $destacado_principal[0]['noticia'][0];
        $post_info  = get_post($id_post);
        $imagen     = get_the_post_thumbnail($post_info->ID, 'regular-bigger', array('class' => 'elastic-img cover'));
        $intro_text = get_the_title($post_info->ID);
        $link       = get_permalink($post_info->ID);
        $texto_link = $destacado_principal[0]['texto_url'];
        restore_current_blog();
    } else if( $destacado_principal[0]['acf_fc_layout'] === 'testimonio' ) {
        $id_post    = $destacado_principal[0]['testimonio'][0];
        $post_info  = get_post($id_post);
        $imagen     = get_the_post_thumbnail($post_info->ID, 'regular-bigger', array('class' => 'elastic-img cover'));
        $intro_text = get_field('texto_intro',$post_info->ID);
        $link       = get_permalink($post_info->ID);
        $texto_link = $destacado_principal[0]['texto_url'];
    } else if( $destacado_principal[0]['acf_fc_layout'] === 'festividad' ) {
        $id_post    = $destacado_principal[0]['festividad'][0];
        $post_info  = get_post($id_post);
        $imagen     = get_the_post_thumbnail($post_info->ID, 'regular-bigger', array('class' => 'elastic-img cover'));
        $intro_text = get_field('texto_intro',$post_info->ID);
        $link       = get_permalink($post_info->ID);
        $texto_link = $destacado_principal[0]['texto_url'];
    } else if( $destacado_principal[0]['acf_fc_layout'] === 'contenido_interno' ) {
        $id_post    = $destacado_principal[0]['contenido'][0];
        $post_info  = get_post($id_post);
        $imagen     = get_the_post_thumbnail($post_info->ID, 'regular-bigger', array('class' => 'elastic-img cover'));
        $intro_text = get_field('texto_intro',$post_info->ID);
        $link       = get_permalink($post_info->ID);
        $texto_link = $destacado_principal[0]['texto_url'];
    }
}
?>

<main id="main-content" class="main-content" role="main">
    <section class="container">
        <div class="grid-8 grid-tablet-12 no-gutter">
            <?php $test_dest = get_field('testimonio_destacado_home', 'options')[0]; ?>
            <article class="featured-testimonial">
                <?php echo $imagen; ?>
                <div class="testimonial-access">
                    <h2 class="testimonial-title"><?php echo $intro_text; ?></h2>
                    <a class="testimonial-link pretty-link arrow" href="<?php echo $link; ?>" title="<?php echo $texto_link; ?>" rel="contents"><?php echo $texto_link; ?></a>
                </div>
            </article>
        </div>
        <div class="grid-4 grid-tablet-12 no-gutter">
        <?php
            $cajas = get_field('cajas_destacadas', 'options');
            foreach( $cajas as $caja ):
        ?>
            <article class="grid-tablet-6 grid-smalltablet-12 grid-mobile-4 featured-access">
                <h3 class="featured-access-title"><?php echo $caja['titulo']; ?></h3>
                <p><?php echo $caja['texto_intro']; ?></p>
                <div class="featured-access-actions">
                    <a class="button secundario" href="<?php echo $caja['boton']; ?>" title="Inscribirme" rel="contents">Inscribirme</a>
                    <?php
                        if( !empty( $caja['link'] ) && !empty($caja['texto_link']) ){
                            echo '<a class="pretty-link arrow" href="'. ensure_url($caja['link']) .'" title="'. $caja['texto_link'] .'" rel="contents">'. $caja['texto_link'] .'</a>';
                        }
                    ?>
                </div>
            </article>
        <?php endforeach; ?>
        </div>
    </section>

    <section class="full-section bordered bg-neutral pattern hide-on-vertical-tablet-down">
        <div class="container">
            <div class="grid-8 grid-tablet-12 no-gutter-tablet centered full-section-body">
                <h2 class="full-section-title centered-text"><?php the_field('titulo_seccion_1', 'options'); ?></h2>
                <p class="full-section-desc centered-text"><?php the_field('descripcion_seccion_1', 'options'); ?></p>
            </div>
        </div>
        <div class="full-section-footer">
            <div class="container">
                <div class="grid-8 grid-tablet-12 no-gutter-tablet centered">
                    <ul class="full-section-nav">
                        <li>Conoce más sobre</li>
                        <?php
                            wp_nav_menu(array(
                                'theme_location' => 'conocemas',
                                'items_wrap' => '%3$s'
                            ));
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="container">
        <?php 
            $news = get_noticias( 'instituto-confucio', 3, 'array', [
                'box_options' => [ 'thumbnail' => true ]
            ]);

            echo $news['title_link'];
            echo '<div class="parent section-body bg-blanco" data-equalize="target" data-mq="phablet-down" data-eq-target=".news">';

            foreach( $news['items'] as $item ){
                echo '<div class="grid-4 grid-mobile-4 no-gutter-mobile">';
                echo $item;
                echo '</div>';
            }

            echo '</div>';
        ?>
    </section>

    <section class="container">
        <h2 class="section-title small icon plus">
            <a class="bg-neutral" href="<?php echo get_post_type_archive_link('agenda'); ?>" title="Ir a agenda" rel="section">Agenda</a>
        </h2>
        <?php
        /*
        <article class="featured-event no-thumbnail">
            <?php
                $agenda_dest = get_field('evento_destacado_home', 'option')[0];
                echo generate_event_module( $agenda_dest );
            ?>
        </article>
        */
        ?>

        <div class="parent section-body bg-blanco" data-equalize="target" data-mq="phablet-down" data-eq-target=".event-content">
            <?php 
                echo get_eventos(['posts_per_page' => 4], false, false, [
                    'wrap_start' => '<div class="responsive-section grid-3 grid-tablet-6 grid-mobile-4 no-gutter-mobile">',
                    'wrap_end' => '</div>',
                ]);
            ?>
        </div>

        <?php 
        /*
        <div class="responsive-section grid-8 no-gutter-left grid-tablet-12 no-gutter-tablet">
            <h2 class="section-title small icon plus">
                <a class="bg-neutral" href="<?php echo get_post_type_archive_link('agenda'); ?>" title="Ir a agenda" rel="section">Agenda</a>
            </h2>
            
            <?php
                $agenda_dest = get_field('evento_destacado_home', 'option')[0];
                $thumb = get_the_post_thumbnail( $agenda_dest, 'horizontal', array( 'class' => 'elastic-img cover' ));

                $dest_class = $thumb ? '' : 'no-thumbnail';
            ?>
            <article class="featured-event <?php echo $dest_class; ?>">
                <?php
                    echo $thumb;
                    echo generate_event_module( $agenda_dest );
                ?>
            </article>

            <div class="parent">
                <div class="grid-6 grid-smalltablet-12 no-gutter-smalltablet no-gutter-left">
                    <?php echo get_eventos(array( 'posts_per_page' => 2 )); ?>
                </div>
                <div class="grid-6 grid-smalltablet-12 no-gutter-smalltablet no-gutter-right">
                    <?php echo get_eventos(array( 'posts_per_page' => 2, 'offset' => 2 )); ?>
                </div>
            </div>
        </div>
        <div class="responsive-section grid-4 no-gutter-right grid-tablet-12 no-gutter-tablet">
            <?php echo get_noticias( 'instituto-confucio', 3 ); ?>
        </div>
        */
        ?>
    </section>
    
    <section class="full-section bordered bg-primario pattern">
        <div class="container">
            <div class="grid-4 no-gutter-left hide-on-tablet-down">
                <?php echo wp_get_attachment_image( get_field('foto_newsletter_home', 'options'), 'regular-small', false, array( 'class' => 'elastic-img cover' )); ?>
            </div>
            <div class="grid-8 no-gutter-right grid-tablet-12 no-gutter-tablet full-section-body">
                <h2 class="full-section-title">Suscríbete a nuestro newsletter</h2>
                <p class="full-section-desc">Recibe semanalmente todas las novedades que Instituto Confucio UST tiene para tí.</p>

                <?php echo generate_suscribe_form(); ?>
            </div>
        </div>      
    </section>

    <section class="full-section bg-neutral pattern">
        <?php
            // chequeo de datos para retrocompatibilidad
            $mosaico = get_field('mosaico_portada', 'options');
            
            if( !empty($mosaico) ){
                echo get_mixed_mosaic( $mosaico );
            }
            else {
                echo get_testimonials_mosaic();
            }
        ?>
    </section>
</main>

<section class="full-section standalone bg-primario pattern">
    <div class="container relative-pos confucio-quote-box">
        <blockquote class="confucio-quote" >
            <?php the_field('cita_confucio_home', 'options'); ?>
        </blockquote>
    </div>      
</section>

<?php get_footer(); ?>