<?php
/**
* 404.php
* @package WordPress
* @subpackage webtranslations
* @since webtranslations 1.0
*/
get_header();
?>

<!-- Cuerpo principal de la web -->
	<main class="fondo_color">
		<section>
			<header class="heading">
				<h1>
					<?php _e('Error 404', 'webtranslations');?>
					<span class="icon-question"></span>
				</h1>
			</header>
			<article class="articulo Panel--contenido">
				<h2 class="aligncenter">
					<?php _e('No entendemos lo que estás haciendo. Intentá buscar una página que tengamos.', 'webtranslations');?>
				</h2>
				<figure>
					<img src="<?php bloginfo('stylesheet_directory');?>/img/error404.jpg" alt="<?php __('Error 404', 'webtranslations') ?>" />
				</figure>
			</article>
		</section>
	</main>

<?php get_footer();?>