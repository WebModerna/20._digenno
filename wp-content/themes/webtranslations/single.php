<?php
/**
* @package WordPress
* @subpackage webtranslations
* @since webtranslations 1.0
*/
get_header();
?>
<?php if ( have_posts() ) : ?>

	<main class="fondo_color">
		<section>
			<article>
				<header class="heading">
					<h1>
						<?php the_title();?>
						<span class="icon-file-text2 left"></span>
					</h1>
				</header>
			</article>
		</section>

		<section>
			<article class="left">
				<?php the_breadcrums();?>
			</article>
		</section>

		<?php rewind_posts(); // Para resetear todo el loop ?>
		<!-- El loop que mostrará todos los post -->
		<?php while ( have_posts() ) : the_post() ?>

		<section class="Panel">
			<article class="Panel--contenido">
				<?php
					$optional_size	= 'custom-thumb-600-x';
					$optional_size2	= 'custom-thumb-900-x';
					$img_id			= get_post_thumbnail_id($post->ID);
					$image			= wp_get_attachment_image_src($img_id, $optional_size);
					$image2			= wp_get_attachment_image_src($img_id, $optional_size2);
					$alt_text		= get_post_meta($img_id , '_wp_attachment_image_alt', true);
					$perm			= get_permalink($post->ID);

					if ( $image != "" )	{ ?>
				<figure>
				<?php if(wpmd_is_phone()) { ?>
					<img src="<?php echo $image[0];?>" alt="<?php echo $alt_text;?>" />
				<?php } else {
						/* <a href="<?php echo $image2[0];?>" data-lightbox="galeria">*/
					?>
						<img src="<?php echo $image[0];?>" alt="<?php echo $alt_text;?>" />
				<?php
					// </a>
				};
				if ( $alt_text != null )
				{
					echo '<figcaption>'.$alt_text.'</figcaption>';
				}
				?>
				</figure>


				<div class="elementos_post--contenedor">

					<div class="Panel-small--tag">
						<span class="icon-calendar2 right"></span><?php the_date();?>
					</div>

					<div class="Panel-small--tag">
						<span class="icon-user2 right"></span><?php the_author();?>
					</div>

					<div class="Panel-small--tag">
						<span class="icon-folder right"></span><?php _e('Categorías:', 'webtranslations');?>
						<ul>
							<?php the_category( '<li>', '</li>', '' ); ?>
						</ul>
					</div>

					<?php if ( get_the_tags() != '' ) { ?>
					<div class="Panel-small--tag">
						<span class="icon-price-tag right"></span><?php _e('Etiquetas:', 'webtranslations');?>
						<ul>
							<?php the_tags( '<li>', ', ', '</li>' ); ?>
						</ul>
					</div>
					<?php } ?>

				</div>

				<?php };
					$titulo_secundario = get_post_meta( $post->ID, '_my_meta_value_key', true );
					if ( $titulo_secundario != "" ) {
				?>
				<h2><?php echo $titulo_secundario;?></h2>
				<?php };?>

				<?php the_content();?>


				<div class="galeria">
					<ul>

				<?php
				/* Por motivos técnicos lo desactivamos ya que no lo necesitará más.
				//Móviles
				if( wpmd_is_phone() )
				{
					$attachID = get_post_meta( $post->ID, 'custom_imagenrepetible', true );
					if ( $attachID != null )
					{
						foreach ($attachID as $item)
						{
							$imagen = wp_get_attachment_image_src($item,'custom-thumb-450-x');
							$alt = get_post_meta($item, '_wp_attachment_image_alt', true);
							$descripcion = get_post_field('post_content', $item);
							echo '<li class="galeria--item"><img src="' . $imagen[0] . '"';
							if (count($alt))
							{
								echo ' alt="' . $alt . '"';
							}
							echo ' /></li>';
						}
					}
				}


				//Desktop.
				if( wpmd_is_notphone() )
				{
					$attachID = get_post_meta( $post->ID, 'custom_imagenrepetible', false );
					if ( $attachID != null )
					{
						foreach ( $attachID as $item )
						{
							$imagen = wp_get_attachment_image_src($item,'custom-thumb-450-450');
							$imagen2 = wp_get_attachment_image_src($item,'custom-thumb-900-x');
							$alt = get_post_meta($item, '_wp_attachment_image_alt', true);
							$descripcion = get_post_field('post_content', $item);
							echo '<li class="galeria--item"><a data-lightbox="galeria" href="'.$imagen2[0].'"><img class="slide" src="' . $imagen[0] . '"';
							if (count($alt))
							{
								echo ' alt="' . $alt . '"';
							}
							echo ' /></a></li>';
						}
					}
				};
*/
				?>
					</ul>
				</div>

			</article>

			<?php
			// Get Author Data
			$author             = get_the_author();
			$author_description = get_the_author_meta( 'description' );
			$author_url         = esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );
			$author_avatar      = get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'wpex_author_bio_avatar_size', 75 ) );

			// Only display if author has a description
		//	if ( $author_description ) :
			// datos del autor
			?>

			<article>
				<div class="autor comment redes_sociales">
					<div class="comment-body">
						<figure>
							<?php echo get_avatar(
								get_the_author_meta('email'),
								$size = '200',
								$default = '/img/fotomv-250x300.jpg' );
							?>
						</figure>
						<h3 class="autor--titular">
							<?php echo $author;?>
						</h3>
						<h4 class="autor--titular">
						<?php
							$profesion_perfil = get_the_author_meta( 'profesion_perfil' );
							if ( $profesion_perfil && $profesion_perfil != '' )
							{
								echo $profesion_perfil;
							}
						?>
						</h4>
						<ul>
							<?php
							$facebook_perfil = get_the_author_meta( 'facebook_perfil' );
							if ( $facebook_perfil && $facebook_perfil != '' )
							{
								echo '<li><a title="Facebook" class="blanco redondo icon-facebook" href="' . esc_url($facebook_perfil) . '" rel="author" target="_blank"></a></li>';
							}

							$google_mas_perfil = get_the_author_meta( 'google_mas_perfil' );
							if ( $google_mas_perfil && $google_mas_perfil != '' )
							{
								echo '<li><a title="Google+" class="blanco redondo icon-google-plus" href="' . esc_url($google_mas_perfil) . '" rel="author" target="_blank"></a></li>';
							}

							$twitter_perfil = get_the_author_meta( 'twitter_perfil' );
							if ( $twitter_perfil && $twitter_perfil != '' )
							{
								echo '<li><a title="Twitter" class="blanco redondo icon-twitter" href="' . esc_url($twitter_perfil) . '" rel="author" target="_blank"></a></li>';
							}

							$linkedin_perfil = get_the_author_meta( 'linkedin_perfil' );
							if ( $linkedin_perfil && $linkedin_perfil != '' )
							{
								echo '<li><a title="LinkedIn" class="blanco redondo icon-linkedin2" href="' . esc_url($linkedin_perfil) . '" rel="author" target="_blank"></a></li>';
							}
							/*<li>
								<a title="E-Mail" class="blanco redondo icon-mail" href="mailto:<?php echo get_the_author_meta('email');?>" ></a>
							</li>*/
							?>
						</ul>
						<p><?php the_author_meta('description'); ?></p>
					</div>
				</div>
			</article>
			<?php // endif; ?>
		</section>

		<?php endwhile; ?>

		<!-- Post navigation, o sea la paginación -->
		<section>
			<article class="enlaces__navegacion">
				<?php previous_post_link('<div class="prev">%link</div>' );?>
				<?php next_post_link( '<div class="next">%link</div>' ); ?>
			</article>
		</section>

		<section>
			<article>
				<?php comments_template(); ?>
			</article>
		</section>

		<!-- Post navigation, o sea la paginación -->
		<section>
			<article class="enlaces__navegacion">
				<?php previous_post_link('<div class="prev">%link</div>' );?>
				<?php next_post_link( '<div class="next">%link</div>' ); ?>
			</article>
		</section>

		<?php else : ?>
		<!-- No hay posts -->
		<section class="Panel">
			<article class="Panel--contenido">
				<h2>
					<?php _e('No hay entradas del blog publicadas.', 'webtranslations');?>
				</h2>
			</article>
		</section>

	<?php endif; ?>
	</main>

<?php get_footer();?>