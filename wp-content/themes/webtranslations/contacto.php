<?php
/**
* Template Name: Contacto
* @package WordPress
* @subpackage webtranslations
* @since webtranslations 1.0
*/
get_header();
rewind_posts();
if ( have_posts() ) : while ( have_posts() ) : ?>

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
				<?php the_post(); the_content();?>
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