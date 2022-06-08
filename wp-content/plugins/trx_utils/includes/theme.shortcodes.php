<?php
if (!function_exists('insurance_ancora_theme_shortcodes_setup')) {
	add_action( 'insurance_ancora_action_before_init_theme', 'insurance_ancora_theme_shortcodes_setup', 1 );
	function insurance_ancora_theme_shortcodes_setup() {
		add_filter('insurance_ancora_filter_googlemap_styles', 'insurance_ancora_theme_shortcodes_googlemap_styles');
	}
}


// Add theme-specific Google map styles
if ( !function_exists( 'insurance_ancora_theme_shortcodes_googlemap_styles' ) ) {
	function insurance_ancora_theme_shortcodes_googlemap_styles($list) {
		$list['simple']		= esc_html__('Simple', 'trx_utils');
		$list['greyscale']	= esc_html__('Greyscale', 'trx_utils');
		$list['inverse']	= esc_html__('Inverse', 'trx_utils');
		$list['apple']		= esc_html__('Apple', 'trx_utils');
		return $list;
	}
}
?>