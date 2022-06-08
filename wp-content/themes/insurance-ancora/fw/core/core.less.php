<?php
/**
 * InsuranceAncora Framework: less manipulations
 *
 * @package	insurance_ancora
 * @since	insurance_ancora 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


// Theme init
if (!function_exists('insurance_ancora_less_theme_setup2')) {
	add_action( 'insurance_ancora_action_after_init_theme', 'insurance_ancora_less_theme_setup2' );
	function insurance_ancora_less_theme_setup2() {
		if (insurance_ancora_get_theme_setting('less_compiler')!='no' && !is_admin() && insurance_ancora_get_theme_option('debug_mode')=='yes') {

			// Regular run - if not admin - recompile only changed files
			$check_time = true;
			if (!is_customize_preview() && (int) get_option(insurance_ancora_storage_get('options_prefix') . '_compile_less') > 0) {
				update_option(insurance_ancora_storage_get('options_prefix') . '_compile_less', 0);
				$check_time = false;
			}
			
			insurance_ancora_storage_set('less_check_time', $check_time);
			do_action('insurance_ancora_action_compile_less');
			insurance_ancora_storage_set('less_check_time', false);

		}
	}
}



/* LESS
-------------------------------------------------------------------------------- */

// Recompile all LESS files
if (!function_exists('insurance_ancora_compile_less')) {	
	function insurance_ancora_compile_less($list = array(), $recompile=true) {

		if (!function_exists('trx_utils_less_compiler')) return false;

		$success = true;

		// Less compiler
		$less_compiler = insurance_ancora_get_theme_setting('less_compiler');
		if ($less_compiler == 'no') return $success;
	
		// Prepare theme specific LESS-vars (colors, backgrounds, logo height, etc.)
		$less_split = insurance_ancora_get_theme_setting('less_split');
		$vars = apply_filters('insurance_ancora_filter_prepare_less', '');
		if ($less_compiler=='external' || !$less_split) {
			// Save LESS-vars into theme.vars.less
			insurance_ancora_fpc(insurance_ancora_get_file_dir('css/theme.vars.less'), $vars);
			if ($less_compiler=='external') return $success;
			$vars = '';
		}
		
		// Generate map for the LESS-files
		$less_map = insurance_ancora_get_theme_setting('less_map');
		if (insurance_ancora_get_theme_option('debug_mode')=='no' || $less_compiler=='lessc') $less_map = 'no';
		
		// Get separator to split LESS-files
		$less_sep = $less_map!='no' ? '' : insurance_ancora_get_theme_setting('less_separator');

		// Collect .less files in parent and child themes
		if (empty($list)) {
			$list = insurance_ancora_collect_files(get_template_directory(), 'less');
			if (get_template_directory() != get_stylesheet_directory()) $list = array_merge($list, insurance_ancora_collect_files(get_stylesheet_directory(), 'less'));
		}
		// Prepare separate array with less utils (not compile it alone - only with main files)
		$utils = $less_map!='no' ? array() : '';
		$utils_time = 0;
		if (is_array($list) && count($list) > 0) {
			foreach($list as $k=>$file) {
				$fname = basename($file);
				if ($fname[0]=='_') {
					if ($less_map!='no')
						$utils[] = $file;
					else
						$utils .= insurance_ancora_fgc($file);
					$list[$k] = '';
					$tmp = filemtime($file);
					if ($utils_time < $tmp) $utils_time = $tmp;
				}
			}
		}
		
		// Compile all .less files
		if (is_array($list) && count($list) > 0) {
			$success = trx_utils_less_compiler($list, array(
				'compiler' => $less_compiler,
				'map' => $less_map,
				'parse_files' => !$less_split,
				'utils' => $utils,
				'utils_time' => $utils_time,
				'vars' => $vars,
				'import' => array(insurance_ancora_get_folder_dir('css')),
				'separator' => $less_sep,
				'check_time' => insurance_ancora_storage_get('less_check_time')==true,
				'compressed' => insurance_ancora_get_theme_option('debug_mode')=='no'
				)
			);
		}
		
		return $success;
	}
}
?>