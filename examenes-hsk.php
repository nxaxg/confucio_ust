<?php
    /*
    Template Name: Examenes HSK (Oral o escrito)
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
            <h1 class="section-title big icon hide-on-vertical-tablet-down">
                <span class="bg-neutral" ><?php echo the_title(); ?></span>
            </h1>

            <?php get_template_part( 'partials/regular', 'page-header' ); ?>
        </section>
          
        <section class="parent page-body">
            <aside class="grid-3 no-gutter-left grid-smalltablet-12 no-gutter-smalltablet" data-area-name="desktop-page-nav">
                <?php get_sidebar(); ?>
            </aside>
            <section class="grid-9 no-gutter-right grid-smalltablet-12 no-gutter-smalltablet">
                <?php echo generate_article_actions_box( $post, get_field('texto_intro') ); ?>
                <?php
                    $niveles = get_field('niveles');
                    if( !empty($niveles) ) :
                    foreach( $niveles as $nivel ) :
                ?>
                    <div id="<?php echo sanitize_title( $nivel['nombre'] ); ?>" class="page-content bg-blanco">
                        <h2 class="important-title"><?php echo $nivel['nombre']; ?></h2>
                        <?php 
                            echo apply_filters('the_content', $nivel['descripcion']); 

                            if( isset($nivel['descargable']) && $nivel['descargable'] ){
                                $file_info = get_file_info( $nivel['descargable'] );
                                echo '<a class="pretty-link download" href="'. $file_info['file_url'] .'" title="Descargar PDF" rel="appendix">Descargar PDF</a>';
                            }
                        ?>
                    </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </section>
        </section>

        <?php get_template_part( 'partials/regular', 'page-footer' ); ?>
    </div>
</main>

<?php get_footer(); ?>