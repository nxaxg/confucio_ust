   <?php
    /*
    Template Name: Inscripción Talleres
    */
   
    //// acciones para recibir el POST del formulario
    $sending_form_valid = false;
    $sending_reminder_valid = false;

    if( strpos( $_SERVER['REQUEST_URI'] ,'exito') !== false && !isset( $_POST['st_nonce'] ) ){
        wp_redirect( get_permalink( $post->ID ), 301 );
        exit;
    }
    elseif( isset( $_POST['st_nonce'] ) ){
        $sending_form_valid = send_inscripcion_taller_form( $_POST );
    }
    elseif( isset( $_POST['st_nonce_reminder'] ) ){
        $sending_reminder_valid = send_reminder_form( $_POST );
    }

    $paises = get_paises();

    $ancestor_id = get_super_parent( $post );
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

        <div class="mobile-page-nav-holder" data-area-name="mobile-page-nav" >
            <a id="mobile-nav-expander" class="section-title-expander small icon arrow" href="#" title="Ir a Instituto confucio" rel="section" data-func="toggleTarget" data-target="#mobile-nav-expander, #page-navigation">
                <span class="bg-neutral" ><?php echo get_the_title( $ancestor_id ); ?></span>
            </a>
        </div>

        <section class="page-header">
            <h1 class="section-title big icon hide-on-vertical-tablet-down">
                <span class="bg-neutral" ><?php echo get_the_title(); ?></span>
            </h1>

            <div class="parent page-content font-bigger bg-blanco">
                <?php echo apply_filters('the_content', get_field('texto_intro') ); ?>
            </div>
        </section>
          
        <section class="parent page-body">
            <aside class="grid-3 no-gutter-left grid-smalltablet-12 no-gutter-smalltablet" data-area-name="desktop-page-nav">
                <?php get_sidebar(); ?>
            </aside>
            <section id="formulario" class="grid-9 no-gutter-right grid-smalltablet-12 no-gutter-smalltablet">
                <div class="page-content bg-blanco">
                    <div class="grid-8 grid-tablet-12 no-gutter centered">
                        <?php if( $sending_form_valid === true ) : ?>
                            <h2>Su inscripción fue recibida con éxito</h2>
                            <p>
                                Agradecemos su interés por participar en una de las actividades organizada por nosotros.
                            </p>
                            <p>
                                Saluda <br>
                                <strong>Instituto Confucio</strong>
                            </p>
                        <?php elseif( $sending_form_valid === 'invalid' ) : ?>
                            <h2>Lo sentimos</h2>
                            <p>
                                Su inscripción no pudo ser enviara, recomendamos que <a href="<?php the_permalink(); ?>" title="Volver al formulario">intente de nuevo</a> o espere un momento para volver a intentar
                            </p>
                            <p>
                                Saluda <br>
                                <strong>Instituto Confucio</strong>
                            </p>
                        <?php else : ?>
                            <form class="regular-form" method="post" action="<?php the_permalink(); ?>exito/#formulario" enctype="multipart/form-data" data-validation="complex" >                                
                                <label class="regular-label required" for="sede">Sede</label>
                                <select class="regular-input select" id="sede" name="sede" required data-role="events-place" data-custom-validation="eventsLoad">
                                    <option value="">Seleccione una sede</option>
                                    <?php
                                        $terms = get_terms('sede');
                                        if( !empty($terms) ){
                                            foreach( $terms as $t ){
                                                echo '<option value="'. $t->term_id .'">'. $t->name .'</option>';
                                            }
                                        }
                                    ?>
                                </select>

                                <label class="regular-label required" for="taller">Taller o actividad</label>
                                <select class="regular-input select" id="taller" name="taller" required data-role="events-holder">
                                    <option value="">Seleccione un taller o actividad</option>
                                </select>

                                <label class="regular-label required" for="nombre">Nombre</label>
                                <input class="regular-input" type="text" id="nombre" name="nombre" placeholder="Ingrese su nombre" required>

                                <label class="regular-label required" for="apellido">Apellidos</label>
                                <input class="regular-input" type="text" id="apellido" name="apellido" placeholder="Ingrese sus apellidos" required>

                                <!-- <label class="regular-label required" for="rut">RUT</label>
                                <input class="regular-input" type="text" id="rut" name="rut" name="rut" required placeholder="Ingrese su rut" data-custom-validation="validateRut"> -->

                                <label class="regular-label required" for="telefono">Teléfono</label>
                                <input class="regular-input" type="text" id="telefono" name="telefono" placeholder="Ingrese ssu teléfono" required>

                                <label class="regular-label required" for="email">E-mail</label>
                                <input class="regular-input" type="email" id="email" name="email" placeholder="Ingrese su email" required data-custom-validation="mustMatch" data-match-type="master">

                                <label class="regular-label required" for="email-comfirm">Confirmar Email</label>
                                <input class="regular-input" type="email" id="email-comfirm" name="email-comfirm" placeholder="Confirme su email" required data-custom-validation="mustMatch" data-match-type="slave" >

                                <!-- <label class="regular-label required" for="pais">País</label>
                                <select class="regular-input select" id="pais" name="pais" required>
                                    <option value="">Seleccione su país</option>
                                    <?php
                                        foreach( $paises as $pais ){
                                            $selected = $pais === 'Chile' ? 'selected' : '';
                                            echo '<option '. $selected .' value="'. $pais .'">'. $pais .'</option>';
                                        }
                                    ?>
                                </select> -->

                                <label class="regular-label required" for="tipo-asistente">Tipo de asistente</label>
                                <select class="regular-input select" id="tipo-asistente" name="tipo-asistente" required data-func="inputControl" data-events="change.st" data-group="asistente-type">
                                    <option value="" >Seleccione una opción</option>
                                    <option value="Alumno Santo Tomás" >Alumno Santo Tomás</option>
                                    <option value="Alumno Instituto Confucio UST" >Alumno Instituto Confucio UST</option>
                                    <option value="Egresado Santo Tomás" >Egresado Santo Tomás</option>
                                    <option value="Docente o funcionario Santo Tomás" >Docente o funcionario Santo Tomás</option>
                                    <option value="Publico externo" >Publico externo</option>
                                </select>

                                <div class="changing-inputs" data-role="asistente-type" data-name="Alumno Santo Tomás">
                                    <label class="regular-label required" for="alumno-carrera">Carrera</label>
                                    <input class="regular-input" type="text" id="alumno-carrera" name="alumno-carrera" placeholder="Ingrese su carrera" >
                                </div>

                                <div class="changing-inputs" data-role="asistente-type" data-name="Egresado Santo Tomás">
                                    <label class="regular-label required" for="egresado-carrera">Carrera</label>
                                    <input class="regular-input" type="text" id="egresado-carrera" name="egresado-carrera" placeholder="Ingrese su carrera" >
                                </div>

                                <div class="changing-inputs" data-role="asistente-type" data-name="Publico externo">
                                    <label class="regular-label required" for="institucion">Empresa, institución u organización</label>
                                    <input class="regular-input" type="text" id="institucion" name="institucion" placeholder="Ingrese su institución" >
                                </div>

                                <!-- <label class="regular-label required" for="comprobante">Comprobante</label>
                                <input type="file" id="comprobante" name="comprobante" required data-placeholder="Adjuntar comprobante">  -->
                                
                                <label class="regular-label checkbox-label">
                                    <input type="checkbox" name="suscribe-newsletter" value="1" checked>
                                    <span>Deseo recibir información a través del Newsletter</span>
                                </label>

                                <div class="island">
                                    <input class="button secundario" type="submit" value="Enviar">
                                    <p data-role="required-helper" class="regular-form-helper">*Campos requeridos</p>
                                </div>

                                <?php wp_nonce_field('enviar_inscripcion_talleres', 'st_nonce'); ?>
                            </form>

                        <?php endif; ?>
                    </div>
                </div>
                <!-- <div class="page-content bg-blanco only-on-device">
                    <div class="grid-8 grid-tablet-12 no-gutter centered">
                        <?php if( $sending_reminder_valid === true ) : ?>
                            <p>
                                Le hemos enviado un recordatorio a su correo electrónico
                            </p>
                            <p>
                                Saluda <br>
                                <strong>Instituto Confucio</strong>
                            </p>
                        <?php else : ?>
                            <?php
                                echo alerta(array( 'mensaje' => 'Para la inscripción a un examen debe ingresar desde un computador de escritorio.' ));
                            ?>

                            <form class="regular-form" method="post" action="<?php the_permalink(); ?>" enctype="multipart/form-data" data-validation="generic" >
                                <p>Si desea que le recordemos su inscripción, ingrese su email.</p>

                                <label class="regular-label required" for="reminder-nombre">Nombre</label>
                                <input class="regular-input" type="text" id="reminder-nombre" name="reminder-nombre" placeholder="Ingrese su nombre" required>

                                <label class="regular-label required" for="reminder-email">Email</label>
                                <input class="regular-input" type="email" id="reminder-email" name="reminder-email" placeholder="Ingrese su email" required>

                                <div class="island">
                                    <input class="button secundario" type="submit" value="Enviar">
                                    <p class="regular-form-helper">*Campos requeridos</p>
                                </div>

                                <?php wp_nonce_field('enviar_recordatorio', 'st_nonce_reminder'); ?>
                            </form>
                        <?php endif; ?>
                    </div>
                </div> -->
            </section>
        </section>
    </div>
</main>

<?php get_footer(); ?>