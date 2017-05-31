<?php
    /*
    Template Name: Biblioteca
    */
   
    //// acciones para recibir el POST del contacto
    $sending_form_valid = false;
    if( isset( $_POST['st_nonce'] ) ){
        $sending_form_valid = send_biblioteca_form( $_POST );
    }

    $ancestor_id = get_super_parent( $post );
    get_header();
    the_post();
?>

<main id="main-content" class="main-content" role="main">
    <div class="container">
        <?php echo generate_breadcrumbs(); ?>

        <div class="mobile-page-nav-holder" data-area-name="mobile-page-nav" >
            <a id="mobile-nav-expander" class="section-title-expander small icon arrow" href="#" title="Ir a Instituto confucio" rel="section" data-func="toggleTarget" data-target="#mobile-nav-expander, #page-navigation">
                <span class="bg-neutral" ><?php echo get_the_title($ancestor_id); ?></span>
            </a>
        </div>

        <section class="page-header">
            <h1 class="section-title big icon hide-on-vertical-tablet-down">
                <span class="bg-neutral" ><?php the_title(); ?></span>
            </h1>

            <?php get_template_part( 'partials/regular', 'page-header' ); ?>
        </section>
          
        <section class="parent page-body">
            <aside class="grid-3 no-gutter-left grid-smalltablet-12 no-gutter-smalltablet" data-area-name="desktop-page-nav">
                <?php get_sidebar(); ?>
            </aside>
            <section class="grid-9 no-gutter-right grid-smalltablet-12 no-gutter-smalltablet">
                <div class="page-content bg-blanco">
                    <?php 
                        echo generate_regular_gallery_slider( get_field('galeria') );
                        the_content(); 
                    ?>
                </div>

                <div id="feedback" class="page-content bg-blanco">
                    <?php if( $sending_form_valid === true ) : ?>
                        <h2>¡Gracias por escribirnos!</h2>
                        <p>
                            Su mail ha sido recibido con éxito.<br>
                            Prontamente le enviaremos una respuesta a su cuenta de correo
                        </p>
                        <p>
                            Saluda <br>
                            <strong>Instituto Confucio UST</strong>
                        </p>
                    <?php elseif($sending_form_valid === 'invalid') : ?>
                        <h2>Lo sentimos</h2>
                        <p>
                            Su mail no pudo ser enviado, recomendamos que <a href="<?php the_permalink(); ?>" title="Volver al formulario" >intente de nuevo</a> o espere un momento para volver a intentar
                        </p>
                        <p>
                            Saluda <br>
                            <strong>Instituto Confucio UST</strong>
                        </p>
                    <?php else : ?>

                        <form class="regular-form" method="post" action="<?php the_permalink(); ?>#feedback" data-validation="generic">
                            <h2>¿Qué tipo de libros buscas?</h2>

                            <label class="regular-label required" for="biblioteca-nombre">Nombre</label>
                            <input class="regular-input" type="text" id="biblioteca-nombre" name="biblioteca-nombre" placeholder="Ingrese su nombre" required>

                            <label class="regular-label required" for="biblioteca-email">E-mail</label>
                            <input class="regular-input" type="email" id="biblioteca-email" name="biblioteca-email" placeholder="Ingrese su email" required>

                            <label class="regular-label required" for="biblioteca-mensaje">¿Qué tipo de libro buscas?</label>
                            <textarea class="regular-input" id="biblioteca-mensaje" name="biblioteca-mensaje" placeholder="Ingrese nombre de texto que busca (Máximo 500 caracteres)" required maxlength="500"></textarea>
                            <p class="regular-form-helper">Recuerde que este campo tiene un máximo de 500 caracteres</p>

                            <label class="regular-label required" for="biblioteca-ciudad">Ciudad de residencia</label>
                            <input class="regular-input" type="text" id="biblioteca-ciudad" name="biblioteca-ciudad" placeholder="Ingrese la ciudad donde vive" required>

                            <label class="regular-label checkbox-label">
                                <input type="checkbox" name="suscribe-newsletter" value="1" checked>
                                <span>Deseo recibir información a través del Newsletter</span>
                            </label>

                            <div class="island">
                                <input class="button secundario" type="submit" value="Enviar formulario">
                                <p class="regular-form-helper">*Campos requeridos</p>
                            </div>

                            <?php wp_nonce_field('enviar_biblioteca', 'st_nonce'); ?>
                        </form>

                    <?php endif; ?>
                </div>
            </section>
        </section>

        <?php get_template_part( 'partials/regular', 'page-footer' ); ?>
    </div>
</main>

<?php get_footer(); ?>