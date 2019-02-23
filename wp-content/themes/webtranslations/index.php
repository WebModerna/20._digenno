<?php
/**
* index.php
* @package WordPress
* @subpackage webtranslations
* @since webtranslations 1.0
*/
get_header();
?>

<!-- Cuerpo principal de la web -->
	<main class="fondo_color">
		<section class="left">
			<header class="heading heading--blog">
				<h1><?php _e('Blog', 'webtranslations');?></h1>
			</header>

			<div class="columnas__2">

			<?php rewind_posts();
			if ( have_posts() ) : while ( have_posts() ) : the_post() ?>

				<article class="Panel-small">
					<header>
						<h3 class="Panel-small--titulo">
							<a href="<?php the_permalink(); ?>"><?php the_title();?></a>
						</h3>
						<div class="elementos_post"><?php the_date();?>
							<span class="icon-user2 left right"></span><?php the_author();?>
						</div>
					</header>

					<figure>
						<a href="<?php the_permalink();?>">
						<?php if( has_post_thumbnail() ) { the_post_thumbnail( 'custom-thumb-100-100' ); } else { ?>
							<img src="<?php bloginfo('stylesheet_directory');?>/img/logo-webtranslations-6.png" alt="algo" />
						<?php };?>
						</a>
					</figure>

					<div class="Panel-small--contenido">
						<?php the_excerpt();?>
						<p><a class="leer_mas" href="<?php the_permalink(); ?>"><?php _e('Leer más', 'webtranslations');?></a></p>
					</div>
					<footer>

						<?php if ( get_the_tags() != '' ) { ?>
						<div class="Panel-small--tag">
							<span class="icon-price-tag right"></span>Etiquetas:
							<ul>
								<?php the_tags( '<li>', ', ', '</li>' ); ?>
							</ul>
						</div>
						<?php } ?>

						<div class="Panel-small--tag">
							<ul>
								<li>
									<span class="icon-folder-open right"></span>Categorías: 
								</li>
								<?php the_category( '<li>', '</li>', '' ); ?>
							</ul>
						</div>
					</footer>
				</article>

				<?php endwhile; ?>

			</div>
		</section>

		<section>
			<div class='pagination'>
				<?php if ( function_exists("pagination") ) { pagination(); } ?>
			</div>
		</section>

		<?php else : ?>
			</div>
		</section>
		<section>
			<article>
				<h2>
					<?php _e('No hay entradas del blog publicadas.', 'webtranslations');?>
				</h2>
			</article>
		</section>

		<?php endif; ?>
	</main>

<?php get_footer();?>