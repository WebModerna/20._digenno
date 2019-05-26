<?php
/*
* @package WordPress
* @subpackage webtranslations
* @since webtranslations 1.0
*/

// Detección de móviles.
require_once "includes/wp-mobile-detect.php";

// Soporte para los headers personalizados
// require get_template_directory() . '/includes/custom-header.php';

// Configuración del slider
// require_once "includes/options-slider.php";

// Inclusión de soporte para metaboxes
// require_once "includes/demo.php";

/* Cargar Panle de Opciones
/*-----------------------------------------*/
if ( !function_exists( 'optionsframework_init' ) )
{
	define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/includes/' );
	require_once dirname( __FILE__ ) . '/includes/options-framework.php';
}

/*
// Cargar Panel de Opciones
if ( !function_exists( 'optionsframework_init' ) )
{
	define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/includes/' );
	require_once dirname( __FILE__ ) . '/includes/options-framework.php';
}
*/

// Deshabilitar Iconos Emoji
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

// Desactivar el rest api
add_filter('rest_enabled', '_return_false');
add_filter('rest_jsonp_enabled', '_return_false');
remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );

// Remover cosas raras de Wordpress
remove_action( 'wp_head', 'wp_resource_hints', 2 );
remove_action( 'wp_head', 'dns-prefetch' );

// Desactivar el script de embebidos
function my_deregister_scripts()
{
	wp_deregister_script( 'wp-embed' );
}
add_action( 'wp_footer', 'my_deregister_scripts' );


// Agregando un favion al área de administración
function admin_favicon()
{
	echo '<link rel="shortcut icon" type="image/x-icon" href="'.get_bloginfo('stylesheet_directory').'/img/favicon.ico" />';
	echo '<style>img.custom_preview_image {width:100px;}</style>';
}
add_action('admin_head', 'admin_favicon');


/*// Deshabilitar el mensaje de actualización del WordPress
if ( !current_user_can( 'edit_users' ) ) {
  add_action( 'init', create_function( '$a', "remove_action( 'init', 'wp_version_check' );" ), 2 );
  add_filter( 'pre_option_update_core', create_function( '$a', "return null;" ) );
}*/

/*
// Agregando una clase al formulario de contacto
add_filter( 'wpcf7_form_class_attr', 'your_custom_form_class_attr' );

function your_custom_form_class_attr( $class ) {
	$class .= ' vform';
	return $class;
}
*/


// Agregar clases a los enlaces de los posts next y back
function add_class_next_post_link($html)
{
	$html = str_replace('<a','<a title="'.__('Siguiente', 'webtranslations').'" class="enlaces__navegacion"', $html);
	return $html;
}
add_filter('next_post_link','add_class_next_post_link',10,1);

function add_class_previous_post_link($html)
{
	$html = str_replace('<a','<a title="'.__('Anterior', 'webtranslations').'" class="enlaces__navegacion"', $html);
	return $html;
	echo '<span style="padding-right:2em;"></span>';
}
add_filter('previous_post_link','add_class_previous_post_link', 10, 1);


// Permitir comentarios encadenados
function enable_threaded_comments()
{
	if(is_singular() AND comments_open() AND (get_option('thread_comments')==1))
	{
		wp_enqueue_script('comment-reply');
	}
}; 
add_action('get_header','enable_threaded_comments');


// Remover clases automáticas del the_post_thumbnail
function the_post_thumbnail_remove_class($output)
{
	$output = preg_replace('/class=".*?"/', '', $output);
	return $output;
}
add_filter('post_thumbnail_html', 'the_post_thumbnail_remove_class');


//Remover atributos de ancho y alto de las imágenes insertadas
add_filter( 'post_thumbnail_html', 'remove_width_attribute', 10 );
add_filter( 'image_send_to__ditor', 'remove_width_attribute', 10 );
function remove_width_attribute( $html )
{
   $html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
   return $html;
};


//Cambiar el logo del login y la url del mismo y el título
function custom_login_logo()
{
	echo '<style type="text/css">
		body.login
		{
			background: url('.get_bloginfo('stylesheet_directory').'/img/fotografa.jpg) center center no-repeat !important;
			background-size: 100% auto !important;
			background-size: cover !important;
			-o-background-size: cover !important;
			-ms-background-size: cover !important;
			-moz-background-size: cover !important;
			-webkit-background-size: cover !important;
		}
		h1
		{
			padding-top: 20px !important;
		}
		h1 a
		{
			background: #ffffff url('.get_bloginfo('stylesheet_directory').'/img/favicon-196x196.png) center center no-repeat !important;
			background-size: 100% auto !important;
			background-size: cover !important;
			-o-background-size: cover !important;
			-ms-background-size: cover !important;
			-moz-background-size: cover !important;
			-webkit-background-size: cover !important;
			height: 98px !important;
			overflow: hidden !important;
			width: 98px !important;
		}
		div#login
		{
			padding: 0 !important;
		}
		.message, #loginform, h1 a
		{
			border-radius: 5px;
			-moz-border-radius: 5px;
			-webkit-border-radius: 5px;
			box-shadow: 8px 8px 8px #000 !important;

		}

		</style>';
};
add_action('login_head', 'custom_login_logo');
function the_url( $url )
{
	return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'the_url' );
function change_wp_login_title()
{
	return get_option('blogname');
};
add_filter('login_headertitle', 'change_wp_login_title');


//Permitir svg en las imágenes para cargar.
function cc_mime_types($mimes)
{
	$mimes['svg']='image/svg+xml';return $mimes;
};
add_filter('upload_mimes','cc_mime_types');


// Deshabilitar la edición desde otros programas, el link corto y la versión del WP.
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator'); 
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'index_rel_link', 1);
remove_action('wp_head', 'wlwmanifest_link'); 
remove_action('wp_head', 'feed_links__xtra', 3);
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');


//Remover clases e ids automáticos de los menúes
add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1);
add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1);
add_filter('page_css_class', 'my_css_attributes_filter', 100, 1);
function my_css_attributes_filter($var)
{
	return is_array($var) ? array_intersect($var, array('current-menu-item', 'current_page_item')) : '';
};


// Personalizar las palabras del excerpt.
function custom__xcerpt_length($length)
{
	return 40;
}; 
add_filter('excerpt_length','custom__xcerpt_length');


//Remover versiones de los scripts y css innecesarios
function remove_script_version($src)
{
	$parts = explode('?', $src); return $parts[0];
};
// add_filter('script_loader_src', 'remove_script_version', 15, 1);
// add_filter('style_loader_src', 'remove_script_version', 15, 1);


// Deshabilitar los enlaces automáticos en los comentarios
remove_filter('comment_text', 'make_clickable', 9);


//Cambio del avatar de WordPress por uno personalizado
function new_default_avatar ( $avatar_defaults )
{
	//Set the URL where the image file for your avatar is located
	$new_avatar_url = get_bloginfo( 'template_directory' ) . '/img/favicon-128.png';
	//Set the text that will appear to the right of your avatar in Settings>>Discussion
	$avatar_defaults[$new_avatar_url] = 'Webtranslations Avatar';
	return $avatar_defaults;
}
add_filter( 'avatar_defaults', 'new_default_avatar' );
/*function sp_gravatar ($avatar)
{
	$custom_avatar = get_stylesheet_directory_uri() . '/img/favicon-128.png';
	$avatar[$custom_avatar] = "Webtranslations Icono";
	return $avatar;
}
add_filter( 'avatar_defaults', 'sp_gravatar' );*/


// Tamaño del gravatar
function wpsites_change_gravatar_size($size) { return '200';}
add_filter( 'genesis_author_box_gravatar_size', 'wpsites_change_gravatar_size' );

//Modifica el pie de página del panel de administarción
function remove_footer_admin()
{
	echo _e('Desarrollado por', 'webtranslations').' <a title="'.__('WebModerna | el futuro de la web', 'webtranslations').'" href="http://www.webmoderna.com.ar" target="_blank"> <img title="WebModerna" src="'.get_bloginfo("stylesheet_directory").'/img/webmoderna11.png" width="150" style="display:inline-block;vertical-align:middle;" /></a>';
};
add_filter('admin_footer_text','remove_footer_admin');


//Modificar los campos del perfil de usuario de WordPress
function extra_contact_info($contactmethods)
{
	unset($contactmethods['the_author_url']);
	unset($contactmethods['aim']);
	unset($contactmethods['yim']);
	unset($contactmethods['jabber']);
	$contactmethods['profesion_perfil']='Profesión';
	$contactmethods['facebook_perfil']='Facebook';
	$contactmethods['twitter_perfil']='Twitter';
	$contactmethods['linkedin_perfil']='LinkedIn';
	$contactmethods['google_mas_perfil']='Google+';
	return $contactmethods;
};
add_filter('user_contactmethods','extra_contact_info', 10, 1);


//Remover versión del WordPress
function remove_wp_version() { return''; };
add_filter('the_generator','remove_wp_version');


//Eliminar el atributo rel="category tag".
function remove_category_list_rel($output)
{
	return str_replace(' rel="category tag"','',$output);
};
add_filter('wp_list_categories','remove_category_list_rel');
add_filter('the_category','remove_category_list_rel');


//Eliminar css y scripts de comentarios cuando no hagan falta
function clean_header()
{
	wp_deregister_script('comment-reply');
};
add_action('init', 'clean_header');

// Cargar scripts para comentarios solo en single.php y page.php
function wd_single_scripts()
{
   if(is_singular() || is_page())
	{
	   wp_enqueue_script( 'comment-reply' ); // Carga el javascript necesario para los comentarios anidados
	}
}
add_action('wp_print_scripts', 'wd_single_scripts');


//Definir tamaños personalizados de miniaturas - hay que configurarlas
add_theme_support('post-thumbnails');

the_post_thumbnail( 'thumbnail' ); 	// 300x300 real: PEQUEÑO, reducido a 150x150 px.
the_post_thumbnail( 'medium' ); 	// 700x450 real: MEDIO, reducido a 350x225 px.
the_post_thumbnail( 'large' ); 		// 1200x800 real: GRANDE, reducido a 600x400 px.
the_post_thumbnail( 'full' ); 		// COMPLETO. TAMAÑO ORIGINAL. No usar nunca.

add_image_size('custom-thumb-450-450', 900, 900, true); // Galería de imágenes
add_image_size('custom-thumb-300-300', 600, 600, true); // Galería de imágenes
add_image_size('custom-thumb-100-100', 200, 200, true); // Para el blog

// Fotos redimensionables según el tamaño de pantalla
add_image_size('custom-thumb-900-x', 1800, false); // Para el lightbox
add_image_size('custom-thumb-600-x', 1200, false); // Para el single.php
add_image_size('custom-thumb-450-x', 900, false); // Para page.php


//Las miguitas de pan ;-)
function the_breadcrums()
{
	//Defino la ubicación como una variable; así la puedo cargar en la función del bradcrums.
	$ubicacion = __('Ud. está aquí:', 'webtranslations');
	echo '<ul class="breadcrums">';
	if ( !is_home() )
	{
		echo '<li class="breadcrums--label">'.$ubicacion.'<li><a href="';
		echo get_option('home');
		echo '">';
		echo _e('Inicio', 'webtranslations');
		echo '</a></li>';

		if (is_category())
		{
			echo '<li>'.single_cat_title("", false).'</li>';
		};

		if (is_single())
		{
			echo '<li>';
			the_category('<li>', '</li>');
			echo '</li>';
			echo '<li class="breadcrums-muted">';
			echo the_title();
			echo '</li>';
		};

		if (is_page())
		{
			echo '<li class="breadcrums-muted">';
			echo the_title();
			echo '</li>';
		};
	};
echo '</ul>';
};

// gets the value of the custom field featured_image and prints it.
if ( function_exists( 'get_custom_field_value' ) ) get_custom_field_value( 'featured_image', true );


// Habilitar la compresión de imágenes
add_filter('jpeg_quality', create_function('','return 50;'));


//Registrar las menúes de navegación
register_nav_menus (array(
	'header_nav'	=>	__('Menú Principal',  'webtranslations')
	// 'second_nav'	=>	__('Menú Secundario', 'webtranslations')
	)
);

// El mapa de sitio para Google
add_action("publish_post", "eg_create_sitemap");
add_action("publish_page", "eg_create_sitemap");

function eg_create_sitemap()
{
	$postsForSitemap = get_posts(array(
		'numberposts' => -1,
		'orderby' => 'modified',
		'post_type'  => array('post','page'),
		'order'    => 'DESC'
		));

	$sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
	$sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

	foreach($postsForSitemap as $post)
	{
		setup_postdata($post);
		$postdate = explode(" ", $post->post_modified);
		$sitemap .= '<url>'.'<loc>'. get_permalink($post->ID) .'</loc>'.'<lastmod>'. $postdate[0] .'</lastmod>'.'<changefreq>monthly</changefreq>'.'</url>';
	}

	$sitemap .= '</urlset>';

	$fp = fopen(ABSPATH . "sitemap.xml", 'w');
	fwrite($fp, $sitemap);
	fclose($fp);
}

/*
// Crear el sidebar de la derecha
register_sidebar(
	array(
		'name'			=>	__('Barra lateral derecha', 'webtranslations'),
		'id'			=>	'sidebar_right',
		'before_widget'	=>	'<aside class="widget">',
		'after_widget'	=>	'</aside>',
		'before_title'	=>	'<header><h4>',
		'after_title'	=>	'</h4></header>'
	)
);

// Los sidebars del footer
register_sidebar(
	array(
		'name'			=>	__('Pie de página 1 de 4', 'webtranslations'),
		'id'			=>	'sidebar_footer_1',
		'before_widget'	=>	'<aside class="widget widget--sidebar--footer">',
		'after_widget'	=>	'</aside>',
		'before_title'	=>	'<header><h4>',
		'after_title'	=>	'</h4></header>'
	)
);

register_sidebar(
	array(
		'name'			=>	__('Pie de página 2 de 4', 'webtranslations'),
		'id'			=>	'sidebar_footer_2',
		'before_widget'	=>	'<aside class="widget widget--sidebar--footer">',
		'after_widget'	=>	'</aside>',
		'before_title'	=>	'<header><h4>',
		'after_title'	=>	'</h4></header>'
	)
);
register_sidebar(
	array(
		'name'			=>	__('Pie de página 3 de 4', 'webtranslations'),
		'id'			=>	'sidebar_footer_3',
		'before_widget'	=>	'<aside class="widget widget--sidebar--footer">',
		'after_widget'	=>	'</aside>',
		'before_title'	=>	'<header><h4>',
		'after_title'	=>	'</h4></header>'
	)
);
register_sidebar(
	array(
		'name'			=>	__('Pie de página 4 de 4', 'webtranslations'),
		'id'			=>	'sidebar_footer_4',
		'before_widget'	=>	'<aside class="widget widget--sidebar--footer">',
		'after_widget'	=>	'</aside>',
		'before_title'	=>	'<header><h4>',
		'after_title'	=>	'</h4></header>'
	)
);
*/

// Agregar nofollow a los enlaces externos
function auto_nofollow($content)
{
	return preg_replace_callback('/<a>]+/', 'auto_nofollow_callback', $content);
}
function auto_nofollow_callback($matches)
{
	$link = $matches[0];
	$site_link = get_bloginfo('url'); 
	if (strpos($link, 'rel') === false)
	{
		$link = preg_replace("%(href=S(?!$site_link))%i", 'rel="nofollow" $1', $link);
	}
	elseif (preg_match("%href=S(?!$site_link)%i", $link))
	{
		$link = preg_replace('/rel=S(?!nofollow)S*/i', 'rel="nofollow"', $link);
	}
	return $link;
}
add_filter('comment_text', 'auto_nofollow');


//Habilitar botones de edición avanzados
function habilitar_mas_botones($buttons)
{
	$buttons[]='hr';
	$buttons[]='sub';
	$buttons[]='sup';
	$buttons[]='fontselect';
	$buttons[]='fontsizeselect';
	$buttons[]='cleanup';
	$buttons[]='styleselect';
	return $buttons;
};
add_filter("mce_buttons_3","habilitar_mas_botones");

/*
// Agregar varias imágenes a las entradas y páginas
function add_custom_meta_box() {
	add_meta_box(
	'custom_meta_box', // id
	'<strong>'.__('Subir las fotos desde aquí', 'webtranslations').'</strong>', // título
	'show_custom_meta_box', // función a la que llamamos
	'page', // sólo para páginas
	'normal', // contexto
	'high'); // prioridad

	add_meta_box(
	'custom_meta_box', // id
	'<strong>'.__('Subir las fotos desde aquí', 'webtranslations').'</strong>', // título
	'show_custom_meta_box', // función a la que llamamos
	'post', // sólo para páginas
	'normal', // contexto
	'high'); // prioridad
};
add_action('add_meta_boxes', 'add_custom_meta_box');

// Para imágenes cargamos el script sólo si estamos en páginas.
function add_admin_scripts ($hook) {
	global $post;
	if ( $hook == 'post-new.php' || $hook == 'post.php' ) {wp_enqueue_script('custom-js', get_stylesheet_directory_uri().'/js/custom-js.js');}
};
add_action( 'admin_enqueue_scripts', 'add_admin_scripts', 10, 1 );

//Nombre del campo personalizado.
$prefix = 'custom_';
$custom_meta_fields = array( // Dentro de este array podemos incluir más tipos
	 array(
	   'label'  => 'Fotos',
	   'desc'   => __('IMPORTANTE!!: Las imágenes deben ser mínimo de 2000px de ancho.', 'webtranslations'),
	   'id'     => $prefix.'imagenrepetible',
	   'type'   => 'imagenrepetible' ));

// Función show custom metabox. Es larguísimaaaa!!!
function show_custom_meta_box() {
	global $custom_meta_fields, $post;
	// Usamos nonce para verificación
	wp_nonce_field( basename( __FILE__ ), 'custom_meta_box_nonce' );
 // Creamos la tabla de campos personalizados y empezamos un loop con todos ellos
	echo '<table class="form-table"><tr><td><label for="imagenrepetible"><input type="checkbox"  id="imagenrepetible" name="imagenrepetible" value="" />'._e('Activar las diapositivas', 'webtranslations').'</label></td></tr>';
	foreach ($custom_meta_fields as $field) { // Hacemos un loop con todos los campos personalizados
					// obtenemos el valor del campo personalizado si existe para este $post->ID
		$meta = get_post_meta($post->ID, $field['id'], true);
					// comenzamos una fila de la tabla
	echo '<tr><th><label for="'.$field['id'].'">'.$field['label'].'</label></th><td>';
	switch($field['type']) { // Si tenemos varios tipos de campos aquí se seleccionan
// En nuestro caso tenemos solo uno: Imagen repetible
	case 'imagenrepetible': // Lo que pone en "type" más arriba
		$image = get_stylesheet_directory_uri().'/img/favicon-196x196.png'; // Ponemos una imagen por defecto
		echo '<i class="custom_default_image" style="display:none">'.$image.'</i>'; // Al principio no la mostramos
		echo '<ul id="'.$field['id'].'-repeatable" class="custom_repeatable">';
		$i = 0;
	if ($meta) { // Si get_post_meta nos ha dado valores, hacemos un foreach
		foreach($meta as $row) {

// Podéis poner en su lugar thumbnail, medium o large      
		$image = wp_get_attachment_image_src($row, 'custom-thumb-100-100');
// la primera parte de wp_get_attachment_image_src nos da su url.
		$image = $image[0]; ?>
	<li><!-- Añadimos la imagen que se arrastra para cambiar posición, dentro de tu tema -->
		<i title="<?php _e('Arrastrar y soltar. Mover arriba o abajo.', 'webtranslations');?>" class="sort hndle dashicons-before dashicons-image-flip-vertical" style="float:left;">&nbsp;&nbsp;&nbsp;</i>
	<!-- El input con el valor del meta. Su attributo "name" tiene un número que se irá incrementando a medida que creamos nuevos campos -->
	<input name="<?php echo $field['id'] . '['.$i.']'; ?>" id="<?php echo $field['id']; ?>" type="hidden" class="custom_upload_image" value="<?php echo $row; ?>" />
	<!-- mostramos la imagen con 200px de ancho para ver lo que hemos subido -->
	<img src="<?php echo $image; ?>" class="custom_preview_image" alt="" width="70"/><br />
	<!-- El botón de Seleccionar Imagen -->
	<input class="custom_upload_image_button button" type="button" value="<?php _e('Seleccionar imagen', 'webtranslations');?>" />&nbsp;&nbsp;&nbsp;
	<!-- Los botones de eliminar imagen y de quitar fila-->
	<small><a href="#" class="custom_clear_image_button"><?php _e('Eliminar imagen', 'webtranslations');?></a></small>                      
	&nbsp;&nbsp;&nbsp;<a class="repeatable-remove button" href="#"><?php _e('Quitar fila', 'webtranslations');?></a>
</li>
	<?php $i++; // Incrementamos el contador para que no se repita el atributo "name"
} // Fin del foreach
	} else { // Si no hay datos ?>

<li><i title="<?php _e('Arrastrar y soltar. Mover arriba o abajo.', 'webtranslations');?>" class="sort hndle dashicons-before dashicons-image-flip-vertical" style="float:left;">&nbsp;&nbsp;&nbsp;</i>
	<input name="<?php echo $field['id'] . '['.$i.']'; ?>" id="<?php echo $field['id']; ?>" type="hidden" class="custom_upload_image" value="<?php echo $row; ?>" />
	<img src="<?php echo $image; ?>" class="custom_preview_image" alt="" width="200" /><br />
	<input class="custom_upload_image_button button" type="button" value="<?php _e('Seleccionar imagen', 'webtranslations');?>" />
	<small><a href="#" class="custom_clear_image_button"><?php _e('Eliminar imagen', 'webtranslations');?></a></small>
	&nbsp;&nbsp;&nbsp;<a class="repeatable-remove button" href="#"><?php _e('Quitar fila', 'webtranslations');?></a>
</li>
<?php } ?>
</ul><br />
<!-- Botón para añadir una nueva fila -->
<a class="repeatable-add button-primary" href="#">+<?php _e(' Agregar Imagen', 'webtranslations');?></a>
<!-- Aquí va la descripción -->
<br clear="all" /><br /><p class="description"><?php echo $field['desc']; ?></p>
<?php break;} // fin del switch
	echo '</td></tr>';} // fin del foreach
	echo '</table>'; // fin de la tabla
}; // Fin de la función

// Grabar los datos de las imágenes subidas.
function save_custom_meta($post_id) {
	global $custom_meta_fields;
// verificamos usando nonce

	if (!isset($_POST['custom_meta_box_nonce']) || !wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__)))
	return $post_id;
// comprobamos si se ha realizado una grabación automática, para no tenerla en cuenta
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
	return $post_id;
// comprobamos que el usuario puede editar
	if ('page' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id))
		return $post_id;
		} elseif (!current_user_can('edit_post', $post_id)) {
		return $post_id;
}
// hacemos un loop por todos los campos y guardamos los datos
	foreach ($custom_meta_fields as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];
	if ($new && $new != $old) {
		update_post_meta($post_id, $field['id'], $new);
	} elseif ('' == $new && $old) {
		delete_post_meta($post_id, $field['id'], $old);}
	} // final del foreach
};
add_action('save_post', 'save_custom_meta');
*/

// Paginación avanzada
function pagination($pages = '', $range = 2)
{
	$pagina_palabra			= __('Página', 'webtranslations');
	$de_palabra				= __('de', 'webtranslations');
	$primero 				= __('Primero', 'webtranslations');
	$atras 					= __('Atrás', 'webtranslations');
	$siguiente 				= __('Siguiente', 'webtranslations');
	$ultimo 				= __('Último', 'webtranslations');
	$showitems 				= ($range * 1) + 1;
	global $paged;
	if(empty($paged)) $paged = 1;
	if($pages == '')
	{
		global $wp_query;
		$pages = $wp_query->max_num_pages;
		if(!$pages)
		{
			$pages = 1;
		}
	}
	if(1 != $pages)
	{
		echo "<span>".$pagina_palabra." ".$paged." ".$de_palabra." ".$pages."</span>";
		if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a class='boton small' href='".get_pagenum_link(1)."' title=".$primero.">&laquo;</a>";
		if($paged > 1 && $showitems < $pages) echo "<a class='boton small' title=".$atras." href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a>";
		for ($i=1; $i <= $pages; $i++)
		{
			if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
			{
				echo ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive boton small' title='".$i."'>".$i."</a>";
			}
		}
		if ($paged < $pages && $showitems < $pages) echo "<a class='boton small' title=".$siguiente." href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a>"; 
		if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a class='boton small' title=".$ultimo." href='".get_pagenum_link($pages)."'>&raquo;</a>";
	}
};


//Para hacer posible que esta plantilla pueda cambiar de idioma
load_theme_textdomain('webtranslations',TEMPLATEPATH.'/languages');
$locale = get_locale();
$locale_file = TEMPLATEPATH."/languages/$locale.php";
if(is_readable($locale_file)) require_once($locale_file);


//Detén las adivinanzas de URLs de WordPress
add_filter('redirect_canonical','stop_guessing');
function stop_guessing($url)
{
	if(is_404())
	{
		return false;
	}
	return $url;
}

//Ocultar los errores en la pantalla de Inicio de sesión de WordPress
function no__rrors_please()
{
	return __('¡Sal de mi jardín! ¡AHORA MISMO!', 'webtranslations');
};
add_filter('login__rrors','no__rrors_please');


//Eliminar palabras cortas de URL
function remove_short_words($slug)
{
	if (!is_admin()) return $slug;
	$slug = explode('-', $slug);
	foreach ($slug as $k => $word)
	{
		if (strlen($word) < 3)
		{
			unset($slug[$k]);
		}
	}
	return implode('-', $slug);
};
add_filter('sanitize_title', 'remove_short_words');


// Relativas las url.
function relative_url()
{
	// Don't do anything if:
	// - In feed
	// - In sitemap by WordPress SEO plugin
	if ( is_feed() || get_query_var( 'sitemap' ) )
	return;
	$filters = array(
	'post_link',       // Normal post link
	'post_type_link',  // Custom post type link
	'page_link',       // Page link
	'attachment_link', // Attachment link
	'get_shortlink',   // Shortlink
	'post_type_archive_link',    // Post type archive link
	'get_pagenum_link',          // Paginated link
	'get_comments_pagenum_link', // Paginated comment link
	'term_link',   // Term link, including category, tag
	'search_link', // Search link
	'day_link',   // Date archive link
	'month_link',
	'year_link',

	// site location
	// Los comento porque generan error en el modo Depuración en WordPress

	// 'option_siteurl',
	// 'option_home',
	// 'admin_url',
	// 'home_url',
	// 'site_url',//Hasta acá estaba comentado
	'blog_option_siteurl',
	'includes_url',
	'site_option_siteurl',
	'network_home_url',
	'network_site_url',

	// debug only filters
	'get_the_author_url',
	'get_comment_link',
	'wp_get_attachment_image_src',
	'wp_get_attachment_thumb_url',
	'wp_get_attachment_url',
	'wp_login_url',
	'wp_logout_url',
	'wp_lostpassword_url',
	'get_stylesheet_uri',
	'get_stylesheet_directory_uri',//
	'plugins_url',//
	'plugin_dir_url',//
	'stylesheet_directory_uri',//
	'get_template_directory_uri',//
	'template_directory_uri',//
	'get_locale_stylesheet_uri',
	'script_loader_src', // plugin scripts url
	// 'style_loader_src', // Este también estaba comentado
	'get_theme_root_uri',
	// Comento para omitir error en Depuración en WordPress
	);
	foreach ( $filters as $filter )
	{
		add_filter( $filter, 'wp_make_link_relative' );
	};
	home_url($path = '', $scheme = null);
};
add_action( 'template_redirect', 'relative_url', 0 );

/*
// Agrega un título secundario
function myplugin_add_meta_box()
{
	$screens = array( 'post' );
	foreach ( $screens as $screen )
	{
		add_meta_box(
			'myplugin_sectionid',
			__( 'Título secundario.', 'webtranslations' ),
			'myplugin_meta_box_callback',
			$screen
		);
	}
}
add_action( 'add_meta_boxes', 'myplugin_add_meta_box' );

function myplugin_meta_box_callback( $post )
{
	wp_nonce_field( 'myplugin_meta_box', 'myplugin_meta_box_nonce' );
	$value = get_post_meta( $post->ID, '_my_meta_value_key', true );
	echo '<textarea maxlength="160" rows="1" style="width:100%;" id="myplugin_new_field" placeholder="'.__('Escribí un título secundario. Es opcional.', 'webtranslations').'" name="myplugin_new_field">' . esc_attr( $value ) . '</textarea>';
}

function myplugin_save_meta_box_data( $post_id )
{
	if ( ! isset( $_POST['myplugin_meta_box_nonce'] ) )
	{
		return;
	}
	if ( ! wp_verify_nonce( $_POST['myplugin_meta_box_nonce'], 'myplugin_meta_box' ) )
	{
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
	{
		return;
	}
	if ( isset( $_POST['post_type'] ) && 'myplugin_new_field' == $_POST['post_type'] )
	{
		if ( ! current_user_can( 'edit_page', $post_id ) )
		{
			return;
		}
	}
	else
	{
		if ( ! current_user_can( 'edit_post', $post_id ) )
		{
			return;
		}
	}
	if ( ! isset( $_POST['myplugin_new_field'] ) )
	{
		return;
	}
	$my_data = sanitize_text_field( $_POST['myplugin_new_field'] );
	update_post_meta( $post_id, '_my_meta_value_key', $my_data );
}
add_action( 'save_post', 'myplugin_save_meta_box_data' );
*/

// Agrega un meta description
function myplugin_add_meta_box2()
{
	$screens = array( 'page', 'post' );
	foreach ( $screens as $screen )
	{
		add_meta_box(
			'myplugin_sectionid2',
			__( 'Meta: Descripción. Máximo 160 caracteres.', 'webtranslations' ),
			'myplugin_meta_box_callback2',
			$screen
		);
	}
}
add_action( 'add_meta_boxes', 'myplugin_add_meta_box2' );

function myplugin_meta_box_callback2( $post )
{
	wp_nonce_field( 'myplugin_meta_box2', 'myplugin_meta_box_nonce2' );
	$value = get_post_meta( $post->ID, '_my_meta_value_key2', true );
	echo '<textarea maxlength="160" rows="2" style="width:100%;" id="myplugin_new_field2" placeholder="'.__('Es una descripción que aparece en el meta description. Es muy recomendable para SEO.', 'webtranslations').'" name="myplugin_new_field2">' . esc_attr( $value ) . '</textarea>';
}

function myplugin_save_meta_box_data2( $post_id )
{
	if ( ! isset( $_POST['myplugin_meta_box_nonce2'] ) )
	{
		return;
	}
	if ( ! wp_verify_nonce( $_POST['myplugin_meta_box_nonce2'], 'myplugin_meta_box2' ) )
	{
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
	{
		return;
	}
	if ( isset( $_POST['post_type'] ) && 'myplugin_new_field2' == $_POST['post_type'] )
	{
		if ( ! current_user_can( 'edit_page', $post_id ) )
		{
			return;
		}
	}
	else
	{
		if ( ! current_user_can( 'edit_post', $post_id ) )
		{
			return;
		}
	}
	if ( ! isset( $_POST['myplugin_new_field2'] ) )
	{
		return;
	}
	$my_data = sanitize_text_field( $_POST['myplugin_new_field2'] );
	update_post_meta( $post_id, '_my_meta_value_key2', $my_data );
}
add_action( 'save_post', 'myplugin_save_meta_box_data2' );


// Agrega un meta keywords
function myplugin_add_meta_box3()
{
	$screens = array( 'page', 'post' );
	foreach ( $screens as $screen )
	{
		add_meta_box(
			'myplugin_sectionid3',
			__( 'Meta: Palabras claves. Máximo 160 caracteres.', 'webtranslations' ),
			'myplugin_meta_box_callback3',
			$screen
		);
	}
}
add_action( 'add_meta_boxes', 'myplugin_add_meta_box3' );

function myplugin_meta_box_callback3( $post )
{
	wp_nonce_field( 'myplugin_meta_box3', 'myplugin_meta_box_nonce3' );
	$value = get_post_meta( $post->ID, '_my_meta_value_key3', true );
	echo '<textarea maxlength="160" rows="1" style="width:100%;" id="myplugin_new_field3" placeholder="'.__('Palabras claves (keywords) separadas por comas. Son útiles para SEO en algunos buscadores.', 'webtranslations').'" name="myplugin_new_field3">' . esc_attr( $value ) . '</textarea>';
}

function myplugin_save_meta_box_data3( $post_id )
{
	if ( ! isset( $_POST['myplugin_meta_box_nonce3'] ) )
	{
		return;
	}
	if ( ! wp_verify_nonce( $_POST['myplugin_meta_box_nonce3'], 'myplugin_meta_box3' ) )
	{
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
	{
		return;
	}
	if ( isset( $_POST['post_type'] ) && 'myplugin_new_field3' == $_POST['post_type'] )
	{
		if ( ! current_user_can( 'edit_page', $post_id ) )
		{
			return;
		}
	}
	else
	{
		if ( ! current_user_can( 'edit_post', $post_id ) )
		{
			return;
		}
	}
	if ( ! isset( $_POST['myplugin_new_field3'] ) )
	{
		return;
	}
	$my_data = sanitize_text_field( $_POST['myplugin_new_field3'] );
	update_post_meta( $post_id, '_my_meta_value_key3', $my_data );
}
add_action( 'save_post', 'myplugin_save_meta_box_data3' );



// Agrega un enlace al botón
function myplugin_add_meta_box4()
{
	$screens = array( 'home_page' );
	foreach ( $screens as $screen )
	{
		add_meta_box(
			'myplugin_sectionid4',
			__( 'Botón principal', 'webtranslations' ),
			'myplugin_meta_box_callback4',
			$screen
		);
	}
}
add_action( 'add_meta_boxes', 'myplugin_add_meta_box4' );

function myplugin_meta_box_callback4( $post )
{
	wp_nonce_field( 'myplugin_meta_box4', 'myplugin_meta_box_nonce4' );
	$value = get_post_meta( $post->ID, '_my_meta_value_key4', true );
	echo '<label for="myplugin_new_field4">'._e('Texto a mostrar en el botón', 'webtranslations').'</label>';
	echo '<textarea maxlength="160" placeholder="'.__('Texto de Botón', 'webtranslations').'" rows="1" style="width:100%;" id="myplugin_new_field4" name="myplugin_new_field4">' . esc_attr( $value ) . '</textarea>';
}

function myplugin_save_meta_box_data4( $post_id )
{
	if ( ! isset( $_POST['myplugin_meta_box_nonce4'] ) )
	{
		return;
	}
	if ( ! wp_verify_nonce( $_POST['myplugin_meta_box_nonce4'], 'myplugin_meta_box4' ) )
	{
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
	{
		return;
	}
	if ( isset( $_POST['post_type'] ) && 'myplugin_new_field4' == $_POST['post_type'] )
	{
		if ( ! current_user_can( 'edit_page', $post_id ) )
		{
			return;
		}
	}
	else
	{
		if ( ! current_user_can( 'edit_post', $post_id ) )
		{
			return;
		}
	}
	if ( ! isset( $_POST['myplugin_new_field4'] ) )
	{
		return;
	}
	$my_data = sanitize_text_field( $_POST['myplugin_new_field4'] );
	update_post_meta( $post_id, '_my_meta_value_key4', $my_data );
}
add_action( 'save_post', 'myplugin_save_meta_box_data4' );


/*
// Quitar cajas del escritorio
function quita_cajas_escritorio()
{
	if( !current_user_can('manage_options'))
	{
		remove_meta_box('dashboard_right_now', 'dashboard', 'normal');   // Ahoramismo
		remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal'); // Comentarios recientes
		remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');  // Enlaces entrantes
		remove_meta_box('dashboard_plugins', 'dashboard', 'normal');   // Plugins
		remove_meta_box('dashboard_quick_press', 'dashboard', 'side');  // Publicación rápida
		remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side');  // Borradores recientes
		remove_meta_box('dashboard_primary', 'dashboard', 'side');   // Noticas del blog de WordPress
		remove_meta_box('dashboard_secondary', 'dashboard', 'side');   // Otras noticias de WordPress
		// utiliza 'dashboard-network' como segundo parámetro para quitar cajas del escritorio de red.
		remove_meta_box('dashboard_right_now', 'dashboard-network', 'normal');   // Ahoramismo
		remove_meta_box('dashboard_recent_comments', 'dashboard-network', 'normal'); // Comentarios recientes
		remove_meta_box('dashboard_incoming_links', 'dashboard-network', 'normal');  // Enlaces entrantes
		remove_meta_box('dashboard_plugins', 'dashboard-network', 'normal');   // Plugins
		remove_meta_box('dashboard_quick_press', 'dashboard-network', 'side');  // Publicación rápida
		remove_meta_box('dashboard_recent_drafts', 'dashboard-network', 'side');  // Borradores recientes
		remove_meta_box('dashboard_primary', 'dashboard-network', 'side');   // Noticas del blog de WordPress
		remove_meta_box('dashboard_secondary', 'dashboard-network', 'side');   // Otras noticias de WordPress
	}
}
add_action('wp_dashboard_setup', 'quita_cajas_escritorio' );
*/

//Función para Minificar el HTML
class WP_HTML_Compression
{
	protected $compress_css = true;
	protected $compress_js = true;
	protected $info_comment = true;
	protected $remove_comments = true;
	protected $html;
	public function __construct($html)
	{
		if (!empty($html))
		{
			$this->parseHTML($html);
		}
	}
	public function __toString()
	{
		return $this->html;
	}
	protected function bottomComment($raw, $compressed)
	{
		$raw = strlen($raw);
		$compressed = strlen($compressed);
		$savings = ($raw-$compressed) / $raw * 100;
		$savings = round($savings, 2);
		return '<!-- HTML Minify | Se ha reducido el tamaño de la web un '.$savings.'% | De '.$raw.' Bytes a '.$compressed.' Bytes -->';
	}
	protected function minifyHTML($html)
	{
		$pattern = '/<(?<script>script).*?<\/script\s*>|<(?<style>style).*?<\/style\s*>|<!(?<comment>--).*?-->|<(?<tag>[\/\w.:-]*)(?:".*?"|\'.*?\'|[^\'">]+)*>|(?<text>((<[^!\/\w.:-])?[^<]*)+)|/si';
		preg_match_all($pattern, $html, $matches, PREG_SET_ORDER);
		$overriding = false;
		$raw_tag = false;
		$html = '';
		foreach ($matches as $token)
		{
			$tag = (isset($token['tag'])) ? strtolower($token['tag']) : null;
			$content = $token[0];
			if (is_null($tag))
			{
				if ( !empty($token['script']) )
				{
					$strip = $this->compress_js;
				}
				else if ( !empty($token['style']) )
				{
					$strip = $this->compress_css;
				}
				else if ($content == '<!--wp-html-compression no compression-->')
				{
					$overriding = !$overriding;
					continue;
				}
				else if ($this->remove_comments)
				{
					if (!$overriding && $raw_tag != 'textarea')
					{
						$content = preg_replace('/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/s', '', $content);
					}
				}
			}
			else
			{
				if ($tag == 'pre' || $tag == 'textarea')
				{
					$raw_tag = $tag;
				}
				else if ($tag == '/pre' || $tag == '/textarea')
				{
					$raw_tag = false;
				}
				else
				{
					if ($raw_tag || $overriding)
					{
						$strip = false;
					}
					else
					{
						$strip = true;
						$content = preg_replace('/(\s+)(\w++(?<!\baction|\balt|\bcontent|\bsrc)="")/', '$1', $content);
						$content = str_replace(' />', '/>', $content);
					}
				}
			}
			if ($strip)
			{
				$content = $this->removeWhiteSpace($content);
			}
			$html .= $content;
		}
		return $html;
	}
	public function parseHTML($html)
	{
		$this->html = $this->minifyHTML($html);
		if ($this->info_comment)
		{
			$this->html .= "\n" . $this->bottomComment($html, $this->html);
		}
	}
	protected function removeWhiteSpace($str)
	{
		$str = str_replace("\t", ' ', $str);
		$str = str_replace("\n",  '', $str);
		$str = str_replace("\r",  '', $str);
		while (stristr($str, '  '))
		{
			$str = str_replace('  ', ' ', $str);
		}
		return $str;
	}
}
function wp_html_compression_finish($html)
{
	return new WP_HTML_Compression($html);
}
function wp_html_compression_start()
{
	ob_start('wp_html_compression_finish');
}
add_action('get_header', 'wp_html_compression_start');

/**
 * Redirect WordPress front end https URLs to http without a plugin
 *
 * Necessary when running forced SSL in admin and you don't want links to the front end to remain https.
 *
 * @link http://blackhillswebworks.com/?p=5088
 */
 /*
add_action( 'template_redirect', 'bhww_ssl_template_redirect', 1 );

function bhww_ssl_template_redirect() {

	if ( is_ssl() && ! is_admin() ) {
	
		if ( 0 === strpos( $_SERVER['REQUEST_URI'], 'http' ) ) {
		
			wp_redirect( preg_replace( '|^https://|', 'http://', $_SERVER['REQUEST_URI'] ), 301 );
			exit();
			
		} else {
		
			wp_redirect( 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], 301 );
			exit();
			
		}
		
	}
	
}

add_filter("set_url_scheme", "rsssl_check_protocol_multisite", 20, 3 );

function rsssl_check_protocol_multisite($url, $scheme, $orig_scheme){
    if (is_multisite()) {
    //get blog id by url.
    //make sure the domain is with http, e.g. http://domain.com
    $domain = str_replace("https://","http://",$url);
    //remove http:// from the domain. e.g. domain.com
    $domain = str_replace("http://","",$domain);
    $blog_id = get_blog_id_from_url($domain);
    // exit if no blog id was found.
    if ($blog_id==0) return $url; //no blog id found
    
    //request the blog url and return it. If it is http, the returned url will now also be http.

    $url = get_blog_option($blog_id, "siteurl");
  }
  return $url;
}

// Algo con respecto a las ssl seguro..
define( 'PILAU_REQUEST_PROTOCOL', isset( $_SERVER[ 'HTTPS' ] ) ? 'https' : 'http' );

*/
// Cambiando el background del panel de administración
/*add_action('admin_head', 'logo_admin');
function logo_admin()
{
echo '
	<style type="text/css">
		body
		{
			background: url('.get_bloginfo('template_directory').'/img/home.jpg) top left no-repeat fixed !important;
			background-size: cover !important;
			-o-background-size: cover !important;
			-ms-background-size: cover !important;
			-moz-background-size: cover !important;
			-webkit-background-size: cover !important;
		}
	</style>';
}
*/


?>