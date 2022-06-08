<?php
/**
 * Theme custom styles
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if (!function_exists('insurance_ancora_action_theme_styles_theme_setup')) {
	add_action( 'insurance_ancora_action_before_init_theme', 'insurance_ancora_action_theme_styles_theme_setup', 1 );
	function insurance_ancora_action_theme_styles_theme_setup() {
	
		// Add theme fonts in the used fonts list
		add_filter('insurance_ancora_filter_used_fonts',			'insurance_ancora_filter_theme_styles_used_fonts');
		// Add theme fonts (from Google fonts) in the main fonts list (if not present).
		add_filter('insurance_ancora_filter_list_fonts',			'insurance_ancora_filter_theme_styles_list_fonts');

		// Add theme stylesheets
		add_action('insurance_ancora_action_add_styles',			'insurance_ancora_action_theme_styles_add_styles');
		// Add theme inline styles
		add_filter('insurance_ancora_filter_add_styles_inline',		'insurance_ancora_filter_theme_styles_add_styles_inline');

		// Add theme scripts
		add_action('insurance_ancora_action_add_scripts',			'insurance_ancora_action_theme_styles_add_scripts');
		// Add theme scripts inline
		add_filter('insurance_ancora_filter_localize_script',		'insurance_ancora_filter_theme_styles_localize_script');

		// Add theme less files into list for compilation
		add_filter('insurance_ancora_filter_compile_less',			'insurance_ancora_filter_theme_styles_compile_less');


		/* Color schemes
		
		// Block's border and background
		bd_color		- border for the entire block
		bg_color		- background color for the entire block
		// Next settings are deprecated
		//bg_image, bg_image_position, bg_image_repeat, bg_image_attachment  - first background image for the entire block
		//bg_image2,bg_image2_position,bg_image2_repeat,bg_image2_attachment - second background image for the entire block
		
		// Additional accented colors (if need)
		accent2			- theme accented color 2
		accent2_hover	- theme accented color 2 (hover state)		
		accent3			- theme accented color 3
		accent3_hover	- theme accented color 3 (hover state)		
		
		// Headers, text and links
		text			- main content
		text_light		- post info
		text_dark		- headers
		text_link		- links
		text_hover		- hover links
		
		// Inverse blocks
		inverse_text	- text on accented background
		inverse_light	- post info on accented background
		inverse_dark	- headers on accented background
		inverse_link	- links on accented background
		inverse_hover	- hovered links on accented background
		
		// Input colors - form fields
		input_text		- inactive text
		input_light		- placeholder text
		input_dark		- focused text
		input_bd_color	- inactive border
		input_bd_hover	- focused borde
		input_bg_color	- inactive background
		input_bg_hover	- focused background
		
		// Alternative colors - highlight blocks, form fields, etc.
		alter_text		- text on alternative background
		alter_light		- post info on alternative background
		alter_dark		- headers on alternative background
		alter_link		- links on alternative background
		alter_hover		- hovered links on alternative background
		alter_bd_color	- alternative border
		alter_bd_hover	- alternative border for hovered state or active field
		alter_bg_color	- alternative background
		alter_bg_hover	- alternative background for hovered state or active field 
		// Next settings are deprecated
		//alter_bg_image, alter_bg_image_position, alter_bg_image_repeat, alter_bg_image_attachment - background image for the alternative block
		
		*/


		// Add color schemes
		insurance_ancora_add_color_scheme('original', array(

			'title'					=> esc_html__('Original', 'insurance-ancora'),
			
			// Whole block border and background
			'bd_color'				=> '#e4e7e8',
			'bg_color'				=> '#ffffff', //+
			
			// Headers, text and links colors
			'text'					=> '#7c7c7e', //+
			'text_light'			=> '#acb4b6',
			'text_dark'				=> '#393d45', //+
			'text_link'				=> '#5e93f6', //+
			'text_hover'			=> '#2e4a93', //+

			// Inverse colors
			'inverse_text'			=> '#ffffff',
			'inverse_light'			=> '#ffffff',
			'inverse_dark'			=> '#ffffff',
			'inverse_link'			=> '#ffffff',
			'inverse_hover'			=> '#ffffff',
		
			// Input fields
			'input_text'			=> '#8a8a8a',
			'input_light'			=> '#acb4b6',
			'input_dark'			=> '#232a34',
			'input_bd_color'		=> '#dddddd',
			'input_bd_hover'		=> '#bbbbbb',
			'input_bg_color'		=> '#f7f7f7',
			'input_bg_hover'		=> '#f0f0f0',
		
			// Alternative blocks (submenu items, etc.)
			'alter_text'			=> '#8a8a8a',
			'alter_light'			=> '#acb4b6',
			'alter_dark'			=> '#232a34',
			'alter_link'			=> '#e35750', //+
			'alter_hover'			=> '#5583d7', //+
			'alter_bd_color'		=> '#d3d4d5', //+
			'alter_bd_hover'		=> '#bbbbbb',
			'alter_bg_color'		=> '#f5f6f7', //+
			'alter_bg_hover'		=> '#f0f0f0',
			)
		);

		// Add color schemes
		insurance_ancora_add_color_scheme('color_blocks', array(

			'title'					=> esc_html__('Color blocks', 'insurance-ancora'),
			
			// Whole block border and background
			'bd_color'				=> '#1DB3B6',
			'bg_color'				=> '#20C7CA',

			// Headers, text and links colors
			'text'					=> '#F0F0F0',
			'text_light'			=> '#E0E0E0',
			'text_dark'				=> '#FFFFFF',
			'text_link'				=> '#1D9B9D',
			'text_hover'			=> '#23E8EB',

			// Inverse colors
			'inverse_text'			=> '#F0F0F0',
			'inverse_light'			=> '#E0F0F0',
			'inverse_dark'			=> '#FFFFFF',
			'inverse_link'			=> '#FCFFA3',
			'inverse_hover'			=> '#FFFF00',
		
			// Input fields
			'input_text'			=> '#DADADA',
			'input_light'			=> '#B4B8B8',
			'input_dark'			=> '#FFFFFF',
			'input_bd_color'		=> '#06564E',
			'input_bd_hover'		=> '#017E72',
			'input_bg_color'		=> '#0F7468',
			'input_bg_hover'		=> '#108678',
		
			// Alternative blocks (submenu items, etc.)
			'alter_text'			=> '#DADADA',
			'alter_light'			=> '#B4B8B8',
			'alter_dark'			=> '#FFFFFF',
			'alter_link'			=> '#CAB720',
			'alter_hover'			=> '#998B18',
			'alter_bd_color'		=> '#06564E',
			'alter_bd_hover'		=> '#017E72',
			'alter_bg_color'		=> '#f5f6f7',
			'alter_bg_hover'		=> '#108678',
			)
		);

		/* Font slugs:
		h1 ... h6	- headers
		p			- plain text
		link		- links
		info		- info blocks (Posted 15 May, 2015 by John Doe)
		menu		- main menu
		submenu		- dropdown menus
		logo		- logo text
		button		- button's caption
		input		- input fields
		*/

		// Add Custom fonts
		insurance_ancora_add_custom_font('h1', array(
			'title'			=> esc_html__('Heading 1', 'insurance-ancora'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '3.75em',
			'font-weight'	=> '300',
			'font-style'	=> '',
			'line-height'	=> '1.3em',
			'margin-top'	=> '0.5em',
			'margin-bottom'	=> '0.4em'
			)
		);
		insurance_ancora_add_custom_font('h2', array(
			'title'			=> esc_html__('Heading 2', 'insurance-ancora'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '3.125em',
			'font-weight'	=> '300',
			'font-style'	=> '',
			'line-height'	=> '1.3em',
			'margin-top'	=> '0.6667em',
			'margin-bottom'	=> '0.4em'
			)
		);
		insurance_ancora_add_custom_font('h3', array(
			'title'			=> esc_html__('Heading 3', 'insurance-ancora'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '2.5em',
			'font-weight'	=> '300',
			'font-style'	=> '',
			'line-height'	=> '1.3em',
			'margin-top'	=> '0.6667em',
			'margin-bottom'	=> '0.5em'
			)
		);
		insurance_ancora_add_custom_font('h4', array(
			'title'			=> esc_html__('Heading 4', 'insurance-ancora'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '1.438em',
			'font-weight'	=> '500',
			'font-style'	=> '',
			'line-height'	=> '1.3em',
			'margin-top'	=> '1.2em',
			'margin-bottom'	=> '1em'
			)
		);
		insurance_ancora_add_custom_font('h5', array(
			'title'			=> esc_html__('Heading 5', 'insurance-ancora'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '1.25em',
			'font-weight'	=> '500',
			'font-style'	=> '',
			'line-height'	=> '1.3em',
			'margin-top'	=> '1.2em',
			'margin-bottom'	=> '1.4em'
			)
		);
		insurance_ancora_add_custom_font('h6', array(
			'title'			=> esc_html__('Heading 6', 'insurance-ancora'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '1em',
			'font-weight'	=> '600',
			'font-style'	=> '',
			'line-height'	=> '1.3em',
			'margin-top'	=> '1.25em',
			'margin-bottom'	=> '0.65em'
			)
		);
		insurance_ancora_add_custom_font('p', array(
			'title'			=> esc_html__('Text', 'insurance-ancora'),
			'description'	=> '',
			'font-family'	=> 'Hind',
			'font-size' 	=> '16px',
			'font-weight'	=> '400',
			'font-style'	=> '',
			'line-height'	=> '1.5em',
			'margin-top'	=> '',
			'margin-bottom'	=> '1em'
			)
		);
		insurance_ancora_add_custom_font('link', array(
			'title'			=> esc_html__('Links', 'insurance-ancora'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '',
			'font-weight'	=> '',
			'font-style'	=> ''
			)
		);
		insurance_ancora_add_custom_font('info', array(
			'title'			=> esc_html__('Post info', 'insurance-ancora'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '0.813em',
			'font-weight'	=> '600',
			'font-style'	=> '',
			'line-height'	=> 'em',
			'margin-top'	=> '',
			'margin-bottom'	=> '1.5em'
			)
		);
		insurance_ancora_add_custom_font('menu', array(
			'title'			=> esc_html__('Main menu items', 'insurance-ancora'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '1em',
			'font-weight'	=> '600',
			'font-style'	=> '',
			'line-height'	=> '1em',
			'margin-top'	=> '1.5em',
			'margin-bottom'	=> '1.55em'
			)
		);
		insurance_ancora_add_custom_font('submenu', array(
			'title'			=> esc_html__('Dropdown menu items', 'insurance-ancora'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '',
			'font-weight'	=> '',
			'font-style'	=> '',
			'line-height'	=> '1.2857em',
			'margin-top'	=> '',
			'margin-bottom'	=> ''
			)
		);
		insurance_ancora_add_custom_font('logo', array(
			'title'			=> esc_html__('Logo', 'insurance-ancora'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '0.875em',
			'font-weight'	=> '400',
			'font-style'	=> '',
			'line-height'	=> '1em',
			'margin-top'	=> '1.95em',
			'margin-bottom'	=> '0.95em'
			)
		);
		insurance_ancora_add_custom_font('button', array(
			'title'			=> esc_html__('Buttons', 'insurance-ancora'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '',
			'font-weight'	=> '600',
			'font-style'	=> '',
			'line-height'	=> '1em'
			)
		);
		insurance_ancora_add_custom_font('input', array(
			'title'			=> esc_html__('Input fields', 'insurance-ancora'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '',
			'font-weight'	=> '',
			'font-style'	=> '',
			'line-height'	=> '1.2857em'
			)
		);

	}
}





//------------------------------------------------------------------------------
// Theme fonts
//------------------------------------------------------------------------------

// Add theme fonts in the used fonts list
if (!function_exists('insurance_ancora_filter_theme_styles_used_fonts')) {
	function insurance_ancora_filter_theme_styles_used_fonts($theme_fonts) {
		$theme_fonts['Hind'] = 1;
		return $theme_fonts;
	}
}

// Add theme fonts (from Google fonts) in the main fonts list (if not present).
// To use custom font-face you not need add it into list in this function
// How to install custom @font-face fonts into the theme?
// All @font-face fonts are located in "theme_name/css/font-face/" folder in the separate subfolders for the each font. Subfolder name is a font-family name!
// Place full set of the font files (for each font style and weight) and css-file named stylesheet.css in the each subfolder.
// Create your @font-face kit by using Fontsquirrel @font-face Generator (http://www.fontsquirrel.com/fontface/generator)
// and then extract the font kit (with folder in the kit) into the "theme_name/css/font-face" folder to install
if (!function_exists('insurance_ancora_filter_theme_styles_list_fonts')) {
	function insurance_ancora_filter_theme_styles_list_fonts($list) {
         if (!isset($list['Hind'])) {
        		$list['Hind'] = array(
        			'family' => 'sans-serif',																						// (required) font family
        			'link'   => 'Hind:400,300,500,600,700',                                                                     	// (optional) if you use Google font repository
        			);
         }
		return $list;
	}
}



//------------------------------------------------------------------------------
// Theme stylesheets
//------------------------------------------------------------------------------

// Add theme.less into list files for compilation
if (!function_exists('insurance_ancora_filter_theme_styles_compile_less')) {
	function insurance_ancora_filter_theme_styles_compile_less($files) {
		if (file_exists(insurance_ancora_get_file_dir('css/theme.less'))) {
		 	$files[] = insurance_ancora_get_file_dir('css/theme.less');
		}
		return $files;	
	}
}

// Add theme stylesheets
if (!function_exists('insurance_ancora_action_theme_styles_add_styles')) {
	function insurance_ancora_action_theme_styles_add_styles() {
		// Add stylesheet files only if LESS supported
		if ( insurance_ancora_get_theme_setting('less_compiler') != 'no' ) {
			wp_enqueue_style( 'insurance-ancora-theme-style', insurance_ancora_get_file_url('css/theme.css'), array(), null );
			wp_add_inline_style( 'insurance-ancora-theme-style', insurance_ancora_get_inline_css() );
		}
	}
}

// Add theme inline styles
if (!function_exists('insurance_ancora_filter_theme_styles_add_styles_inline')) {
	function insurance_ancora_filter_theme_styles_add_styles_inline($custom_style) {
		// Todo: add theme specific styles in the $custom_style to override

		// Submenu width
		$menu_width = insurance_ancora_get_theme_option('menu_width');
		if (!empty($menu_width)) {
			$custom_style .= "
				/* Submenu width */
				.menu_side_nav > li ul,
				.menu_main_nav > li ul {
					width: ".intval($menu_width)."px;
				}
				.menu_side_nav > li > ul ul,
				.menu_main_nav > li > ul ul {
					left:".intval($menu_width+4)."px;
				}
				.menu_side_nav > li > ul ul.submenu_left,
				.menu_main_nav > li > ul ul.submenu_left {
					left:-".intval($menu_width+1)."px;
				}
			";
		}
	
		// Logo height
		$logo_height = insurance_ancora_get_custom_option('logo_height');
		if (!empty($logo_height)) {
			$custom_style .= "
				/* Logo header height */
				.sidebar_outer_logo .logo_main,
				.top_panel_wrap .logo_main,
				.top_panel_wrap .logo_fixed {
					height:".intval($logo_height)."px;
				}
			";
		}
	
		// Logo top offset
		$logo_offset = insurance_ancora_get_custom_option('logo_offset');
		if (!empty($logo_offset)) {
			$custom_style .= "
				/* Logo header top offset */
				.top_panel_wrap .logo {
					margin-top:".intval($logo_offset)."px;
				}
			";
		}

		// Logo footer height
		$logo_height = insurance_ancora_get_theme_option('logo_footer_height');
		if (!empty($logo_height)) {
			$custom_style .= "
				/* Logo footer height */
				.contacts_wrap .logo img {
					height:".intval($logo_height)."px;
				}
			";
		}

		// Custom css from theme options
		$custom_style .= insurance_ancora_get_custom_option('custom_css');

		return $custom_style;	
	}
}


//------------------------------------------------------------------------------
// Theme scripts
//------------------------------------------------------------------------------

// Add theme scripts
if (!function_exists('insurance_ancora_action_theme_styles_add_scripts')) {
	function insurance_ancora_action_theme_styles_add_scripts() {
		if (insurance_ancora_get_theme_option('show_theme_customizer') == 'yes' && file_exists(insurance_ancora_get_file_dir('js/theme.customizer.js')))
			wp_enqueue_script( 'insurance-ancora-theme-styles-customizer-script', insurance_ancora_get_file_url('js/theme.customizer.js'), array(), null, true );
	}
}

// Add theme scripts inline
if (!function_exists('insurance_ancora_filter_theme_styles_localize_script')) {
	function insurance_ancora_filter_theme_styles_localize_script($vars) {
		if (empty($vars['theme_font']))
			$vars['theme_font'] = insurance_ancora_get_custom_font_settings('p', 'font-family');
		$vars['theme_color'] = insurance_ancora_get_scheme_color('text_dark');
		$vars['theme_bg_color'] = insurance_ancora_get_scheme_color('bg_color');
		return $vars;
	}
}
?>