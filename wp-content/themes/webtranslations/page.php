<?php
/**
*
* @package WordPress
* @subpackage webtranslations
* @since webtranslations 1.0
*/
get_header();

?>
<?php rewind_posts();
	if ( have_posts() ) : while ( have_posts() ) : ?>


	<main class="fondo_color">

		<?php the_post(); ?>
		<!-- post -->

		<section>
			<header class="heading">
				<h1>
					<?php the_title();?>
					<span class="icon-stack left"></span>
				</h1>
			</header>
		</section>

		<section class="articulo">
			<article>
				<?php
					$optional_size 	= 'custom-thumb-450-x';
					$img_id			= get_post_thumbnail_id($post->ID);
					$image 			= wp_get_attachment_image_src($img_id, $optional_size);
					$alt_text 		= get_post_meta($img_id , '_wp_attachment_image_alt', true);
					$perm 			= get_permalink($post->ID);

					if ( $image != "" )	{ ?>
				<figure>
					<img src="<?php echo $image[0];?>" alt="<?php echo $alt_text;?>" />
					<figcaption><?php echo $alt_text;?></figcaption>
				</figure>

				<?php };
				the_content();?>

			</article>

		</section>

		<?php endwhile; ?>
		<?php else: ?>
		<!-- no posts found -->
		<?php endif; ?>
	</main>

<?php get_footer();?>
