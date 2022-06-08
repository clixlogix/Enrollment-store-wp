<?php
/**
 * InsuranceAncora Framework
 *
 * @package insurance_ancora
 * @since insurance_ancora 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Framework directory path from theme root
if ( ! defined( 'INSURANCE_ANCORA_FW_DIR' ) )			define( 'INSURANCE_ANCORA_FW_DIR', 'fw' );
if ( ! defined( 'INSURANCE_ANCORA_THEME_PATH' ) )	define( 'INSURANCE_ANCORA_THEME_PATH',	trailingslashit( get_template_directory() ) );
if ( ! defined( 'INSURANCE_ANCORA_FW_PATH' ) )		define( 'INSURANCE_ANCORA_FW_PATH',		INSURANCE_ANCORA_THEME_PATH . INSURANCE_ANCORA_FW_DIR . '/' );

// Include theme variables storage
require_once trailingslashit( get_template_directory() ) . INSURANCE_ANCORA_FW_DIR . '/core/core.storage.php';

// Theme variables storage
insurance_ancora_storage_set('options_prefix', 'insurance_ancora');
insurance_ancora_storage_set('page_template', '');
insurance_ancora_storage_set('widgets_args', array(
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h6 class="widget_title">',
		'after_title'   => '</h6>',
	)
);

/* Theme setup section
-------------------------------------------------------------------- */
if ( !function_exists( 'insurance_ancora_loader_theme_setup' ) ) {
	add_action( 'after_setup_theme', 'insurance_ancora_loader_theme_setup', 20 );
	function insurance_ancora_loader_theme_setup() {

		// Before init theme
		do_action('insurance_ancora_action_before_init_theme');

		// Load current values for main theme options
		insurance_ancora_load_main_options();

		if ( is_admin() ) {
			insurance_ancora_core_init_theme();
		}
	}
}


/* Include core parts
------------------------------------------------------------------------ */
// Manual load important libraries before load all rest files
require_once trailingslashit( get_template_directory() ) . INSURANCE_ANCORA_FW_DIR . '/core/core.strings.php';
require_once trailingslashit( get_template_directory() ) . INSURANCE_ANCORA_FW_DIR . '/core/core.files.php';

// Include debug utilities
require_once trailingslashit( get_template_directory() ) . INSURANCE_ANCORA_FW_DIR . '/core/core.debug.php';

// Include custom theme files
insurance_ancora_autoload_folder( 'includes' );

// Include core files
insurance_ancora_autoload_folder( 'core' );

// Include theme-specific plugins and post types
insurance_ancora_autoload_folder( 'plugins' );

// Include theme templates
insurance_ancora_autoload_folder( 'templates' );

// Include theme widgets
insurance_ancora_autoload_folder( 'widgets' );
?>