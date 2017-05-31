<?php 

$search_term = sanitize_text_field( get_query_var('s') );

get_header();

?>

<main id="main-content" class="main-content" role="main">
    <div class="container">
        <section class="breadcrumbs hide-on-vertical-tablet-down" >
            <a href="<?php echo home_url(); ?>" title="Ir a la página de inicio" rel="index">Inicio</a>
            <span>Resultado de búsqueda</span>
        </section>
          
        <section class="parent page-body">
            <div class="grid-8 grid-smalltablet-12 no-gutter-left no-gutter-smalltablet">
                <div class="bg-blanco">
                    <h1 class="section-title big icon standalone always-visible">
                        <span class="bg-neutral" >Resultado de búsqueda</span>
                    </h1>
                    
                    <form class="filters-form regular-form" method="get" action="<?php echo home_url(); ?>" >
                        <div class="filters-wrap bigger">
                            <input class="regular-input inline-input filter-object" type="search" name="s" placeholder="Ingrese su búsqueda" value="<?php echo $search_term; ?>" required >
                            <input class="filter-object search-submit" type="submit" value="Filtrar" >
                        </div>
                    </form>

                    <?php echo get_complex_search(); ?>
                </div>
            </div>
            <aside class="grid-4 grid-smalltablet-12 no-gutter-right no-gutter-smalltablet">
                <?php get_sidebar('busqueda'); ?>
            </aside>
        </section>
    </div>
</main>

<?php get_footer(); ?>