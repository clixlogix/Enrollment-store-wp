<?php
/* WPBakery PageBuilder support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('insurance_ancora_vc_theme_setup')) {
	add_action( 'insurance_ancora_action_before_init_theme', 'insurance_ancora_vc_theme_setup', 1 );
	function insurance_ancora_vc_theme_setup() {
		if (insurance_ancora_exists_visual_composer()) {
			add_action('insurance_ancora_action_add_styles',		 				'insurance_ancora_vc_frontend_scripts' );
		}
		if (is_admin()) {
			add_filter( 'insurance_ancora_filter_importer_required_plugins',		'insurance_ancora_vc_importer_required_plugins', 10, 2 );
			add_filter( 'insurance_ancora_filter_required_plugins',					'insurance_ancora_vc_required_plugins' );
		}
	}
}

// Check if WPBakery PageBuilder installed and activated
if ( !function_exists( 'insurance_ancora_exists_visual_composer' ) ) {
	function insurance_ancora_exists_visual_composer() {
		return class_exists('Vc_Manager');
	}
}

// Check if WPBakery PageBuilder in frontend editor mode
if ( !function_exists( 'insurance_ancora_vc_is_frontend' ) ) {
	function insurance_ancora_vc_is_frontend() {
		return (isset($_GET['vc_editable']) && $_GET['vc_editable']=='true')
			|| (isset($_GET['vc_action']) && $_GET['vc_action']=='vc_inline');
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'insurance_ancora_vc_required_plugins' ) ) {
	function insurance_ancora_vc_required_plugins($list=array()) {
		if (in_array('visual_composer', (array)insurance_ancora_storage_get('required_plugins'))) {
			$path = insurance_ancora_get_file_dir('plugins/install/js_composer.zip');
			if (file_exists($path)) {
				$list[] = array(
					'name' 		=> esc_html__('WPBakery PageBuilder', 'insurance-ancora'),
					'slug' 		=> 'js_composer',
                    'version'	=> '6.1',
					'source'	=> $path,
					'required' 	=> false
				);
			}
		}
		return $list;
	}
}

// Enqueue VC custom styles
if ( !function_exists( 'insurance_ancora_vc_frontend_scripts' ) ) {
	function insurance_ancora_vc_frontend_scripts() {
		if (file_exists(insurance_ancora_get_file_dir('css/plugin.visual-composer.css')))
			wp_enqueue_style( 'insurance-ancora-plugin-visual-composer-style',  insurance_ancora_get_file_url('css/plugin.visual-composer.css'), array(), null );
	}
}



// One-click import support
//------------------------------------------------------------------------

// Check VC in the required plugins
if ( !function_exists( 'insurance_ancora_vc_importer_required_plugins' ) ) {
	function insurance_ancora_vc_importer_required_plugins($not_installed='', $list='') {
		if (!insurance_ancora_exists_visual_composer() )		
			$not_installed .= '<br>' . esc_html__('WPBakery PageBuilder', 'insurance-ancora');
		return $not_installed;
	}
}
?>