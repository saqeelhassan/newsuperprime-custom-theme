<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="search-form">
	<div class="form-group">
		<input type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>"
			placeholder="<?php nsp_ta( 'Search Here', 'ابحث هنا' ); ?>" required>
		<button type="submit" aria-label="<?php echo esc_attr( nsp_t( __( 'Search', 'newsuperprime' ), __( 'بحث', 'newsuperprime' ) ) ); ?>"><i class="fa fa-search" aria-hidden="true"></i></button>
	</div>
</form>
