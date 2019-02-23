<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 */
/*function optionsframework_option_name() {
	// Change this to use your theme slug
	return 'options-framework-theme';
}*/
function optionsframework_option_name() {
	// Nombre de la plantilla
	$themename = wp_get_theme();
	$themename = preg_replace("/W/", "_", strtolower($themename) );

	$optionsframework_settings = get_option( 'optionsframework' );
	$optionsframework_settings['id'] = $themename;
	update_option( 'optionsframework', $optionsframework_settings );
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'webtranslations'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */


function optionsframework_options()
{
	//Pestaña Configuración general
	$options[] = array(
	'name' => __('Configuración General', 'options_framework_theme'),
	'type' => 'heading');

	//Cambio del logo
	$options[] = array(
	'name' => __('Logotipo del Sitio Web', 'options_check'),
	'desc' => __('Selecciona el logo a mostrar en la web, tamaño 160px x 160px.', 'options_check'),
	'id' => 'logo_uploader',
	'type' => 'upload');

	// Background normal del sitio web
	$options[] = array(
	'name' => __('Color de Fondo e Imagen de Fondo de la web', 'options_framework_theme'),
	'desc' => __('Selecciona una imagen grande de 1300px mínimo de ancho por 900px ó más de alto. También elegí un color de fondo.', 'options_framework_theme'),
	'id' => 'background_de_la_web',
	'type' => 'background',
	'class' => 'of-background-properties');

	// Background Retina Display del sitio web
	$options[] = array(
	'name' => __('Color de Fondo e Imagen Retina Display de Fondo de la web', 'options_framework_theme'),
	'desc' => __('Selecciona una imagen grande de 2600px mínimo de ancho por 1800px ó más de alto. También elegí un color de fondo.', 'options_framework_theme'),
	'id' => 'background_retina_de_la_web',
	'type' => 'background',
	'class' => 'of-background-properties');

	// Meta: keywords
	$options[] = array(
		'name' => __('Palabras claves', 'options_framework_theme'),
		'desc' => __('Introducir palabras claves de la web que son útiles para algunos buscadores. Muy importantes para SEO.', 'options_framework_theme'),
		'id' => 'meta_keywords2',
		'placeholder' => 'palabra1, palabra2, palabra3...',
		'class' => '',
		'type' => 'text'
	);

	// Data Fiscal
	$options[] = array(
		'name' => __('Data Fiscal', 'options_framework_theme'),
		'desc' => __('Introduzca su enlace al Data Fiscal de AFIP o entidad gubernamental impositiva.', 'options_framework_theme'),
		'id' => 'data_fiscal',
		'placeholder' => '<a href="datafiscal"><img /></a>',
		'class' => '',
		'type' => 'textarea'
	);

	// Google Analitics
	$options[] = array(
		'name' => __('Google Analitycs', 'options_framework_theme'),
		'desc' => __('Introduzca el script de Google Analitycs.', 'options_framework_theme'),
		'id' => 'google_analitycs',
		'placeholder' => 'var _gaq = _gaq || []; _gaq.push(["_setAccount", "UA-40089469-1"]); _gaq.push(["_trackPageview"]); etc...',
		'class' => '',
		'type' => 'textarea'
	);


	/*====================================================================================*/
	/* =================== Pestaña información de contacto ============================== */
	$options[] = array(
	'name' => __('Información de contacto', 'options_framework_theme'),
	'type' => 'heading' );

	// Facebook
	$options[] = array(
		'name' => __('Facebook', 'options_framework_theme'),
		'desc' => __('Introduzca el enlace a Facebook.', 'options_framework_theme'),
		'id' => 'facebook_contact',
		'class' => '',
		'placeholder' => 'www.facebook.com/usuario',
		'type' => 'text'
	);


	// Twitter
	$options[] = array(
		'name' => __('Twitter', 'options_framework_theme'),
		'desc' => __('Introduzca su enlace a Twitter.', 'options_framework_theme'),
		'id' => 'twitter_contact',
		'placeholder' => 'www.twitter.com/usuario',
		'class' => '',
		'type' => 'text'
	);
	
	// LinkedIn
	$options[] = array(
		'name' => __('LinkedIn', 'options_framework_theme'),
		'desc' => __('Introduzca su enlace al perfil de LinkedIn.', 'options_framework_theme'),
		'id' => 'linkedin_contact',
		'placeholder' => 'www.linkedin.com/usuario',
		'class' => '',
		'type' => 'text'
	);
	
	// Google+
	$options[] = array(
		'name' => __('Google+', 'options_framework_theme'),
		'desc' => __('Introduzca su enlace a Google+.', 'options_framework_theme'),
		'id' => 'google_plus_contact',
		'placeholder' => 'plus.google.com/usuario',
		'class' => '',
		'type' => 'text'
	);

	// Email de contacto
	$options[] = array(
		'name' => __('E-mail de contacto', 'options_framework_theme'),
		'desc' => __('Introduzca el Email de contacto, se mostrará al pie del sitio web en un ícono.', 'options_framework_theme'),
		'id' => 'email_contact',
		'placeholder' => 'tu-mail@lo-que-sea.com.ar',
		'class' => '',
		'type' => 'text'
	);
	
	$facebook_contact = of_get_option('facebook_contact','');
	$twitter_contact = of_get_option('twitter_contact','');
	$linkedin_contact = of_get_option('linkedin_contact', '');
	$google_plus_contact = of_get_option('google_plus_contact','');
	$email_contact = of_get_option('email_contact','');
	
	/* para guardar los campos en variable y para mostrarlos con un condicional
	<ul>
	   <?php
			if($tel_contact){echo "<li><strong>Teléfono:</strong>" . $tel_contact . "</li>";}
			if($email_contact){ echo "<li><strong>Email:</strong>" . $email_contact . "</li>";}
			if($dir_contact){ echo"<li><strong>Dirección:</strong>" . $dir_contact . "</li>";}
			if($cp_contact){echo"<li><strong>Cp:</strong>" . $cp_contact . "</li>";}
	   ?>
	</ul>

	*/

	/* ============================================================================== */
	/* Panel de la home page =========================================================*/
	$options[] = array(
	'name' => __('Página de portada principal', 'options_framework_theme'),
	'type' => 'heading');

	// Nombre completo
	$options[] = array(
		'name' => __('Nombre', 'options_framework_theme'),
		'desc' => __('Introduzca su nombre completo.', 'options_framework_theme'),
		'id' => 'nombre_web',
		'placeholder' => 'Don Fulgencio',
		'class' => 'mini',
		'type' => 'text'
	);

	// Apellido completo
	$options[] = array(
		'name' => __('Apellido', 'options_framework_theme'),
		'desc' => __('Introduzca su apellido completo.', 'options_framework_theme'),
		'id' => 'apellido_web',
		'placeholder' => 'Torres Vernet',
		'class' => 'mini',
		'type' => 'text'
	);

	// Título profesional
	$options[] = array(
		'name' => __('Título Profesional u oficio', 'options_framework_theme'),
		'desc' => __('Introduzca su profesión u oficio/actividad.', 'options_framework_theme'),
		'id' => 'profesion_web',
		'placeholder' => __('Domador de grillos', 'webtranslations'),
		'class' => 'mini',
		'type' => 'text'
	);

	// Matrícula profesional
	$options[] = array(
		'name' => __('Matrícula profesional', 'options_framework_theme'),
		'desc' => __('Introduzca un número de matrícula profesional o de registro.', 'options_framework_theme'),
		'id' => 'matricula_web',
		'placeholder' => 'M.P. 123-4',
		'class' => 'mini',
		'type' => 'text'
	);

	// Enlace al colegio profesional
	$options[] = array(
		'name' => __('Enlace de la institución profesional', 'options_framework_theme'),
		'desc' => __('Introduzca un enlace a una institución o registro profesional de su matrícula, o similar.', 'options_framework_theme'),
		'id' => 'enlace_matricula_web',
		'placeholder' => 'www.colegioprofesional.gob.ar/tu-matricula',
		'class' => '',
		'type' => 'text'
	);

	// Texto del botón de acción principal
	$options[] = array(
		'name' => __('Texto del botón de acción principal', 'options_framework_theme'),
		'desc' => __('Introduzca un texto que mostrará el botón.', 'options_framework_theme'),
		'id' => 'boton_principal_web',
		'placeholder' => __('Pedir presupuesto', 'webtranslations'),
		'class' => 'mini',
		'type' => 'text'
	);

	// Almacenamos las páginas de wordpress
	$options_pages = array();
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = __('Seleccione una página:', 'webtranslations');
	foreach ($options_pages_obj as $page)
	{
		$options_pages[$page->ID] = $page->post_title;
	}
	// Elegir la página al cual se enlazará el botón principal
	$options[] = array(
		'name' => __('Enlace del botón principal', 'options_framework_theme'),
		'desc' => __('Elegir a cual página se enlazará el botón de acción principal.', 'options_framework_theme'),
		'id' => 'enlace_boton_principal_web',
		'std' => 'three',
		'type' => 'select',
		'class' => 'small', //mini
		'options' => $options_pages
		);//Pasamos la variable del array de datos que queremos mostrar



	return $options;
}