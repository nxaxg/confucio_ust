<?php
    /*
    Template Name: Portadilla Talleres y Actividades
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

            <div class="page-header-intro standalone bg-blanco" >
                <?php echo apply_filters('the_content', get_field('texto_intro')) ?>
            </div>
        </section>

        <section class="separated-section">
            <h2 class="section-title small icon plus only-on-vertical-tablet-down">
                <a class="bg-neutral" href="<?php echo get_post_type_archive_link('agenda'); ?>" title="Ir a agenda" rel="section">Agenda</a>
            </h2>
            <article class="featured-event grid-8 grid-smalltablet-12 no-gutter-smalltablet no-gutter-left">
                <?php
                    $agenda_dest = get_field('evento_destacado', 'option')[0];
                    echo get_the_post_thumbnail( $agenda_dest, 'horizontal', array( 'class' => 'elastic-img cover' ));
                    echo generate_event_module( $agenda_dest );
                ?>
            </article>

            <div class="grid-4 grid-smalltablet-12 no-gutter-smalltablet no-gutter-right bg-blanco">
                <?php 
                    echo get_eventos(array(
                        'posts_per_page' => 2,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'tipo_agenda',
                                'field'    => 'slug',
                                'terms'    => 'agenda-cultural'
                            )
                        )
                    ));
                ?>
                <div class="grid-12 island">
                    <a href="<?php echo get_post_type_archive_link('agenda'); ?>" class="pretty-link arrow" rel="section" title="Ver toda la agenda">Ver toda la agenda</a>
                </div>
            </div>
        </section>
          
        <section class="parent separated-section">
            <?php
            $children = get_posts(array(
                'posts_per_page' => -1,
                'post_type' => 'page',
                'post_parent' => $post->ID,
                'orderby' => 'menu_order',
                'order' => 'ASC'
            ));
            foreach( $children as $child ){ ?>
                <div class="grid-6 grid-smalltablet-12">
                    <figure class="figure big">
                        <?php echo get_the_post_thumbnail( $child->ID, 'regular-big', array( 'class' => 'elastic-img cover' )); ?>
                        <figcaption class="figure-data">
                            <p class="figure-name" data-func="deployParent" data-parent=".figure" >
                                <?php echo get_the_title( $child->ID ); ?>
                            </p>
                            <div class="figure-meta">
                                <?php
                                    $sedes_asociadas = get_field('sedes_asociadas', $child->ID);
                                    if( !empty( $sedes_asociadas ) ){
                                        $nombres = array();
                                        foreach( $sedes_asociadas as $sede ){
                                            $nombres[] = $sede->name;
                                        }
                                        echo '<p>Sedes: '. implode(', ', $nombres) .'</p>';
                                    }
                                ?>
                                <div class="island righted-text">
                                    <a href="<?php echo get_permalink($child->ID); ?>" class="pretty-link arrow inline" rel="subsection" title="Ver <?php echo get_the_title( $child->ID ); ?>">Ver más</a>
                                </div>
                            </div>
                        </figcaption>
                    </figure>
                </div>
            <?php } ?>
        </section>
    </div>
</main>

<?php get_footer(); ?>