<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('insurance_ancora_sc_hide_theme_setup')) {
	add_action( 'insurance_ancora_action_before_init_theme', 'insurance_ancora_sc_hide_theme_setup' );
	function insurance_ancora_sc_hide_theme_setup() {
		add_action('insurance_ancora_action_shortcodes_list', 		'insurance_ancora_sc_hide_reg_shortcodes');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_hide selector="unique_id"]
*/

if (!function_exists('insurance_ancora_sc_hide')) {	
	function insurance_ancora_sc_hide($atts, $content=null){	
		if (insurance_ancora_in_shortcode_blogger()) return '';
		extract(insurance_ancora_html_decode(shortcode_atts(array(
			// Individual params
			"selector" => "",
			"hide" => "on",
			"delay" => 0
		), $atts)));
		$selector = trim(chop($selector));
		if (!empty($selector)) {
			insurance_ancora_storage_concat('js_code', '
				'.($delay>0 ? 'setTimeout(function() {' : '').'
					jQuery("'.esc_attr($selector).'").' . ($hide=='on' ? 'hide' : 'show') . '();
				'.($delay>0 ? '},'.($delay).');' : '').'
			');
		}
		return apply_filters('insurance_ancora_shortcode_output', $output, 'trx_hide', $atts, $content);
	}
	add_shortcode('trx_hide', 'insurance_ancora_sc_hide');
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'insurance_ancora_sc_hide_reg_shortcodes' ) ) {
	//add_action('insurance_ancora_action_shortcodes_list', 'insurance_ancora_sc_hide_reg_shortcodes');
	function insurance_ancora_sc_hide_reg_shortcodes() {
	
		insurance_ancora_sc_map("trx_hide", array(
			"title" => esc_html__("Hide/Show any block", 'trx_utils'),
			"desc" => wp_kses_data( __("Hide or Show any block with desired CSS-selector", 'trx_utils') ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"selector" => array(
					"title" => esc_html__("Selector", 'trx_utils'),
					"desc" => wp_kses_data( __("Any block's CSS-selector", 'trx_utils') ),
					"value" => "",
					"type" => "text"
				),
				"hide" => array(
					"title" => esc_html__("Hide or Show", 'trx_utils'),
					"desc" => wp_kses_data( __("New state for the block: hide or show", 'trx_utils') ),
					"value" => "yes",
					"size" => "small",
					"options" => insurance_ancora_get_sc_param('yes_no'),
					"type" => "switch"
				)
			)
		));
	}
}
?>