<?php require_once( "meta-header.php" ); ?>

<header id="main-header" class="main-header bg-primario pattern">
    <section class="hide-on-vertical-tablet-down bg-corporativo pattern">
        <div class="container">
            <div class="top-bar-menu" data-name="sitios-santo-tomas" data-area-name="sitios-santo-tomas">
                <?php
                    if( $sitios_santo_tomas = get_field('sitios_santo_tomas', 'options') ){
                        echo '<div class="top-bar-menu-items-holder columns-list" data-mutable="vertical-tablet-down" data-mobile-area="mobile-sitios-santo-tomas" data-desktop-area="sitios-santo-tomas">';

                        echo '<ul class="top-bar-menu-list">';

                        foreach( $sitios_santo_tomas as $sitio ){
                            echo '<li><a href="'. ensure_url( $sitio['url_sitio'] ) .'" title="Ver sitio" rel="external nofollow">'. $sitio['nombre_sitio'] .'</a></li>';
                        }

                        echo '</ul>';

                        echo '</div>';
                    }
                ?>
            </div>
        </div>
    </section>
    <section class="menu-top hide-on-vertical-tablet-down" >
        <div class="container">
            <div class="grid-4 no-gutter-left">
                <button id="topbartoggle" class="top-bar-toggle" data-func="toggleTarget" data-target='[data-name="sitios-santo-tomas"], #topbartoggle'>Sitios Santo Tomás</button>
            </div>
            <div class="grid-8 float-right no-gutter-right menu-top-nav" data-area-name="desktop-top-nav">
                <?php 
                    wp_nav_menu(array(
                        'theme_location' => 'menutop',
                        'menu_class' => 'menu-top-items',
                        'items_wrap' => '<ul id="%1$s" class="%2$s" data-mutable="vertical-tablet-down" data-mobile-area="mobile-main-nav" data-desktop-area="desktop-top-nav" data-order="2">%3$s</ul>'
                    ));

                    $perfiles = get_social_links();
                ?>
                <a href="<?php echo ensure_url( $perfiles['facebook'] ); ?>" rel="help external" title="Ver Perfil de facebook" class="social-square-link facebook" data-mutable="vertical-tablet-down" data-mobile-area="mobile-main-nav-socials" data-desktop-area="desktop-top-nav" data-order="3">Facebook</a>
                <a href="<?php echo ensure_url( $perfiles['twitter'] ); ?>" rel="help external" title="Ver Perfil de twitter" class="social-square-link twitter" data-mutable="vertical-tablet-down" data-mobile-area="mobile-main-nav-socials" data-desktop-area="desktop-top-nav" data-order="4">Twitter</a>
                <a href="<?php echo ensure_url( $perfiles['instagram'] ); ?>" rel="help external" title="Ver Perfil de instagram" class="social-square-link instagram" data-mutable="vertical-tablet-down" data-mobile-area="mobile-main-nav-socials" data-desktop-area="desktop-top-nav" data-order="5">Instagram</a>
                <a href="<?php echo ensure_url( $perfiles['youtube'] ); ?>" rel="help external" title="Ver Perfil de youtube" class="social-square-link youtube" data-mutable="vertical-tablet-down" data-mobile-area="mobile-main-nav-socials" data-desktop-area="desktop-top-nav" data-order="6">Youtube</a>
            </div>
        </div>
    </section>
    <section class="header-body" >
        <button class="mobile-deployer nav-deployer" title="Mostrar menú principal" data-func="deployMainNav" >
            <span></span>
        </button>

        <div class="container">
            <nav class="secondary-nav righted-text centered-text-tablet-down hide-on-vertical-tablet-down" data-area-name="desktop-secondary-nav">
                <?php
                    wp_nav_menu(array(
                        'theme_location' => 'secundario',
                        'menu_class' => 'secondary-nav-items',
                        'items_wrap' => '<ul id="%1$s" class="%2$s" data-mutable="vertical-tablet-down" data-mobile-area="mobile-main-nav" data-desktop-area="desktop-secondary-nav" data-order="1">%3$s</ul>'
                    ));
                ?>
            </nav>
            <a class="logo-holder centered-text-tablet-down" href="<?php echo home_url(); ?>" title="<?php pll_e('Ir al inicio'); ?>" rel="index">
                <img class="elastic-img cover" src="<?php bloginfo('template_directory'); ?>/images/logos/logo-confuciov2.svg" alt="Logotipo Instituto Confucio">
            </a>
            <nav id="main-nav" class="main-nav righted-text centered-text-tablet-down" >
                <ul class="main-nav-items">
                    <?php
                        wp_nav_menu(array(
                            'theme_location' => 'principal',
                            'items_wrap' => '%3$s'
                        ));
                    ?>
                    <li class="hide-on-vertical-tablet-down">
                        <button class="main-search-expander" title="Expandir formulario de búsqueda" data-func="toggleTarget" data-target="#main-search-holder" data-focus="#header-search-input" ></button>
                    </li>
                    <li id="main-search-holder" class="main-search-holder" data-area-name="desktop-search-holder" >
                        <form class="main-search" method="get" action="<?php echo home_url(); ?>" data-validation="generic" data-mutable="vertical-tablet-down" data-mobile-area="mobile-search-holder" data-desktop-area="desktop-search-holder" data-order="1">
                            <input id="header-search-input" class="input-search" type="search" name="s" placeholder="Escribe aquí lo que estás buscando..." required>
                            <button type="button" class="main-search-collapser" title="Cerrar formulario de búsqueda" data-func="toggleTarget" data-target="#main-search-holder" ></button>
                            <input class="button secundario" type="submit" value="Buscar">
                        </form>
                    </li>
                </ul>
                <div data-area-name="mobile-main-nav" ></div>
                <div data-area-name="mobile-sitios-santo-tomas" class="only-on-vertical-tablet-down" ></div>
                <div class="mobile-main-nav-socials" data-area-name="mobile-main-nav-socials" ></div>
            </nav>

            <div id="mobile-search-holder" class="mobile-search-holder" data-area-name="mobile-search-holder"></div>
        </div>

        <button class="mobile-deployer search-deployer" title="Mostrar formulario de búsqueda" data-func="deployMobileSearch" ></button>
    </section>
</header>
