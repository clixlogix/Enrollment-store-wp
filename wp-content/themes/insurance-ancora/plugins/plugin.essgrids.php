<?php
/* Essential Grid support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('insurance_ancora_essgrids_theme_setup')) {
	add_action( 'insurance_ancora_action_before_init_theme', 'insurance_ancora_essgrids_theme_setup', 1 );
	function insurance_ancora_essgrids_theme_setup() {
		// Register shortcode in the shortcodes list
		if (insurance_ancora_exists_essgrids()) {
			if (is_admin()) {
				add_filter( 'insurance_ancora_filter_importer_import_row',		'insurance_ancora_essgrids_importer_check_row', 9, 4);
			}
		}
		if (is_admin()) {
			add_filter( 'insurance_ancora_filter_importer_required_plugins',	'insurance_ancora_essgrids_importer_required_plugins', 10, 2 );
			add_filter( 'insurance_ancora_filter_required_plugins',				'insurance_ancora_essgrids_required_plugins' );
		}
	}
}


// Check if Ess. Grid installed and activated
if ( !function_exists( 'insurance_ancora_exists_essgrids' ) ) {
	function insurance_ancora_exists_essgrids() {
		return defined('EG_PLUGIN_PATH');
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'insurance_ancora_essgrids_required_plugins' ) ) {
	function insurance_ancora_essgrids_required_plugins($list=array()) {
		if (in_array('essgrids', (array)insurance_ancora_storage_get('required_plugins'))) {
			$path = insurance_ancora_get_file_dir('plugins/install/essential-grid.zip');
			if (file_exists($path)) {
				$list[] = array(
					'name' 		=> esc_html__('Essential Grid', 'insurance-ancora'),
					'slug' 		=> 'essential-grid',
                    'version'	=> '2.3.6',
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

// Check in the required plugins
if ( !function_exists( 'insurance_ancora_essgrids_importer_required_plugins' ) ) {
	function insurance_ancora_essgrids_importer_required_plugins($not_installed='', $list='') {
		if (insurance_ancora_strpos($list, 'essgrids')!==false && !insurance_ancora_exists_essgrids() )
			$not_installed .= '<br>'.esc_html__('Essential Grids', 'insurance-ancora');
		return $not_installed;
	}
}

// Check if the row will be imported
if ( !function_exists( 'insurance_ancora_essgrids_importer_check_row' ) ) {
	
	function insurance_ancora_essgrids_importer_check_row($flag, $table, $row, $list) {
		if ($flag || strpos($list, 'essgrids')===false) return $flag;
		if ( insurance_ancora_exists_essgrids() ) {
			if ($table == 'posts')
				$flag = $row['post_type']==apply_filters('essgrid_PunchPost_custom_post_type', 'essential_grid');
		}
		return $flag;
	}
}
?>