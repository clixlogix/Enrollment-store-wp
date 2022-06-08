<?php
/**
 * InsuranceAncora Framework: Theme options custom fields
 *
 * @package	insurance_ancora
 * @since	insurance_ancora 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'insurance_ancora_options_custom_theme_setup' ) ) {
	add_action( 'insurance_ancora_action_before_init_theme', 'insurance_ancora_options_custom_theme_setup' );
	function insurance_ancora_options_custom_theme_setup() {

		if ( is_admin() ) {
			add_action("admin_enqueue_scripts",	'insurance_ancora_options_custom_load_scripts');
		}
		
	}
}

// Load required styles and scripts for custom options fields
if ( !function_exists( 'insurance_ancora_options_custom_load_scripts' ) ) {
	function insurance_ancora_options_custom_load_scripts() {
		wp_enqueue_script( 'insurance-ancora-options-custom-script',	insurance_ancora_get_file_url('core/core.options/js/core.options-custom.js'), array(), null, true );
	}
}


// Show theme specific fields in Post (and Page) options
if ( !function_exists( 'insurance_ancora_show_custom_field' ) ) {
	function insurance_ancora_show_custom_field($id, $field, $value) {
		$output = '';
		switch ($field['type']) {
			case 'reviews':
				$output .= '<div class="reviews_block">' . trim(insurance_ancora_reviews_get_markup($field, $value, true)) . '</div>';
				break;
	
			case 'mediamanager':
				wp_enqueue_media( );
				$output .= '<a id="'.esc_attr($id).'" class="button mediamanager insurance_ancora_media_selector"
					data-param="' . esc_attr($id) . '"
					data-choose="'.esc_attr(isset($field['multiple']) && $field['multiple'] ? esc_html__( 'Choose Images', 'insurance-ancora') : esc_html__( 'Choose Image', 'insurance-ancora')).'"
					data-update="'.esc_attr(isset($field['multiple']) && $field['multiple'] ? esc_html__( 'Add to Gallery', 'insurance-ancora') : esc_html__( 'Choose Image', 'insurance-ancora')).'"
					data-multiple="'.esc_attr(isset($field['multiple']) && $field['multiple'] ? 'true' : 'false').'"
					data-linked-field="'.esc_attr($field['media_field_id']).'"
					>' . (isset($field['multiple']) && $field['multiple'] ? esc_html__( 'Choose Images', 'insurance-ancora') : esc_html__( 'Choose Image', 'insurance-ancora')) . '</a>';
				break;
		}
		return apply_filters('insurance_ancora_filter_show_custom_field', $output, $id, $field, $value);
	}
}
?>