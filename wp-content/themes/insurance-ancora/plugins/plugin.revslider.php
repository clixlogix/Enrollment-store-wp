<?php
/* Revolution Slider support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('insurance_ancora_revslider_theme_setup')) {
	add_action( 'insurance_ancora_action_before_init_theme', 'insurance_ancora_revslider_theme_setup', 1 );
	function insurance_ancora_revslider_theme_setup() {
		if (insurance_ancora_exists_revslider()) {
			add_filter( 'insurance_ancora_filter_list_sliders',					'insurance_ancora_revslider_list_sliders' );
			add_filter( 'insurance_ancora_filter_shortcodes_params',			'insurance_ancora_revslider_shortcodes_params' );
			add_filter( 'insurance_ancora_filter_theme_options_params',			'insurance_ancora_revslider_theme_options_params' );

		}
		if (is_admin()) {
			add_filter( 'insurance_ancora_filter_importer_required_plugins',	'insurance_ancora_revslider_importer_required_plugins', 10, 2 );
			add_filter( 'insurance_ancora_filter_required_plugins',				'insurance_ancora_revslider_required_plugins' );
		}
	}
}

if ( !function_exists( 'insurance_ancora_revslider_settings_theme_setup2' ) ) {
	add_action( 'insurance_ancora_action_before_init_theme', 'insurance_ancora_revslider_settings_theme_setup2', 3 );
	function insurance_ancora_revslider_settings_theme_setup2() {
		if (insurance_ancora_exists_revslider()) {

			// Add Revslider specific options in the Theme Options
			insurance_ancora_storage_set_array_after('options', 'slider_engine', "slider_alias", array(
				"title" => esc_html__('Revolution Slider: Select slider',  'insurance-ancora'),
				"desc" => wp_kses_data( __("Select slider to show (if engine=revo in the field above)", 'insurance-ancora') ),
				"override" => "category,services_group,page",
				"dependency" => array(
					'show_slider' => array('yes'),
					'slider_engine' => array('revo')
				),
				"std" => "",
				"options" => insurance_ancora_get_options_param('list_revo_sliders'),
				"type" => "select"
				)
			);

		}
	}
}

// Check if RevSlider installed and activated
if ( !function_exists( 'insurance_ancora_exists_revslider' ) ) {
	function insurance_ancora_exists_revslider() {
		return function_exists('rev_slider_shortcode');
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'insurance_ancora_revslider_required_plugins' ) ) {
	function insurance_ancora_revslider_required_plugins($list=array()) {
		if (in_array('revslider', (array)insurance_ancora_storage_get('required_plugins'))) {
			$path = insurance_ancora_get_file_dir('plugins/install/revslider.zip');
			if (file_exists($path)) {
				$list[] = array(
					'name' 		=> esc_html__('Revolution Slider', 'insurance-ancora'),
					'slug' 		=> 'revslider',
                    'version'	=> '6.1.8',
					'source'	=> $path,
					'required' 	=> false
					);
			}
		}
		return $list;
	}
}



// One-click import support
//------------------------------------------------------------------------

// Check RevSlider in the required plugins
if ( !function_exists( 'insurance_ancora_revslider_importer_required_plugins' ) ) {
	function insurance_ancora_revslider_importer_required_plugins($not_installed='', $list='') {
		
		if (insurance_ancora_strpos($list, 'revslider')!==false && !insurance_ancora_exists_revslider() )
			$not_installed .= '<br>' . esc_html__('Revolution Slider', 'insurance-ancora');
		return $not_installed;
	}
}



// Lists
//------------------------------------------------------------------------

// Add RevSlider in the sliders list, prepended inherit (if need)
if ( !function_exists( 'insurance_ancora_revslider_list_sliders' ) ) {
	
	function insurance_ancora_revslider_list_sliders($list=array()) {
		$list = is_array($list) ? $list : array();
		$list["revo"] = esc_html__("Layer slider (Revolution)", 'insurance-ancora');
		return $list;
	}
}

// Return Revo Sliders list, prepended inherit (if need)
if ( !function_exists( 'insurance_ancora_get_list_revo_sliders' ) ) {
	function insurance_ancora_get_list_revo_sliders($prepend_inherit=false) {
		if (($list = insurance_ancora_storage_get('list_revo_sliders'))=='') {
			$list = array();
			if (insurance_ancora_exists_revslider()) {
				global $wpdb;
				$rows = $wpdb->get_results( "SELECT alias, title FROM " . esc_sql($wpdb->prefix) . "revslider_sliders" );
				if (is_array($rows) && count($rows) > 0) {
					foreach ($rows as $row) {
						$list[$row->alias] = $row->title;
					}
				}
			}
			$list = apply_filters('insurance_ancora_filter_list_revo_sliders', $list);
			if (insurance_ancora_get_theme_setting('use_list_cache')) insurance_ancora_storage_set('list_revo_sliders', $list);
		}
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}

// Add RevSlider in the shortcodes params
if ( !function_exists( 'insurance_ancora_revslider_shortcodes_params' ) ) {
	function insurance_ancora_revslider_shortcodes_params($list=array()) {
		$list["revo_sliders"] = insurance_ancora_get_list_revo_sliders();
		return $list;
	}
}

// Add RevSlider in the Theme Options params
if ( !function_exists( 'insurance_ancora_revslider_theme_options_params' ) ) {
	function insurance_ancora_revslider_theme_options_params($list=array()) {
		$list["list_revo_sliders"] = array('$insurance_ancora_get_list_revo_sliders' => '');
		return $list;
	}
}
?>