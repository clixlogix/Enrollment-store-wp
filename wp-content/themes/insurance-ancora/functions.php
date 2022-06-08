<?php
/**
 * Theme sprecific functions and definitions
 */

/* Theme setup section
------------------------------------------------------------------- */

if ( ! isset( $content_width ) ) $content_width = 1170; /* pixels */



if ( !function_exists( 'insurance_ancora_theme_setup' ) ) {
	add_action( 'insurance_ancora_action_before_init_theme', 'insurance_ancora_theme_setup', 1 );
	function insurance_ancora_theme_setup() {

        // Add default posts and comments RSS feed links to head
        add_theme_support( 'automatic-feed-links' );

        // Enable support for Post Thumbnails
        add_theme_support( 'post-thumbnails' );

        // Custom header setup
        add_theme_support( 'custom-header', array('header-text'=>false));

        // Custom backgrounds setup
        add_theme_support( 'custom-background');

        // Supported posts formats
        add_theme_support( 'post-formats', array('gallery', 'video', 'audio', 'link', 'quote', 'image', 'status', 'aside', 'chat') );

        // Autogenerate title tag
        add_theme_support('title-tag');

        // Add user menu
        add_theme_support('nav-menus');

        // WooCommerce Support
        add_theme_support( 'woocommerce' );

        // Add wide and full blocks support
        add_theme_support( 'align-wide' );

		// Register theme menus
		add_filter( 'insurance_ancora_filter_add_theme_menus',		'insurance_ancora_add_theme_menus' );

		// Register theme sidebars
		add_filter( 'insurance_ancora_filter_add_theme_sidebars',	'insurance_ancora_add_theme_sidebars' );

		// Set options for importer
		add_filter( 'insurance_ancora_filter_importer_options',		'insurance_ancora_set_importer_options' );

		// Add theme required plugins
		add_filter( 'insurance_ancora_filter_required_plugins',		'insurance_ancora_add_required_plugins' );
		
		// Add preloader styles
		add_filter('insurance_ancora_filter_add_styles_inline',		'insurance_ancora_head_add_page_preloader_styles');

		// Init theme after WP is created
		add_action( 'wp',									'insurance_ancora_core_init_theme' );

		// Add theme specified classes into the body
		add_filter( 'body_class', 							'insurance_ancora_body_classes' );

		// Add data to the head and to the beginning of the body
		add_action('wp_head',								'insurance_ancora_head_add_page_meta', 1);
		add_action('before',								'insurance_ancora_body_add_gtm');
		add_action('before',								'insurance_ancora_body_add_toc');
		add_action('before',								'insurance_ancora_body_add_page_preloader');

		// Add data to the footer (priority 1, because priority 2 used for localize scripts)
		add_action('wp_footer',								'insurance_ancora_footer_add_views_counter', 1);
		add_action('wp_footer',								'insurance_ancora_footer_add_theme_customizer', 1);

		if (function_exists('insurance_ancora_footer_add_scroll_to_top')){
            add_action('wp_footer',								'insurance_ancora_footer_add_scroll_to_top', 1);
        }

		add_action('wp_footer',								'insurance_ancora_footer_add_custom_html', 1);
		add_action('wp_footer',								'insurance_ancora_footer_add_gtm2', 1);

		// Set list of the theme required plugins
		insurance_ancora_storage_set('required_plugins', array(
            'booked',
			'essgrids',
			'revslider',
			'trx_utils',
			'visual_composer',
            'wp_gdpr_compliance',
            'contact_form_7',
            'instagram-widget-by-wpzoom'
			)
		);


		
	}
}


// Add/Remove theme nav menus
if ( !function_exists( 'insurance_ancora_add_theme_menus' ) ) {
	function insurance_ancora_add_theme_menus($menus) {
		return $menus;
	}
}


// Add theme specific widgetized areas
if ( !function_exists( 'insurance_ancora_add_theme_sidebars' ) ) {
	function insurance_ancora_add_theme_sidebars($sidebars=array()) {
		if (is_array($sidebars)) {
			$theme_sidebars = array(
				'sidebar_main'		=> esc_html__( 'Main Sidebar', 'insurance-ancora' ),
				'sidebar_footer'	=> esc_html__( 'Footer Sidebar', 'insurance-ancora' )
			);
			if (function_exists('insurance_ancora_exists_woocommerce') && insurance_ancora_exists_woocommerce()) {
				$theme_sidebars['sidebar_cart']  = esc_html__( 'WooCommerce Cart Sidebar', 'insurance-ancora' );
			}
			$sidebars = array_merge($theme_sidebars, $sidebars);
		}
		return $sidebars;
	}
}


// Add theme required plugins
if ( !function_exists( 'insurance_ancora_add_required_plugins' ) ) {
	function insurance_ancora_add_required_plugins($plugins) {
		$plugins[] = array(
			'name' 		=> 'TRX Utils plugin',
			'version'	=> '3.2.1',
			'slug' 		=> 'trx_utils',
			'source'	=> insurance_ancora_get_file_dir('plugins/install/trx_utils.zip'),
			'required' 	=> true
		);
		return $plugins;
	}
}



//------------------------------------------------------------------------ 
// One-click import support 
//------------------------------------------------------------------------ 

// Set theme specific importer options 
if ( ! function_exists( 'insurance_ancora_importer_set_options' ) ) {
    add_filter( 'trx_utils_filter_importer_options', 'insurance_ancora_importer_set_options', 9 );
    function insurance_ancora_importer_set_options( $options=array() ) {
        if ( is_array( $options ) ) {
            // Save or not installer's messages to the log-file 
            $options['debug'] = false;
            // Prepare demo data 
            if ( is_dir( INSURANCE_ANCORA_THEME_PATH . 'demo/' ) ) {
                $options['demo_url'] = INSURANCE_ANCORA_THEME_PATH . 'demo/';
            } else {
                $options['demo_url'] = esc_url( insurance_ancora_get_protocol().'://demofiles.ancorathemes.com/insurance/' ); // Demo-site domain
            }

            // Required plugins 
            $options['required_plugins'] =  array(
                'booked',
                'instagram_widget',
                'essential-grid',
                'revslider',
                'trx_utils',
                'js_composer',
                'contact-form-7'
            );

            $options['theme_slug'] = 'insurance_ancora';

            // Set number of thumbnails to regenerate when its imported (if demo data was zipped without cropped images) 
            // Set 0 to prevent regenerate thumbnails (if demo data archive is already contain cropped images) 
            $options['regenerate_thumbnails'] = 3;
            // Default demo 
            $options['files']['default']['title'] = esc_html__( 'Education Demo', 'insurance-ancora' );
            $options['files']['default']['domain_dev'] = esc_url(insurance_ancora_get_protocol().'://insurance.dv.ancorathemes.com'); // Developers domain
            $options['files']['default']['domain_demo']= esc_url(insurance_ancora_get_protocol().'://insurance.ancorathemes.com'); // Demo-site domain

        }
        return $options;
    }
}

// Add data to the head and to the beginning of the body
//------------------------------------------------------------------------

// Add theme specified classes to the body tag
if ( !function_exists('insurance_ancora_body_classes') ) {
	function insurance_ancora_body_classes( $classes ) {

		$classes[] = 'insurance_ancora_body';
		$classes[] = 'body_style_' . trim(insurance_ancora_get_custom_option('body_style'));
		$classes[] = 'body_' . (insurance_ancora_get_custom_option('body_filled')=='yes' ? 'filled' : 'transparent');
		$classes[] = 'article_style_' . trim(insurance_ancora_get_custom_option('article_style'));
		
		$blog_style = insurance_ancora_get_custom_option(is_singular() && !insurance_ancora_storage_get('blog_streampage') ? 'single_style' : 'blog_style');
		$classes[] = 'layout_' . trim($blog_style);
		$classes[] = 'template_' . trim(insurance_ancora_get_template_name($blog_style));
		
		$body_scheme = insurance_ancora_get_custom_option('body_scheme');
		if (empty($body_scheme)  || insurance_ancora_is_inherit_option($body_scheme)) $body_scheme = 'original';
		$classes[] = 'scheme_' . $body_scheme;

		$top_panel_position = insurance_ancora_get_custom_option('top_panel_position');
		if (!insurance_ancora_param_is_off($top_panel_position)) {
			$classes[] = 'top_panel_show';
			$classes[] = 'top_panel_' . trim($top_panel_position);
		} else 
			$classes[] = 'top_panel_hide';
		$classes[] = insurance_ancora_get_sidebar_class();

		if (insurance_ancora_get_custom_option('show_video_bg')=='yes' && (insurance_ancora_get_custom_option('video_bg_youtube_code')!='' || insurance_ancora_get_custom_option('video_bg_url')!=''))
			$classes[] = 'video_bg_show';

		if (!insurance_ancora_param_is_off(insurance_ancora_get_theme_option('page_preloader')))
			$classes[] = 'preloader';

		return $classes;
	}
}


// Add page meta to the head
if (!function_exists('insurance_ancora_head_add_page_meta')) {
	function insurance_ancora_head_add_page_meta() {
		?>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1<?php if (insurance_ancora_get_theme_option('responsive_layouts')=='yes') echo ', maximum-scale=1'; ?>">
		<meta name="format-detection" content="telephone=no">
	
		<link rel="profile" href="//gmpg.org/xfn/11" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<?php
	}
}

// Add page preloader styles to the head
if (!function_exists('insurance_ancora_head_add_page_preloader_styles')) {
	function insurance_ancora_head_add_page_preloader_styles($css) {
		if (($preloader=insurance_ancora_get_theme_option('page_preloader'))!='none') {
			$image = insurance_ancora_get_theme_option('page_preloader_image');
			$bg_clr = insurance_ancora_get_scheme_color('bg_color');
			$link_clr = insurance_ancora_get_scheme_color('text_link');
			$css .= '
				#page_preloader {
					background-color: '. esc_attr($bg_clr) . ';'
					. ($preloader=='custom' && $image
						? 'background-image:url('.esc_url($image).');'
						: ''
						)
				    . '
				}
				.preloader_wrap > div {
					background-color: '.esc_attr($link_clr).';
				}';
		}
		return $css;
	}
}

// Add gtm code to the beginning of the body 
if (!function_exists('insurance_ancora_body_add_gtm')) {
	function insurance_ancora_body_add_gtm() {
		insurance_ancora_show_layout(insurance_ancora_get_custom_option('gtm_code'));
	}
}

// Add TOC anchors to the beginning of the body 
if (!function_exists('insurance_ancora_body_add_toc')) {
	function insurance_ancora_body_add_toc() {
		if (insurance_ancora_get_custom_option('menu_toc_home')=='yes' && function_exists('insurance_ancora_sc_anchor'))
			insurance_ancora_show_layout(insurance_ancora_sc_anchor(array(
				'id' => "toc_home",
				'title' => esc_html__('Home', 'insurance-ancora'),
				'description' => esc_html__('{{Return to Home}} - ||navigate to home page of the site', 'insurance-ancora'),
				'icon' => "icon-home",
				'separator' => "yes",
				'url' => esc_url(home_url('/'))
				)
			)); 
		if (insurance_ancora_get_custom_option('menu_toc_top')=='yes' && function_exists('insurance_ancora_sc_anchor'))
			insurance_ancora_show_layout(insurance_ancora_sc_anchor(array(
				'id' => "toc_top",
				'title' => esc_html__('To Top', 'insurance-ancora'),
				'description' => esc_html__('{{Back to top}} - ||scroll to top of the page', 'insurance-ancora'),
				'icon' => "icon-double-up",
				'separator' => "yes")
				)); 
	}
}

// Add page preloader to the beginning of the body
if (!function_exists('insurance_ancora_body_add_page_preloader')) {
	function insurance_ancora_body_add_page_preloader() {
		if ( ($preloader=insurance_ancora_get_theme_option('page_preloader')) != 'none' && ( $preloader != 'custom' || ($image=insurance_ancora_get_theme_option('page_preloader_image')) != '')) {
			?><div id="page_preloader"><?php
				if ($preloader == 'circle') {
					?><div class="preloader_wrap preloader_<?php echo esc_attr($preloader); ?>"><div class="preloader_circ1"></div><div class="preloader_circ2"></div><div class="preloader_circ3"></div><div class="preloader_circ4"></div></div><?php
				} else if ($preloader == 'square') {
					?><div class="preloader_wrap preloader_<?php echo esc_attr($preloader); ?>"><div class="preloader_square1"></div><div class="preloader_square2"></div></div><?php
				}
			?></div><?php
		}
	}
}


// Add data to the footer
//------------------------------------------------------------------------

// Add post/page views counter
if (!function_exists('insurance_ancora_footer_add_views_counter')) {
	function insurance_ancora_footer_add_views_counter() {
		get_template_part(insurance_ancora_get_file_slug('templates/_parts/views-counter.php'));
	}
}

// Add theme customizer
if (!function_exists('insurance_ancora_footer_add_theme_customizer')) {
	function insurance_ancora_footer_add_theme_customizer() {
		if (insurance_ancora_get_custom_option('show_theme_customizer')=='yes') {
			get_template_part(insurance_ancora_get_file_slug('core/core.customizer/front.customizer.php'));
		}
	}
}

// Add custom html
if (!function_exists('insurance_ancora_footer_add_custom_html')) {
	function insurance_ancora_footer_add_custom_html() {
		?><div class="custom_html_section"><?php
			insurance_ancora_show_layout(insurance_ancora_get_custom_option('custom_code'));
		?></div><?php
	}
}

// Add gtm code
if (!function_exists('insurance_ancora_footer_add_gtm2')) {
	function insurance_ancora_footer_add_gtm2() {
		insurance_ancora_show_layout(insurance_ancora_get_custom_option('gtm_code2'));
	}
}

// Add theme required plugins
if ( !function_exists( 'insurance_ancora_add_trx_utils' ) ) {
    add_filter( 'trx_utils_active', 'insurance_ancora_add_trx_utils' );
    function insurance_ancora_add_trx_utils($enable=true) {
        return true;
    }
}

// Return placeholder for reviews block
if ( !function_exists( 'insurance_ancora_get_reviews_placeholder' ) ) {
    function insurance_ancora_get_reviews_placeholder() {
        return '<!-- #TRX_REVIEWS_PLACEHOLDER# -->';
    }
}

// Replace placeholder with the reviews block
if ( !function_exists( 'insurance_ancora_reviews_wrapper' ) ) {
    function insurance_ancora_reviews_wrapper($str) {
        $placeholder = insurance_ancora_get_reviews_placeholder();
        if (insurance_ancora_strpos($str, $placeholder)!==false) {
            if (($reviews_markup=insurance_ancora_storage_get('reviews_markup'))!='') {
                $str = str_replace($placeholder, $reviews_markup, $str);
                insurance_ancora_storage_set('reviews_markup', '');
            }
        }
        return $str;
    }
}

// Add class trx_utils_activated
if(!function_exists('insurance_ancora_add_body_class')) {
    if(!function_exists ( 'trx_utils_require_shortcode')){
        add_filter( 'body_class', 'insurance_ancora_add_body_class' );
        function insurance_ancora_add_body_class($classes){
            $classes[] = 'default_theme';
            return $classes;
        }
    }
}

// Include framework core files
//-------------------------------------------------------------------
require_once trailingslashit( get_template_directory() ) . 'fw/loader.php';
?>