<?php
    /*
    Template Name: Portadilla Sedes y Salones
    */
    get_header();
    the_post();
?>

<main id="main-content" class="main-content" role="main">
    <div class="container">
        <section class="breadcrumbs hide-on-vertical-tablet-down" >
            <a href="#" title="Ir a la página de inicio" rel="index">Inicio</a>
            <span>Sedes y Salones</span>
        </section>

        <div class="mobile-page-nav-holder" data-area-name="mobile-page-nav" >
            <a id="mobile-nav-expander" class="section-title-expander small icon arrow" href="#" title="Ir a Instituto confucio" rel="section" data-func="toggleTarget" data-target="#mobile-nav-expander, #page-navigation">
                <span class="bg-neutral" >Sedes y Salones</span>
            </a>
        </div>

        <section class="page-header">
            <h1 class="section-title big icon hide-on-vertical-tablet-down">
                <span class="bg-neutral" >Sedes y Salones</span>
            </h1>

            <div class="parent" data-equalize="children" data-mq="tablet-down">
                <div class="grid-7 grid-tablet-12 no-gutter" data-area-name="page-header-intro-text" >
                    <div class="page-header-intro bg-neutralalt pattern" data-mutable="tablet-down" data-mobile-area="page-header-intro-img" data-desktop-area="page-header-intro-text" data-order="1">
                        <p>Conoce Nuestro instituto Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vel maximus nisl, et tempor arcu. Pellentesque vel tempus ante.</p>
                    </div>
                </div>      
                <div class="grid-5 grid-tablet-12 no-gutter" data-area-name="page-header-intro-img">
                    <img src="https://placehold.it/508x286" class="elastic-img cover" data-mutable="tablet-down" data-mobile-area="page-header-intro-text" data-desktop-area="page-header-intro-img" data-order="1">
                </div>
            </div>
        </section>
          
        <section class="parent page-body">
            <aside class="grid-3 no-gutter-left grid-smalltablet-12 no-gutter-smalltablet" data-area-name="desktop-page-nav">
                <nav id="page-navigation" class="page-navigation" data-mutable="vertical-tablet-down" data-mobile-area="mobile-page-nav" data-desktop-area="desktop-page-nav" data-order="1" >
                    <a href="#" title="Ir a Sedes" rel="section">Sedes</a>
                    <a class="current" href="#" title="Ir a Salones" rel="section">Salones</a>
                </nav>
            </aside>
            <section class="grid-9 no-gutter-right grid-smalltablet-12 no-gutter-smalltablet">
                <div class="grid-6 grid-smalltablet-12 no-gutter-left no-gutter-smalltablet">
                    <div class="inner-access bg-corporativo">
                        <h3 class="section-title icon small full standalone">
                            <span class="bg-neutral" >Sedes</span>
                        </h3>
                        <div class="inner-access-body">
                            <p>Conoce nuestro Instituto Lorem ipsumn dolor sit amet, consecteur adipiscing elit.</p>

                            <a class="pretty-link arrow" href="#">Viña</a>
                            <a class="pretty-link arrow" href="#">Santiago</a>
                            <a class="pretty-link arrow" href="#">Talca</a>
                            <a class="pretty-link arrow" href="#">Temuco</a>
                            <a class="pretty-link arrow" href="#">Osorno</a>
                        </div>
                    </div>
                </div>
                <div class="grid-6 grid-smalltablet-12 no-gutter-left no-gutter-smalltablet">
                    <div class="inner-access bg-corporativo">
                        <h3 class="section-title icon small full standalone">
                            <span class="bg-neutral" >Salones</span>
                        </h3>
                        <div class="inner-access-body">
                            <p>Conoce nuestro Instituto Lorem ipsumn dolor sit amet, consecteur adipiscing elit.</p>

                            <a class="pretty-link arrow" href="#">Lista de Salones</a>
                            <a class="pretty-link arrow" href="#">Postula tu colegio como salón</a>
                        </div>                        
                    </div>
                </div>
            </section>
        </section>
    </div>
</main>


<?php get_footer(); ?>