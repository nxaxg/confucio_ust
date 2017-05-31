<?php
    /*
    Template Name: Contacto
    */
    
    //// acciones para recibir el POST del contacto
    $sending_form_valid = false;
    if( isset( $_POST['st_nonce'] ) ){
        $sending_form_valid = send_contact_form( $_POST );
    }
    elseif( strpos( $_SERVER['REQUEST_URI'] ,'exito') !== false ){
        wp_redirect( get_permalink( $post->ID ), 301 );
        exit;
    }
    
    get_header();
    the_post();
?>

<!-- Google Code for Confucio ST Conversion Page -->
<script type=“text/javascript”>
/* <![CDATA[ */
var google_conversion_id = 853485656;
var google_conversion_language = “en”;
var google_conversion_format = “3”;
var google_conversion_color = “ffffff”;
var google_conversion_label = “O-zBCIaK-nAQ2ND8lgM”;
var google_remarketing_only = false;
/* ]]> */
</script>
<script type=“text/javascript” src=“//www.googleadservices.com/pagead/conversion.js“>
</script>
<noscript>
<div style=“display:inline“>
<img height=“1” width=“1" style=“border-style:none” alt=“” src="www.googleadservices.com/pagead/conversion/853485656/?label=O-zBCIaK-nAQ2ND8lgM&amp;guid=ON&amp;script=0”/>
</div>
</noscript>

<main id="main-content" class="main-content" role="main">
    <div class="container">
        <?php echo generate_breadcrumbs(); ?>

        <section class="page-header">
            <h1 class="section-title big icon hide-on-vertical-tablet-down">
                <span class="bg-neutral" ><?php the_title(); ?></span>
            </h1>
            <?php 
                // echo generate_map_box( get_field('mapa_general', 'options') );
                echo get_the_post_thumbnail( $post->ID, 'horizontal', array( 'class' => 'elastic-img cover' ));
            ?>
        </section>
          
        <section class="parent page-body">
            <section class="grid-9 no-gutter-right grid-smalltablet-12 no-gutter-smalltablet centered">
                <div class="page-content bg-blanco">
                    <h1><?php the_title(); ?></h1>
                    <?php the_content(); ?>
                </div>
                <div class="page-content bg-blanco">
                    <?php if( $sending_form_valid === true ) : ?>
                        <h2>¡Gracias por escribirnos!</h2>
                        <p>
                            Su mail ha sido recibido con éxito.<br>
                            Prontamente le enviaremos una respuesta a su cuenta de correo
                        </p>
                        <p>Saluda <br> <strong>Instituto Confucio</strong></p>
                    <?php elseif( $sending_form_valid === 'invalid' ) : ?>
                        <h2>Lo sentimos</h2>
                        <p>Su mail no pudo ser enviado, le recomendamos que intente de nuevo o espere un momento para volver a intentar</p>
                        <p>Saluda <br> <strong>Instituto Confucio</strong></p>
                    <?php else : ?>
                        <form class="regular-form" method="post" action="<?php the_permalink(); ?>exito/#feedback" data-validation="generic">
                            <label class="regular-label required" for="contacto-nombre">Nombre</label>
                            <input class="regular-input" type="text" id="contacto-nombre" name="contacto-nombre" placeholder="Ingrese su nombre" required>

                            <?php
                                $invalid_class = '';
                                $invalid_mess = '';
                                if( $sending_form_valid === 'invalid_email' ){
                                    $invalid_class = 'invalid_input';
                                    $invalid_mess = '<p class="regular-form-error" >El email que ingresó no es válido</p>';
                                }
                            ?>

                            <label class="regular-label required" for="contacto-email">E-mail</label>
                            <input class="regular-input <?php echo $invalid_class; ?>" type="email" id="contacto-email" name="contacto-email" placeholder="Ingrese su email" required>
                            <?php echo $invalid_mess; ?>

                            <label class="regular-label required" for="contacto-mensaje">Mensaje</label>
                            <textarea class="regular-input" id="contacto-mensaje" name="contacto-mensaje" placeholder="Ingrese su mensaje" required></textarea>

                            <div class="island">
                                <input class="button secundario" type="submit" value="Enviar mensaje">
                                <p class="regular-form-helper">*Campos requeridos</p>
                            </div>

                            <?php wp_nonce_field('enviar_contacto', 'st_nonce'); ?>
                        </form>
                    <?php endif; ?>
                </div>
            </section>
        </section>
    </div>
</main>

<?php get_footer(); ?>