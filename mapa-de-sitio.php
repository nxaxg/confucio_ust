<?php
    /*
    Template Name: Mapa del sitio
    */
    get_header();
    the_post();
?>

<main id="main-content" class="main-content" role="main">
    <div class="container">
        <?php echo generate_breadcrumbs(); ?>

        <section class="page-header bg-blanco">
            <h1 class="section-title big icon standalone">
                <span class="bg-neutral" ><?php the_title(); ?></span>
            </h1>
        </section>
          
        <section class="parent page-body">
            <section class="grid-9 centered no-gutter-right grid-smalltablet-12 no-gutter-smalltablet">
                <div class="page-content bg-blanco">
                    <?php the_content(); ?>
                </div>
            </section>
        </section>
    </div>
</main>

<?php get_footer(); ?>