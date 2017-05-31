<?php
    /*
    Template Name: Indice complejo
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
                <span class="bg-neutral" ><?php echo get_the_title( $ancestor_id ); ?></span>
            </h1>

            <?php get_template_part( 'partials/regular', 'page-header' ); ?>
        </section>
          
        <section class="parent page-body">
            <aside class="grid-3 no-gutter-left grid-smalltablet-12 no-gutter-smalltablet" data-area-name="desktop-page-nav">
                <?php get_sidebar(); ?>
            </aside>
            <section class="grid-9 no-gutter-right grid-smalltablet-12 no-gutter-smalltablet">
                <?php
                    $hijas = get_child_by_slug( $post->ID, false );
                    foreach( $hijas as $hijo_id ) :
                        $title = get_the_title( $hijo_id );
                ?>
                <div class="grid-6 grid-smalltablet-12">
                    <a class="child-access" href="<?php echo get_permalink($hijo_id); ?>" title="Ver <?php echo $title; ?>" rel="subsection">
                        <span class="section-title small icon full">
                            <span class="bg-neutral" ><?php echo $title; ?></span>
                        </span>
                        <?php echo get_the_post_thumbnail($hijo_id, 'regular-big', array('class' => 'elastic-img cover' )); ?>
                        <span class="child-access-desc">
                            <?php echo wp_trim_words( get_field('texto_intro', $hijo_id), 20 ); ?>
                        </span>
                    </a>
                </div>
                <?php endforeach; ?>
            </section>
        </section>
    </div>
</main>

<?php get_footer(); ?>