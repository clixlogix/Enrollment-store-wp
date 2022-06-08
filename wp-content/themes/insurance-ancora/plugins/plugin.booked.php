<?php
/* Booked Appointments support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('insurance_ancora_booked_theme_setup')) {
	add_action( 'insurance_ancora_action_before_init_theme', 'insurance_ancora_booked_theme_setup', 1 );
	function insurance_ancora_booked_theme_setup() {
		// Register shortcode in the shortcodes list
		if (insurance_ancora_exists_booked()) {
			add_action('insurance_ancora_action_add_styles', 					'insurance_ancora_booked_frontend_scripts');
			add_action('insurance_ancora_action_shortcodes_list',				'insurance_ancora_booked_reg_shortcodes');
			if (function_exists('insurance_ancora_exists_visual_composer') && insurance_ancora_exists_visual_composer())
				add_action('insurance_ancora_action_shortcodes_list_vc',		'insurance_ancora_booked_reg_shortcodes_vc');

		}
		if (is_admin()) {
			add_filter( 'insurance_ancora_filter_importer_required_plugins',	'insurance_ancora_booked_importer_required_plugins', 10, 2);
			add_filter( 'insurance_ancora_filter_required_plugins',				'insurance_ancora_booked_required_plugins' );
		}
	}
}


// Check if plugin installed and activated
if ( !function_exists( 'insurance_ancora_exists_booked' ) ) {
	function insurance_ancora_exists_booked() {
		return class_exists('booked_plugin');
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'insurance_ancora_booked_required_plugins' ) ) {
	function insurance_ancora_booked_required_plugins($list=array()) {
		if (in_array('booked', (array)insurance_ancora_storage_get('required_plugins'))) {
			$path = insurance_ancora_get_file_dir('plugins/install/booked.zip');
			if (file_exists($path)) {
				$list[] = array(
					'name' 		=> esc_html__('Booked', 'insurance-ancora'),
					'slug' 		=> 'booked',
                    'version'	=> '2.2.5',
					'source'	=> $path,
					'required' 	=> false
					);
			}
		}
		return $list;
	}
}

// Enqueue custom styles
if ( !function_exists( 'insurance_ancora_booked_frontend_scripts' ) ) {
	function insurance_ancora_booked_frontend_scripts() {
		if (file_exists(insurance_ancora_get_file_dir('css/plugin.booked.css')))
			wp_enqueue_style( 'insurance-ancora-plugin-booked-style',  insurance_ancora_get_file_url('css/plugin.booked.css'), array(), null );
	}
}



// One-click import support
//------------------------------------------------------------------------

// Check in the required plugins
if ( !function_exists( 'insurance_ancora_booked_importer_required_plugins' ) ) {
	function insurance_ancora_booked_importer_required_plugins($not_installed='', $list='') {
		if (insurance_ancora_strpos($list, 'booked')!==false && !insurance_ancora_exists_booked() )
			$not_installed .= '<br>' . esc_html__('Booked Appointments', 'insurance-ancora');
		return $not_installed;
	}
}


// Lists
//------------------------------------------------------------------------

// Return booked calendars list, prepended inherit (if need)
if ( !function_exists( 'insurance_ancora_get_list_booked_calendars' ) ) {
	function insurance_ancora_get_list_booked_calendars($prepend_inherit=false) {
		return insurance_ancora_exists_booked() ? insurance_ancora_get_list_terms($prepend_inherit, 'booked_custom_calendars') : array();
	}
}



// Register plugin's shortcodes
//------------------------------------------------------------------------

// Register shortcode in the shortcodes list
if (!function_exists('insurance_ancora_booked_reg_shortcodes')) {
	function insurance_ancora_booked_reg_shortcodes() {
		if (insurance_ancora_storage_isset('shortcodes')) {

			$booked_cals = insurance_ancora_get_list_booked_calendars();

			insurance_ancora_sc_map('booked-appointments', array(
				"title" => esc_html__("Booked Appointments", 'insurance-ancora'),
				"desc" => esc_html__("Display the currently logged in user's upcoming appointments", 'insurance-ancora'),
				"decorate" => true,
				"container" => false,
				"params" => array()
				)
			);

			insurance_ancora_sc_map('booked-calendar', array(
				"title" => esc_html__("Booked Calendar", 'insurance-ancora'),
				"desc" => esc_html__("Insert booked calendar", 'insurance-ancora'),
				"decorate" => true,
				"container" => false,
				"params" => array(
					"calendar" => array(
						"title" => esc_html__("Calendar", 'insurance-ancora'),
						"desc" => esc_html__("Select booked calendar to display", 'insurance-ancora'),
						"value" => "0",
						"type" => "select",
						"options" => insurance_ancora_array_merge(array(0 => esc_html__('- Select calendar -', 'insurance-ancora')), $booked_cals)
					),
					"year" => array(
						"title" => esc_html__("Year", 'insurance-ancora'),
						"desc" => esc_html__("Year to display on calendar by default", 'insurance-ancora'),
						"value" => date("Y"),
						"min" => date("Y"),
						"max" => date("Y")+10,
						"type" => "spinner"
					),
					"month" => array(
						"title" => esc_html__("Month", 'insurance-ancora'),
						"desc" => esc_html__("Month to display on calendar by default", 'insurance-ancora'),
						"value" => date("m"),
						"min" => 1,
						"max" => 12,
						"type" => "spinner"
					)
				)
			));
		}
	}
}


// Register shortcode in the VC shortcodes list
if (!function_exists('insurance_ancora_booked_reg_shortcodes_vc')) {
	function insurance_ancora_booked_reg_shortcodes_vc() {

		$booked_cals = insurance_ancora_get_list_booked_calendars();

		// Booked Appointments
		vc_map( array(
				"base" => "booked-appointments",
				"name" => esc_html__("Booked Appointments", 'insurance-ancora'),
				"description" => esc_html__("Display the currently logged in user's upcoming appointments", 'insurance-ancora'),
				"category" => esc_html__('Content', 'insurance-ancora'),
				'icon' => 'icon_trx_booked',
				"class" => "trx_sc_single trx_sc_booked_appointments",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => false,
				"params" => array()
			) );
			
		class WPBakeryShortCode_Booked_Appointments extends Insurance_Ancora_VC_ShortCodeSingle {}

		// Booked Calendar
		vc_map( array(
				"base" => "booked-calendar",
				"name" => esc_html__("Booked Calendar", 'insurance-ancora'),
				"description" => esc_html__("Insert booked calendar", 'insurance-ancora'),
				"category" => esc_html__('Content', 'insurance-ancora'),
				'icon' => 'icon_trx_booked',
				"class" => "trx_sc_single trx_sc_booked_calendar",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "calendar",
						"heading" => esc_html__("Calendar", 'insurance-ancora'),
						"description" => esc_html__("Select booked calendar to display", 'insurance-ancora'),
						"admin_label" => true,
						"class" => "",
						"std" => "0",
						"value" => array_flip((array)insurance_ancora_array_merge(array(0 => esc_html__('- Select calendar -', 'insurance-ancora')), $booked_cals)),
						"type" => "dropdown"
					),
					array(
						"param_name" => "year",
						"heading" => esc_html__("Year", 'insurance-ancora'),
						"description" => esc_html__("Year to display on calendar by default", 'insurance-ancora'),
						"admin_label" => true,
						"class" => "",
						"std" => date("Y"),
						"value" => date("Y"),
						"type" => "textfield"
					),
					array(
						"param_name" => "month",
						"heading" => esc_html__("Month", 'insurance-ancora'),
						"description" => esc_html__("Month to display on calendar by default", 'insurance-ancora'),
						"admin_label" => true,
						"class" => "",
						"std" => date("m"),
						"value" => date("m"),
						"type" => "textfield"
					)
				)
			) );
			
		class WPBakeryShortCode_Booked_Calendar extends Insurance_Ancora_VC_ShortCodeSingle {}

	}
}
?>