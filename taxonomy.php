<?php 
    $current_term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));

    $sede_filtro = 0;
    if( isset($_GET['sede-filtro']) && $_GET['sede-filtro'] && is_numeric($_GET['sede-filtro']) ){
        $sede_filtro = intval($_GET['sede-filtro']);
    }

    get_header();
?>

<main id="main-content" class="main-content" role="main">
    <div class="container">
        <?php echo generate_breadcrumbs(); ?>

        <div class="mobile-page-nav-holder" >
            <a id="mobile-nav-expander" class="section-title-expander small icon arrow" href="#" title="Ir a Instituto confucio" rel="section" data-func="toggleTarget" data-target="#mobile-nav-expander, #page-navigation">
                <span class="bg-neutral" ><?php echo $current_term->name; ?></span>
            </a>

            <nav id="page-navigation" class="page-navigation">
                <a class="<?php echo $current_term->slug === 'agenda-cultural' ? 'current' : ''; ?>" href="<?php echo get_term_link( 'agenda-cultural', 'tipo_agenda' ); ?>" title="Ver todos los eventos en Agenda cultural">Agenda cultural</a>
                <a class="<?php echo $current_term->slug === 'agenda-academica' ? 'current' : ''; ?>" href="<?php echo get_term_link( 'agenda-academica', 'tipo_agenda' ); ?>" title="Ver todos los eventos en Agenda académica">Agenda académica</a>
            </nav>
        </div>

        <section class="parent page-body">
            <div class="grid-8 grid-smalltablet-12 no-gutter-left no-gutter-smalltablet">
                <div class="bg-blanco">
                    <h1 class="section-title big icon standalone hide-on-vertical-tablet-down">
                        <span class="bg-neutral" ><?php echo $current_term->name; ?></span>
                    </h1>

                    <form class="filters-form regular-form" method="get" action="" >
                        <div class="filters-wrap">
                            <span class="filter-object" >Ver</span>
                            <select class="regular-input inline-input select filter-object" name="sede-filtro"  >
                                <option value="">Todas las sedes</option>
                                <?php
                                    $sedes = get_terms('sede');
                                    if( !empty($sedes) ){
                                        foreach( $sedes as $sede ){
                                            $selected = $sede->term_id == $sede_filtro ? 'selected' : '';
                                            echo '<option '. $selected .' value="'. $sede->term_id .'" >'. $sede->name .'</option>';
                                        }
                                    }
                                ?>
                            </select>
                            <input class="filter-object" type="submit" value="Filtrar" >
                        </div>
                    </form>

                    <div class="archive-box">
                        <h2 class="important-title" >Próximos eventos</h2>
                        <?php echo get_eventos(array(), true, true); ?>
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