<?php
/* WP GDPR Compliance support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('insurance_ancora_wp_gdpr_compliance_theme_setup')) {
    add_action( 'insurance_ancora_action_before_init_theme', 'insurance_ancora_wp_gdpr_compliance_theme_setup', 1 );
    function insurance_ancora_wp_gdpr_compliance_theme_setup() {
        if (is_admin()) {
            add_filter( 'insurance_ancora_filter_required_plugins', 'insurance_ancora_wp_gdpr_compliance_required_plugins' );
        }
    }
}

// Check if Instagram Widget installed and activated
if ( !function_exists( 'insurance_ancora_exists_wp_gdpr_compliance' ) ) {
    function insurance_ancora_exists_wp_gdpr_compliance() {
        return defined( 'WP_GDPR_Compliance_VERSION' );
    }
}

// Filter to add in the required plugins list
if ( !function_exists( 'insurance_ancora_wp_gdpr_compliance_required_plugins' ) ) {
    
    function insurance_ancora_wp_gdpr_compliance_required_plugins($list=array()) {
        if (in_array('wp_gdpr_compliance', (array)insurance_ancora_storage_get('required_plugins')))
            $list[] = array(
                'name'         => esc_html__('WP GDPR Compliance', 'insurance-ancora'),
                'slug'         => 'wp-gdpr-compliance',
                'required'     => false
            );
        return $list;
    }
}
?>
