<div class="sidebar-widget sidebar-suscribe-box bg-primario pattern centered-text">
    <h2>Suscríbete a nuestro newsletter</h2>
    <p>Recibe semanalmente todas las novedades que Instituto Confucio UST tiene para tí.</p>

    <?php echo generate_suscribe_form(); ?>
</div>

<div class="sidebar-widget titled-box">
    <h3 class="section-title small icon plus">
        <a class="bg-neutral" href="<?php echo get_post_type_archive_link('agenda'); ?>" title="Ir a Agenda" rel="section">Agenda</a>
    </h3>

    <div>
        <?php 
            echo get_eventos(array( 'posts_per_page' => 3 ));
        ?>
    </div>
</div>

<div class="sidebar-widget">
    <?php echo get_noticias(); ?>
</div>