<div class="sidebar-widget sidebar-suscribe-box bg-primario pattern centered-text">
    <h2>Suscríbete a nuestro newsletter</h2>
    <p>Recibe semanalmente todas las novedades que Instituto Confucio UST tiene para tí.</p>

    <?php echo generate_suscribe_form(); ?>
</div>

<div class="sidebar-widget">
    <nav class="page-navigation minified" >
        <p class="page-navigation-intro">Conoce más acerca de:</p>
        <?php
            $menu = wp_nav_menu(array(
                'theme_location' => 'menusidebar',
                'echo' => false,
                'items_wrap' => '%3$s'
            ));
            echo strip_tags($menu, '<a>' );
        ?>
    </nav>
</div>

<div class="sidebar-widget titled-box">
    <h3 class="section-title small icon plus">
        <a class="bg-neutral" href="<?php echo get_term_link( 'agenda-cultural', 'tipo_agenda' ); ?>" title="Ir a Agenda cultural" rel="section">Agenda cultural</a>
    </h3>

    <div>
        <?php 
            echo get_eventos(array(
                'posts_per_page' => 3,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'tipo_agenda',
                        'field' => 'slug',
                        'terms' => 'agenda-cultural'
                    )
                )
            )); 
        ?>
    </div>
</div>

<div class="sidebar-widget titled-box">
    <h3 class="section-title small icon plus">
        <a class="bg-neutral" href="<?php echo get_term_link( 'agenda-academica', 'tipo_agenda' ); ?>" title="Ir a Agenda académica" rel="section">Agenda académica</a>
    </h3>

    <div>
        <?php 
            echo get_eventos(array(
                'posts_per_page' => 3,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'tipo_agenda',
                        'field' => 'slug',
                        'terms' => 'agenda-academica'
                    )
                )
            )); 
        ?>
    </div>
</div>