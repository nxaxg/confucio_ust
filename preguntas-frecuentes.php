<?php
    /*
    Template Name: Preguntas frecuentes
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
            <section class="grid-9 no-gutter-right grid-smalltablet-12 no-gutter-smalltablet faq-holder centered">
                <?php
                    $preguntas = get_field('preguntas');
                    if( !empty($preguntas) ) : foreach($preguntas as $pregunta) :
                ?>
                    <article class="faq">
                        <h2 class="faq-title" data-func="deployParent" data-parent=".faq" ><?php echo $pregunta['pregunta']; ?></h2>
                        <div class="faq-body">
                            <div class="page-content">
                                <?php echo apply_filters('the_content', $pregunta['respuesta']); ?>
                            </div>
                        </div>
                    </article>
                <?php endforeach; endif; ?>
            </section>
        </section>
    </div>
</main>

<?php get_footer(); ?>