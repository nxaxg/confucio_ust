<?php
    /*
    Template Name: Portadilla Instituto Confucio
    */
    get_header();
    the_post();
?>

<main id="main-content" class="main-content" role="main">
    <div class="container">
        <section class="breadcrumbs hide-on-vertical-tablet-down" >
            <a href="#" title="Ir a la página de inicio" rel="index">Inicio</a>
            <a href="#" title="Ir a Instituto Confucio" rel="section">Instituto Confucio</a>
        </section>

        <div class="mobile-page-nav-holder" data-area-name="mobile-page-nav" >
            <a id="mobile-nav-expander" class="section-title-expander small icon arrow" href="#" title="Ir a Instituto confucio" rel="section" data-func="toggleTarget" data-target="#mobile-nav-expander, #page-navigation">
                <span class="bg-neutral" >Instituto Confucio</span>
            </a>
        </div>

        <section class="page-header">
            <h1 class="section-title big icon hide-on-vertical-tablet-down">
                <span class="bg-neutral" >Instituto Confucio</span>
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
                    <a href="#" title="Ir a Quiénes somos" rel="section">Quiénes somos</a>
                    <a class="current" href="#" title="Ir a Qué hacemos" rel="section">Qué hacemos</a>
                    <a href="#" title="Ir a Equipo de trabajo" rel="section">Equipo de trabajo</a>
                    <a href="#" title="Ir a Cuerpo docente" rel="section">Cuerpo docente</a>
                    <a href="#" title="Ir a Biblioteca" rel="section">Biblioteca</a>
                    <a href="#" title="Ir a Historias para contar" rel="section">Historias para contar</a>
                </nav>
            </aside>
            <section class="grid-9 no-gutter-right grid-smalltablet-12 no-gutter-smalltablet">
                <div class="grid-6 grid-smalltablet-12">
                    <a class="child-access" href="#" title="Ver Página" rel="subsection">
                        <span class="section-title small icon full">
                            <span class="bg-neutral" >Quiénes somos</span>
                        </span>
                        <img src="http://placehold.it/410x230" class="elastic-img cover">
                        <span class="child-access-desc">
                            Conoce Nuestro instituto Lorem ipsum dolor sit amet, consecteur adipiscing elit.
                        </span>
                    </a>
                </div>
                <div class="grid-6 grid-smalltablet-12">
                    <a class="child-access" href="#" title="Ver Página" rel="subsection">
                        <span class="section-title small icon full">
                            <span class="bg-neutral" >Qué hacemos</span>
                        </span>
                        <img src="http://placehold.it/410x230" class="elastic-img cover">
                        <span class="child-access-desc">
                            Conoce Nuestro instituto Lorem ipsum dolor sit amet, consecteur adipiscing elit.
                        </span>
                    </a>
                </div>
                <div class="grid-6 grid-smalltablet-12">
                    <a class="child-access" href="#" title="Ver Página" rel="subsection">
                        <span class="section-title small icon full">
                            <span class="bg-neutral" >Equipo de trabajo</span>
                        </span>
                        <img src="http://placehold.it/410x230" class="elastic-img cover">
                        <span class="child-access-desc">
                            Conoce Nuestro instituto Lorem ipsum dolor sit amet, consecteur adipiscing elit.
                        </span>
                    </a>
                </div>
                <div class="grid-6 grid-smalltablet-12">
                    <a class="child-access" href="#" title="Ver Página" rel="subsection">
                        <span class="section-title small icon full">
                            <span class="bg-neutral" >Cuerpo docente</span>
                        </span>
                        <img src="http://placehold.it/410x230" class="elastic-img cover">
                        <span class="child-access-desc">
                            Conoce Nuestro instituto Lorem ipsum dolor sit amet, consecteur adipiscing elit.
                        </span>
                    </a>
                </div>
                <div class="grid-6 grid-smalltablet-12">
                    <a class="child-access" href="#" title="Ver Página" rel="subsection">
                        <span class="section-title small icon full">
                            <span class="bg-neutral" >Biblioteca</span>
                        </span>
                        <img src="http://placehold.it/410x230" class="elastic-img cover">
                        <span class="child-access-desc">
                            Conoce Nuestro instituto Lorem ipsum dolor sit amet, consecteur adipiscing elit.
                        </span>
                    </a>
                </div>
                <div class="grid-6 grid-smalltablet-12">
                    <a class="child-access" href="#" title="Ver Página" rel="subsection">
                        <span class="section-title small icon full">
                            <span class="bg-neutral" >Historias para contar</span>
                        </span>
                        <img src="http://placehold.it/410x230" class="elastic-img cover">
                        <span class="child-access-desc">
                            Conoce Nuestro instituto Lorem ipsum dolor sit amet, consecteur adipiscing elit.
                        </span>
                    </a>
                </div>
            </section>
        </section>
    </div>
</main>


<?php get_footer(); ?>