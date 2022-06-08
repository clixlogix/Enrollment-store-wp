<?php
/* Instagram Feed support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('insurance_ancora_instagram_feed_theme_setup')) {
	add_action( 'insurance_ancora_action_before_init_theme', 'insurance_ancora_instagram_feed_theme_setup', 1 );
	function insurance_ancora_instagram_feed_theme_setup() {
		if (insurance_ancora_exists_instagram_feed()) {
			if (is_admin()) {
				add_filter( 'insurance_ancora_filter_importer_options',				'insurance_ancora_instagram_feed_importer_set_options' );
			}
		}
		if (is_admin()) {
			add_filter( 'insurance_ancora_filter_importer_required_plugins',		'insurance_ancora_instagram_feed_importer_required_plugins', 10, 2 );
			add_filter( 'insurance_ancora_filter_required_plugins',					'insurance_ancora_instagram_feed_required_plugins' );
		}
	}
}

// Check if Instagram Feed installed and activated
if ( !function_exists( 'insurance_ancora_exists_instagram_feed' ) ) {
	function insurance_ancora_exists_instagram_feed() {
		return defined('SBIVER');
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'insurance_ancora_instagram_feed_required_plugins' ) ) {
	
	function insurance_ancora_instagram_feed_required_plugins($list=array()) {
		if (in_array('instagram_feed', (array)insurance_ancora_storage_get('required_plugins')))
			$list[] = array(
					'name' 		=> esc_html__('Instagram Feed', 'insurance-ancora'),
					'slug' 		=> 'instagram-feed',
					'required' 	=> false
				);
		return $list;
	}
}



// One-click import support
//------------------------------------------------------------------------

// Check Instagram Feed in the required plugins
if ( !function_exists( 'insurance_ancora_instagram_feed_importer_required_plugins' ) ) {
	function insurance_ancora_instagram_feed_importer_required_plugins($not_installed='', $list='') {
		if (insurance_ancora_strpos($list, 'instagram_feed')!==false && !insurance_ancora_exists_instagram_feed() )
			$not_installed .= '<br>' . esc_html__('Instagram Feed', 'insurance-ancora');
		return $not_installed;
	}
}

// Set options for one-click importer
if ( !function_exists( 'insurance_ancora_instagram_feed_importer_set_options' ) ) {
	function insurance_ancora_instagram_feed_importer_set_options($options=array()) {
		if ( in_array('instagram_feed', (array)insurance_ancora_storage_get('required_plugins')) && insurance_ancora_exists_instagram_feed() ) {
			// Add slugs to export options for this plugin
			$options['additional_options'][] = 'sb_instagram_settings';
		}
		return $options;
	}
}
?>