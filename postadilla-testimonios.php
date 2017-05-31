<?php
    /*
    Template Name: Portadilla Historias para contar
    */
    get_header();
    the_post();
?>

<main id="main-content" class="main-content" role="main">
    <div class="container">
        <?php echo generate_breadcrumbs(); ?>

        <section class="page-header">
            <h1 class="section-title big icon">
                <span class="bg-neutral" ><?php the_title(); ?></span>
            </h1>

            <?php get_template_part( 'partials/regular', 'page-header' ); ?>
        </section>
          
        <section class="parent page-body">
            <section class="grid-8 no-gutter-right grid-smalltablet-12 no-gutter-smalltablet" data-equalize="target" data-mq="vertical-tablet-down" data-eq-target=".news" >
                <?php echo get_testimonios_archive(); ?>
            </section>
            <div class="grid-4 grid-smalltablet-12 no-gutter-right no-gutter-smalltablet">
                <?php get_sidebar('general'); ?>
            </div>
        </section>
    </div>
</main>

<?php get_footer(); ?>