<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="search-form">
	<div class="form-group">
		<input type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>"
			placeholder="<?php nsp_ta( 'Search Here', 'ابحث هنا' ); ?>" required>
		<button type="submit"><i class="fa fa-search"></i></button>
	</div>
</form>
