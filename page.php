<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
while ( have_posts() ) : the_post();
nsp_breadcrumb( '', get_the_title() );
?>

<section id="clinox-page" class="clinox-page-section page-section-padding">
	<div class="container">
		<div class="clinox-page-content pera-content headline">
			<?php the_content(); ?>
		</div>
	</div>
</section>

<?php endwhile; get_footer(); ?>
