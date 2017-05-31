        <section class="full-section standalone bg-primario pattern only-on-vertical-tablet-down">
            <button class="go-to-top-btn" data-func="goToTop">
                Ir arriba
            </button>
        </section>
        
        <footer class="main-footer bg-neutral pattern">
            <section class="container footer-body">
                <div class="grid-6 grid-smalltablet-12 no-gutter-smalltablet no-gutter-left">
                    <div class="grid-3 grid-smalltablet-12 no-gutter-smalltablet no-gutter-left footer-body-section separated centered-text-vertical-tablet-down">
                        <img class="elastic-img" src="<?php bloginfo('template_directory'); ?>/images/logos/logo-st.svg" >
                    </div>
                    <?php
                        $contact_info = get_field('informacion_contacto', 'option')[0];
                    ?>
                    <div class="grid-6 grid-smalltablet-12 no-gutter-smalltablet footer-body-section">
                        <h3 class="footer-title">Sede Central Viña del Mar</h3>
                        <p class="footer-info icon map"><?php echo $contact_info['direccion']; ?></p>
                        <p class="footer-info icon phone"><?php echo $contact_info['telefono']; ?></p>
                        <p class="footer-info icon mail"><?php echo $contact_info['email_general']; ?></p>
                        <a class="footer-info icon featured" href="<?php echo get_permalink( get_post_by_slug('sedes-y-salones', 'ID') ); ?>" title="Ver todas las sedes de Instituto Confucio">Ver todas las sedes de Instituto Confucio</a>
                    </div>
                    <ul class="grid-3 grid-smalltablet-12 no-gutter-smalltablet no-gutter-right footer-body-section footer-nav">
                        <?php
                            wp_nav_menu(array(
                                'theme_location' => 'menufooter',
                                'items_wrap' => '%3$s'
                            ));
                        ?>
                    </ul>
                </div>
                <div class="grid-6 grid-smalltablet-12 no-gutter-smalltablet no-gutter-right">
                    <div class="grid-8 hide-on-vertical-tablet-down no-gutter-left footer-body-section ">
                        <h3 class="footer-title">Suscríbete a nuestro Newsletter</h3>
                        <?php echo generate_suscribe_form(); ?>
                    </div>
                    <div class="grid-4 grid-smalltablet-12 no-gutter-smalltablet no-gutter-right footer-body-section ">
                        <h3 class="footer-title">Instituto Confucio UST en las redes sociales</h3>
                        <?php $perfiles = get_social_links(); ?>
                        <div class="footer-socials" >
                            <a href="<?php echo $perfiles['facebook']; ?>" rel="help external" title="Ver Perfil de facebook" class="social-square-link facebook">Facebook</a>
                            <a href="<?php echo $perfiles['twitter']; ?>" rel="help external" title="Ver Perfil de twitter" class="social-square-link twitter">Twitter</a>
                            <a href="<?php echo $perfiles['instagram']; ?>" rel="help external" title="Ver Perfil de instagram" class="social-square-link instagram" >Instagram</a>
                            <a href="<?php echo $perfiles['youtube']; ?>" rel="help external" title="Ver Perfil de youtube" class="social-square-link youtube" >Youtube</a>
                        </div>
                    </div>
                </div>
            </section>
            <section class="footer-bottom centered-text bg-neutral">
                <p class="container">
                    <a href="<?php echo get_permalink( get_post_by_slug('politicas-de-privacidad-y-condiciones-de-uso', 'ID') ); ?>" title="Ver Políticas de privacidad y condiciones de uso" rel="help">Políticas de privacidad y condiciones de uso</a> | Santo Tomás &copy; todos los derechos reservados | <a href="<?php echo get_permalink( get_post_by_slug('mapa-del-sitio', 'ID') ); ?>" rel="sitemap" title="Ver mapa del sitio">Mapa del sitio</a>
                </p>
            </section>
        </footer>
    </body>

    <?php wp_footer(); ?>
</html>