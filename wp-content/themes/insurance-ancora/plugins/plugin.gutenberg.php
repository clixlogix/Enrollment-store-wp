<?php
/* Gutenberg support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('insurance_ancora_gutenberg_theme_setup')) {
    add_action( 'insurance_ancora_action_before_init_theme', 'insurance_ancora_gutenberg_theme_setup', 1 );
    function insurance_ancora_gutenberg_theme_setup() {
        if (is_admin()) {
            add_filter( 'insurance_ancora_filter_required_plugins', 'insurance_ancora_gutenberg_required_plugins' );
        }
    }
}

// Check if Instagram Widget installed and activated
if ( !function_exists( 'insurance_ancora_exists_gutenberg' ) ) {
    function insurance_ancora_exists_gutenberg() {
        return function_exists( 'the_gutenberg_project' ) && function_exists( 'register_block_type' );
    }
}

// Filter to add in the required plugins list
if ( !function_exists( 'insurance_ancora_gutenberg_required_plugins' ) ) {
    
    function insurance_ancora_gutenberg_required_plugins($list=array()) {
        if (in_array('gutenberg', (array)insurance_ancora_storage_get('required_plugins')))
            $list[] = array(
                'name'         => esc_html__('Gutenberg', 'insurance-ancora'),
                'slug'         => 'gutenberg',
                'required'     => false
            );
        return $list;
    }
}
?>