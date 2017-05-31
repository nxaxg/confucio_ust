<?php
    $email_contents = $GLOBALS['email_contents'];
?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $email_contents['title']; ?></title>
</head>
<body style="background: #ededed; padding: 0; margin: 0; font-family: sans-serif;" >

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
	
	<div id="header" style="display: block; width: 100%; background: #be0010; text-align: center; padding: 40px 10px;" >
		<img style="display: inline-block; max-width: 90%" src="<?php bloginfo('template_directory'); ?>/images/logos/logo-confucio.png">
	</div>

	<div id="cuerpo" style="padding: 40px 0;" >
		<div style="background: #ffffff; padding: 40px; width: 600px; max-width: 100%; margin: 0 auto; box-sizing: border-box;" >
			<table style="border-collapse: collapse; width: 100%;" >
				<tr>
					<td>
						<h1 style="display: block; font-size: 14px; font-weight: bold; margin: 0 0 1.5em 0; color: #84001A;">
							<?php echo $email_contents['intro']; ?>
						</h1>

						<div style="display: block; font-size: 14px; color: #333; margin-bottom: 40px;" >
							<?php echo $email_contents['mensaje']; ?>

							<p>
								Saluda <br>
								<strong>Instituto Confucio UST</strong>
							</p>
						</div>

						<p style="font-size: 11px;" >Por favor, no responda a este correo.</p>
					</td>
				</tr>
			</table>
		</div>
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