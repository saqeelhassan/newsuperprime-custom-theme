<?php
if ( ! defined( 'ABSPATH' ) ) exit;

// Sponsor logo strip is intentionally hidden site-wide.
return;
?>
<section id="clinox-sponsor" class="clinox-sponsor-section">
	<div class="container">
		<div class="clinox-sponsor-slider">
			<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
			<div class="slider-inner-item">
				<div class="clinox-sponsor-img">
					<img src="<?php echo esc_url( nsp_asset( 'assets/img/sponsor/logo_' . $i . '.png' ) ); ?>" alt="">
				</div>
			</div>
			<?php endfor; ?>
		</div>
	</div>
</section>
