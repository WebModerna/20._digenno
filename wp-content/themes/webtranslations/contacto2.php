<?php
/*
* Template Name: Contacto 2
* @package WordPress
* @subpackage webtranslations
* @since webtranslations 1.0
*/
?>
	<?php
		$email_contact = of_get_option('email_contact', '');

		if ( isset( $_POST['boton'] ) )
		{
			if ( $_POST['nombre'] == '' )
			{
				$error1 = '<span class="error" id="error1">'.__('Ingrese su nombre y apellido completo', 'webtranslations').'</span>';
			}
			else if ( $_POST['email'] == '' or !preg_match("/^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/",$_POST['email']) )
			{
				$error2 = '<span class="error" id="error2">'.__('Ingrese un email correcto', 'webtranslations').'</span>';
			}
			else if ( $_POST['telefono'] == '' )
			{
				$error3 = '<span class="error" id="error3">'.__('Ingrese un teléfono correcto', 'webtranslations').'</span>';
			}
			else if ( $_POST['mensaje'] == '' )
			{
				$error4 = '<span class="error" id="error4">'.__('Tiene que ingresar un mensaje', 'webtranslations').'</span>';
			}
			else
			{
				$dest		=	$email_contact;				// Email de destino
				$nombre		=	$_POST['nombre'];			// Nombre de quien envia
				$email		=	$_POST['email'];			// Email de quien envia
				$telefono	=	$_POST['telefono'];		// Teléfono de quién envía
				$idioma		=	$_POST['idioma'];			// Idioma de destino
				$asunto		=	__('Consulta vía Web', 'webtranslations');
				$cuerpo		=	'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es" xml:lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.5, user-scalable=yes" />
	<title>Consulta vía web | María Verónica Di Genno</title>
	<link rel="shortcut icon" type="image/x-icon" href="http://webtranslations.com.ar/wp-content/themes/webtranslations/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="http://webtranslations.com.ar/wp-content/themes/webtranslations/assets/index.css" media="all" />
</head>
<body>
	<table width="100%"align="center" >
		<tr>
			<td>
				<table bgcolor="#ffffff" style="margin:auto;max-width:700px !important;">
					<caption>
						<img src="http://webtranslations.com.ar/wp-content/themes/webtranslations/favicon.ico" alt="Logo" width="16" />
						María Verónica Di Genno
					</caption>
					<thead>
						<tr>
							<th align="center" colspan="2" class="heading heading--contacto centrado">
								<h1 class="centrado">Consulta vía web</h1>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class="right">Apellido y Nonmbre: </td>
							<td class="left">';
							$cuerpo .=$_POST['nombre'];
							$cuerpo .='</td></tr>';
							$cuerpo .='<tr><td class="right">E-Mail: </td><td class="left">';
							$cuerpo .=$_POST['email'];
							$cuerpo .='</td></tr>';
							$cuerpo .='<tr><td class="right">Teléfono: </td><td class="left">';
							$cuerpo .=$_POST['telefono'];
							$cuerpo .='</td></tr>';
							$cuerpo .='<tr><td class="right">Idioma de origen: </td><td class="left">';
							$cuerpo .=$_POST['idioma'];
							$cuerpo .='</td></tr>';
							$cuerpo .='<tr><td class="right">Mensaje: </td><td class="left">';
							$cuerpo .=$_POST['mensaje'];
							$cuerpo .='
								</td>
							</tr>
						</tbody>
					<tfoot>
						<tr>
							<td class="centrado" align="center" colspan="2"><a href="http://webtranslations.com.ar" target="_blank">Web Translations</a> | Todos los derechos reservados</td>
						</tr>
						<tr>
							<td class="centrado" align="center" colspan="2">Desarrollado por <a href="http://www.webmoderna.com.ar" target="_blank">WebModerna</a></td>
						</tr>
					</tfoot>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>';

				// Cabeceras del correo
				$headers  ="From: ".$nombre."<".$email.">"."\r\n";
				$headers .="X-Mailer: PHP5 \n";
				$headers .="MIME-Version: 1.0 \n";
				$headers .="Content-type: text/html; charset=utf-8 \r\n";
				$headers .=$examinar;

				if ( mail ( $dest, $asunto, $cuerpo, $headers ) )
				{
					$result = '<div class="result_ok">'.__('Mensaje enviado correctamente :)', 'webtranslations').'</div>';
					// si el envio fue exitoso reseteamos lo que el usuario escribio:
					$_POST['nombre'] = '';
					$_POST['email'] = '';
					$_POST['telefono'] = '';
					$_POST['idioma'] = '';
					$_POST['mensaje'] = '';
				}
				else
				{
					$result = '<div class="result_fail">'.__('Hubo un error al enviar el mensaje :-(', 'webtranslations').'</div>';
				}
			}
		}
	?>
<?php get_header(); rewind_posts(); if ( have_posts() ) : while ( have_posts() ) :?>
					<!-- Cuerpo principal de la web -->
	<main class="fondo_color">
		<section>
			<header class="heading">
				<h1>
					<?php the_title();?>
					<span class="icon-mail left"></span>
				</h1>
			</header>
			<article>
				<?php the_post();?>
				<div class="estilizacion">
					<div role="form"  dir="ltr">
						<form class="contacto" method="POST" action="" enctype="multipart/form-data">
							<fieldset>
								<legend><?php _e('Datos personales', 'webtranslations');?></legend>

								<input type="text" name="nombre" class="nombre" placeholder="<?php _e('Nombre y Apellido:', 'webtranslations');?>" maxlength="40" value="<?php echo $_POST['nombre'];?>" />
								<div><?php echo $error1 ?></div>

								<input type="email" placeholder="Email:" class="email" name="email" maxlength="60"  value="<?php echo $_POST['email'];?>" />
								<div><?php echo $error2;?></div>

								<input type="tel" placeholder="<?php _e('Teléfono (Optativo):', 'webtranslations');?>" class="telefono" name="telefono" maxlength="15" value="<?php echo $_POST['telefono']; ?>" />
								<div><?php echo $error3;?></div>
							</fieldset>

							<fieldset>
								<legend><?php _e('Idioma de origen', 'webtranslations');?></legend>
								<label for="spanish" class="radio">
									<input type="radio" value="spanish" id="spanish" name="idioma" />
									<?php _e('Español', 'webtranslations');?>
								</label>
								<label for="english" class="radio">
									<input type="radio" value="english" id="english" name="idioma" />
									<?php _e('Inglés', 'webtranslations');?>
								</label>
							</fieldset>

							<fieldset>
								<legend><?php _e('Adjuntar archivo', 'webtranslations');?></legend>
								<p>Hasta 10 Mg (doc, docx, txt, rtf, pdf)</p>
								<label for="examinar" class="boton">
									<input id="examinar" name="examinar" type="file" accept=".doc, .docx, .xls, .xlsx, .txt, .rtf, .pdf"  enctype="multipart/form-data" multiple="multiple" />
								</label>
							</fieldset>

							<fieldset>
								<legend for="mensaje"><?php _e('Detalles', 'webtranslations');?></legend>
								<?php the_content();?>
								<textarea class="mensaje" rows="5" name="mensaje" placeholder="<?php _e('Escriba aquí su mensaje') ?>"><?php echo $_POST['mensaje'];?></textarea>
								<div><?php echo $error4;?></div>
							</fieldset>

							<div>
								<button type="submit" class="boton" name="boton">
									<span class=" icon-check-alt right"></span>
									<?php _e('Enviar', 'webtranslations');?>
								</button>

								<button type="reset" class="boton">
									<span class="icon-x-altx-alt right"></span>
									<?php _e('Limpiar', 'webtranslations');?>
								</button>
							</div>
							<div><?php echo $result;?></div>
						</form>
					</div>
				</div>
			</article>
		</section>




		<?php endwhile; ?>
		<?php else: ?>
		<section class="columna--right">
			<article>
				<h2><?php _e('No hay nada publicado', 'webtranslations') ?></h2>
			</article>
		</section>
		<?php endif; ?>
	</main>

<?php get_footer();?>