<?php
    /*
    Template Name: Equipo de trabajo
    */
    $ancestor_id = get_super_parent( $post );
    get_header();
    the_post();
?>

<main id="main-content" class="main-content" role="main">
    <div class="container">
        <?php echo generate_breadcrumbs(); ?>

        <div class="mobile-page-nav-holder" data-area-name="mobile-page-nav" >
            <a id="mobile-nav-expander" class="section-title-expander small icon arrow" href="#" title="Ir a Instituto confucio" rel="section" data-func="toggleTarget" data-target="#mobile-nav-expander, #page-navigation">
                <span class="bg-neutral" ><?php echo get_the_title( $ancestor_id ); ?></span>
            </a>
        </div>

        <section class="page-header">
            <h1 class="section-title big icon">
                <span class="bg-neutral" ><?php the_title(); ?></span>
            </h1>

            <?php get_template_part( 'partials/regular', 'page-header' ); ?>
        </section>
          
        <section class="parent page-body">
            <aside class="grid-3 no-gutter-left grid-smalltablet-12 no-gutter-smalltablet" data-area-name="desktop-page-nav">
                <?php get_sidebar(); ?>
            </aside>
            <section class="grid-9 no-gutter-right grid-smalltablet-12 no-gutter-smalltablet">
                <?php
                    $equipo = get_field('personas');
                    if( !empty($equipo) ){
                        foreach( $equipo as $persona ){
                            echo '<div class="grid-4 grid-tablet-6 grid-smalltablet-12">';

                            // informacion de redes sociales se saca del repeater forzado
                            $redes = $persona['contacto'][0];
                            $redes_string = '';
                            if( $redes['twitter'] || $redes['email'] || $redes['linkedin'] ){
                                $redes_string = '<div>';

                                if( $redes['twitter'] ){
                                    $redes_string .= '<a href="'. ensure_url($redes['twitter']) .'" rel="help external" title="Ver Perfil de twitter" class="social-square-link twitter transparent">Twitter</a>';
                                }

                                if( $redes['email'] ){
                                    $redes_string .= '<a href="mailto:'. $redes['email'] .'" rel="help external" title="Contactar vía email" class="social-square-link email transparent">Email</a>';
                                }

                                if( $redes['linkedin'] ){
                                    $redes_string .= '<a href="'. ensure_url($redes['linkedin']) .'" rel="help external" title="Ver Perfil de linkedin" class="social-square-link linkedin transparent">Linkedin</a>';
                                }

                                $redes_string .= '</div>';
                            }
                            


                            echo generate_figure_module(array(
                                'foto_url' => wp_get_attachment_image_src( $persona['foto'], 'square' )[0],
                                'nombre' => $persona['nombre'],
                                'meta_1' => 'Cargo: ' . $persona['cargo'],
                                'meta_2' => $persona['descripcion'],
                                'adicional' => $redes_string
                            ));
                            echo '</div>';
                        }
                    }
                ?>
            </section>
        </section>

        <?php get_template_part( 'partials/regular', 'page-footer' ); ?>
    </div>
</main>

<?php get_footer(); ?>