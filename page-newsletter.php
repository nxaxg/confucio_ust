<?php
    /*
    Template Name: Suscripción newsletter
    */
    
    //// acciones para recibir el POST del formulario
    $sending_form_valid = false;
    if( isset( $_POST['st_nonce'] ) ){
        $sending_form_valid = send_newsletter_form( $_POST );
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

            <?php get_template_part( 'partials/regular', 'page-header' ); ?>
        </section>
          
        <section class="parent page-body">
            <section class="grid-9 no-gutter-right grid-smalltablet-12 no-gutter-smalltablet centered">
                <div class="page-content bg-blanco">
                    <h1><?php the_title(); ?></h1>
                    <?php the_content(); ?>
                </div>
                <div id="feedback" class="page-content bg-blanco">
                    <?php if( $sending_form_valid === true ) : ?>
                        <h2>El formulario se envió con éxito</h2>
                        <p>Muchas gracias por suscribirte</p>
                        <p>Saluda <br> <strong>Instituto Confucio</strong></p>

                    <?php else: ?>
                        <?php
                            $error_feedback = false;
                            $error_class = '';
                            if( $sending_form_valid === 'invalid_email' ){
                                $error_class = 'invalid-input';
                                $error_feedback = '<p class="regular-form-error" >El email que ingresó no es válido</p>';
                            }
                            elseif( $sending_form_valid === 'email_exists' ){
                                $error_class = 'invalid-input';
                                $error_feedback = '<p class="regular-form-error" >El email ya se encuentra suscrito</p>';
                            }
                        ?>

                        <form class="regular-form" method="post" action="<?php echo get_permalink( get_post_by_slug('newsletter', 'ID') ); ?>exito/#feedback" data-validation="generic">
                            <label class="regular-label required">E-mail</label>
                            <input class="regular-input <?php echo $error_class; ?>" type="email" name="suscriber-email" placeholder="Ingrese su email" required>
                            <?php echo $error_feedback; ?>
                            <div class="island">
                                <input class="button secundario" type="submit" value="Suscribirme">
                                <p class="regular-form-helper">*Campos requeridos</p>
                            </div>

                            <?php wp_nonce_field('enviar_suscripcion', 'st_nonce'); ?>
                        </form>

                    <?php endif; ?>
                </div>
            </section>
        </section>

        <?php get_template_part( 'partials/regular', 'page-footer' ); ?>
    </div>
</main>

<?php get_footer(); ?>