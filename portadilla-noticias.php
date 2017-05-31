<?php
    /*
    Template Name: Portadilla Noticias
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
            <?php echo get_noticias_featured_archive(); ?>
        </section>
          
        <section class="parent page-body">
            <div class="grid-8 grid-smalltablet-12 no-gutter-left no-gutter-smalltablet">
                <div class="bg-blanco">
                    <?php echo get_noticias_archive(); ?>
                </div>
            </div>
            <div class="grid-4 grid-smalltablet-12 no-gutter-right no-gutter-smalltablet">
                <?php get_sidebar('general'); ?>
            </div>
        </section>
    </div>
</main>

<?php get_footer(); ?>