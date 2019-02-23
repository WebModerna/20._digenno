<?php
/**
* Template Name: Servicios
* @package WordPress
* @subpackage webtranslations
* @since webtranslations 1.0
*/
get_header();
rewind_posts();
if ( have_posts() ) : while ( have_posts() ) : ?>
	<main class="fondo_color">
		<section class="articulo">
			<header class="heading">
				<h1>
					<?php the_title(); ?>
					<span class="icon-cog2 left"></span>
				</h1>
			</header>
			<?php the_post(); ?>
			<article class="columnas__2 listado__servicios">
				<?php the_content(); ?>
				<ul>
					<li>
						<img src="<?php bloginfo('stylesheet_directory');?>/img/iconos-png/Entypo_27a2(24)_128.png" alt="">
						Servicio 1
					</li>
					<li>
						<img src="<?php bloginfo('stylesheet_directory');?>/img/iconos-png/Entypo_2691(31)_128.png" alt="">
						Servicio 2
					</li>
					<li>
						<img src="<?php bloginfo('stylesheet_directory');?>/img/iconos-png/Entypo_d83c(10)_128.png" alt="">
						Servicio 3
					</li>
					<li>
						<img src="<?php bloginfo('stylesheet_directory');?>/img/iconos-png/Entypo_d83c(0)_128.png" alt="">
						Servicio 4
					</li>
					<li>
						<img src="<?php bloginfo('stylesheet_directory');?>/img/iconos-png/Entypo_e738(20)_128.png" alt="">
						Servicio 5
					</li>
					<li>
						<img src="<?php bloginfo('stylesheet_directory');?>/img/iconos-png/Entypo_e754(18)_128.png" alt="">
						Servicio 6
					</li>
				</ul>
			</article>

		<?php endwhile; ?>
		<?php else: ?>
			<article>
				<h2><?php _e('No hay nada publicado', 'webtranslations') ?></h2>
			</article>
		<?php endif; ?>
		</section>

	</main>
<?php get_footer();?>