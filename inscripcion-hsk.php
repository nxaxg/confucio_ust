   <?php
    /*
    Template Name: Inscripción examen HSK
    */
   
    //// acciones para recibir el POST del formulario
    $sending_form_valid = false;
    $sending_reminder_valid = false;

    if( strpos( $_SERVER['REQUEST_URI'] ,'exito') !== false && !isset( $_POST['st_nonce'] ) ){
        wp_redirect( get_permalink( $post->ID ), 301 );
        exit;
    }
    elseif( isset( $_POST['st_nonce'] ) ){
        $sending_form_valid = send_inscripcion_examen_form( $_POST );
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
                <span class="bg-neutral" >Inscripción al Examen HSK</span>
            </h1>

            <div class="parent page-content font-bigger bg-blanco">
                <?php echo apply_filters('the_content', get_field('texto_intro') ); ?>
            </div>
        </section>
          
        <section id="feedback" class="parent page-body">
            <aside class="grid-3 no-gutter-left grid-smalltablet-12 no-gutter-smalltablet" data-area-name="desktop-page-nav">
                <?php get_sidebar(); ?>
            </aside>
            <section id="formulario" class="grid-9 no-gutter-right grid-smalltablet-12 no-gutter-smalltablet">
                <div class="page-content bg-blanco hide-on-device">
                    <?php if( $sending_form_valid === true ) : ?>
                        <div class="grid-8 grid-tablet-12 no-gutter centered">
                            <h2>Su inscripción fue recibida con éxito</h2>
                            <p>
                                Prontamente nos contactaremos con usted para confirmar lugar y hora de rendición del examen.
                            </p>
                            <p>
                                Saluda <br>
                                <strong>Instituto Confucio</strong>
                            </p>
                        </div>
                    <?php elseif( $sending_form_valid === 'invalid' ) : ?>
                        <div class="grid-8 grid-tablet-12 no-gutter centered">
                            <h2>Lo sentimos</h2>
                            <p>
                                Su inscripción no pudo ser enviada, recomendamos que <a href="<?php the_permalink(); ?>" title="Volver al formulario">intente de nuevo</a> o espere un momento para volver intentar
                            </p>
                            <p>
                                Asegúrese de tener todos los documentos que deben ser adjuntados en el formulario.
                            </p>
                            <p>
                                Saluda <br>
                                <strong>Instituto Confucio</strong>
                            </p>
                        </div>
                    <?php else : ?>
                        <form class="regular-form parent" method="post" action="<?php the_permalink(); ?>exito/#feedback" enctype="multipart/form-data" data-validation="complex" >
                            <h2 class="important-title">
                                Datos sobre el examen
                            </h2>
                            <fieldset class="grid-8 grid-tablet-12 no-gutter centered" >
                                <label class="regular-label required">Seleccione el tipo de examen que desea rendir</label>
                                <p class="regular-form-helper">Puede elegir uno o ambos exámenes</p>

                                <div class="inline-options-box">
                                    <label class="checkbox-label">
                                        <input class="required" type="checkbox" name="tipo-examen[]" value="Oral" data-custom-validation="oneOfUs" data-input-group="tipo-examen">
                                        <span>Examen oral</span>
                                    </label>
                                    <label class="checkbox-label">
                                        <input class="required" type="checkbox" name="tipo-examen[]" value="Escrito" data-custom-validation="oneOfUs" data-input-group="tipo-examen">
                                        <span>Examen escrito</span>
                                    </label>
                                </div>

                                <label class="regular-label">Seleccione nivel examen escrito</label>
                                <div class="inline-options-box">
                                    <label class="radio-label">
                                        <input type="radio" name="examen-escrito" value="1">
                                        <span>1</span>
                                    </label>
                                    <label class="radio-label">
                                        <input type="radio" name="examen-escrito" value="2">
                                        <span>2</span>
                                    </label>
                                    <label class="radio-label">
                                        <input type="radio" name="examen-escrito" value="3">
                                        <span>3</span>
                                    </label>
                                    <label class="radio-label">
                                        <input type="radio" name="examen-escrito" value="4">
                                        <span>4</span>
                                    </label>
                                    <label class="radio-label">
                                        <input type="radio" name="examen-escrito" value="5">
                                        <span>5</span>
                                    </label>
                                    <label class="radio-label">
                                        <input type="radio" name="examen-escrito" value="6">
                                        <span>6</span>
                                    </label>
                                </div>

                                <label class="regular-label">Seleccione nivel examen oral</label>
                                <div class="inline-options-box">
                                    <label class="radio-label">
                                        <input type="radio" name="examen-oral" value="Básico">
                                        <span>Básico</span>
                                    </label>
                                    <label class="radio-label">
                                        <input type="radio" name="examen-oral" value="Intermedio">
                                        <span>Intermedio</span>
                                    </label>
                                    <label class="radio-label">
                                        <input type="radio" name="examen-oral" value="Avanzado">
                                        <span>Avanzado</span>
                                    </label>
                                </div>
                                <label class="regular-label required" for="sede">Seleccione su sede de rendición:</label>
                                <select data-func="inputControl" data-events="change.st" data-group="activity-type"class="regular-input select" id="sede" name="sede" required>
                                    <option value="">Seleccione su sede</option>
                                    <option value="Sede Arica">Arica</option>
                                    <option value="Sede Iquique">Iquique</option>
                                    <option value="Sede Antofagasta">Antofagasta</option>
                                    <option value="Sede Copiapó">Copiapó</option>
                                    <option value="Sede La Serena">La Serena</option>
                                    <option value="Sede Ovalle">Ovalle</option>
                                    <option value="Sede Viña del Mar">Viña del Mar</option>
                                    <option value="Sede Santiago">Santiago</option>
                                    <option value="Sede Rancagua">Rancagua</option>
                                    <option value="Sede Curicó">Curicó</option>
                                    <option value="Sede Talca">Talca</option>
                                    <option value="Sede Chillán">Chillán</option>
                                    <option value="Sede Concepción">Concepción</option>
                                    <option value="Sede Los Angeles">Los Angeles</option>
                                    <option value="Sede Temuco">Temuco</option>
                                    <option value="Sede Valdivia">Valdivia</option>
                                    <option value="Sede Osorno">Osorno</option>
                                    <option value="Sede Puerto Montt">Puerto Montt</option>
                                    <option value="Sede Punta Arenas">Punta Arenas</option>
                                </select>
                            </fieldset>

                            <h2 class="important-title">
                                Adjuntar documentación
                            </h2>
                            <fieldset class="grid-8 grid-tablet-12 no-gutter centered" >
                                <label class="regular-label required" for="comprobante">Comprobante de depósito</label>
                                <p class="regular-form-helper">Formatos permitidos: PDF y JPG</p>
                                <input type="file" id="comprobante" name="comprobante" required data-placeholder="Adjuntar comprobante de deposito" accept="application/pdf, application/x-pdf, image/jpeg, image/jpg">

                                <label class="regular-label required" for="foto-cedula">Cédula de identidad por ambos lados</label>
                                <p class="regular-form-helper">Formatos permitidos: PDF y JPG</p>
                                <input type="file" id="foto-cedula" name="foto-cedula" required data-placeholder="Adjuntar cédula de identidad por ambos lados" accept="application/pdf, application/x-pdf, image/jpeg, image/jpg">

                                <label class="regular-label required" for="foto-pasaporte">Fotografía Digital Tipo Pasaporte</label>
                                <p class="regular-form-helper">Formatos permitidos: JPG (Tamaño máximo 500kb)</p>
                                <input type="file" id="foto-pasaporte" name="foto-pasaporte" required data-placeholder="Adjuntar pasaporte" accept="image/jpeg, image/jpg" data-max-filesize="500000">
                            </fieldset>

                            <h2 class="important-title">
                                Datos personales
                            </h2>
                            <fieldset class="grid-8 grid-tablet-12 no-gutter centered" >
                                <label class="regular-label required" for="nombre">Nombre</label>
                                <input class="regular-input" type="text" id="nombre" name="nombre" placeholder="Ingrese su nombre" required>

                                <label class="regular-label required" for="apellido">Apellidos</label>
                                <input class="regular-input" type="text" id="apellido" name="apellido" placeholder="Ingrese su apellido paterno y materno" required>

                                <label class="regular-label required" for="pais">Nacionalidad</label>
                                <select class="regular-input select" id="pais" name="pais" required>
                                    <option value="">Seleccione su nacionalidad</option>
                                    <?php
                                        foreach( $paises as $pais ){
                                            $selected = $pais === 'Chile' ? 'selected' : '';
                                            echo '<option '. $selected .' value="'. $pais .'">'. $pais .'</option>';
                                        }
                                    ?>
                                </select>

                                <label class="regular-label required" for="rut">Cédula de identidad</label>
                                <input class="regular-input" type="text" id="rut" name="rut" required placeholder="Ingrese su rut" data-custom-validation="validateRut">

                                <label class="regular-label required">Fecha de nacimiento</label>
                                <div class="inline-options-box">
                                    <select class="regular-input select" name="born-day" required>
                                        <option value="">Día</option>
                                        <?php
                                            for( $i = 1; $i < 32; $i++ ){
                                                echo '<option value="'. $i .'">'. $i .'</option>';
                                            }
                                        ?>
                                    </select>

                                    <select class="regular-input select" name="born-month" required>
                                        <option value="">Mes</option>
                                        <?php
                                            for( $i = 1; $i < 13; $i++ ){
                                                echo '<option value="'. $i .'">'. ucfirst(date_i18n('F', mktime(0,0,0,$i,1,date('Y')))) .'</option>';
                                            }
                                        ?>
                                    </select>

                                    <select class="regular-input select" name="born-year" required>
                                        <option value="">Año</option>
                                        <?php
                                            $current_year = date('Y');
                                            for( $i = $current_year; $i > 1900; $i-- ){
                                                echo '<option value="'. $i .'">'. $i .'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>

                                <label class="regular-label required" for="idioma">Idioma nativo</label>
                                <input class="regular-input" type="text" id="idioma" name="idioma" placeholder="Ingrese su idioma" required>
                                
                                <label class="regular-label required" for="telefono">Teléfono</label>
                                <input class="regular-input" type="text" id="telefono" name="telefono" placeholder="Ingrese su teléfono" required>

                                <label class="regular-label required" for="email">E-mail</label>
                                <input class="regular-input" type="email" id="email" name="email" placeholder="Ingrese su email" required>

                                <label class="regular-label required" for="direccion">Dirección</label>
                                <input class="regular-input" type="text" id="direccion" name="direccion" placeholder="Calle, nº (depto.), Comuna, Ciudad" required>
                                
                                <label class="regular-label required" for="ciudad">Ciudad de residencia</label>
                                <input class="regular-input" type="text" id="ciudad" name="ciudad" placeholder="Ingrese la ciudad donde vive" required>

                                <label class="regular-label required" for="actividad">Actividad</label>
                                <select data-func="inputControl" data-events="change.st" data-group="activity-type"class="regular-input select" id="actividad" name="actividad" required>
                                    <option value="">Seleccione su actividad</option>
                                    <option value="Profesión">Profesión / Ocupación</option>
                                    <option value="Educación superior">Educación superior</option>
                                </select>

                                <div class="changing-inputs" data-role="activity-type" data-name="Profesión">
                                    <label class="regular-label required" for="profesion">Profesión / Ocupación</label>
                                    <input class="regular-input" type="text" id="profesion" name="profesion" placeholder="Ingrese su profesión u ocupación" >
                                </div>
                                
                                <div class="changing-inputs" data-role="activity-type" data-name="Educación superior">
                                    <label class="regular-label required" for="institucion">Colegio o Institución</label>
                                    <input class="regular-input" type="text" id="institucion" name="institucion" placeholder="Ingrese su colegio o institución" >

                                    <label class="regular-label required" for="carrera">Curso o Carrera</label>
                                    <input class="regular-input" type="text" id="carrera" name="carrera" placeholder="Ingrese su curso o carrera" >
                                </div>

                                <label class="regular-label">¿Posee estudios de Chino?</label>
                                <div class="inline-options-box">
                                    <label class="radio-label">
                                        <input type="radio" name="estudios-chino" value="Si" data-func="inputControl" data-events="change.st" data-group="estudios-chino">
                                        <span>Si</span>
                                    </label>
                                    <label class="radio-label">
                                        <input type="radio" name="estudios-chino" value="No" checked data-func="inputControl" data-events="change.st" data-group="estudios-chino">
                                        <span>No</span>
                                    </label>
                                </div>

                                <div class="changing-inputs" data-role="estudios-chino" data-name="Si">
                                    <label class="regular-label required" for="lugar-estudio-chino">Lugar donde estudió Chino</label>
                                    <input class="regular-input" type="text" id="lugar-estudio-chino" name="lugar-estudio-chino" placeholder="Ingrese dónde estudió chino" >

                                    <label class="regular-label required" for="rango-duracion">Estudios de chino (Duración)</label>
                                    <select class="regular-input select" id="rango-duracion" name="rango-duracion">
                                        <option value="">Seleccione un rango</option>
                                        <option value="0 - 6 meses">0 - 6 meses</option>
                                        <option value="6 meses - 1 año">6 meses - 1 año</option>
                                        <option value="1 año - 3 años">1 año - 3 años</option>
                                        <option value="Mas de 3 años">Mas de 3 años</option>
                                    </select>
                                </div>

                                <div class="island">
                                    <input class="button secundario" type="submit" value="Enviar">
                                    <p data-role="required-helper" class="regular-form-helper">*Campos requeridos</p>
                                </div>

                                <?php wp_nonce_field('enviar_inscripcion_hsk', 'st_nonce'); ?>
                            </fieldset>
                        </form>
                    <?php endif; ?>
                </div>
                <div class="page-content bg-blanco only-on-device">
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
                </div>
            </section>
        </section>
    </div>
</main>

<?php get_footer(); ?>