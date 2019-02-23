<?php // configuración del slider

// Register Custom Post Type
function sliders()
{

	$labels = array(
		'name'                => _x( 'Sliders', 'Post Type General Name', 'Sliders' ),
		'singular_name'       => _x( 'Slider', 'Post Type Singular Name', 'Sliders' ),
		'menu_name'           => __( 'SlideShow', 'Sliders' ),
		'name_admin_bar'      => __( 'SlideShow', 'Sliders' ),
		'parent_item_colon'   => __( 'SlideShow superior:', 'Sliders' ),
		'all_items'           => __( 'Todos los SlideShows', 'Sliders' ),
		'add_new_item'        => __( 'Agregar nuevo SlideShow', 'Sliders' ),
		'add_new'             => __( 'Agregar uno nuevo', 'Sliders' ),
		'new_item'            => __( 'Nuevo SlideShow', 'Sliders' ),
		'edit_item'           => __( 'Editar SlideShow', 'Sliders' ),
		'update_item'         => __( 'Actualizar SlideShow', 'Sliders' ),
		'view_item'           => __( 'Ver SlideShow', 'Sliders' ),
		'search_items'        => __( 'Buscar SlideShow', 'Sliders' ),
		'not_found'           => __( 'No hay SlideShows', 'Sliders' ),
		'not_found_in_trash'  => __( 'No hay SlideShows en la papelera', 'Sliders' ),
	);
	$rewrite = array(
		'slug'                => 'sliders',
		'with_front'          => true,
		'pages'               => false,
		'feeds'               => false,
	);
	$args = array(
		'label'               => __( 'Slider', 'Sliders' ),
		'description'         => __( 'Sliders', 'Sliders' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail' ),
		'hierarchical'        => true,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-images-alt2',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => true,		
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'rewrite'             => $rewrite,
		'capability_type'     => 'page',
	);
	register_post_type( 'sliders', $args );

}
add_action( 'init', 'sliders', 0 );
?>