<section class="page-additionals parent">
    <div class="grid-8 grid-tablet-12 no-gutter-tablet no-gutter-left titled-box">
        <h2 class="section-title small icon plus">
            <a class="bg-neutral" href="<?php echo get_post_type_archive_link('agenda'); ?>" title="Ir a Agenda" rel="section">Agenda</a>
        </h2>

        <div class="grid-6 grid-smalltablet-12 no-gutter-smalltablet no-gutter-left">
            <?php echo get_eventos(array('posts_per_page' => 3 )); ?>
        </div>
        <div class="grid-6 no-gutter-right hide-on-vertical-tablet-down">
            <?php echo get_eventos(array('posts_per_page' => 3, 'offset' => 3 )); ?>
        </div>
    </div>
    <div class="responsive-section grid-4 grid-tablet-12 no-gutter-tablet no-gutter-right">
        <?php echo get_noticias(); ?>
    </div>
</section>