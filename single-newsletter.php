<?php
    if( function_exists('newrelic_disable_autorum') ){
        newrelic_disable_autorum();
    }
    the_post();
?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php the_title(); ?></title>
</head>
<body style="background: #ededed; padding: 0; margin: 0; font-family: sans-serif;" >
	
	<div id="header" style="display: block; width: 100%; background: #be0010; text-align: center; padding: 40px 10px;" >
		<img style="display: inline-block; max-width: 90%" src="<?php bloginfo('template_directory'); ?>/images/logos/logo-confucio.png">
	</div>

    <div style="background: #000000; padding: 5px; text-align: center; font-size: 16px; color: #ffffff" >
        NEWSLETTER <?php echo ucfirst(date_i18n('F Y', strtotime($post->post_date))); ?>
    </div>

	<div id="cuerpo">
        <?php
            $noticia_destacada = get_field('noticia_destacada');
            if( !empty( $noticia_destacada ) ) :
                $dest_id = $noticia_destacada[0];

                // cambiamos a st en linea
                switch_to_blog(2);
        ?>
        		<div style="background: #ffffff; padding: 20px; width: 600px; max-width: 100%; margin: 0 auto; box-sizing: border-box;" >
        			<table style="border-collapse: collapse; width: 100%;" >
        				<tr>
        					<td>
                                <?php
                                    echo get_the_post_thumbnail($dest_id, 'featured-news', array(
                                        'style' => 'display: block; width: 100%; height: auto; margin-bottom: 20px;'
                                    ));
                                ?>

                                <h2 style="font-size: 18px;" >
                                    <a style="color: #be0010" href="<?php echo get_permalink( $dest_id ); ?>"><?php echo get_the_title($dest_id); ?></a>
                                </h2>

                                <p style="line-height: 1.5; font-size: 14px;" >
                                    <?php
                                        echo wp_trim_words( strip_shortcodes( get_content_by_id($dest_id) ), 40 );
                                    ?>
                                </p>
        					</td>
        				</tr>
        			</table>
        		</div>
        <?php
            // volvemos al sitio actual
            restore_current_blog();
            endif;
        ?>

        <div style="background: #000000; padding: 20px; margin: 20px auto; width: 600px; max-width: 100%; box-sizing: border-box; border-radius: 30px 0 30px 0; text-align: center; color: #ffffff; font-size: 18px;" >
            <p style="margin: 0 0 10px 0;">¿Quieres aprender Chino Mandarín?</p>


            <a style="
                display: block;
                padding: 10px;
                background: #f3b610;
                border: 3px solid #daa500;
                color: #000000;
                text-transform: uppercase;
                font-size: 14px;
                text-align: center;
                font-weight: bold;
                text-decoration: none;
                margin: 0 auto;
                width: 70%;
            " href="<?php echo get_permalink( get_post_by_slug('cursos', 'ID') ); ?>">Conoce nuestros Cursos</a>
        </div>

        <?php
            // wp_reset_query();
            $otras_noticias = get_field('otras_noticias');
            if( !empty($otras_noticias) ) : 
                // cambiamos a st en linea
                switch_to_blog(2);
        ?>

            <div style="background: #ffffff; padding: 20px; width: 600px; max-width: 100%; margin: 0 auto; box-sizing: border-box;" >
                <h2 style="
                    display: block;
                    margin: 0;
                    border-top: 3px solid #666666;
                    color: #ffffff;
                    font-weight: bold;
                    text-transform: uppercase;
                    font-size: 20px;
                ">
                    <span style="
                        display: block;
                        padding: 5px 20px;
                        border-radius: 0 0 20px 0;
                        background: #000000;
                        width: 50%;
                        margin-top: -3px;
                    ">
                        Más Novedades
                    </span>
                </h2>
                
                <?php
                    $primera_id = array_shift($otras_noticias);
                ?>

                <table style="border-collapse: collapse; width: 100%; border-bottom: 1px solid #666666;" >
                    <tr>
                        <td>
                            <?php
                                echo get_the_post_thumbnail($primera_id, 'featured-news', array(
                                    'style' => 'display: block; width: 100%; height: auto; margin-bottom: 20px;'
                                ));
                            ?>

                            <h2 style="font-size: 18px;" >
                                <a style="color: #be0010" href="<?php echo get_permalink( $primera_id ); ?>"><?php echo get_the_title($primera_id); ?></a>
                            </h2>

                            <p style="line-height: 1.5; font-size: 14px;" >
                                <?php
                                    echo wp_trim_words( strip_shortcodes( get_content_by_id($primera_id) ), 40 );
                                ?>
                            </p>
                        </td>
                    </tr>
                </table>

                <?php
                    if( !empty($otras_noticias) ) :
                ?>
                    <ul style="line-height: 1.6;">
                        <?php
                            foreach( $otras_noticias as $id ){
                                echo '<li>';
                                echo '<a style="font-weight: bold; color: #daa500;" href="'. get_permalink($id) .'" >'. get_the_title($id) .'</a>';
                                echo '</li>';
                            }
                        ?>
                    </ul>

                <?php
                    endif;
                ?>

            </div>
        <?php
            // volvemos al sitio actual
            restore_current_blog();
            endif;
        ?>
	</div>

	<div id="footer" style="display: block; width: 100%; background: #000000; text-align: center; padding: 40px 10px;" >
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="100%" align="center" style="max-width:600px;">
                    <p style="font-size:18px; color:#FFFFFF; text-transform:uppercase; font-weight:bold; text-align:center;">Síguenos en:</p>
                </td>
            </tr>
            <tr>
                <td width="100%" align="center" style="padding-bottom:10px;">
                    <?php
                        $perfiles = get_social_links();
                    ?>
                    <table>
                        <tr>
                            <td width="40%"></td>
                            <td style="text-align:center; margin:0 auto;">
                                <a href="<?php echo ensure_url( $perfiles['facebook'] ); ?>" title="Facebook">
                                    <img src="<?php bloginfo('template_directory'); ?>/images/emails/facebook-logo.png" alt="Facebook">
                                </a>
                            </td>
                            <td style="text-align:center; margin:0 auto;">
                                <a href="<?php echo ensure_url( $perfiles['twitter'] ); ?>" title="Twitter">
                                    <img src="<?php bloginfo('template_directory'); ?>/images/emails/twitter-logo.png" alt="Twitter">
                                </a>
                            </td>
                            <td style="text-align:center; margin:0 auto;">
                                <a href="<?php echo ensure_url( $perfiles['instagram'] ); ?>" title="Instagram">
                                    <img src="<?php bloginfo('template_directory'); ?>/images/emails/instagram-logo.png" alt="Instagram">
                                </a>
                            </td>
                            <td style="text-align:center; margin:0 auto;">
                                <a href="<?php echo ensure_url( $perfiles['youtube'] ); ?>" title="Youtube">
                                    <img src="<?php bloginfo('template_directory'); ?>/images/emails/youtube-logo.png" alt="Youtube">
                                </a>
                            </td>
                            <td width="40%"></td>
                        </tr>  
                    </table>
                </td>
            </tr>
        </table>
	</div>
</body>
</html>