<?php get_header();
$logo_uploader = of_get_option('logo_uploader', '');
$nombre_web = of_get_option('nombre_web', '');
$apellido_web = of_get_option('apellido_web', '');
$profesion_web = of_get_option('profesion_web', '');
$matricula_web = of_get_option('matricula_web', '');
$enlace_matricula_web = of_get_option('enlace_matricula_web', '');
$boton_principal_web = of_get_option('boton_principal_web', '');
$enlace_boton_principal_web = of_get_option('enlace_boton_principal_web', '');
?>

	<!-- Cuerpo principal de la web -->
	<main>
		<!-- El titular de la home -->
		<section>
			<article class="titulo_home">

				<figure class="logo_home">
					<a href="<?php bloginfo('url');?>">
					<?php if( $logo_uploader != null )
					{
						echo '<img src="'.$logo_uploader.'" alt="'.get_bloginfo('name').'" />';
					} else { ?>
						<img src="<?php bloginfo('stylesheet_directory');?>/img/logo-webtranslations-7.png" alt="<?php bloginfo('name');?>" />
					<?php };?>
					</a>
				</figure>
				<h1>
					<?php if ( $nombre_web != null )
					{
						echo $nombre_web;
					} else {
						echo _e('Nombre Completo', 'webtranslations');
					};?>
					<br />
					<?php if ( $apellido_web != null )
					{
						echo $apellido_web;
					} else {
						echo _e('Apellido Completo', 'webtranslations');
					};?>
				</h1>

				<p>
					<?php if( $profesion_web != null )
					{
						echo $profesion_web.'<br />';
					};?>
					<a target="_blank" href="http://<?php if($enlace_matricula_web != null ) { echo $enlace_matricula_web; } else { echo '#'; }?>">
					<?php if ( $matricula_web != null )
					{
						echo $matricula_web;
					} else {
						echo "M.P. 123";
					}?>
					</a>
				</p>

				<div class="boton_home">
					<?php if( $enlace_boton_principal_web != null )
						{
							echo '<a class="boton" href="'.get_page_link($enlace_boton_principal_web).'">';
						} else {
							echo '<a class="boton" href="'.bloginfo('url').'" >';
						};

						if ( $boton_principal_web != null)
						{
							echo $boton_principal_web;
						} else {
							echo _e('Botón Principal', 'webtranslations');
						};
					?>
					</a>
				</div>
			</article>
		</section>
	</main>

<?php get_footer();?>