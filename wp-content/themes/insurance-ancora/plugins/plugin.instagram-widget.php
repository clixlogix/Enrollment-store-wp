<?php
/* Instagram Widget support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('insurance_ancora_instagram_widget_theme_setup')) {
	add_action( 'insurance_ancora_action_before_init_theme', 'insurance_ancora_instagram_widget_theme_setup', 1 );
	function insurance_ancora_instagram_widget_theme_setup() {
		if (insurance_ancora_exists_instagram_widget()) {
			add_action( 'insurance_ancora_action_add_styles', 						'insurance_ancora_instagram_widget_frontend_scripts' );
		}
		if (is_admin()) {
			add_filter( 'insurance_ancora_filter_importer_required_plugins',		'insurance_ancora_instagram_widget_importer_required_plugins', 10, 2 );
			add_filter( 'insurance_ancora_filter_required_plugins',					'insurance_ancora_instagram_widget_required_plugins' );
		}
	}
}

// Check if Instagram Widget installed and activated
if ( !function_exists( 'insurance_ancora_exists_instagram_widget' ) ) {
	function insurance_ancora_exists_instagram_widget() {
		return function_exists('wpiw_init');
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'insurance_ancora_instagram_widget_required_plugins' ) ) {
	function insurance_ancora_instagram_widget_required_plugins($list=array()) {
		if (in_array('instagram_widget', (array)insurance_ancora_storage_get('required_plugins')))
			$list[] = array(
					'name' 		=> esc_html__('Instagram Widget', 'insurance-ancora'),
					'slug' 		=> 'wp-instagram-widget',
					'required' 	=> false
				);
		return $list;
	}
}

// Enqueue custom styles
if ( !function_exists( 'insurance_ancora_instagram_widget_frontend_scripts' ) ) {
	function insurance_ancora_instagram_widget_frontend_scripts() {
		if (file_exists(insurance_ancora_get_file_dir('css/plugin.instagram-widget.css')))
			wp_enqueue_style( 'insurance-ancora-plugin-instagram-widget-style',  insurance_ancora_get_file_url('css/plugin.instagram-widget.css'), array(), null );
	}
}



// One-click import support
//------------------------------------------------------------------------

// Check Instagram Widget in the required plugins
if ( !function_exists( 'insurance_ancora_instagram_widget_importer_required_plugins' ) ) {
	function insurance_ancora_instagram_widget_importer_required_plugins($not_installed='', $list='') {
		if (insurance_ancora_strpos($list, 'instagram_widget')!==false && !insurance_ancora_exists_instagram_widget() )
			$not_installed .= '<br>' . esc_html__('WP Instagram Widget', 'insurance-ancora');
		return $not_installed;
	}
}
?>