<?php get_header();

// WP_Query arguments
$args = array (
	'post_type'              => array( 'home_page' ),
);

// The Query
$query = new WP_Query( $args );
?>

	<!-- Cuerpo principal de la web -->
	<main>
		<!-- El titular de la home -->
		<section>
			<article class="titulo_home">
			<?php
			// The Loop
			if ( $query->have_posts() )
			{
				while ( $query->have_posts() )
				{
					$query->the_post();
					// do something
			 ?>
				<figure class="logo_home">
					<a href="<?php bloginfo('url');?>">
					<?php if( has_post_thumbnail() ) { the_post_thumbnail( 'custom-thumb-100-100' ); } else { ?>
						<img src="<?php bloginfo('stylesheet_directory');?>/img/logo-webtranslations-6.png" alt="algo" />
					<?php };?>
					</a>
				</figure>
				<?php the_content();?>
				<div class="boton_home">
					<?php $boton_principal	= get_post_meta( $post->ID, '_my_meta_value_key4', true );?>
					<a class="boton" href="<?php bloginfo('url');?>/contacto"><?php echo $boton_principal;?></a>
				</div>
			<?php }
			} else {
				// no posts found
			}
			// Restore original Post Data
			wp_reset_postdata();?>
			</article>
		</section>
	</main>

<?php get_footer();?>