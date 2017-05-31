<?php
    /*
    Template Name: Condiciones de uso
    */
    get_header();
    the_post();
?>

<main id="main-content" class="main-content" role="main">
    <div class="container">
        <?php echo generate_breadcrumbs(); ?>

        <section class="page-header">
            <h1 class="section-title big icon hide-on-vertical-tablet-down">
                <span class="bg-neutral" ><?php echo the_title(); ?></span>
            </h1>

            <?php get_template_part( 'partials/regular', 'page-header' ); ?>
        </section>
          
        <section class="parent page-body">
            <section class="grid-9 no-gutter-right grid-smalltablet-12 no-gutter-smalltablet centered">
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