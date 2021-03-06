<?php
/**
 * InsuranceAncora Framework: return lists
 *
 * @package insurance_ancora
 * @since insurance_ancora 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }



// Return styles list
if ( !function_exists( 'insurance_ancora_get_list_styles' ) ) {
	function insurance_ancora_get_list_styles($from=1, $to=2, $prepend_inherit=false) {
		$list = array();
		for ($i=$from; $i<=$to; $i++)
			$list[$i] = sprintf(esc_html__('Style %d', 'insurance-ancora'), $i);
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}


// Return list of the shortcodes margins
if ( !function_exists( 'insurance_ancora_get_list_margins' ) ) {
	function insurance_ancora_get_list_margins($prepend_inherit=false) {
		if (($list = insurance_ancora_storage_get('list_margins'))=='') {
			$list = array(
				'null'		=> esc_html__('0 (No margin)',	'insurance-ancora'),
				'tiny'		=> esc_html__('Tiny',		'insurance-ancora'),
				'small'		=> esc_html__('Small',		'insurance-ancora'),
				'medium'	=> esc_html__('Medium',		'insurance-ancora'),
				'large'		=> esc_html__('Large',		'insurance-ancora'),
				'huge'		=> esc_html__('Huge',		'insurance-ancora'),
				'tiny-'		=> esc_html__('Tiny (negative)',	'insurance-ancora'),
				'small-'	=> esc_html__('Small (negative)',	'insurance-ancora'),
				'medium-'	=> esc_html__('Medium (negative)',	'insurance-ancora'),
				'large-'	=> esc_html__('Large (negative)',	'insurance-ancora'),
				'huge-'		=> esc_html__('Huge (negative)',	'insurance-ancora')
				);
			$list = apply_filters('insurance_ancora_filter_list_margins', $list);
			if (insurance_ancora_get_theme_setting('use_list_cache')) insurance_ancora_storage_set('list_margins', $list);
		}
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}


// Return list of the line styles
if ( !function_exists( 'insurance_ancora_get_list_line_styles' ) ) {
	function insurance_ancora_get_list_line_styles($prepend_inherit=false) {
		if (($list = insurance_ancora_storage_get('list_line_styles'))=='') {
			$list = array(
				'solid'	=> esc_html__('Solid', 'insurance-ancora'),
				'dashed'=> esc_html__('Dashed', 'insurance-ancora'),
				'dotted'=> esc_html__('Dotted', 'insurance-ancora'),
				'double'=> esc_html__('Double', 'insurance-ancora'),
				'image'	=> esc_html__('Image', 'insurance-ancora')
				);
			$list = apply_filters('insurance_ancora_filter_list_line_styles', $list);
			if (insurance_ancora_get_theme_setting('use_list_cache')) insurance_ancora_storage_set('list_line_styles', $list);
		}
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}


// Return list of the animations
if ( !function_exists( 'insurance_ancora_get_list_animations' ) ) {
	function insurance_ancora_get_list_animations($prepend_inherit=false) {
		if (($list = insurance_ancora_storage_get('list_animations'))=='') {
			$list = array(
				'none'			=> esc_html__('- None -',	'insurance-ancora'),
				'bounce'		=> esc_html__('Bounce',		'insurance-ancora'),
				'elastic'		=> esc_html__('Elastic',	'insurance-ancora'),
				'flash'			=> esc_html__('Flash',		'insurance-ancora'),
				'flip'			=> esc_html__('Flip',		'insurance-ancora'),
				'pulse'			=> esc_html__('Pulse',		'insurance-ancora'),
				'rubberBand'	=> esc_html__('Rubber Band','insurance-ancora'),
				'shake'			=> esc_html__('Shake',		'insurance-ancora'),
				'swing'			=> esc_html__('Swing',		'insurance-ancora'),
				'tada'			=> esc_html__('Tada',		'insurance-ancora'),
				'wobble'		=> esc_html__('Wobble',		'insurance-ancora')
				);
			$list = apply_filters('insurance_ancora_filter_list_animations', $list);
			if (insurance_ancora_get_theme_setting('use_list_cache')) insurance_ancora_storage_set('list_animations', $list);
		}
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}


// Return list of the enter animations
if ( !function_exists( 'insurance_ancora_get_list_animations_in' ) ) {
	function insurance_ancora_get_list_animations_in($prepend_inherit=false) {
		if (($list = insurance_ancora_storage_get('list_animations_in'))=='') {
			$list = array(
				'none'				=> esc_html__('- None -',			'insurance-ancora'),
				'bounceIn'			=> esc_html__('Bounce In',			'insurance-ancora'),
				'bounceInUp'		=> esc_html__('Bounce In Up',		'insurance-ancora'),
				'bounceInDown'		=> esc_html__('Bounce In Down',		'insurance-ancora'),
				'bounceInLeft'		=> esc_html__('Bounce In Left',		'insurance-ancora'),
				'bounceInRight'		=> esc_html__('Bounce In Right',	'insurance-ancora'),
				'elastic'			=> esc_html__('Elastic In',			'insurance-ancora'),
				'fadeIn'			=> esc_html__('Fade In',			'insurance-ancora'),
				'fadeInUp'			=> esc_html__('Fade In Up',			'insurance-ancora'),
				'fadeInUpSmall'		=> esc_html__('Fade In Up Small',	'insurance-ancora'),
				'fadeInUpBig'		=> esc_html__('Fade In Up Big',		'insurance-ancora'),
				'fadeInDown'		=> esc_html__('Fade In Down',		'insurance-ancora'),
				'fadeInDownBig'		=> esc_html__('Fade In Down Big',	'insurance-ancora'),
				'fadeInLeft'		=> esc_html__('Fade In Left',		'insurance-ancora'),
				'fadeInLeftBig'		=> esc_html__('Fade In Left Big',	'insurance-ancora'),
				'fadeInRight'		=> esc_html__('Fade In Right',		'insurance-ancora'),
				'fadeInRightBig'	=> esc_html__('Fade In Right Big',	'insurance-ancora'),
				'flipInX'			=> esc_html__('Flip In X',			'insurance-ancora'),
				'flipInY'			=> esc_html__('Flip In Y',			'insurance-ancora'),
				'lightSpeedIn'		=> esc_html__('Light Speed In',		'insurance-ancora'),
				'rotateIn'			=> esc_html__('Rotate In',			'insurance-ancora'),
				'rotateInUpLeft'	=> esc_html__('Rotate In Down Left','insurance-ancora'),
				'rotateInUpRight'	=> esc_html__('Rotate In Up Right',	'insurance-ancora'),
				'rotateInDownLeft'	=> esc_html__('Rotate In Up Left',	'insurance-ancora'),
				'rotateInDownRight'	=> esc_html__('Rotate In Down Right','insurance-ancora'),
				'rollIn'			=> esc_html__('Roll In',			'insurance-ancora'),
				'slideInUp'			=> esc_html__('Slide In Up',		'insurance-ancora'),
				'slideInDown'		=> esc_html__('Slide In Down',		'insurance-ancora'),
				'slideInLeft'		=> esc_html__('Slide In Left',		'insurance-ancora'),
				'slideInRight'		=> esc_html__('Slide In Right',		'insurance-ancora'),
				'wipeInLeftTop'		=> esc_html__('Wipe In Left Top',	'insurance-ancora'),
				'zoomIn'			=> esc_html__('Zoom In',			'insurance-ancora'),
				'zoomInUp'			=> esc_html__('Zoom In Up',			'insurance-ancora'),
				'zoomInDown'		=> esc_html__('Zoom In Down',		'insurance-ancora'),
				'zoomInLeft'		=> esc_html__('Zoom In Left',		'insurance-ancora'),
				'zoomInRight'		=> esc_html__('Zoom In Right',		'insurance-ancora')
				);
			$list = apply_filters('insurance_ancora_filter_list_animations_in', $list);
			if (insurance_ancora_get_theme_setting('use_list_cache')) insurance_ancora_storage_set('list_animations_in', $list);
		}
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}


// Return list of the out animations
if ( !function_exists( 'insurance_ancora_get_list_animations_out' ) ) {
	function insurance_ancora_get_list_animations_out($prepend_inherit=false) {
		if (($list = insurance_ancora_storage_get('list_animations_out'))=='') {
			$list = array(
				'none'				=> esc_html__('- None -',			'insurance-ancora'),
				'bounceOut'			=> esc_html__('Bounce Out',			'insurance-ancora'),
				'bounceOutUp'		=> esc_html__('Bounce Out Up',		'insurance-ancora'),
				'bounceOutDown'		=> esc_html__('Bounce Out Down',	'insurance-ancora'),
				'bounceOutLeft'		=> esc_html__('Bounce Out Left',	'insurance-ancora'),
				'bounceOutRight'	=> esc_html__('Bounce Out Right',	'insurance-ancora'),
				'fadeOut'			=> esc_html__('Fade Out',			'insurance-ancora'),
				'fadeOutUp'			=> esc_html__('Fade Out Up',		'insurance-ancora'),
				'fadeOutUpBig'		=> esc_html__('Fade Out Up Big',	'insurance-ancora'),
				'fadeOutDown'		=> esc_html__('Fade Out Down',		'insurance-ancora'),
				'fadeOutDownSmall'	=> esc_html__('Fade Out Down Small','insurance-ancora'),
				'fadeOutDownBig'	=> esc_html__('Fade Out Down Big',	'insurance-ancora'),
				'fadeOutLeft'		=> esc_html__('Fade Out Left',		'insurance-ancora'),
				'fadeOutLeftBig'	=> esc_html__('Fade Out Left Big',	'insurance-ancora'),
				'fadeOutRight'		=> esc_html__('Fade Out Right',		'insurance-ancora'),
				'fadeOutRightBig'	=> esc_html__('Fade Out Right Big',	'insurance-ancora'),
				'flipOutX'			=> esc_html__('Flip Out X',			'insurance-ancora'),
				'flipOutY'			=> esc_html__('Flip Out Y',			'insurance-ancora'),
				'hinge'				=> esc_html__('Hinge Out',			'insurance-ancora'),
				'lightSpeedOut'		=> esc_html__('Light Speed Out',	'insurance-ancora'),
				'rotateOut'			=> esc_html__('Rotate Out',			'insurance-ancora'),
				'rotateOutUpLeft'	=> esc_html__('Rotate Out Down Left','insurance-ancora'),
				'rotateOutUpRight'	=> esc_html__('Rotate Out Up Right','insurance-ancora'),
				'rotateOutDownLeft'	=> esc_html__('Rotate Out Up Left',	'insurance-ancora'),
				'rotateOutDownRight'=> esc_html__('Rotate Out Down Right','insurance-ancora'),
				'rollOut'			=> esc_html__('Roll Out',			'insurance-ancora'),
				'slideOutUp'		=> esc_html__('Slide Out Up',		'insurance-ancora'),
				'slideOutDown'		=> esc_html__('Slide Out Down',		'insurance-ancora'),
				'slideOutLeft'		=> esc_html__('Slide Out Left',		'insurance-ancora'),
				'slideOutRight'		=> esc_html__('Slide Out Right',	'insurance-ancora'),
				'zoomOut'			=> esc_html__('Zoom Out',			'insurance-ancora'),
				'zoomOutUp'			=> esc_html__('Zoom Out Up',		'insurance-ancora'),
				'zoomOutDown'		=> esc_html__('Zoom Out Down',		'insurance-ancora'),
				'zoomOutLeft'		=> esc_html__('Zoom Out Left',		'insurance-ancora'),
				'zoomOutRight'		=> esc_html__('Zoom Out Right',		'insurance-ancora')
				);
			$list = apply_filters('insurance_ancora_filter_list_animations_out', $list);
			if (insurance_ancora_get_theme_setting('use_list_cache')) insurance_ancora_storage_set('list_animations_out', $list);
		}
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}

// Return classes list for the specified animation
if (!function_exists('insurance_ancora_get_animation_classes')) {
	function insurance_ancora_get_animation_classes($animation, $speed='normal', $loop='none') {
		// speed:	fast=0.5s | normal=1s | slow=2s
		// loop:	none | infinite
		return insurance_ancora_param_is_off($animation) ? '' : 'animated '.esc_attr($animation).' '.esc_attr($speed).(!insurance_ancora_param_is_off($loop) ? ' '.esc_attr($loop) : '');
	}
}


// Return list of the main menu hover effects
if ( !function_exists( 'insurance_ancora_get_list_menu_hovers' ) ) {
	function insurance_ancora_get_list_menu_hovers($prepend_inherit=false) {
		if (($list = insurance_ancora_storage_get('list_menu_hovers'))=='') {
			$list = array(
				'fade'			=> esc_html__('Fade',		'insurance-ancora'),
				'slide_line'	=> esc_html__('Slide Line',	'insurance-ancora'),
				'slide_box'		=> esc_html__('Slide Box',	'insurance-ancora'),
				'zoom_line'		=> esc_html__('Zoom Line',	'insurance-ancora'),
				'path_line'		=> esc_html__('Path Line',	'insurance-ancora'),
				'roll_down'		=> esc_html__('Roll Down',	'insurance-ancora'),
				'color_line'	=> esc_html__('Color Line',	'insurance-ancora'),
				);
			$list = apply_filters('insurance_ancora_filter_list_menu_hovers', $list);
			if (insurance_ancora_get_theme_setting('use_list_cache')) insurance_ancora_storage_set('list_menu_hovers', $list);
		}
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}


// Return list of the button's hover effects
if ( !function_exists( 'insurance_ancora_get_list_button_hovers' ) ) {
	function insurance_ancora_get_list_button_hovers($prepend_inherit=false) {
		if (($list = insurance_ancora_storage_get('list_button_hovers'))=='') {
			$list = array(
				'default'		=> esc_html__('Default',			'insurance-ancora'),
				'fade'			=> esc_html__('Fade',				'insurance-ancora'),
				'slide_left'	=> esc_html__('Slide from Left',	'insurance-ancora'),
				'slide_top'		=> esc_html__('Slide from Top',		'insurance-ancora'),
				'arrow'			=> esc_html__('Arrow',				'insurance-ancora'),
				);
			$list = apply_filters('insurance_ancora_filter_list_button_hovers', $list);
			if (insurance_ancora_get_theme_setting('use_list_cache')) insurance_ancora_storage_set('list_button_hovers', $list);
		}
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}


// Return list of the input field's hover effects
if ( !function_exists( 'insurance_ancora_get_list_input_hovers' ) ) {
	function insurance_ancora_get_list_input_hovers($prepend_inherit=false) {
		if (($list = insurance_ancora_storage_get('list_input_hovers'))=='') {
			$list = array(
				'default'	=> esc_html__('Default',	'insurance-ancora'),
				'accent'	=> esc_html__('Accented',	'insurance-ancora'),
				'path'		=> esc_html__('Path',		'insurance-ancora'),
				'jump'		=> esc_html__('Jump',		'insurance-ancora'),
				'underline'	=> esc_html__('Underline',	'insurance-ancora'),
				'iconed'	=> esc_html__('Iconed',		'insurance-ancora'),
				);
			$list = apply_filters('insurance_ancora_filter_list_input_hovers', $list);
			if (insurance_ancora_get_theme_setting('use_list_cache')) insurance_ancora_storage_set('list_input_hovers', $list);
		}
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}


// Return list of the search field's styles
if ( !function_exists( 'insurance_ancora_get_list_search_styles' ) ) {
	function insurance_ancora_get_list_search_styles($prepend_inherit=false) {
		if (($list = insurance_ancora_storage_get('list_search_styles'))=='') {
			$list = array(
				'default'	=> esc_html__('Default',	'insurance-ancora'),
				'fullscreen'=> esc_html__('Fullscreen',	'insurance-ancora'),
				'slide'		=> esc_html__('Slide',		'insurance-ancora'),
				'expand'	=> esc_html__('Expand',		'insurance-ancora'),
				);
			$list = apply_filters('insurance_ancora_filter_list_search_styles', $list);
			if (insurance_ancora_get_theme_setting('use_list_cache')) insurance_ancora_storage_set('list_search_styles', $list);
		}
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}


// Return list of categories
if ( !function_exists( 'insurance_ancora_get_list_categories' ) ) {
	function insurance_ancora_get_list_categories($prepend_inherit=false) {
		if (($list = insurance_ancora_storage_get('list_categories'))=='') {
			$list = array();
			$args = array(
				'type'                     => 'post',
				'child_of'                 => 0,
				'parent'                   => '',
				'orderby'                  => 'name',
				'order'                    => 'ASC',
				'hide_empty'               => 0,
				'hierarchical'             => 1,
				'exclude'                  => '',
				'include'                  => '',
				'number'                   => '',
				'taxonomy'                 => 'category',
				'pad_counts'               => false );
			$taxonomies = get_categories( $args );
			if (is_array($taxonomies) && count($taxonomies) > 0) {
				foreach ($taxonomies as $cat) {
					$list[$cat->term_id] = $cat->name;
				}
			}
			if (insurance_ancora_get_theme_setting('use_list_cache')) insurance_ancora_storage_set('list_categories', $list);
		}
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}


// Return list of taxonomies
if ( !function_exists( 'insurance_ancora_get_list_terms' ) ) {
	function insurance_ancora_get_list_terms($prepend_inherit=false, $taxonomy='category') {
		if (($list = insurance_ancora_storage_get('list_taxonomies_'.($taxonomy)))=='') {
			$list = array();
			if ( is_array($taxonomy) || taxonomy_exists($taxonomy) ) {
				$terms = get_terms( $taxonomy, array(
					'child_of'                 => 0,
					'parent'                   => '',
					'orderby'                  => 'name',
					'order'                    => 'ASC',
					'hide_empty'               => 0,
					'hierarchical'             => 1,
					'exclude'                  => '',
					'include'                  => '',
					'number'                   => '',
					'taxonomy'                 => $taxonomy,
					'pad_counts'               => false
					)
				);
			} else {
				$terms = insurance_ancora_get_terms_by_taxonomy_from_db($taxonomy);
			}
			if (!is_wp_error( $terms ) && is_array($terms) && count($terms) > 0) {
				foreach ($terms as $cat) {
					$list[$cat->term_id] = $cat->name;	
				}
			}
			if (insurance_ancora_get_theme_setting('use_list_cache')) insurance_ancora_storage_set('list_taxonomies_'.($taxonomy), $list);
		}
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}

// Return list of post's types
if ( !function_exists( 'insurance_ancora_get_list_posts_types' ) ) {
	function insurance_ancora_get_list_posts_types($prepend_inherit=false) {
		if (($list = insurance_ancora_storage_get('list_posts_types'))=='') {
			// Return only theme inheritance supported post types
			$list = apply_filters('insurance_ancora_filter_list_post_types', array());
			if (insurance_ancora_get_theme_setting('use_list_cache')) insurance_ancora_storage_set('list_posts_types', $list);
		}
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}


// Return list post items from any post type and taxonomy
if ( !function_exists( 'insurance_ancora_get_list_posts' ) ) {
	function insurance_ancora_get_list_posts($prepend_inherit=false, $opt=array()) {
		$opt = array_merge(array(
			'post_type'			=> 'post',
			'post_status'		=> 'publish',
			'taxonomy'			=> 'category',
			'taxonomy_value'	=> '',
			'posts_per_page'	=> -1,
			'orderby'			=> 'post_date',
			'order'				=> 'desc',
			'return'			=> 'id'
			), is_array($opt) ? $opt : array('post_type'=>$opt));

		$hash = 'list_posts_'.($opt['post_type']).'_'.($opt['taxonomy']).'_'.($opt['taxonomy_value']).'_'.($opt['orderby']).'_'.($opt['order']).'_'.($opt['return']).'_'.($opt['posts_per_page']);
		if (($list = insurance_ancora_storage_get($hash))=='') {
			$list = array();
			$list['none'] = esc_html__("- Not selected -", 'insurance-ancora');
			$args = array(
				'post_type' => $opt['post_type'],
				'post_status' => $opt['post_status'],
				'posts_per_page' => $opt['posts_per_page'],
				'ignore_sticky_posts' => true,
				'orderby'	=> $opt['orderby'],
				'order'		=> $opt['order']
			);
			if (!empty($opt['taxonomy_value'])) {
				$args['tax_query'] = array(
					array(
						'taxonomy' => $opt['taxonomy'],
						'field' => (int) $opt['taxonomy_value'] > 0 ? 'id' : 'slug',
						'terms' => $opt['taxonomy_value']
					)
				);
			}
			$posts = get_posts( $args );
			if (is_array($posts) && count($posts) > 0) {
				foreach ($posts as $post) {
					$list[$opt['return']=='id' ? $post->ID : $post->post_title] = $post->post_title;
				}
			}
			if (insurance_ancora_get_theme_setting('use_list_cache')) insurance_ancora_storage_set($hash, $list);
		}
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}


// Return list pages
if ( !function_exists( 'insurance_ancora_get_list_pages' ) ) {
	function insurance_ancora_get_list_pages($prepend_inherit=false, $opt=array()) {
		$opt = array_merge(array(
			'post_type'			=> 'page',
			'post_status'		=> 'publish',
			'posts_per_page'	=> -1,
			'orderby'			=> 'title',
			'order'				=> 'asc',
			'return'			=> 'id'
			), is_array($opt) ? $opt : array('post_type'=>$opt));
		return insurance_ancora_get_list_posts($prepend_inherit, $opt);
	}
}


// Return list of registered users
if ( !function_exists( 'insurance_ancora_get_list_users' ) ) {
	function insurance_ancora_get_list_users($prepend_inherit=false, $roles=array('administrator', 'editor', 'author', 'contributor', 'shop_manager')) {
		if (($list = insurance_ancora_storage_get('list_users'))=='') {
			$list = array();
			$list['none'] = esc_html__("- Not selected -", 'insurance-ancora');
			$args = array(
				'orderby'	=> 'display_name',
				'order'		=> 'ASC' );
			$users = get_users( $args );
			if (is_array($users) && count($users) > 0) {
				foreach ($users as $user) {
					$accept = true;
					if (is_array($user->roles)) {
						if (is_array($user->roles) && count($user->roles) > 0) {
							$accept = false;
							foreach ($user->roles as $role) {
								if (in_array($role, $roles)) {
									$accept = true;
									break;
								}
							}
						}
					}
					if ($accept) $list[$user->user_login] = $user->display_name;
				}
			}
			if (insurance_ancora_get_theme_setting('use_list_cache')) insurance_ancora_storage_set('list_users', $list);
		}
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}


// Return slider engines list, prepended inherit (if need)
if ( !function_exists( 'insurance_ancora_get_list_sliders' ) ) {
	function insurance_ancora_get_list_sliders($prepend_inherit=false) {
		if (($list = insurance_ancora_storage_get('list_sliders'))=='') {
			$list = array(
				'swiper' => esc_html__("Posts slider (Swiper)", 'insurance-ancora')
			);
			$list = apply_filters('insurance_ancora_filter_list_sliders', $list);
			if (insurance_ancora_get_theme_setting('use_list_cache')) insurance_ancora_storage_set('list_sliders', $list);
		}
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}


// Return slider controls list, prepended inherit (if need)
if ( !function_exists( 'insurance_ancora_get_list_slider_controls' ) ) {
	function insurance_ancora_get_list_slider_controls($prepend_inherit=false) {
		if (($list = insurance_ancora_storage_get('list_slider_controls'))=='') {
			$list = array(
				'no'		=> esc_html__('None', 'insurance-ancora'),
				'side'		=> esc_html__('Side', 'insurance-ancora'),
				'bottom'	=> esc_html__('Bottom', 'insurance-ancora'),
				'pagination'=> esc_html__('Pagination', 'insurance-ancora')
				);
			$list = apply_filters('insurance_ancora_filter_list_slider_controls', $list);
			if (insurance_ancora_get_theme_setting('use_list_cache')) insurance_ancora_storage_set('list_slider_controls', $list);
		}
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}


// Return slider controls classes
if ( !function_exists( 'insurance_ancora_get_slider_controls_classes' ) ) {
	function insurance_ancora_get_slider_controls_classes($controls) {
		if (insurance_ancora_param_is_off($controls))	$classes = 'sc_slider_nopagination sc_slider_nocontrols';
		else if ($controls=='bottom')			$classes = 'sc_slider_nopagination sc_slider_controls sc_slider_controls_bottom';
		else if ($controls=='pagination')		$classes = 'sc_slider_pagination sc_slider_pagination_bottom sc_slider_controls';
		else									$classes = 'sc_slider_nopagination sc_slider_controls sc_slider_controls_side';
		return $classes;
	}
}

// Return list with popup engines
if ( !function_exists( 'insurance_ancora_get_list_popup_engines' ) ) {
	function insurance_ancora_get_list_popup_engines($prepend_inherit=false) {
		if (($list = insurance_ancora_storage_get('list_popup_engines'))=='') {
			$list = array(
				"pretty"	=> esc_html__("Pretty photo", 'insurance-ancora'),
				"magnific"	=> esc_html__("Magnific popup", 'insurance-ancora')
				);
			$list = apply_filters('insurance_ancora_filter_list_popup_engines', $list);
			if (insurance_ancora_get_theme_setting('use_list_cache')) insurance_ancora_storage_set('list_popup_engines', $list);
		}
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}

// Return menus list, prepended inherit
if ( !function_exists( 'insurance_ancora_get_list_menus' ) ) {
	function insurance_ancora_get_list_menus($prepend_inherit=false) {
		if (($list = insurance_ancora_storage_get('list_menus'))=='') {
			$list = array();
			$list['default'] = esc_html__("Default", 'insurance-ancora');
			$menus = wp_get_nav_menus();
			if (is_array($menus) && count($menus) > 0) {
				foreach ($menus as $menu) {
					$list[$menu->slug] = $menu->name;
				}
			}
			if (insurance_ancora_get_theme_setting('use_list_cache')) insurance_ancora_storage_set('list_menus', $list);
		}
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}

// Return custom sidebars list, prepended inherit and main sidebars item (if need)
if ( !function_exists( 'insurance_ancora_get_list_sidebars' ) ) {
	function insurance_ancora_get_list_sidebars($prepend_inherit=false) {
		if (($list = insurance_ancora_storage_get('list_sidebars'))=='') {
			if (($list = insurance_ancora_storage_get('registered_sidebars'))=='') $list = array();
			if (insurance_ancora_get_theme_setting('use_list_cache')) insurance_ancora_storage_set('list_sidebars', $list);
		}
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}

// Return sidebars positions
if ( !function_exists( 'insurance_ancora_get_list_sidebars_positions' ) ) {
	function insurance_ancora_get_list_sidebars_positions($prepend_inherit=false) {
		if (($list = insurance_ancora_storage_get('list_sidebars_positions'))=='') {
			$list = array(
				'none'  => esc_html__('Hide',  'insurance-ancora'),
				'left'  => esc_html__('Left',  'insurance-ancora'),
				'right' => esc_html__('Right', 'insurance-ancora')
				);
			if (insurance_ancora_get_theme_setting('use_list_cache')) insurance_ancora_storage_set('list_sidebars_positions', $list);
		}
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}

// Return sidebars class
if ( !function_exists( 'insurance_ancora_get_sidebar_class' ) ) {
	function insurance_ancora_get_sidebar_class() {
		$sb_main = insurance_ancora_get_custom_option('show_sidebar_main');
		$sb_outer = insurance_ancora_get_custom_option('show_sidebar_outer');
		return (insurance_ancora_param_is_off($sb_main) ? 'sidebar_hide' : 'sidebar_show sidebar_'.($sb_main))
				. ' ' . (insurance_ancora_param_is_off($sb_outer) ? 'sidebar_outer_hide' : 'sidebar_outer_show sidebar_outer_'.($sb_outer));
	}
}

// Return body styles list, prepended inherit
if ( !function_exists( 'insurance_ancora_get_list_body_styles' ) ) {
	function insurance_ancora_get_list_body_styles($prepend_inherit=false) {
		if (($list = insurance_ancora_storage_get('list_body_styles'))=='') {
			$list = array(
				'boxed'	=> esc_html__('Boxed',		'insurance-ancora'),
				'wide'	=> esc_html__('Wide',		'insurance-ancora')
				);
			if (insurance_ancora_get_theme_setting('allow_fullscreen')) {
				$list['fullwide']	= esc_html__('Fullwide',	'insurance-ancora');
				$list['fullscreen']	= esc_html__('Fullscreen',	'insurance-ancora');
			}
			$list = apply_filters('insurance_ancora_filter_list_body_styles', $list);
			if (insurance_ancora_get_theme_setting('use_list_cache')) insurance_ancora_storage_set('list_body_styles', $list);
		}
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}

// Return css-themes list
if ( !function_exists( 'insurance_ancora_get_list_themes' ) ) {
	function insurance_ancora_get_list_themes($prepend_inherit=false) {
		if (($list = insurance_ancora_storage_get('list_themes'))=='') {
			$list = insurance_ancora_get_list_files("css/themes");
			if (insurance_ancora_get_theme_setting('use_list_cache')) insurance_ancora_storage_set('list_themes', $list);
		}
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}

// Return templates list, prepended inherit
if ( !function_exists( 'insurance_ancora_get_list_templates' ) ) {
	function insurance_ancora_get_list_templates($mode='') {
		if (($list = insurance_ancora_storage_get('list_templates_'.($mode)))=='') {
			$list = array();
			$tpl = insurance_ancora_storage_get('registered_templates');
			if (is_array($tpl) && count($tpl) > 0) {
				foreach ($tpl as $k=>$v) {
					if ($mode=='' || in_array($mode, explode(',', $v['mode'])))
						$list[$k] = !empty($v['icon']) 
									? $v['icon'] 
									: (!empty($v['title']) 
										? $v['title'] 
										: insurance_ancora_strtoproper($v['layout'])
										);
				}
			}
			if (insurance_ancora_get_theme_setting('use_list_cache')) insurance_ancora_storage_set('list_templates_'.($mode), $list);
		}
		return $list;
	}
}

// Return blog styles list, prepended inherit
if ( !function_exists( 'insurance_ancora_get_list_templates_blog' ) ) {
	function insurance_ancora_get_list_templates_blog($prepend_inherit=false) {
		if (($list = insurance_ancora_storage_get('list_templates_blog'))=='') {
			$list = insurance_ancora_get_list_templates('blog');
			if (insurance_ancora_get_theme_setting('use_list_cache')) insurance_ancora_storage_set('list_templates_blog', $list);
		}
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}

// Return blogger styles list, prepended inherit
if ( !function_exists( 'insurance_ancora_get_list_templates_blogger' ) ) {
	function insurance_ancora_get_list_templates_blogger($prepend_inherit=false) {
		if (($list = insurance_ancora_storage_get('list_templates_blogger'))=='') {
			$list = insurance_ancora_array_merge(insurance_ancora_get_list_templates('blogger'), insurance_ancora_get_list_templates('blog'));
			if (insurance_ancora_get_theme_setting('use_list_cache')) insurance_ancora_storage_set('list_templates_blogger', $list);
		}
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}

// Return single page styles list, prepended inherit
if ( !function_exists( 'insurance_ancora_get_list_templates_single' ) ) {
	function insurance_ancora_get_list_templates_single($prepend_inherit=false) {
		if (($list = insurance_ancora_storage_get('list_templates_single'))=='') {
			$list = insurance_ancora_get_list_templates('single');
			if (insurance_ancora_get_theme_setting('use_list_cache')) insurance_ancora_storage_set('list_templates_single', $list);
		}
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}

// Return header styles list, prepended inherit
if ( !function_exists( 'insurance_ancora_get_list_templates_header' ) ) {
	function insurance_ancora_get_list_templates_header($prepend_inherit=false) {
		if (($list = insurance_ancora_storage_get('list_templates_header'))=='') {
			$list = insurance_ancora_get_list_templates('header');
			if (insurance_ancora_get_theme_setting('use_list_cache')) insurance_ancora_storage_set('list_templates_header', $list);
		}
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}

// Return form styles list, prepended inherit
if ( !function_exists( 'insurance_ancora_get_list_templates_forms' ) ) {
	function insurance_ancora_get_list_templates_forms($prepend_inherit=false) {
		if (($list = insurance_ancora_storage_get('list_templates_forms'))=='') {
			$list = insurance_ancora_get_list_templates('forms');
			if (insurance_ancora_get_theme_setting('use_list_cache')) insurance_ancora_storage_set('list_templates_forms', $list);
		}
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}

// Return article styles list, prepended inherit
if ( !function_exists( 'insurance_ancora_get_list_article_styles' ) ) {
	function insurance_ancora_get_list_article_styles($prepend_inherit=false) {
		if (($list = insurance_ancora_storage_get('list_article_styles'))=='') {
			$list = array(
				"boxed"   => esc_html__('Boxed', 'insurance-ancora'),
				"stretch" => esc_html__('Stretch', 'insurance-ancora')
				);
			if (insurance_ancora_get_theme_setting('use_list_cache')) insurance_ancora_storage_set('list_article_styles', $list);
		}
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}

// Return post-formats filters list, prepended inherit
if ( !function_exists( 'insurance_ancora_get_list_post_formats_filters' ) ) {
	function insurance_ancora_get_list_post_formats_filters($prepend_inherit=false) {
		if (($list = insurance_ancora_storage_get('list_post_formats_filters'))=='') {
			$list = array(
				"no"      => esc_html__('All posts', 'insurance-ancora'),
				"thumbs"  => esc_html__('With thumbs', 'insurance-ancora'),
				"reviews" => esc_html__('With reviews', 'insurance-ancora'),
				"video"   => esc_html__('With videos', 'insurance-ancora'),
				"audio"   => esc_html__('With audios', 'insurance-ancora'),
				"gallery" => esc_html__('With galleries', 'insurance-ancora')
				);
			if (insurance_ancora_get_theme_setting('use_list_cache')) insurance_ancora_storage_set('list_post_formats_filters', $list);
		}
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}

// Return portfolio filters list, prepended inherit
if ( !function_exists( 'insurance_ancora_get_list_portfolio_filters' ) ) {
	function insurance_ancora_get_list_portfolio_filters($prepend_inherit=false) {
		if (($list = insurance_ancora_storage_get('list_portfolio_filters'))=='') {
			$list = array(
				"hide"		=> esc_html__('Hide', 'insurance-ancora'),
				"tags"		=> esc_html__('Tags', 'insurance-ancora'),
				"categories"=> esc_html__('Categories', 'insurance-ancora')
				);
			if (insurance_ancora_get_theme_setting('use_list_cache')) insurance_ancora_storage_set('list_portfolio_filters', $list);
		}
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}

// Return hover styles list, prepended inherit
if ( !function_exists( 'insurance_ancora_get_list_hovers' ) ) {
	function insurance_ancora_get_list_hovers($prepend_inherit=false) {
		if (($list = insurance_ancora_storage_get('list_hovers'))=='') {
			$list = array();
			$list['circle effect1']  = esc_html__('Circle Effect 1',  'insurance-ancora');
			$list['circle effect2']  = esc_html__('Circle Effect 2',  'insurance-ancora');
			$list['circle effect3']  = esc_html__('Circle Effect 3',  'insurance-ancora');
			$list['circle effect4']  = esc_html__('Circle Effect 4',  'insurance-ancora');
			$list['circle effect5']  = esc_html__('Circle Effect 5',  'insurance-ancora');
			$list['circle effect6']  = esc_html__('Circle Effect 6',  'insurance-ancora');
			$list['circle effect7']  = esc_html__('Circle Effect 7',  'insurance-ancora');
			$list['circle effect8']  = esc_html__('Circle Effect 8',  'insurance-ancora');
			$list['circle effect9']  = esc_html__('Circle Effect 9',  'insurance-ancora');
			$list['circle effect10'] = esc_html__('Circle Effect 10',  'insurance-ancora');
			$list['circle effect11'] = esc_html__('Circle Effect 11',  'insurance-ancora');
			$list['circle effect12'] = esc_html__('Circle Effect 12',  'insurance-ancora');
			$list['circle effect13'] = esc_html__('Circle Effect 13',  'insurance-ancora');
			$list['circle effect14'] = esc_html__('Circle Effect 14',  'insurance-ancora');
			$list['circle effect15'] = esc_html__('Circle Effect 15',  'insurance-ancora');
			$list['circle effect16'] = esc_html__('Circle Effect 16',  'insurance-ancora');
			$list['circle effect17'] = esc_html__('Circle Effect 17',  'insurance-ancora');
			$list['circle effect18'] = esc_html__('Circle Effect 18',  'insurance-ancora');
			$list['circle effect19'] = esc_html__('Circle Effect 19',  'insurance-ancora');
			$list['circle effect20'] = esc_html__('Circle Effect 20',  'insurance-ancora');
			$list['square effect1']  = esc_html__('Square Effect 1',  'insurance-ancora');
			$list['square effect2']  = esc_html__('Square Effect 2',  'insurance-ancora');
			$list['square effect3']  = esc_html__('Square Effect 3',  'insurance-ancora');
			$list['square effect5']  = esc_html__('Square Effect 5',  'insurance-ancora');
			$list['square effect6']  = esc_html__('Square Effect 6',  'insurance-ancora');
			$list['square effect7']  = esc_html__('Square Effect 7',  'insurance-ancora');
			$list['square effect8']  = esc_html__('Square Effect 8',  'insurance-ancora');
			$list['square effect9']  = esc_html__('Square Effect 9',  'insurance-ancora');
			$list['square effect10'] = esc_html__('Square Effect 10',  'insurance-ancora');
			$list['square effect11'] = esc_html__('Square Effect 11',  'insurance-ancora');
			$list['square effect12'] = esc_html__('Square Effect 12',  'insurance-ancora');
			$list['square effect13'] = esc_html__('Square Effect 13',  'insurance-ancora');
			$list['square effect14'] = esc_html__('Square Effect 14',  'insurance-ancora');
			$list['square effect15'] = esc_html__('Square Effect 15',  'insurance-ancora');
			$list['square effect_dir']   = esc_html__('Square Effect Dir',   'insurance-ancora');
			$list['square effect_shift'] = esc_html__('Square Effect Shift', 'insurance-ancora');
			$list['square effect_book']  = esc_html__('Square Effect Book',  'insurance-ancora');
			$list['square effect_more']  = esc_html__('Square Effect More',  'insurance-ancora');
			$list['square effect_fade']  = esc_html__('Square Effect Fade',  'insurance-ancora');
			$list['square effect_pull']  = esc_html__('Square Effect Pull',  'insurance-ancora');
			$list['square effect_slide'] = esc_html__('Square Effect Slide', 'insurance-ancora');
			$list['square effect_border'] = esc_html__('Square Effect Border', 'insurance-ancora');
			$list = apply_filters('insurance_ancora_filter_portfolio_hovers', $list);
			if (insurance_ancora_get_theme_setting('use_list_cache')) insurance_ancora_storage_set('list_hovers', $list);
		}
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}


// Return list of the blog counters
if ( !function_exists( 'insurance_ancora_get_list_blog_counters' ) ) {
	function insurance_ancora_get_list_blog_counters($prepend_inherit=false) {
		if (($list = insurance_ancora_storage_get('list_blog_counters'))=='') {
			$list = array(
				'views'		=> esc_html__('Views', 'insurance-ancora'),
				'likes'		=> esc_html__('Likes', 'insurance-ancora'),
				'rating'	=> esc_html__('Rating', 'insurance-ancora'),
				'comments'	=> esc_html__('Comments', 'insurance-ancora')
				);
			$list = apply_filters('insurance_ancora_filter_list_blog_counters', $list);
			if (insurance_ancora_get_theme_setting('use_list_cache')) insurance_ancora_storage_set('list_blog_counters', $list);
		}
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}

// Return list of the item sizes for the portfolio alter style, prepended inherit
if ( !function_exists( 'insurance_ancora_get_list_alter_sizes' ) ) {
	function insurance_ancora_get_list_alter_sizes($prepend_inherit=false) {
		if (($list = insurance_ancora_storage_get('list_alter_sizes'))=='') {
			$list = array(
					'1_1' => esc_html__('1x1', 'insurance-ancora'),
					'1_2' => esc_html__('1x2', 'insurance-ancora'),
					'2_1' => esc_html__('2x1', 'insurance-ancora'),
					'2_2' => esc_html__('2x2', 'insurance-ancora'),
					'1_3' => esc_html__('1x3', 'insurance-ancora'),
					'2_3' => esc_html__('2x3', 'insurance-ancora'),
					'3_1' => esc_html__('3x1', 'insurance-ancora'),
					'3_2' => esc_html__('3x2', 'insurance-ancora'),
					'3_3' => esc_html__('3x3', 'insurance-ancora')
					);
			$list = apply_filters('insurance_ancora_filter_portfolio_alter_sizes', $list);
			if (insurance_ancora_get_theme_setting('use_list_cache')) insurance_ancora_storage_set('list_alter_sizes', $list);
		}
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}

// Return extended hover directions list, prepended inherit
if ( !function_exists( 'insurance_ancora_get_list_hovers_directions' ) ) {
	function insurance_ancora_get_list_hovers_directions($prepend_inherit=false) {
		if (($list = insurance_ancora_storage_get('list_hovers_directions'))=='') {
			$list = array(
				'left_to_right' => esc_html__('Left to Right',  'insurance-ancora'),
				'right_to_left' => esc_html__('Right to Left',  'insurance-ancora'),
				'top_to_bottom' => esc_html__('Top to Bottom',  'insurance-ancora'),
				'bottom_to_top' => esc_html__('Bottom to Top',  'insurance-ancora'),
				'scale_up'      => esc_html__('Scale Up',  'insurance-ancora'),
				'scale_down'    => esc_html__('Scale Down',  'insurance-ancora'),
				'scale_down_up' => esc_html__('Scale Down-Up',  'insurance-ancora'),
				'from_left_and_right' => esc_html__('From Left and Right',  'insurance-ancora'),
				'from_top_and_bottom' => esc_html__('From Top and Bottom',  'insurance-ancora')
			);
			$list = apply_filters('insurance_ancora_filter_portfolio_hovers_directions', $list);
			if (insurance_ancora_get_theme_setting('use_list_cache')) insurance_ancora_storage_set('list_hovers_directions', $list);
		}
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}


// Return list of the label positions in the custom forms
if ( !function_exists( 'insurance_ancora_get_list_label_positions' ) ) {
	function insurance_ancora_get_list_label_positions($prepend_inherit=false) {
		if (($list = insurance_ancora_storage_get('list_label_positions'))=='') {
			$list = array(
				'top'		=> esc_html__('Top',		'insurance-ancora'),
				'bottom'	=> esc_html__('Bottom',		'insurance-ancora'),
				'left'		=> esc_html__('Left',		'insurance-ancora'),
				'over'		=> esc_html__('Over',		'insurance-ancora')
			);
			$list = apply_filters('insurance_ancora_filter_label_positions', $list);
			if (insurance_ancora_get_theme_setting('use_list_cache')) insurance_ancora_storage_set('list_label_positions', $list);
		}
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}


// Return list of the bg image positions
if ( !function_exists( 'insurance_ancora_get_list_bg_image_positions' ) ) {
	function insurance_ancora_get_list_bg_image_positions($prepend_inherit=false) {
		if (($list = insurance_ancora_storage_get('list_bg_image_positions'))=='') {
			$list = array(
				'left top'	   => esc_html__('Left Top', 'insurance-ancora'),
				'center top'   => esc_html__("Center Top", 'insurance-ancora'),
				'right top'    => esc_html__("Right Top", 'insurance-ancora'),
				'left center'  => esc_html__("Left Center", 'insurance-ancora'),
				'center center'=> esc_html__("Center Center", 'insurance-ancora'),
				'right center' => esc_html__("Right Center", 'insurance-ancora'),
				'left bottom'  => esc_html__("Left Bottom", 'insurance-ancora'),
				'center bottom'=> esc_html__("Center Bottom", 'insurance-ancora'),
				'right bottom' => esc_html__("Right Bottom", 'insurance-ancora')
			);
			if (insurance_ancora_get_theme_setting('use_list_cache')) insurance_ancora_storage_set('list_bg_image_positions', $list);
		}
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}


// Return list of the bg image repeat
if ( !function_exists( 'insurance_ancora_get_list_bg_image_repeats' ) ) {
	function insurance_ancora_get_list_bg_image_repeats($prepend_inherit=false) {
		if (($list = insurance_ancora_storage_get('list_bg_image_repeats'))=='') {
			$list = array(
				'repeat'	=> esc_html__('Repeat', 'insurance-ancora'),
				'repeat-x'	=> esc_html__('Repeat X', 'insurance-ancora'),
				'repeat-y'	=> esc_html__('Repeat Y', 'insurance-ancora'),
				'no-repeat'	=> esc_html__('No Repeat', 'insurance-ancora')
			);
			if (insurance_ancora_get_theme_setting('use_list_cache')) insurance_ancora_storage_set('list_bg_image_repeats', $list);
		}
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}


// Return list of the bg image attachment
if ( !function_exists( 'insurance_ancora_get_list_bg_image_attachments' ) ) {
	function insurance_ancora_get_list_bg_image_attachments($prepend_inherit=false) {
		if (($list = insurance_ancora_storage_get('list_bg_image_attachments'))=='') {
			$list = array(
				'scroll'	=> esc_html__('Scroll', 'insurance-ancora'),
				'fixed'		=> esc_html__('Fixed', 'insurance-ancora'),
				'local'		=> esc_html__('Local', 'insurance-ancora')
			);
			if (insurance_ancora_get_theme_setting('use_list_cache')) insurance_ancora_storage_set('list_bg_image_attachments', $list);
		}
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}


// Return list of the bg tints
if ( !function_exists( 'insurance_ancora_get_list_bg_tints' ) ) {
	function insurance_ancora_get_list_bg_tints($prepend_inherit=false) {
		if (($list = insurance_ancora_storage_get('list_bg_tints'))=='') {
			$list = array(
				'white'	=> esc_html__('White', 'insurance-ancora'),
				'light'	=> esc_html__('Light', 'insurance-ancora'),
				'dark'	=> esc_html__('Dark', 'insurance-ancora')
			);
			$list = apply_filters('insurance_ancora_filter_bg_tints', $list);
			if (insurance_ancora_get_theme_setting('use_list_cache')) insurance_ancora_storage_set('list_bg_tints', $list);
		}
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}

// Return custom fields types list, prepended inherit
if ( !function_exists( 'insurance_ancora_get_list_field_types' ) ) {
	function insurance_ancora_get_list_field_types($prepend_inherit=false) {
		if (($list = insurance_ancora_storage_get('list_field_types'))=='') {
			$list = array(
				'text'     => esc_html__('Text',  'insurance-ancora'),
				'textarea' => esc_html__('Text Area','insurance-ancora'),
				'password' => esc_html__('Password',  'insurance-ancora'),
				'radio'    => esc_html__('Radio',  'insurance-ancora'),
				'checkbox' => esc_html__('Checkbox',  'insurance-ancora'),
				'select'   => esc_html__('Select',  'insurance-ancora'),
				'date'     => esc_html__('Date','insurance-ancora'),
				'time'     => esc_html__('Time','insurance-ancora'),
				'button'   => esc_html__('Button','insurance-ancora')
			);
			$list = apply_filters('insurance_ancora_filter_field_types', $list);
			if (insurance_ancora_get_theme_setting('use_list_cache')) insurance_ancora_storage_set('list_field_types', $list);
		}
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}

// Return Google map styles
if ( !function_exists( 'insurance_ancora_get_list_googlemap_styles' ) ) {
	function insurance_ancora_get_list_googlemap_styles($prepend_inherit=false) {
		if (($list = insurance_ancora_storage_get('list_googlemap_styles'))=='') {
			$list = array(
				'default' => esc_html__('Default', 'insurance-ancora')
			);
			$list = apply_filters('insurance_ancora_filter_googlemap_styles', $list);
			if (insurance_ancora_get_theme_setting('use_list_cache')) insurance_ancora_storage_set('list_googlemap_styles', $list);
		}
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}

// Return images list
if (!function_exists('insurance_ancora_get_list_images')) {
	function insurance_ancora_get_list_images($folder, $ext='', $only_names=false) {
		return function_exists('trx_utils_get_folder_list') ? trx_utils_get_folder_list($folder, $ext, $only_names) : array();
	}
}

// Return iconed classes list
if ( !function_exists( 'insurance_ancora_get_list_icons' ) ) {
	function insurance_ancora_get_list_icons($prepend_inherit=false) {
		if (($list = insurance_ancora_storage_get('list_icons'))=='') {
			$list = insurance_ancora_parse_icons_classes(insurance_ancora_get_file_dir("css/fontello/css/fontello-codes.css"));
			if (insurance_ancora_get_theme_setting('use_list_cache')) insurance_ancora_storage_set('list_icons', $list);
		}
		return $prepend_inherit ? array_merge(array('inherit'), $list) : $list;
	}
}

// Return socials list
if ( !function_exists( 'insurance_ancora_get_list_socials' ) ) {
	function insurance_ancora_get_list_socials($prepend_inherit=false) {
		if (($list = insurance_ancora_storage_get('list_socials'))=='') {
			$list = insurance_ancora_get_list_files("images/socials", "png");
			if (insurance_ancora_get_theme_setting('use_list_cache')) insurance_ancora_storage_set('list_socials', $list);
		}
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}

// Return flags list
if ( !function_exists( 'insurance_ancora_get_list_flags' ) ) {
	function insurance_ancora_get_list_flags($prepend_inherit=false) {
		if (($list = insurance_ancora_storage_get('list_flags'))=='') {
			$list = insurance_ancora_get_list_files("images/flags", "png");
			if (insurance_ancora_get_theme_setting('use_list_cache')) insurance_ancora_storage_set('list_flags', $list);
		}
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}

// Return list with 'Yes' and 'No' items
if ( !function_exists( 'insurance_ancora_get_list_yesno' ) ) {
	function insurance_ancora_get_list_yesno($prepend_inherit=false) {
		$list = array(
			'yes' => esc_html__("Yes", 'insurance-ancora'),
			'no'  => esc_html__("No", 'insurance-ancora')
		);
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}

// Return list with 'On' and 'Of' items
if ( !function_exists( 'insurance_ancora_get_list_onoff' ) ) {
	function insurance_ancora_get_list_onoff($prepend_inherit=false) {
		$list = array(
			"on" => esc_html__("On", 'insurance-ancora'),
			"off" => esc_html__("Off", 'insurance-ancora')
		);
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}

// Return list with 'Show' and 'Hide' items
if ( !function_exists( 'insurance_ancora_get_list_showhide' ) ) {
	function insurance_ancora_get_list_showhide($prepend_inherit=false) {
		$list = array(
			"show" => esc_html__("Show", 'insurance-ancora'),
			"hide" => esc_html__("Hide", 'insurance-ancora')
		);
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}

// Return list with 'Ascending' and 'Descending' items
if ( !function_exists( 'insurance_ancora_get_list_orderings' ) ) {
	function insurance_ancora_get_list_orderings($prepend_inherit=false) {
		$list = array(
			"asc" => esc_html__("Ascending", 'insurance-ancora'),
			"desc" => esc_html__("Descending", 'insurance-ancora')
		);
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}

// Return list with 'Horizontal' and 'Vertical' items
if ( !function_exists( 'insurance_ancora_get_list_directions' ) ) {
	function insurance_ancora_get_list_directions($prepend_inherit=false) {
		$list = array(
			"horizontal" => esc_html__("Horizontal", 'insurance-ancora'),
			"vertical" => esc_html__("Vertical", 'insurance-ancora')
		);
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}

// Return list with item's shapes
if ( !function_exists( 'insurance_ancora_get_list_shapes' ) ) {
	function insurance_ancora_get_list_shapes($prepend_inherit=false) {
		$list = array(
			"round"  => esc_html__("Round", 'insurance-ancora'),
			"square" => esc_html__("Square", 'insurance-ancora')
		);
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}

// Return list with item's sizes
if ( !function_exists( 'insurance_ancora_get_list_sizes' ) ) {
	function insurance_ancora_get_list_sizes($prepend_inherit=false) {
		$list = array(
			"tiny"   => esc_html__("Tiny", 'insurance-ancora'),
			"small"  => esc_html__("Small", 'insurance-ancora'),
			"medium" => esc_html__("Medium", 'insurance-ancora'),
			"large"  => esc_html__("Large", 'insurance-ancora')
		);
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}

// Return list with slider (scroll) controls positions
if ( !function_exists( 'insurance_ancora_get_list_controls' ) ) {
	function insurance_ancora_get_list_controls($prepend_inherit=false) {
		$list = array(
			"hide" => esc_html__("Hide", 'insurance-ancora'),
			"side" => esc_html__("Side", 'insurance-ancora'),
			"bottom" => esc_html__("Bottom", 'insurance-ancora')
		);
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}

// Return list with float items
if ( !function_exists( 'insurance_ancora_get_list_floats' ) ) {
	function insurance_ancora_get_list_floats($prepend_inherit=false) {
		$list = array(
			"none" => esc_html__("None", 'insurance-ancora'),
			"left" => esc_html__("Float Left", 'insurance-ancora'),
			"right" => esc_html__("Float Right", 'insurance-ancora')
		);
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}

// Return list with alignment items
if ( !function_exists( 'insurance_ancora_get_list_alignments' ) ) {
	function insurance_ancora_get_list_alignments($justify=false, $prepend_inherit=false) {
		$list = array(
			"none" => esc_html__("None", 'insurance-ancora'),
			"left" => esc_html__("Left", 'insurance-ancora'),
			"center" => esc_html__("Center", 'insurance-ancora'),
			"right" => esc_html__("Right", 'insurance-ancora')
		);
		if ($justify) $list["justify"] = esc_html__("Justify", 'insurance-ancora');
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}

// Return list with horizontal positions
if ( !function_exists( 'insurance_ancora_get_list_hpos' ) ) {
	function insurance_ancora_get_list_hpos($prepend_inherit=false, $center=false) {
		$list = array();
		$list['left'] = esc_html__("Left", 'insurance-ancora');
		if ($center) $list['center'] = esc_html__("Center", 'insurance-ancora');
		$list['right'] = esc_html__("Right", 'insurance-ancora');
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}

// Return list with vertical positions
if ( !function_exists( 'insurance_ancora_get_list_vpos' ) ) {
	function insurance_ancora_get_list_vpos($prepend_inherit=false, $center=false) {
		$list = array();
		$list['top'] = esc_html__("Top", 'insurance-ancora');
		if ($center) $list['center'] = esc_html__("Center", 'insurance-ancora');
		$list['bottom'] = esc_html__("Bottom", 'insurance-ancora');
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}

// Return sorting list items
if ( !function_exists( 'insurance_ancora_get_list_sortings' ) ) {
	function insurance_ancora_get_list_sortings($prepend_inherit=false) {
		if (($list = insurance_ancora_storage_get('list_sortings'))=='') {
			$list = array(
				"date" => esc_html__("Date", 'insurance-ancora'),
				"title" => esc_html__("Alphabetically", 'insurance-ancora'),
				"views" => esc_html__("Popular (views count)", 'insurance-ancora'),
				"comments" => esc_html__("Most commented (comments count)", 'insurance-ancora'),
				"author_rating" => esc_html__("Author rating", 'insurance-ancora'),
				"users_rating" => esc_html__("Visitors (users) rating", 'insurance-ancora'),
				"random" => esc_html__("Random", 'insurance-ancora')
			);
			$list = apply_filters('insurance_ancora_filter_list_sortings', $list);
			if (insurance_ancora_get_theme_setting('use_list_cache')) insurance_ancora_storage_set('list_sortings', $list);
		}
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}

// Return list with columns widths
if ( !function_exists( 'insurance_ancora_get_list_columns' ) ) {
	function insurance_ancora_get_list_columns($prepend_inherit=false) {
		if (($list = insurance_ancora_storage_get('list_columns'))=='') {
			$list = array(
				"none" => esc_html__("None", 'insurance-ancora'),
				"1_1" => esc_html__("100%", 'insurance-ancora'),
				"1_2" => esc_html__("1/2", 'insurance-ancora'),
				"1_3" => esc_html__("1/3", 'insurance-ancora'),
				"2_3" => esc_html__("2/3", 'insurance-ancora'),
				"1_4" => esc_html__("1/4", 'insurance-ancora'),
				"3_4" => esc_html__("3/4", 'insurance-ancora'),
				"1_5" => esc_html__("1/5", 'insurance-ancora'),
				"2_5" => esc_html__("2/5", 'insurance-ancora'),
				"3_5" => esc_html__("3/5", 'insurance-ancora'),
				"4_5" => esc_html__("4/5", 'insurance-ancora'),
				"1_6" => esc_html__("1/6", 'insurance-ancora'),
				"5_6" => esc_html__("5/6", 'insurance-ancora'),
				"1_7" => esc_html__("1/7", 'insurance-ancora'),
				"2_7" => esc_html__("2/7", 'insurance-ancora'),
				"3_7" => esc_html__("3/7", 'insurance-ancora'),
				"4_7" => esc_html__("4/7", 'insurance-ancora'),
				"5_7" => esc_html__("5/7", 'insurance-ancora'),
				"6_7" => esc_html__("6/7", 'insurance-ancora'),
				"1_8" => esc_html__("1/8", 'insurance-ancora'),
				"3_8" => esc_html__("3/8", 'insurance-ancora'),
				"5_8" => esc_html__("5/8", 'insurance-ancora'),
				"7_8" => esc_html__("7/8", 'insurance-ancora'),
				"1_9" => esc_html__("1/9", 'insurance-ancora'),
				"2_9" => esc_html__("2/9", 'insurance-ancora'),
				"4_9" => esc_html__("4/9", 'insurance-ancora'),
				"5_9" => esc_html__("5/9", 'insurance-ancora'),
				"7_9" => esc_html__("7/9", 'insurance-ancora'),
				"8_9" => esc_html__("8/9", 'insurance-ancora'),
				"1_10"=> esc_html__("1/10", 'insurance-ancora'),
				"3_10"=> esc_html__("3/10", 'insurance-ancora'),
				"7_10"=> esc_html__("7/10", 'insurance-ancora'),
				"9_10"=> esc_html__("9/10", 'insurance-ancora'),
				"1_11"=> esc_html__("1/11", 'insurance-ancora'),
				"2_11"=> esc_html__("2/11", 'insurance-ancora'),
				"3_11"=> esc_html__("3/11", 'insurance-ancora'),
				"4_11"=> esc_html__("4/11", 'insurance-ancora'),
				"5_11"=> esc_html__("5/11", 'insurance-ancora'),
				"6_11"=> esc_html__("6/11", 'insurance-ancora'),
				"7_11"=> esc_html__("7/11", 'insurance-ancora'),
				"8_11"=> esc_html__("8/11", 'insurance-ancora'),
				"9_11"=> esc_html__("9/11", 'insurance-ancora'),
				"10_11"=> esc_html__("10/11", 'insurance-ancora'),
				"1_12"=> esc_html__("1/12", 'insurance-ancora'),
				"5_12"=> esc_html__("5/12", 'insurance-ancora'),
				"7_12"=> esc_html__("7/12", 'insurance-ancora'),
				"10_12"=> esc_html__("10/12", 'insurance-ancora'),
				"11_12"=> esc_html__("11/12", 'insurance-ancora')
			);
			$list = apply_filters('insurance_ancora_filter_list_columns', $list);
			if (insurance_ancora_get_theme_setting('use_list_cache')) insurance_ancora_storage_set('list_columns', $list);
		}
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}

// Return list of locations for the dedicated content
if ( !function_exists( 'insurance_ancora_get_list_dedicated_locations' ) ) {
	function insurance_ancora_get_list_dedicated_locations($prepend_inherit=false) {
		if (($list = insurance_ancora_storage_get('list_dedicated_locations'))=='') {
			$list = array(
				"default" => esc_html__('As in the post defined', 'insurance-ancora'),
				"center"  => esc_html__('Above the text of the post', 'insurance-ancora'),
				"left"    => esc_html__('To the left the text of the post', 'insurance-ancora'),
				"right"   => esc_html__('To the right the text of the post', 'insurance-ancora'),
				"alter"   => esc_html__('Alternates for each post', 'insurance-ancora')
			);
			$list = apply_filters('insurance_ancora_filter_list_dedicated_locations', $list);
			if (insurance_ancora_get_theme_setting('use_list_cache')) insurance_ancora_storage_set('list_dedicated_locations', $list);
		}
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}

// Return post-format name
if ( !function_exists( 'insurance_ancora_get_post_format_name' ) ) {
	function insurance_ancora_get_post_format_name($format, $single=true) {
		$name = '';
		if ($format=='gallery')		$name = $single ? esc_html__('gallery', 'insurance-ancora') : esc_html__('galleries', 'insurance-ancora');
		else if ($format=='video')	$name = $single ? esc_html__('video', 'insurance-ancora') : esc_html__('videos', 'insurance-ancora');
		else if ($format=='audio')	$name = $single ? esc_html__('audio', 'insurance-ancora') : esc_html__('audios', 'insurance-ancora');
		else if ($format=='image')	$name = $single ? esc_html__('image', 'insurance-ancora') : esc_html__('images', 'insurance-ancora');
		else if ($format=='quote')	$name = $single ? esc_html__('quote', 'insurance-ancora') : esc_html__('quotes', 'insurance-ancora');
		else if ($format=='link')	$name = $single ? esc_html__('link', 'insurance-ancora') : esc_html__('links', 'insurance-ancora');
		else if ($format=='status')	$name = $single ? esc_html__('status', 'insurance-ancora') : esc_html__('statuses', 'insurance-ancora');
		else if ($format=='aside')	$name = $single ? esc_html__('aside', 'insurance-ancora') : esc_html__('asides', 'insurance-ancora');
		else if ($format=='chat')	$name = $single ? esc_html__('chat', 'insurance-ancora') : esc_html__('chats', 'insurance-ancora');
		else						$name = $single ? esc_html__('standard', 'insurance-ancora') : esc_html__('standards', 'insurance-ancora');
		return apply_filters('insurance_ancora_filter_list_post_format_name', $name, $format);
	}
}

// Return post-format icon name (from Fontello library)
if ( !function_exists( 'insurance_ancora_get_post_format_icon' ) ) {
	function insurance_ancora_get_post_format_icon($format) {
		$icon = 'icon-';
		if ($format=='gallery')		$icon .= 'pictures';
		else if ($format=='video')	$icon .= 'video';
		else if ($format=='audio')	$icon .= 'note';
		else if ($format=='image')	$icon .= 'picture';
		else if ($format=='quote')	$icon .= 'quote';
		else if ($format=='link')	$icon .= 'link';
		else if ($format=='status')	$icon .= 'comment';
		else if ($format=='aside')	$icon .= 'doc-text';
		else if ($format=='chat')	$icon .= 'chat';
		else						$icon .= 'book-open';
		return apply_filters('insurance_ancora_filter_list_post_format_icon', $icon, $format);
	}
}

// Return fonts styles list, prepended inherit
if ( !function_exists( 'insurance_ancora_get_list_fonts_styles' ) ) {
	function insurance_ancora_get_list_fonts_styles($prepend_inherit=false) {
		if (($list = insurance_ancora_storage_get('list_fonts_styles'))=='') {
			$list = array(
				'i' => esc_html__('I','insurance-ancora'),
				'u' => esc_html__('U', 'insurance-ancora')
			);
			if (insurance_ancora_get_theme_setting('use_list_cache')) insurance_ancora_storage_set('list_fonts_styles', $list);
		}
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}

// Return Google fonts list
if ( !function_exists( 'insurance_ancora_get_list_fonts' ) ) {
	function insurance_ancora_get_list_fonts($prepend_inherit=false) {
		if (($list = insurance_ancora_storage_get('list_fonts'))=='') {
			$list = array();
			$list = insurance_ancora_array_merge($list, insurance_ancora_get_list_font_faces());
			// Google and custom fonts list:
			
			
			
			
			
			$list = insurance_ancora_array_merge($list, array(
				'Advent Pro' => array('family'=>'sans-serif'),
				'Alegreya Sans' => array('family'=>'sans-serif'),
				'Arimo' => array('family'=>'sans-serif'),
				'Asap' => array('family'=>'sans-serif'),
				'Averia Sans Libre' => array('family'=>'cursive'),
				'Averia Serif Libre' => array('family'=>'cursive'),
				'Bree Serif' => array('family'=>'serif',),
				'Cabin' => array('family'=>'sans-serif'),
				'Cabin Condensed' => array('family'=>'sans-serif'),
				'Caudex' => array('family'=>'serif'),
				'Comfortaa' => array('family'=>'cursive'),
				'Cousine' => array('family'=>'sans-serif'),
				'Crimson Text' => array('family'=>'serif'),
				'Cuprum' => array('family'=>'sans-serif'),
				'Dosis' => array('family'=>'sans-serif'),
				'Economica' => array('family'=>'sans-serif'),
				'Exo' => array('family'=>'sans-serif'),
				'Expletus Sans' => array('family'=>'cursive'),
				'Karla' => array('family'=>'sans-serif'),
				'Lato' => array('family'=>'sans-serif'),
				'Lekton' => array('family'=>'sans-serif'),
				'Lobster Two' => array('family'=>'cursive'),
				'Maven Pro' => array('family'=>'sans-serif'),
				'Merriweather' => array('family'=>'serif'),
				'Montserrat' => array('family'=>'sans-serif'),
				'Neuton' => array('family'=>'serif'),
				'Noticia Text' => array('family'=>'serif'),
				'Old Standard TT' => array('family'=>'serif'),
				'Open Sans' => array('family'=>'sans-serif'),
				'Orbitron' => array('family'=>'sans-serif'),
				'Oswald' => array('family'=>'sans-serif'),
				'Overlock' => array('family'=>'cursive'),
				'Oxygen' => array('family'=>'sans-serif'),
				'Philosopher' => array('family'=>'serif'),
				'PT Serif' => array('family'=>'serif'),
				'Puritan' => array('family'=>'sans-serif'),
				'Raleway' => array('family'=>'sans-serif'),
				'Roboto' => array('family'=>'sans-serif'),
				'Roboto Slab' => array('family'=>'sans-serif'),
				'Roboto Condensed' => array('family'=>'sans-serif'),
				'Rosario' => array('family'=>'sans-serif'),
				'Share' => array('family'=>'cursive'),
				'Signika' => array('family'=>'sans-serif'),
				'Signika Negative' => array('family'=>'sans-serif'),
				'Source Sans Pro' => array('family'=>'sans-serif'),
				'Tinos' => array('family'=>'serif'),
				'Ubuntu' => array('family'=>'sans-serif'),
				'Vollkorn' => array('family'=>'serif')
				)
			);
			$list = apply_filters('insurance_ancora_filter_list_fonts', $list);
			if (insurance_ancora_get_theme_setting('use_list_cache')) insurance_ancora_storage_set('list_fonts', $list);
		}
		return $prepend_inherit ? insurance_ancora_array_merge(array('inherit' => esc_html__("Inherit", 'insurance-ancora')), $list) : $list;
	}
}


// Return Custom font-face list
if ( !function_exists( 'insurance_ancora_get_list_font_faces' ) ) {
function insurance_ancora_get_list_font_faces($prepend_inherit=false) {
    static $list = false;
    if (is_array($list)) return $list;
    $list = array();
    $dir = insurance_ancora_get_folder_dir("css/font-face");
    if ( is_dir($dir) ) {
        $files = glob(sprintf("%s/*", $dir), GLOB_ONLYDIR);
        if ( is_array($files) ) {
            foreach ($files as $file) {
                $file_name = basename($file);
                if ( substr($file_name, 0, 1) == '.' || ! is_dir( ($dir) . '/' . ($file_name) ) )
                    continue;
                $css = file_exists( ($dir) . '/' . ($file_name) . '/' . ($file_name) . '.css' )
                    ? insurance_ancora_get_file_url("css/font-face/".($file_name).'/'.($file_name).'.css')
                    : (file_exists( ($dir) . '/' . ($file_name) . '/stylesheet.css' )
                        ? insurance_ancora_get_file_url("css/font-face/".($file_name).'/stylesheet.css')
                        : '');
                if ($css != '')
                    $list[$file_name.' ('.__('uploaded font', 'insurance-ancora').')'] = array('css' => $css);
            }
        }
    }
    return $list;
}
}
?>