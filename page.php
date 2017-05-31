<?php
    $ancestor_id = get_super_parent( $post );
    $ancestor = get_post( $ancestor_id );
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
                <span class="bg-neutral" ><?php echo get_the_title( $ancestor_id ); ?></span>
            </h1>

            <?php get_template_part( 'partials/regular', 'page-header' ); ?>
        </section>
          
        <section class="parent page-body">
            <aside class="grid-3 no-gutter-left grid-smalltablet-12 no-gutter-smalltablet" data-area-name="desktop-page-nav">
                <?php
                    if( $ancestor->post_name === 'cursos' ){
                        get_sidebar( 'cursos' );
                    }
                    else {
                        get_sidebar();
                    }
                ?>
            </aside>
            <section class="grid-9 no-gutter-right grid-smalltablet-12 no-gutter-smalltablet">
                <div class="page-content bg-blanco">
                    <h1><?php the_title(); ?></h1>
                    <?php the_content(); ?>
                </div>
            </section>
        </section>

        <?php get_template_part( 'partials/regular', 'page-footer' ); ?>
    </div>
</main>

<?php get_footer(); ?>