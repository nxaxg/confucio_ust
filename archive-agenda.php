<?php get_header(); ?>

<main id="main-content" class="main-content" role="main">
    <div class="container">
        <?php echo generate_breadcrumbs(); ?>

        <div class="mobile-page-nav-holder" >
            <a id="mobile-nav-expander" class="section-title-expander small icon arrow" href="#" title="Ir a Instituto confucio" rel="section" data-func="toggleTarget" data-target="#mobile-nav-expander, #page-navigation">
                <span class="bg-neutral" >Agenda</span>
            </a>

            <nav id="page-navigation" class="page-navigation">
                <a href="<?php echo get_term_link( 'agenda-cultural', 'tipo_agenda' ); ?>" title="Ver todos los eventos en Agenda cultural">Agenda cultural</a>
                <a href="<?php echo get_term_link( 'agenda-academica', 'tipo_agenda' ); ?>" title="Ver todos los eventos en Agenda académica">Agenda académica</a>
            </nav>
        </div>
          
        <section class="parent page-body">
            <div class="grid-8 grid-smalltablet-12 no-gutter-left no-gutter-smalltablet">
                <div class="bg-blanco">
                    <h1 class="section-title big icon standalone hide-on-vertical-tablet-down">
                        <span class="bg-neutral" >Agenda</span>
                    </h1>

                    <div class="archive-box">
                        <h2 class="important-title" >Agenda Cultural</h2>

                        <?php 
                            echo get_eventos(array(
                                'posts_per_page' => 3,
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => 'tipo_agenda',
                                        'field'    => 'slug',
                                        'terms'    => 'agenda-cultural'
                                    )
                                )
                            ));
                        ?>
                        <a href="<?php echo get_term_link( 'agenda-cultural', 'tipo_agenda' ); ?>" class="pretty-link arrow" title="Ver todos los eventos en Agenda cultural">Ver toda agenda cultural</a>
                    </div>

                    <div class="archive-box">
                        <h2 class="important-title" >Agenda Académica</h2>

                        <?php 
                            echo get_eventos(array(
                                'posts_per_page' => 3,
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => 'tipo_agenda',
                                        'field'    => 'slug',
                                        'terms'    => 'agenda-academica'
                                    )
                                )
                            ));
                        ?>
                        <a href="<?php echo get_term_link( 'agenda-academica', 'tipo_agenda' ); ?>" class="pretty-link arrow" title="Ver todos los eventos en Agenda académica">Ver toda agenda académica</a>
                    </div>
                </div>
            </div>
            <div class="grid-4 grid-smalltablet-12 no-gutter-right no-gutter-smalltablet">
                <?php get_sidebar('agenda'); ?>
            </div>
        </section>
    </div>
</main>

<?php get_footer(); ?>