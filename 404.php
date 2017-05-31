<?php get_header(); ?>
<main id="main-content" class="main-content" role="main">
    <div class="container">
        <section class="page-header">
            <h1 class="section-title big icon">
                <span class="bg-neutral" >Página no encontrada</span>
            </h1>

            <div class="parent" data-equalize="children" data-mq="tablet-down">
                <div class="grid-7 grid-tablet-12 no-gutter" data-area-name="page-header-intro-text" >
                    <div class="page-header-intro bg-primario pattern" data-mutable="tablet-down" data-mobile-area="page-header-intro-img" data-desktop-area="page-header-intro-text" data-order="1">
                        <p>"Jamás se desvía uno tan lejos como cuando cree conocer el camino."</p>
                        <p class="page-header-note">Provervio chino</p>
                    </div>
                </div>      
                <div class="grid-5 grid-tablet-12 no-gutter" data-area-name="page-header-intro-img">
                    <?php 
                        echo get_random_thumbnail('regular-big', false, array(
                            'class' => 'elastic-img cover',
                            'data-mutable' => 'tablet-down',
                            'data-mobile-area' => 'page-header-intro-text',
                            'data-desktop-area' => 'page-header-intro-img',
                            'data-order' => '1'
                        ));
                    ?>
                </div>
            </div>
        </section>
          
        <section class="page-body page-content font-bigger bg-blanco parent">
			<div class="grid-9 grid-smalltablet-12 no-gutter-smalltablet centered">
				<h2>Error 404</h2>
				<p>Lo sentimos, la página que busca fué modificada, borrada o no existe. Lo invitamos a continuar su navegación usando nuestro formulario de búsqueda.</p>

				<form class="filters-form regular-form" method="get" action="<?php echo home_url(); ?>" >
                    <div class="filters-wrap bigger">
                        <input class="regular-input inline-input filter-object" type="search" name="s" placeholder="Ingrese su búsqueda" required >
                        <input class="filter-object search-submit" type="submit" value="Filtrar" >
                    </div>
                </form>

                <p>
                	O puede dirigirse a la <a href="<?php echo home_url(); ?>" rel="index" title="Ir a la página de inicio">Página de inicio</a>
                </p>
			</div>
        </section>
    </div>
</main>



<?php get_footer(); ?>