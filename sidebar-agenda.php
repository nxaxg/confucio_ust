<div class="sidebar-widget sidebar-suscribe-box bg-primario pattern centered-text">
    <h2>Suscríbete a nuestro newsletter</h2>
    <p>Recibe semanalmente todas las novedades que Instituto Confucio UST tiene para tí.</p>

    <?php echo generate_suscribe_form(); ?>
</div>

<?php if( is_tax() ) : ?>
    <?php
        $current_term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
        $tipos_agenda = get_terms('tipo_agenda', array( 'exclude' => array( intval($current_term->term_id) ) ));
        if( !empty($tipos_agenda) ){ 
            foreach( $tipos_agenda as $tipo ){ ?>
                
                <div class="sidebar-widget titled-box">
                    <h3 class="section-title small icon plus">
                        <a class="bg-neutral" href="<?php echo get_term_link($tipo); ?>" title="Ir a <?php echo $tipo->name; ?>" rel="section"><?php echo $tipo->name; ?></a>
                    </h3>

                    <div>
                        <?php 
                            echo get_eventos(array(
                                'posts_per_page' => 2,
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => 'tipo_agenda',
                                        'field' => 'slug',
                                        'terms' => $tipo->slug
                                    )
                                )
                            )); 
                        ?>
                    </div>
                </div>

        <?php   }
        }
    ?>
    
<?php endif; ?>

<div class="sidebar-widget">
    <?php echo get_noticias(); ?>
</div>