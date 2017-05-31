<?php
    /*
    Template Name: Inscripción Cursos
    */
   
    //// acciones para recibir el POST del formulario
    $sending_form_valid = false;

    if( strpos( $_SERVER['REQUEST_URI'] ,'exito') !== false && !isset( $_POST['st_nonce'] ) ){
        wp_redirect( get_permalink( $post->ID ), 301 );
        exit;
    }
    elseif( isset( $_POST['st_nonce'] ) ){
        $sending_form_valid = send_inscripcion_curso_form( $_POST );
    }

    $force_curso = '';
    if( isset($_GET['curso']) && $_GET['curso'] ){
        $force_curso = $_GET['curso'];
    }

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
          
        <section id="feedback" class="parent page-body">
            <aside class="grid-3 no-gutter-left grid-smalltablet-12 no-gutter-smalltablet" data-area-name="desktop-page-nav">
                <?php get_sidebar('cursos'); ?>
            </aside>
            <section class="grid-9 no-gutter-right grid-smalltablet-12 no-gutter-smalltablet">
                <div class="page-content bg-blanco">
                    <div class="grid-8 grid-tablet-12 no-gutter centered">
                        <?php if( $sending_form_valid === true ) : ?>
                            <h2>Su pre inscripción fue recibida con éxito</h2>
                            <p>
                                Le recordamos que esto es una <strong>pre inscripción.</strong><br>
                                Para hacer efectivo su cupo debe matricularse en la sede para la firma del respectivo contrato.<br>
                                Prontamente nos contactaremos con usted para agilizar el proceso.
                            </p>
                            <p>
                                Saluda <br>
                                <strong>Instituto Confucio</strong>
                            </p>
                        <?php elseif( $sending_form_valid === 'invalid' ) : ?>
                            <h2>Lo sentimos</h2>
                            <p>
                                Su pre inscripción no pudo ser enviada, recomendamos que <a href="<?php the_permalink(); ?>" title="Volver al formulario">intente de nuevo</a> o espere un momento para volver intentar
                            </p>
                            <p>
                                Saluda <br>
                                <strong>Instituto Confucio</strong>
                            </p>
                        <?php else : ?>
                            <form class="regular-form" method="post" action="<?php the_permalink(); ?>exito/#feedback" data-validation="complex" >
                                <label class="regular-label required" for="rut">RUT</label>
                                <input class="regular-input" type="text" id="rut" name="rut" required placeholder="Ingrese su rut" data-custom-validation="validateRut">

                                <label class="regular-label required" for="nombre">Nombre</label>
                                <input class="regular-input" type="text" id="nombre" name="nombre" placeholder="Ingrese su nombre" required>

                                <label class="regular-label required" for="apellido">Apellidos</label>
                                <input class="regular-input" type="text" id="apellido" name="apellido" placeholder="Ingrese sus apellidos" required>

                                <label class="regular-label required" for="sede">Sede</label>
                                <?php
                                    $terms = get_terms(array('taxonomy'=>'sede', 'hide_empty' => 0));
                                ?>
                                <select class="regular-input select" id="sede" name="sede" required  data-func="loadCursos" data-events="change.st" data-target="#nivel">
                                    <option value="">Seleccione una sede</option>
                                    <?php
                                        if( !empty($terms) ){
                                            foreach( $terms as $t ){
                                                echo '<option value="'. $t->term_id .'">'. $t->name .'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                                
                                <label class="regular-label required" for="nivel">Nivel</label>
                                <select class="regular-input select" id="nivel" name="nivel" required>
                                    <option value="">Seleccione un nivel</option>
                                    <?php
                                        // $cursos_disponibles = get_field('cursos_disponibles');
                                        // foreach( $cursos_disponibles as $curso_id ) {
                                        //     $title = get_the_title($curso_id);
                                        //     echo '<optgroup label="'. $title .'">';

                                        //     $tabs = get_field('cursos', $curso_id);
                                        //     foreach( $tabs as $tab ){
                                        //         $selected = '';
                                        //         if( $force_curso ===  sanitize_title($tab['titulo']) ){
                                        //             $selected = 'selected';
                                        //         }

                                        //         echo '<option '. $selected .' value="'. $title .' - '. $tab['titulo'] .'">'. $tab['titulo'] .'</option>';
                                        //     }

                                        //     echo '</optgroup>';
                                        // }
                                    ?>
                                </select>                                

                                <label class="regular-label required" for="email">E-mail</label>
                                <input class="regular-input" type="email" id="email" name="email" placeholder="Ingrese su email" required >

                                <label class="regular-label required" for="telefono">Teléfono</label>
                                <input class="regular-input" type="text" id="telefono" name="telefono" placeholder="Ingrese ssu teléfono" required>

                                <!-- <label class="regular-label required" for="convenio">Convenio</label>
                                <select class="regular-input select" id="convenio" name="convenio" required >
                                    <option value="">Seleccione un convenio</option>
                                    <?php
                                        // $convenios_disponibles = get_field('convenios_disponibles');
                                        // if( !empty($convenios_disponibles) ){
                                        //     foreach( $convenios_disponibles as $convenio ){
                                        //         echo '<option value="'. $convenio['nombre_convenio'] .'">'. $convenio['nombre_convenio'] .'</option>';
                                        //     }
                                        // }
                                    ?>
                                </select> -->
                                
                                <label class="regular-label checkbox-label">
                                    <input type="checkbox" name="suscribe-newsletter" value="1" checked>
                                    <span>Deseo recibir información a través del Newsletter</span>
                                </label>

                                <div class="island">
                                    <input class="button secundario" type="submit" value="Enviar">
                                    <p data-role="required-helper" class="regular-form-helper">*Campos requeridos</p>
                                </div>

                                <?php wp_nonce_field('enviar_inscripcion_curso', 'st_nonce'); ?>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
        </section>
    </div>
</main>

<?php get_footer(); ?>