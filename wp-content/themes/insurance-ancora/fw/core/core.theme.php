<?php
/**
 * InsuranceAncora Framework: Theme specific actions
 *
 * @package	insurance_ancora
 * @since	insurance_ancora 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

// Default Theme Options
if ( !function_exists( 'insurance_ancora_core_theme_setup1' ) ) {
	add_action( 'insurance_ancora_action_before_init_theme', 'insurance_ancora_core_theme_setup1', 1 );	// Priority 1 for add insurance_ancora_filter handlers
	function insurance_ancora_core_theme_setup1() {
		// Make theme available for translation
		// Translations can be filled in the /languages directory
		load_theme_textdomain( 'insurance-ancora', insurance_ancora_get_folder_dir('languages') );
	}
}


if ( !function_exists( 'insurance_ancora_core_theme_setup' ) ) {
	add_action( 'insurance_ancora_action_before_init_theme', 'insurance_ancora_core_theme_setup', 11 );
	function insurance_ancora_core_theme_setup() {


		
		// Editor custom stylesheet - for user
		add_editor_style(insurance_ancora_get_file_url('css/editor-style.css'));


		/* Front and Admin actions and filters:
		------------------------------------------------------------------------ */

		if ( !is_admin() ) {
			
			/* Front actions and filters:
			------------------------------------------------------------------------ */
	
			// Filters wp_title to print a neat <title> tag based on what is being viewed
			if (floatval(get_bloginfo('version')) < "4.1") {
				add_action('wp_head',						'insurance_ancora_wp_title_show');
				add_filter('wp_title',						'insurance_ancora_wp_title_modify', 10, 2);
			}

			// Prepare logo text
			add_filter('insurance_ancora_filter_prepare_logo_text',	'insurance_ancora_prepare_logo_text', 10, 1);
	
			// Add class "widget_number_#' for each widget
			add_filter('dynamic_sidebar_params', 			'insurance_ancora_add_widget_number', 10, 1);
	
			// Enqueue scripts and styles
			add_action('wp_enqueue_scripts', 				'insurance_ancora_core_frontend_scripts');
			add_action('wp_footer',		 					'insurance_ancora_core_frontend_scripts_inline', 9);
			add_action('wp_footer',		 					'insurance_ancora_core_frontend_add_js_vars', 2);
			add_filter('insurance_ancora_action_add_scripts_inline','insurance_ancora_core_add_scripts_inline');
			add_filter('insurance_ancora_filter_localize_script',	'insurance_ancora_core_localize_script');
	


			// Prepare theme core global variables
			add_action('insurance_ancora_action_prepare_globals',	'insurance_ancora_core_prepare_globals');
		}

		// Frontend editor: Save post data
		add_action('wp_ajax_frontend_editor_save',		'insurance_ancora_callback_frontend_editor_save');


		// Frontend editor: Delete post
		add_action('wp_ajax_frontend_editor_delete', 	'insurance_ancora_callback_frontend_editor_delete');


		// Register theme specific nav menus
		insurance_ancora_register_theme_menus();

		// Register theme specific sidebars
		insurance_ancora_register_theme_sidebars();
	}
}




/* Theme init
------------------------------------------------------------------------ */

// Init theme template
function insurance_ancora_core_init_theme() {
	if (insurance_ancora_storage_get('theme_inited')===true) return;
	insurance_ancora_storage_set('theme_inited', true);

	// Load custom options from GET and post/page/cat options
	if (isset($_GET['set']) && $_GET['set']==1) {
		foreach ($_GET as $k=>$v) {
			if (insurance_ancora_get_theme_option($k, null) !== null) {
				setcookie($k, $v, 0, '/');
				$_COOKIE[$k] = $v;
			}
		}
	}

	// Get custom options from current category / page / post / shop / event
	insurance_ancora_load_custom_options();

	// Fire init theme actions (after custom options are loaded)
	do_action('insurance_ancora_action_init_theme');

	// Prepare theme core global variables
	do_action('insurance_ancora_action_prepare_globals');

	// Fire after init theme actions
	do_action('insurance_ancora_action_after_init_theme');
}


// Prepare theme global variables
if ( !function_exists( 'insurance_ancora_core_prepare_globals' ) ) {
	function insurance_ancora_core_prepare_globals() {
		if (!is_admin()) {
			// Logo text and slogan
			insurance_ancora_storage_set('logo_text', apply_filters('insurance_ancora_filter_prepare_logo_text', insurance_ancora_get_custom_option('logo_text')));
			insurance_ancora_storage_set('logo_slogan', get_bloginfo('description'));
			
			// Logo image and icons
			$logo        = insurance_ancora_get_logo_icon('logo');
			$logo_side   = insurance_ancora_get_logo_icon('logo_side');
			$logo_fixed  = insurance_ancora_get_logo_icon('logo_fixed');
			$logo_footer = insurance_ancora_get_logo_icon('logo_footer');
			insurance_ancora_storage_set('logo', $logo);
			insurance_ancora_storage_set('logo_icon',   insurance_ancora_get_logo_icon('logo_icon'));
			insurance_ancora_storage_set('logo_side',   $logo_side   ? $logo_side   : $logo);
			insurance_ancora_storage_set('logo_fixed',  $logo_fixed  ? $logo_fixed  : $logo);
			insurance_ancora_storage_set('logo_footer', $logo_footer ? $logo_footer : $logo);
	
			$shop_mode = '';
			if (insurance_ancora_get_custom_option('show_mode_buttons')=='yes')
				$shop_mode = insurance_ancora_get_value_gpc('insurance_ancora_shop_mode');
			if (empty($shop_mode))
				$shop_mode = insurance_ancora_get_custom_option('shop_mode', '');
			if (empty($shop_mode) || !is_archive())
				$shop_mode = 'thumbs';
			insurance_ancora_storage_set('shop_mode', $shop_mode);
		}
	}
}


// Return url for the uploaded logo image
if ( !function_exists( 'insurance_ancora_get_logo_icon' ) ) {
	function insurance_ancora_get_logo_icon($slug) {
		// This way to load retina logo only if 'Retina' enabled in the Theme Options
		
		// This way ignore the 'Retina' setting and load retina logo on any display with retina support
		$mult = (int) insurance_ancora_get_value_gpc('insurance_ancora_retina', 0) > 0 ? 2 : 1;
		$logo_icon = '';
		if ($mult > 1) 			$logo_icon = insurance_ancora_get_custom_option($slug.'_retina');
		if (empty($logo_icon))	$logo_icon = insurance_ancora_get_custom_option($slug);
		return $logo_icon;
	}
}


// Display logo image with text and slogan (if specified)
if ( !function_exists( 'insurance_ancora_show_logo' ) ) {
	function insurance_ancora_show_logo($logo_main=true, $logo_fixed=false, $logo_footer=false, $logo_side=false, $logo_text=true, $logo_slogan=false) {
		if ($logo_main===true) 		$logo_main   = insurance_ancora_storage_get('logo');
		if ($logo_fixed===true)		$logo_fixed  = insurance_ancora_storage_get('logo_fixed');
		if ($logo_footer===true)	$logo_footer = insurance_ancora_storage_get('logo_footer');
		if ($logo_side===true)		$logo_side   = insurance_ancora_storage_get('logo_side');
		if ($logo_text===true)		$logo_text   = insurance_ancora_storage_get('logo_text');
		if ($logo_slogan===true)	$logo_slogan = insurance_ancora_storage_get('logo_slogan');
		if (empty($logo_main) && empty($logo_fixed) && empty($logo_footer) && empty($logo_side) && empty($logo_text))
			 $logo_text = get_bloginfo('name');
		if ($logo_main || $logo_fixed || $logo_footer || $logo_side || $logo_text) {
		?>
		<div class="logo">
			<a href="<?php echo esc_url(home_url('/')); ?>"><?php
				if (!empty($logo_main)) {
					$attr = insurance_ancora_getimagesize($logo_main);
                    $alt = basename($logo_main);
                    $alt = substr($alt,0,strlen($alt) - 4);
                    echo '<img src="'.esc_url($logo_main).'" class="logo_main" alt="'. esc_attr($alt).'"'.(!empty($attr[3]) ? ' '.trim($attr[3]) : '').'>';
				}
				if (!empty($logo_fixed)) {
					$attr = insurance_ancora_getimagesize($logo_fixed);
                    $alt = basename($logo_fixed);
                    $alt = substr($alt,0,strlen($alt) - 4);
					echo '<img src="'.esc_url($logo_fixed).'" class="logo_fixed" alt="'. esc_attr($alt).'"'.(!empty($attr[3]) ? ' '.trim($attr[3]) : '').'>';
				}
				if (!empty($logo_footer)) {
					$attr = insurance_ancora_getimagesize($logo_footer);
					$alt = basename($logo_footer);
                    $alt = substr($alt,0,strlen($alt) - 4);
					echo '<img src="'.esc_url($logo_footer).'" class="logo_footer" alt="'. esc_attr($alt).'"'.(!empty($attr[3]) ? ' '.trim($attr[3]) : '').'>';
				}
				if (!empty($logo_side)) {
					$attr = insurance_ancora_getimagesize($logo_side);
                    $alt = basename($logo_side);
                    $alt = substr($alt,0,strlen($alt) - 4);
					echo '<img src="'.esc_url($logo_side).'" class="logo_side" alt="'. esc_attr($alt).'"'.(!empty($attr[3]) ? ' '.trim($attr[3]) : '').'>';
				}
				echo !empty($logo_text) ? '<div class="logo_text">'.trim($logo_text).'</div>' : '';
				echo !empty($logo_slogan) ? '<br><div class="logo_slogan">' . esc_html($logo_slogan) . '</div>' : '';
			?></a>
		</div>
		<?php 
		}
	} 
}


// Add menu locations
if ( !function_exists( 'insurance_ancora_register_theme_menus' ) ) {
	function insurance_ancora_register_theme_menus() {
		register_nav_menus(apply_filters('insurance_ancora_filter_add_theme_menus', array(
			'menu_main'		=> esc_html__('Main Menu', 'insurance-ancora'),
			'menu_user'		=> esc_html__('User Menu', 'insurance-ancora'),
			'menu_footer'	=> esc_html__('Footer Menu', 'insurance-ancora'),
			'menu_side'		=> esc_html__('Side Menu', 'insurance-ancora')
		)));
	}
}


// Register widgetized area
if ( !function_exists( 'insurance_ancora_register_theme_sidebars' ) ) {
    add_action('widgets_init', 'insurance_ancora_register_theme_sidebars');
    function insurance_ancora_register_theme_sidebars($sidebars=array()) {
        if (!is_array($sidebars)) $sidebars = array();
        // Custom sidebars
        $custom = insurance_ancora_get_theme_option('custom_sidebars');
        if (is_array($custom) && count($custom) > 0) {
            foreach ($custom as $i => $sb) {
                if (trim(chop($sb))=='') continue;
                $sidebars['sidebar_custom_'.($i)]  = $sb;
            }
        }
        $sidebars = apply_filters( 'insurance_ancora_filter_add_theme_sidebars', $sidebars );
        $registered = insurance_ancora_storage_get('registered_sidebars');
        if (!is_array($registered)) $registered = array();
        if (is_array($sidebars) && count($sidebars) > 0) {
            foreach ($sidebars as $id=>$name) {
                if (isset($registered[$id])) continue;
                $registered[$id] = $name;
                register_sidebar( array_merge( array(
                        'name'          => $name,
                        'id'            => $id
                    ),
                        insurance_ancora_storage_get('widgets_args')
                    )
                );
            }
        }
        insurance_ancora_storage_set('registered_sidebars', $registered);
    }
}





/* Front actions and filters:
------------------------------------------------------------------------ */

//  Enqueue scripts and styles
if ( !function_exists( 'insurance_ancora_core_frontend_scripts' ) ) {
	function insurance_ancora_core_frontend_scripts() {
		
		// Modernizr will load in head before other scripts and styles
		// Use older version (from photostack)
		wp_enqueue_script( 'modernizr', insurance_ancora_get_file_url('js/photostack/modernizr.min.js'), array(), null, false );
		
		// Enqueue styles
		//-----------------------------------------------------------------------------------------------------
		
		// Prepare custom fonts
		$fonts = insurance_ancora_get_list_fonts(false);
		$theme_fonts = array();
		$custom_fonts = insurance_ancora_get_custom_fonts();
		if (is_array($custom_fonts) && count($custom_fonts) > 0) {
			foreach ($custom_fonts as $s=>$f) {
				if (!empty($f['font-family']) && !insurance_ancora_is_inherit_option($f['font-family'])) $theme_fonts[$f['font-family']] = 1;
			}
		}
		// Prepare current theme fonts
		$theme_fonts = apply_filters('insurance_ancora_filter_used_fonts', $theme_fonts);
		// Link to selected fonts
		if (is_array($theme_fonts) && count($theme_fonts) > 0) {
			$google_fonts = '';
			foreach ($theme_fonts as $font=>$v) {
				if (isset($fonts[$font])) {
					$font_name = ($pos=insurance_ancora_strpos($font,' ('))!==false ? insurance_ancora_substr($font, 0, $pos) : $font;
					if (!empty($fonts[$font]['css'])) {
						$css = $fonts[$font]['css'];
						wp_enqueue_style( 'insurance-ancora-font-'.str_replace(' ', '-', $font_name).'-style', $css, array(), null );
					} else {
                        // Attention! Using '%7C' instead '|' damage loading second+ fonts
                        $google_fonts .= ($google_fonts ? '|' : '')
							. (!empty($fonts[$font]['link']) ? $fonts[$font]['link'] : str_replace(' ', '+', $font_name).':300,300italic,400,400italic,700,700italic');
					}
				}
			}
            if ($google_fonts) {
                /*
                Translators: If there are characters in your language that are not supported
                by chosen font(s), translate this to 'off'. Do not translate into your own language.
                */
                $google_fonts_enabled = ( 'off' !== esc_html_x( 'on', 'Google fonts: on or off', 'insurance-ancora' ) );
                if ( $google_fonts_enabled ) {
                    wp_enqueue_style( 'insurance-ancora-font-google-fonts-style', add_query_arg( 'family', $google_fonts . '&subset=' . insurance_ancora_get_theme_option('fonts_subset'), "//fonts.googleapis.com/css" ), array(), null );

                }
            }}
		
		// Fontello styles must be loaded before main stylesheet
		wp_enqueue_style( 'fontello-style',  insurance_ancora_get_file_url('css/fontello/css/fontello.css'),  array(), null);

		// Main stylesheet
		wp_enqueue_style( 'insurance-ancora-main-style', get_stylesheet_uri(), array(), null );
		
		// Animations
		if (insurance_ancora_get_theme_option('css_animation')=='yes' && (insurance_ancora_get_theme_option('animation_on_mobile')=='yes' || !wp_is_mobile()) && !insurance_ancora_vc_is_frontend())
			wp_enqueue_style( 'insurance-ancora-animation-style',	insurance_ancora_get_file_url('css/core.animation.css'), array(), null );

		// Theme stylesheets
		do_action('insurance_ancora_action_add_styles');

		// Responsive
		if (insurance_ancora_get_theme_option('responsive_layouts') == 'yes') {
			$suffix = insurance_ancora_param_is_off(insurance_ancora_get_custom_option('show_sidebar_outer')) ? '' : '-outer';
			wp_enqueue_style( 'insurance-ancora-responsive-style', insurance_ancora_get_file_url('css/responsive'.($suffix).'.css'), array(), null );
			do_action('insurance_ancora_action_add_responsive');
			$css = apply_filters('insurance_ancora_filter_add_responsive_inline', '');
			if (!empty($css)) wp_add_inline_style( 'insurance-ancora-responsive-style', $css );
		}

		// Disable loading JQuery UI CSS
		wp_deregister_style('jquery_ui');
		wp_deregister_style('date-picker-css');


		// Enqueue scripts	
		//----------------------------------------------------------------------------------------------------------------------------
		
		// Load separate theme scripts
		wp_enqueue_script( 'superfish', insurance_ancora_get_file_url('js/superfish.js'), array('jquery'), null, true );
		if (in_array(insurance_ancora_get_theme_option('menu_hover'), array('slide_line', 'slide_box'))) {
			wp_enqueue_script( 'slidemenu-script', insurance_ancora_get_file_url('js/jquery.slidemenu.js'), array('jquery'), null, true );
		}

		if ( is_single() && insurance_ancora_get_custom_option('show_reviews')=='yes' ) {
			wp_enqueue_script( 'insurance-ancora-core-reviews-script', insurance_ancora_get_file_url('js/core.reviews.js'), array('jquery'), null, true );
		}

		wp_enqueue_script( 'insurance-ancora-core-utils-script',	insurance_ancora_get_file_url('js/core.utils.js'), array('jquery'), null, true );
		wp_enqueue_script( 'insurance-ancora-core-init-script',	insurance_ancora_get_file_url('js/core.init.js'), array('jquery'), null, true );
		wp_enqueue_script( 'insurance-ancora-theme-init-script',	insurance_ancora_get_file_url('js/theme.init.js'), array('jquery'), null, true );

		// Media elements library	
		if (insurance_ancora_get_theme_option('use_mediaelement')=='yes') {
			wp_enqueue_style ( 'mediaelement' );
			wp_enqueue_style ( 'wp-mediaelement' );
			wp_enqueue_script( 'mediaelement' );
			wp_enqueue_script( 'wp-mediaelement' );
		}
		
		// Video background
		if (insurance_ancora_get_custom_option('show_video_bg') == 'yes' && insurance_ancora_get_custom_option('video_bg_youtube_code') != '') {
			wp_enqueue_script( 'video-bg-script', insurance_ancora_get_file_url('js/jquery.tubular.1.0.js'), array('jquery'), null, true );
		}


		// Social share buttons
		if (is_singular() && !insurance_ancora_storage_get('blog_streampage') && insurance_ancora_get_custom_option('show_share')!='hide') {
			wp_enqueue_script( 'insurance-ancora-social-share-script', insurance_ancora_get_file_url('js/social/social-share.js'), array('jquery'), null, true );
		}

		// Comments
		if ( is_singular() && !insurance_ancora_storage_get('blog_streampage') && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply', false, array(), null, true );
		}

		// Custom panel
		if (insurance_ancora_get_theme_option('show_theme_customizer') == 'yes') {
			if (file_exists(insurance_ancora_get_file_dir('core/core.customizer/front.customizer.css')))
				wp_enqueue_style( 'insurance-ancora-customizer-style',  insurance_ancora_get_file_url('core/core.customizer/front.customizer.css'), array(), null );
			if (file_exists(insurance_ancora_get_file_dir('core/core.customizer/front.customizer.js')))
				wp_enqueue_script( 'insurance-ancora-customizer-script', insurance_ancora_get_file_url('core/core.customizer/front.customizer.js'), array(), null, true );
		}
		
		//Debug utils
		if (insurance_ancora_get_theme_option('debug_mode')=='yes') {
			wp_enqueue_script( 'insurance-ancora-core-debug-script', insurance_ancora_get_file_url('js/core.debug.js'), array(), null, true );
		}

		// Theme scripts
		do_action('insurance_ancora_action_add_scripts');
	}
}

//  Enqueue Swiper Slider scripts and styles
if ( !function_exists( 'insurance_ancora_enqueue_slider' ) ) {
	function insurance_ancora_enqueue_slider($engine='all') {
		if ($engine=='all' || $engine=='swiper') {
			wp_enqueue_style( 'swiperslider-style', 			insurance_ancora_get_file_url('js/swiper/swiper.css'), array(), null );
			// jQuery version of Swiper conflict with Revolution Slider!!! Use DOM version
			wp_enqueue_script( 'swiperslider-script', 			insurance_ancora_get_file_url('js/swiper/swiper.js'), array(), null, true );
		}
	}
}

//  Enqueue Photostack gallery
if ( !function_exists( 'insurance_ancora_enqueue_polaroid' ) ) {
	function insurance_ancora_enqueue_polaroid() {
		wp_enqueue_style( 'polaroid-style', 	insurance_ancora_get_file_url('js/photostack/component.css'), array(), null );
		wp_enqueue_script( 'classie-script',		insurance_ancora_get_file_url('js/photostack/classie.js'), array(), null, true );
		wp_enqueue_script( 'polaroid-script',	insurance_ancora_get_file_url('js/photostack/photostack.js'), array(), null, true );
	}
}

//  Enqueue Messages scripts and styles
if ( !function_exists( 'insurance_ancora_enqueue_messages' ) ) {
	function insurance_ancora_enqueue_messages() {
		wp_enqueue_style( 'insurance-ancora-messages-style',		insurance_ancora_get_file_url('js/core.messages/core.messages.css'), array(), null );
		wp_enqueue_script( 'insurance-ancora-messages-script',	insurance_ancora_get_file_url('js/core.messages/core.messages.js'),  array('jquery'), null, true );
	}
}

//  Enqueue Portfolio hover scripts and styles
if ( !function_exists( 'insurance_ancora_enqueue_portfolio' ) ) {
	function insurance_ancora_enqueue_portfolio($hover='') {
		wp_enqueue_style( 'insurance-ancora-portfolio-style',  insurance_ancora_get_file_url('css/core.portfolio.css'), array(), null );
		if (insurance_ancora_strpos($hover, 'effect_dir')!==false)
			wp_enqueue_script( 'hoverdir', insurance_ancora_get_file_url('js/hover/jquery.hoverdir.js'), array(), null, true );
	}
}

//  Enqueue Charts and Diagrams scripts and styles
if ( !function_exists( 'insurance_ancora_enqueue_diagram' ) ) {
	function insurance_ancora_enqueue_diagram($type='all') {
		if ($type=='all' || $type=='pie') wp_enqueue_script( 'diagram-chart-script',	insurance_ancora_get_file_url('js/diagram/chart.min.js'), array(), null, true );
		if ($type=='all' || $type=='arc') wp_enqueue_script( 'diagram-raphael-script',	insurance_ancora_get_file_url('js/diagram/diagram.raphael.min.js'), array(), 'no-compose', true );
	}
}

// Enqueue Theme Popup scripts and styles
// Link must have attribute: data-rel="popup" or data-rel="popup[gallery]"
if ( !function_exists( 'insurance_ancora_enqueue_popup' ) ) {
	function insurance_ancora_enqueue_popup($engine='') {
		if ($engine=='pretty' || (empty($engine) && insurance_ancora_get_theme_option('popup_engine')=='pretty')) {
			wp_enqueue_style( 'prettyphoto-style',	insurance_ancora_get_file_url('js/prettyphoto/css/prettyPhoto.css'), array(), null );
			wp_enqueue_script( 'prettyphoto-script',	insurance_ancora_get_file_url('js/prettyphoto/jquery.prettyPhoto.min.js'), array('jquery'), 'no-compose', true );
		} else if ($engine=='magnific' || (empty($engine) && insurance_ancora_get_theme_option('popup_engine')=='magnific')) {
			wp_enqueue_style( 'magnific-style',	insurance_ancora_get_file_url('js/magnific/magnific-popup.css'), array(), null );
			wp_enqueue_script( 'magnific-script',insurance_ancora_get_file_url('js/magnific/jquery.magnific-popup.min.js'), array('jquery'), '', true );
		} else if ($engine=='internal' || (empty($engine) && insurance_ancora_get_theme_option('popup_engine')=='internal')) {
			insurance_ancora_enqueue_messages();
		}
	}
}

//  Add inline scripts in the footer hook
if ( !function_exists( 'insurance_ancora_core_frontend_scripts_inline' ) ) {
    
    function insurance_ancora_core_frontend_scripts_inline() {
        $vars = insurance_ancora_storage_get('js_vars');
        if (empty($vars) || !is_array($vars)) $vars = array();
        wp_localize_script( 'insurance-ancora-core-init-script', 'INSURANCE_ANCORA_STORAGE', apply_filters('insurance_ancora_action_add_scripts_inline', $vars));
        $code = insurance_ancora_storage_get('js_code');
        if (!empty($js_code)) {
            $st = '<';
            $ct = '/';
            $et = '>';
            insurance_ancora_show_layout($code, "{$st}script{$et}jQuery(document).ready(function(){", "});{$st}{$ct}script{$et}");
        }
    }
}

//  Localize scripts in the footer hook
if ( !function_exists( 'insurance_ancora_core_frontend_add_js_vars' ) ) {
	function insurance_ancora_core_frontend_add_js_vars() {
		$vars = apply_filters( 'insurance_ancora_filter_localize_script', insurance_ancora_storage_empty('js_vars') ? array() : insurance_ancora_storage_get('js_vars'));
		if (!empty($vars)) wp_localize_script( 'insurance-ancora-core-init-script', 'INSURANCE_ANCORA_STORAGE', $vars);
		if (!insurance_ancora_storage_empty('js_code')) {
			$holder = 'script';
			?><<?php insurance_ancora_show_layout($holder); ?>>
				jQuery(document).ready(function() {
					<?php insurance_ancora_show_layout(insurance_ancora_minify_js(insurance_ancora_storage_get('js_code'))); ?>
				});
			</<?php insurance_ancora_show_layout($holder); ?>><?php
		}
	}
}


//  Add property="stylesheet" into all tags <link> in the footer
if (!function_exists('insurance_ancora_core_add_property_to_link')) {
	function insurance_ancora_core_add_property_to_link($link, $handle='', $href='') {
		return str_replace('<link ', '<link property="stylesheet" ', $link);
	}
}

//  Add inline scripts in the footer
if (!function_exists('insurance_ancora_core_add_scripts_inline')) {
    function insurance_ancora_core_add_scripts_inline($vars = array()) {

        $msg = insurance_ancora_get_system_message(true);
        if (!empty($msg['message'])) insurance_ancora_enqueue_messages();

        // AJAX posts counter
        $vars['use_ajax_views_counter'] = is_singular() && insurance_ancora_get_theme_option('use_ajax_views_counter')=='yes';
        if (is_singular() && insurance_ancora_get_theme_option('use_ajax_views_counter')=='yes') {
            $vars['post_id'] = (int) get_the_ID();
            $vars['views'] = (int) insurance_ancora_get_post_views(get_the_ID()) + 1;
        }

        // AJAX parameters
        $vars['ajax_url'] = esc_url(admin_url('admin-ajax.php'));
        $vars['ajax_nonce'] = esc_attr(wp_create_nonce(admin_url('admin-ajax.php')));

        // Site base url
        $vars['site_url'] = esc_url(get_site_url());

        // VC frontend edit mode
        $vars['vc_edit_mode'] = function_exists('insurance_ancora_vc_is_frontend') && insurance_ancora_vc_is_frontend();

        // Theme base font
        $vars['theme_font'] = insurance_ancora_get_custom_font_settings('p', 'font-family');

        // Theme skin
        $vars['theme_skin'] = esc_attr(insurance_ancora_get_custom_option('theme_skin'));
        $vars['theme_skin_color'] = insurance_ancora_get_scheme_color('text_dark');
        $vars['theme_skin_bg_color'] = insurance_ancora_get_scheme_color('bg_color');

        // Slider height
        $vars['slider_height'] = max(100, insurance_ancora_get_custom_option('slider_height'));

        // System message
        $vars['system_message']    = $msg;

        // User logged in
        $vars['user_logged_in']    = is_user_logged_in();

        // Show table of content for the current page
        $vars['toc_menu'] = insurance_ancora_get_custom_option('menu_toc');
        $vars['toc_menu_home'] = insurance_ancora_get_custom_option('menu_toc')!='hide' && insurance_ancora_get_custom_option('menu_toc_home')=='yes';
        $vars['toc_menu_top'] = insurance_ancora_get_custom_option('menu_toc')!='hide' && insurance_ancora_get_custom_option('menu_toc_top')=='yes';

        // Fix main menu
        $vars['menu_fixed'] = insurance_ancora_get_theme_option('menu_attachment')=='fixed';

        // Use responsive version for main menu
        $vars['menu_mobile'] = insurance_ancora_get_theme_option('responsive_layouts') == 'yes' ? max(0, (int) insurance_ancora_get_theme_option('menu_mobile')) : 0;
        $vars['menu_slider'] = insurance_ancora_get_theme_option('menu_slider')=='yes';

        // Menu cache is used
        $vars['menu_cache']    = insurance_ancora_get_theme_option('use_menu_cache')=='yes';

        // Right panel demo timer
        $vars['demo_time'] = insurance_ancora_get_theme_option('show_theme_customizer')=='yes' ? max(0, (int) insurance_ancora_get_theme_option('customizer_demo')) : 0;

        // Video and Audio tag wrapper
        $vars['media_elements_enabled'] = insurance_ancora_get_theme_option('use_mediaelement')=='yes';

        // Use AJAX search
        $vars['ajax_search_enabled'] = insurance_ancora_get_theme_option('use_ajax_search')=='yes';
        $vars['ajax_search_min_length']    = min(3, insurance_ancora_get_theme_option('ajax_search_min_length'));
        $vars['ajax_search_delay'] = min(200, max(1000, insurance_ancora_get_theme_option('ajax_search_delay')));

        // Use CSS animation
        $vars['css_animation'] = insurance_ancora_get_theme_option('css_animation')=='yes';
        $vars['menu_animation_in'] = insurance_ancora_get_theme_option('menu_animation_in');
        $vars['menu_animation_out'] = insurance_ancora_get_theme_option('menu_animation_out');

        // Popup windows engine
        $vars['popup_engine'] = insurance_ancora_get_theme_option('popup_engine');

        // E-mail mask
        $vars['email_mask'] = '^([a-zA-Z0-9_\\-]+\\.)*[a-zA-Z0-9_\\-]+@[a-z0-9_\\-]+(\\.[a-z0-9_\\-]+)*\\.[a-z]{2,6}$';

        // Messages max length
        $vars['contacts_maxlength']    = intval(insurance_ancora_get_theme_option('message_maxlength_contacts'));
        $vars['comments_maxlength']    = intval(insurance_ancora_get_theme_option('message_maxlength_comments'));

        // Remember visitors settings
        $vars['remember_visitors_settings']    = insurance_ancora_get_theme_option('remember_visitors_settings')=='yes';

        // Internal vars - do not change it!
        // Flag for review mechanism
        $vars['admin_mode'] = false;
        // Max scale factor for the portfolio and other isotope elements before relayout
        $vars['isotope_resize_delta'] = 0.3;
        // jQuery object for the message box in the form
        $vars['error_message_box'] = null;
        // Waiting for the viewmore results
        $vars['viewmore_busy'] = false;
        $vars['video_resize_inited'] = false;
        $vars['top_panel_height'] = 0;

        return $vars;
    }
}

//  Localize script
if (!function_exists('insurance_ancora_core_localize_script')) {
	function insurance_ancora_core_localize_script($vars) {

		// AJAX parameters
		$vars['ajax_url'] = esc_url(admin_url('admin-ajax.php'));
		$vars['ajax_nonce'] = wp_create_nonce(admin_url('admin-ajax.php'));

		// Site base url
		$vars['site_url'] = esc_url(get_site_url());

		// Site protocol
		$vars['site_protocol'] = insurance_ancora_get_protocol();
			
		// VC frontend edit mode
		$vars['vc_edit_mode'] = function_exists('insurance_ancora_vc_is_frontend') && insurance_ancora_vc_is_frontend();
			
		// Theme base font
		$vars['theme_font'] = insurance_ancora_get_custom_font_settings('p', 'font-family');
			
		// Theme colors
		$vars['theme_color'] = insurance_ancora_get_scheme_color('text_dark');
		$vars['theme_bg_color'] = insurance_ancora_get_scheme_color('bg_color');
		$vars['accent1_color'] = insurance_ancora_get_scheme_color('text_link');
		$vars['accent1_hover'] = insurance_ancora_get_scheme_color('text_hover');
			
		// Slider height
		$vars['slider_height'] = max(100, insurance_ancora_get_custom_option('slider_height'));
			
		// User logged in
		$vars['user_logged_in'] = is_user_logged_in();
			
		// Show table of content for the current page
		$vars['toc_menu'] = insurance_ancora_get_custom_option('menu_toc');
		$vars['toc_menu_home'] = insurance_ancora_get_custom_option('menu_toc')!='hide' && insurance_ancora_get_custom_option('menu_toc_home')=='yes';
		$vars['toc_menu_top'] = insurance_ancora_get_custom_option('menu_toc')!='hide' && insurance_ancora_get_custom_option('menu_toc_top')=='yes';

		// Fix main menu
		$vars['menu_fixed'] = insurance_ancora_get_theme_option('menu_attachment')=='fixed';
			
		// Use responsive version for main menu
		$vars['menu_mobile'] = insurance_ancora_get_theme_option('responsive_layouts') == 'yes' ? max(0, (int) insurance_ancora_get_theme_option('menu_mobile')) : 0;
		$vars['menu_hover'] = insurance_ancora_get_theme_option('menu_hover');
			
		// Menu cache is used
		$vars['menu_cache'] = insurance_ancora_get_theme_option('use_menu_cache')=='yes';

		// Theme's buttons hover
		$vars['button_hover'] = insurance_ancora_get_theme_option('button_hover');

		// Theme's form fields style
		$vars['input_hover'] = insurance_ancora_get_theme_option('input_hover');

		// Right panel demo timer
		$vars['demo_time'] = insurance_ancora_get_theme_option('show_theme_customizer')=='yes' ? max(0, (int) insurance_ancora_get_theme_option('customizer_demo')) : 0;

		// Video and Audio tag wrapper
		$vars['media_elements_enabled'] = insurance_ancora_get_theme_option('use_mediaelement')=='yes';
			
		// Use AJAX search
		$vars['ajax_search_enabled'] = insurance_ancora_get_theme_option('use_ajax_search')=='yes';
		$vars['ajax_search_min_length'] = min(3, insurance_ancora_get_theme_option('ajax_search_min_length'));
		$vars['ajax_search_delay'] = min(200, max(1000, insurance_ancora_get_theme_option('ajax_search_delay')));

		// Use CSS animation
		$vars['css_animation'] = insurance_ancora_get_theme_option('css_animation')=='yes';
		$vars['menu_animation_in'] = insurance_ancora_get_theme_option('menu_animation_in');
		$vars['menu_animation_out'] = insurance_ancora_get_theme_option('menu_animation_out');

		// Popup windows engine
		$vars['popup_engine'] = insurance_ancora_get_theme_option('popup_engine');

		// E-mail mask
		$vars['email_mask'] = '^([a-zA-Z0-9_\\-]+\\.)*[a-zA-Z0-9_\\-]+@[a-z0-9_\\-]+(\\.[a-z0-9_\\-]+)*\\.[a-z]{2,6}$';
			
		// Messages max length
		$vars['contacts_maxlength'] = insurance_ancora_get_theme_option('message_maxlength_contacts');
		$vars['comments_maxlength'] = insurance_ancora_get_theme_option('message_maxlength_comments');

		// Remember visitors settings
		$vars['remember_visitors_settings'] = insurance_ancora_get_theme_option('remember_visitors_settings')=='yes';

		// Internal vars - do not change it!
		// Flag for review mechanism
		$vars['admin_mode'] = false;
		// Max scale factor for the portfolio and other isotope elements before relayout
		$vars['isotope_resize_delta'] = 0.3;
		// jQuery object for the message box in the form
		$vars['error_message_box'] = null;
		// Waiting for the viewmore results
		$vars['viewmore_busy'] = false;
		$vars['video_resize_inited'] = false;
		$vars['top_panel_height'] = 0;

		return $vars;
	}
}

// Show content with the html layout (if not empty)
if ( !function_exists('insurance_ancora_show_layout') ) {
	function insurance_ancora_show_layout($str, $before='', $after='') {
		if ($str != '') {
			printf("%s%s%s", $before, $str, $after);
		}
	}
}

// Add class "widget_number_#' for each widget
if ( !function_exists( 'insurance_ancora_add_widget_number' ) ) {
	function insurance_ancora_add_widget_number($prm) {
		if (is_admin()) return $prm;
		static $num=0, $last_sidebar='', $last_sidebar_id='', $last_sidebar_columns=0, $last_sidebar_count=0, $sidebars_widgets=array();
		$cur_sidebar = insurance_ancora_storage_get('current_sidebar');
		if (empty($cur_sidebar)) $cur_sidebar = 'undefined';
		if (count($sidebars_widgets) == 0)
			$sidebars_widgets = wp_get_sidebars_widgets();
		if ($last_sidebar != $cur_sidebar) {
			$num = 0;
			$last_sidebar = $cur_sidebar;
			$last_sidebar_id = $prm[0]['id'];
			$last_sidebar_columns = max(1, (int) insurance_ancora_get_custom_option('sidebar_'.($cur_sidebar).'_columns'));
			$last_sidebar_count = count($sidebars_widgets[$last_sidebar_id]);
		}
		$num++;
		$prm[0]['before_widget'] = str_replace(' class="', ' class="widget_number_'.esc_attr($num).($last_sidebar_columns > 1 ? ' column-1_'.esc_attr($last_sidebar_columns) : '').' ', $prm[0]['before_widget']);
		return $prm;
	}
}


// Show <title> tag under old WP (version < 4.1)
if ( !function_exists( 'insurance_ancora_wp_title_show' ) ) {
	function insurance_ancora_wp_title_show() {
		?><title><?php wp_title( '|', true, 'right' ); ?></title><?php
	}
}

// Filters wp_title to print a neat <title> tag based on what is being viewed.
if ( !function_exists( 'insurance_ancora_wp_title_modify' ) ) {
	function insurance_ancora_wp_title_modify( $title, $sep ) {
		global $page, $paged;
		if ( is_feed() ) return $title;
		// Add the blog name
		$title .= get_bloginfo( 'name' );
		// Add the blog description for the home/front page.
		if ( is_home() || is_front_page() ) {
			$site_description = get_bloginfo( 'description', 'display' );
			if ( $site_description )
				$title .= " $sep $site_description";
		}
		// Add a page number if necessary:
		if ( $paged >= 2 || $page >= 2 )
			$title .= " $sep " . sprintf( esc_html__( 'Page %s', 'insurance-ancora' ), max( $paged, $page ) );
		return $title;
	}
}

// Add main menu classes
if ( !function_exists( 'insurance_ancora_add_mainmenu_classes' ) ) {
	function insurance_ancora_add_mainmenu_classes($items, $args) {
		if (is_admin()) return $items;
		if ($args->menu_id == 'mainmenu' && insurance_ancora_get_theme_option('menu_colored')=='yes' && is_array($items) && count($items) > 0) {
			foreach($items as $k=>$item) {
				if ($item->menu_item_parent==0) {
					if ($item->type=='taxonomy' && $item->object=='category') {
						$cur_tint = insurance_ancora_taxonomy_get_inherited_property('category', $item->object_id, 'bg_tint');
						if (!empty($cur_tint) && !insurance_ancora_is_inherit_option($cur_tint))
							$items[$k]->classes[] = 'bg_tint_'.esc_attr($cur_tint);
					}
				}
			}
		}
		return $items;
	}
}


// Save post data from frontend editor
if ( !function_exists( 'insurance_ancora_callback_frontend_editor_save' ) ) {
	function insurance_ancora_callback_frontend_editor_save() {

		if ( !wp_verify_nonce( insurance_ancora_get_value_gp('nonce'), admin_url('admin-ajax.php') ) )
			wp_die();
		$response = array('error'=>'');

		parse_str($_REQUEST['data'], $output);
		$post_id = $output['frontend_editor_post_id'];

		if ( insurance_ancora_get_theme_option("allow_editor")=='yes' && (current_user_can('edit_posts', $post_id) || current_user_can('edit_pages', $post_id)) ) {
			if ($post_id > 0) {
				$title   = stripslashes($output['frontend_editor_post_title']);
				$content = stripslashes($output['frontend_editor_post_content']);
				$excerpt = stripslashes($output['frontend_editor_post_excerpt']);
				$rez = wp_update_post(array(
					'ID'           => $post_id,
					'post_content' => $content,
					'post_excerpt' => $excerpt,
					'post_title'   => $title
				));
				if ($rez == 0) 
					$response['error'] = esc_html__('Post update error!', 'insurance-ancora');
			} else {
				$response['error'] = esc_html__('Post update error!', 'insurance-ancora');
			}
		} else
			$response['error'] = esc_html__('Post update denied!', 'insurance-ancora');
		
		echo json_encode($response);
		wp_die();
	}
}

// Delete post from frontend editor
if ( !function_exists( 'insurance_ancora_callback_frontend_editor_delete' ) ) {
	function insurance_ancora_callback_frontend_editor_delete() {

		if ( !wp_verify_nonce( insurance_ancora_get_value_gp('nonce'), admin_url('admin-ajax.php') ) )
			wp_die();

		$response = array('error'=>'');
		
		$post_id = insurance_ancora_get_value_gpc('post_id');

		if ( insurance_ancora_get_theme_option("allow_editor")=='yes' && (current_user_can('delete_posts', $post_id) || current_user_can('delete_pages', $post_id)) ) {
			if ($post_id > 0) {
				$rez = wp_delete_post($post_id);
				if ($rez === false) 
					$response['error'] = esc_html__('Post delete error!', 'insurance-ancora');
			} else {
				$response['error'] = esc_html__('Post delete error!', 'insurance-ancora');
			}
		} else
			$response['error'] = esc_html__('Post delete denied!', 'insurance-ancora');

		echo json_encode($response);
		wp_die();
	}
}


// Prepare logo text
if ( !function_exists( 'insurance_ancora_prepare_logo_text' ) ) {
	function insurance_ancora_prepare_logo_text($text) {
		$text = str_replace(array('[', ']'), array('<span class="theme_accent">', '</span>'), $text);
		$text = str_replace(array('{', '}'), array('<strong>', '</strong>'), $text);
		return $text;
	}
}
?>