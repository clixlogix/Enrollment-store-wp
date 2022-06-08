<?php
/* ThemeREX Updater support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('insurance_ancora_trx_updater_theme_setup')) {
    add_action( 'insurance_ancora_action_before_init_theme', 'insurance_ancora_trx_updater_theme_setup' );
    function insurance_ancora_trx_updater_theme_setup() {

        if (is_admin()) {
            add_filter( 'insurance_ancora_filter_importer_required_plugins',	'insurance_ancora_trx_updater_importer_required_plugins', 10, 2 );
            add_filter( 'insurance_ancora_filter_required_plugins',				'insurance_ancora_trx_updater_required_plugins' );
        }
    }
}

// Check if RevSlider installed and activated
if ( !function_exists( 'insurance_ancora_exists_trx_updater' ) ) {
    function insurance_ancora_exists_trx_updater() {
        return defined( 'TRX_UPDATER_VERSION' );
    }
}

// Filter to add in the required plugins list
if ( !function_exists( 'insurance_ancora_trx_updater_required_plugins' ) ) {
    
    function insurance_ancora_trx_updater_required_plugins($list=array()) {
        $list[] = array(
            'name' 		=> 'ThemeREX Updater',
            'slug' 		=> 'trx_updater',
            'version'   => '1.3.9',
            'source'	=> insurance_ancora_get_file_dir('plugins/install/trx_updater.zip'),
            'required' 	=> false
        );

        return $list;
    }
}