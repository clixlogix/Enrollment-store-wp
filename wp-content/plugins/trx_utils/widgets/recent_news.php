<?php
/**
 * Theme Widget: Recent posts
 */

// Theme init
if (!function_exists('insurance_ancora_widget_recent_news_theme_setup')) {
	add_action( 'insurance_ancora_action_before_init_theme', 'insurance_ancora_widget_recent_news_theme_setup', 1 );
	function insurance_ancora_widget_recent_news_theme_setup() {

		// Register shortcodes in the shortcodes list
		if (function_exists('insurance_ancora_exists_visual_composer') && insurance_ancora_exists_visual_composer())
			add_action('insurance_ancora_action_shortcodes_list_vc','insurance_ancora_widget_recent_news_reg_shortcodes_vc');
	}
}

// Load widget
if (!function_exists('insurance_ancora_widget_recent_news_load')) {
	add_action( 'widgets_init', 'insurance_ancora_widget_recent_news_load' );
	function insurance_ancora_widget_recent_news_load() {
		register_widget('insurance_ancora_widget_recent_news');
	}
}


// Widget Class
class insurance_ancora_widget_recent_news extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'widget_recent_news', 'description' => esc_html__('Show recent news in many styles', 'trx_utils'));
		parent::__construct( 'insurance_ancora_widget_recent_news', esc_html__('Insurance - Recent News', 'trx_utils'), $widget_ops );
	}

	// Show widget
	function widget($args, $instance) {
		extract($args);

		$widget_title = apply_filters('widget_title', isset($instance['widget_title']) ? $instance['widget_title'] : '');

		$output = insurance_ancora_sc_recent_news( array(
			'from_widget'		=> true,
			'title' 			=> isset($instance['title']) ? $instance['title'] : '',
			'subtitle'			=> isset($instance['subtitle']) ? $instance['subtitle'] : '',
			'style'				=> isset($instance['style']) ? $instance['style'] : 'news-excerpt',
			'count'				=> isset($instance['count']) ? (int) $instance['count'] : 3,
			'featured'			=> isset($instance['featured']) ? (int) $instance['featured'] : 0,
			'columns'			=> isset($instance['columns']) ? (int) $instance['columns'] : 1,
			'category'			=> isset($instance['category']) ? (int) $instance['category'] : 0,
			'post_type'			=> isset($instance['post_type']) ? $instance['post_type'] : 'post',
			'show_counters'		=> isset($instance['show_counters']) ? (int) $instance['show_counters'] : 1,
			'show_categories'	=> isset($instance['show_categories']) ? (int) $instance['show_categories'] : 1
			)
		);

		if (!empty($output)) {
	
			// Before widget (defined by themes)
			insurance_ancora_show_layout($before_widget);
			
			// Display the widget title if one was input (before and after defined by themes)
			if ($widget_title) insurance_ancora_show_layout($title, $before_title, $after_title);
	
			// Display widget body
			insurance_ancora_show_layout($output);
			
			// After widget (defined by themes)
			insurance_ancora_show_layout($after_widget);
		}
	}

	// Update the widget settings
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['widget_title']	= strip_tags($new_instance['widget_title']);
		$instance['title']			= strip_tags($new_instance['title']);
		$instance['subtitle']		= strip_tags($new_instance['subtitle']);
		$instance['style']			= strip_tags($new_instance['style']);
		$instance['count']			= max(1, (int) $new_instance['count']);
		$instance['featured']		= max(0, min($instance['count'], (int) $new_instance['featured']));
		$instance['columns']		= max(1, min($instance['featured']+1, (int) $new_instance['columns']));		//	Columns <= Featured+1
		$instance['category']		= max(0, (int) $new_instance['category']);
		$instance['post_type'] 		= strip_tags($new_instance['post_type']);
		$instance['show_counters']	= (int) $new_instance['show_counters'] > 0 ? 1 : 0;
		$instance['show_categories']= (int) $new_instance['show_categories'] > 0 ? 1 : 0;
		return $instance;
	}

	// Displays the widget settings controls on the widget panel
	function form($instance) {

		// Set up some default widget settings
		$instance = wp_parse_args( (array) $instance, array(
			'widget_title' => '',
			'title' => '',
			'subtitle' => '',
			'style' => '',
			'count' => 3,
			'featured' => 0,
			'columns' => 1,
			'category' => 0,
			'post_type' => 'post',
			'show_counters' => 1,
			'show_categories' => 1
			)
		);
		$widget_title = $instance['widget_title'];
		$title = $instance['title'];
		$subtitle = $instance['subtitle'];
		$style = $instance['style'];
		$count = (int) $instance['count'];
		$featured = (int) $instance['featured'];
		$columns = (int) $instance['columns'];
		$post_type = $instance['post_type'];
		$category = (int) $instance['category'];
		$show_counters = (int) $instance['show_counters'] > 0 ? 1 : 0;
		$show_categories = (int) $instance['show_categories'] > 0 ? 1 : 0;

		$posts_types = insurance_ancora_get_list_posts_types(false);
		$categories = insurance_ancora_get_list_terms(false, insurance_ancora_get_taxonomy_categories_by_post_type($post_type));
		$news_styles = insurance_ancora_get_list_templates('news');
		?>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('widget_title')); ?>"><?php esc_html_e('Widget title:', 'trx_utils'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id('widget_title')); ?>" name="<?php echo esc_attr($this->get_field_name('widget_title')); ?>" value="<?php echo esc_attr($widget_title); ?>" class="widgets_param_fullwidth" />
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Block title:', 'trx_utils'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($title); ?>" class="widgets_param_fullwidth" />
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('subtitle')); ?>"><?php esc_html_e('Block subtitle:', 'trx_utils'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id('subtitle')); ?>" name="<?php echo esc_attr($this->get_field_name('subtitle')); ?>" value="<?php echo esc_attr($subtitle); ?>" class="widgets_param_fullwidth" />
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('style')); ?>"><?php esc_html_e('Style:', 'trx_utils'); ?></label>
			<select id="<?php echo esc_attr($this->get_field_id('style')); ?>" name="<?php echo esc_attr($this->get_field_name('style')); ?>" class="widgets_param_fullwidth">
			<?php
				if (is_array($news_styles) && count($news_styles) > 0) {
					foreach ($news_styles as $slug => $name) {
						echo '<option value="'.esc_attr($slug).'"'.($slug==$style ? ' selected="selected"' : '').'>'.esc_html($name).'</option>';
					}
				}
			?>
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('post_type')); ?>"><?php esc_html_e('Post type:', 'trx_utils'); ?></label>
			<select id="<?php echo esc_attr($this->get_field_id('post_type')); ?>" name="<?php echo esc_attr($this->get_field_name('post_type')); ?>" class="widgets_param_fullwidth widgets_param_post_type_selector">
			<?php
				if (is_array($posts_types) && count($posts_types) > 0) {
					foreach ($posts_types as $type => $type_name) {
						echo '<option value="'.esc_attr($type).'"'.($post_type==$type ? ' selected="selected"' : '').'>'.esc_html($type_name).'</option>';
					}
				}
			?>
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('category')); ?>"><?php esc_html_e('Category:', 'trx_utils'); ?></label>
			<select id="<?php echo esc_attr($this->get_field_id('category')); ?>" name="<?php echo esc_attr($this->get_field_name('category')); ?>" class="widgets_param_fullwidth">
				<option value="0"><?php esc_html_e('-- Any category --', 'trx_utils'); ?></option> 
			<?php
				if (is_array($categories) && count($categories) > 0) {
					foreach ($categories as $cat_id => $cat_name) {
						echo '<option value="'.esc_attr($cat_id).'"'.($category==$cat_id ? ' selected="selected"' : '').'>'.esc_html($cat_name).'</option>';
					}
				}
			?>
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('count')); ?>"><?php esc_html_e('Number of posts to be displayed:', 'trx_utils'); ?></label>
			<input type="text" id="<?php echo esc_attr($this->get_field_id('count')); ?>" name="<?php echo esc_attr($this->get_field_name('count')); ?>" value="<?php echo esc_attr($count); ?>" class="widgets_param_fullwidth" />
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('featured')); ?>"><?php esc_html_e('Number of featured posts:', 'trx_utils'); ?></label>
			<input type="text" id="<?php echo esc_attr($this->get_field_id('featured')); ?>" name="<?php echo esc_attr($this->get_field_name('featured')); ?>" value="<?php echo esc_attr($featured); ?>" class="widgets_param_fullwidth" />
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('columns')); ?>"><?php esc_html_e('Number of columns:', 'trx_utils'); ?></label>
			<input type="text" id="<?php echo esc_attr($this->get_field_id('columns')); ?>" name="<?php echo esc_attr($this->get_field_name('columns')); ?>" value="<?php echo esc_attr($columns); ?>" class="widgets_param_fullwidth" />
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('show_categories')); ?>_1"><?php esc_html_e('Show categories:', 'trx_utils'); ?></label><br />
			<input type="radio" id="<?php echo esc_attr($this->get_field_id('show_categories')); ?>_2" name="<?php echo esc_attr($this->get_field_name('show_categories')); ?>" value="1" <?php echo (1==$show_categories ? ' checked="checked"' : ''); ?> />
			<label for="<?php echo esc_attr($this->get_field_id('show_categories')); ?>_1"><?php esc_html_e('Show', 'trx_utils'); ?></label>
			<input type="radio" id="<?php echo esc_attr($this->get_field_id('show_categories')); ?>_0" name="<?php echo esc_attr($this->get_field_name('show_categories')); ?>" value="0" <?php echo (0==$show_categories ? ' checked="checked"' : ''); ?> />
			<label for="<?php echo esc_attr($this->get_field_id('show_categories')); ?>_0"><?php esc_html_e('Hide', 'trx_utils'); ?></label>
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('show_counters')); ?>_1"><?php esc_html_e('Show counters:', 'trx_utils'); ?></label><br />
			<input type="radio" id="<?php echo esc_attr($this->get_field_id('show_counters')); ?>_2" name="<?php echo esc_attr($this->get_field_name('show_counters')); ?>" value="1" <?php echo (1==$show_counters ? ' checked="checked"' : ''); ?> />
			<label for="<?php echo esc_attr($this->get_field_id('show_counters')); ?>_1"><?php esc_html_e('Show', 'trx_utils'); ?></label>
			<input type="radio" id="<?php echo esc_attr($this->get_field_id('show_counters')); ?>_0" name="<?php echo esc_attr($this->get_field_name('show_counters')); ?>" value="0" <?php echo (0==$show_counters ? ' checked="checked"' : ''); ?> />
			<label for="<?php echo esc_attr($this->get_field_id('show_counters')); ?>_0"><?php esc_html_e('Hide', 'trx_utils'); ?></label>
		</p>

	<?php
	}
}



// trx_recent_news
//-------------------------------------------------------------
/*
[trx_recent_news id="unique_id" columns="2" count="5" featured="1" style="news-1" title="Block title" subtitle="xxx" category="id|slug" show_categories="yes|no" show_counters="yes|no"]
*/
if ( !function_exists( 'insurance_ancora_sc_recent_news' ) ) {
	function insurance_ancora_sc_recent_news($atts, $content=null){	
		if (insurance_ancora_in_shortcode_blogger(true)) return '';
		extract(insurance_ancora_html_decode(shortcode_atts(array(
			"from_widget" => false,		// true if this shortcode called from the widget
			// Individual params
			"style" => "news-magazine",
			"count" => 3,
			"featured" => 3,
			"columns" => 3,
			"ids" => "",
			"category" => '',
			"cat" => 0,
			'post_type'	=> 'post',
			"offset" => 0,
			"orderby" => "date",
			"order" => "desc",
			"widget_title" => "",
			"title" => "",
			"subtitle" => "",
			"scheme" => '',
			"show_categories" => "no",
			"show_counters" => "no",
			// Common params
			"id" => "",
			"class" => "",
			"animation" => "",
			"css" => "",
			"width" => "",
			"height" => "",
			"top" => "",
			"bottom" => "",
			"left" => "",
			"right" => ""
		), $atts)));

		insurance_ancora_storage_set('sc_blogger_busy', true);

		$class .= ($class ? ' ' : '') . insurance_ancora_get_css_position_as_classes($top, $right, $bottom, $left);
		$css .= insurance_ancora_get_css_dimensions_from_values($width, $height);
		
		if ($show_categories=='') $show_categories = 'no';
		if ($show_counters=='') $show_counters = 'no';

		if (!empty($ids)) {
			$posts = explode(',', $ids);
			$count = count($posts);
		}
		$count = max(1, (int) $count);
		$featured = max(0, min($count, (int) $featured));
		$columns = max(1, min(12, (int) $columns));
		if (in_array($style, array('news-announce', 'news-excerpt'))) $columns = 1;
		if ($featured > 0) $columns = min($featured+1, $columns);		// Columns <= Featured + 1

		if ($post_type=='') $post_type = 'post';
		if ($category=='' && $cat!='') $category = $cat;
		$category = max(0, (int) $category);
		$taxonomy = insurance_ancora_get_taxonomy_categories_by_post_type($post_type);

		// Get categories list
		if (insurance_ancora_param_is_on($show_categories)) {
			if ( !insurance_ancora_storage_isset('categories_'.$category) ) {
				insurance_ancora_storage_set('categories_'.$category, get_categories(array(
					'orderby' => 'name',
					'parent' => $category
					))
				);
			}
		}

		$output = '';
		
		// If insert with VC as widget
		if (empty($from_widget)) {
			$widget_args = insurance_ancora_prepare_widgets_args(insurance_ancora_storage_get('widgets_args'), $id ? $id.'_widget' : 'widget_recent_news', 'widget_recent_news');
			$output .= '<div' . ($id ? ' id="'.esc_attr($id).'"' : '')
							. ' class="widget_area sc_recent_news_wrap' 
								. (insurance_ancora_exists_visual_composer() ? ' vc_recent_news wpb_content_element' : '') 
								. ($scheme && !insurance_ancora_param_is_off($scheme) && !insurance_ancora_param_is_inherit($scheme) ? ' scheme_'.esc_attr($scheme) : '') 
						. '">'
							. $widget_args['before_widget']
							. (!empty($widget_title) ? $widget_args['before_title'] .esc_html($widget_title). $widget_args['after_title'] : '');
		}
		
		// Wrapper
		$output .= '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
						. ' class="sc_recent_news'
							. ' sc_recent_news_style_'.esc_attr($style)
							. ($featured > 0 ? ' sc_recent_news_with_accented' : ' sc_recent_news_without_accented')
							. (!empty($class) ? ' '.esc_attr($class) : '')
							. '"'
						. (!insurance_ancora_param_is_off($animation) ? ' data-animation="'.esc_attr(insurance_ancora_get_animation_classes($animation)).'"' : '')
						. ($css!='' ? ' style="'.esc_attr($css).'"' : '') 
					. '>';

		// Header
		if ( !empty($title) || !empty($subtitle) || (insurance_ancora_param_is_on($show_categories) && !insurance_ancora_storage_empty('categories_'.$category)) ) {
			$output	.= '<div class="sc_recent_news_header'.(insurance_ancora_param_is_on($show_categories) && !insurance_ancora_storage_empty('categories_'.$category) ? ' sc_recent_news_header_split' : '').'">'
							. ( !empty($title) || !empty($subtitle)
								? '<div class="sc_recent_news_header_captions">'
										. (!empty($title) ? '<h4 class="sc_recent_news_title">' . esc_html($title) . '</h4>' : '')
										. (!empty($subtitle) ? '<h6 class="sc_recent_news_subtitle">' . esc_html($subtitle) . '</h6>' : '')
									. '</div>'
								: '');

			// Categories list
			$cat_list = insurance_ancora_storage_get('categories_'.$category);
			if (insurance_ancora_param_is_on($show_categories) && !empty($cat_list)) {
				$output .= '<div class="sc_recent_news_header_categories">';
				if (is_array($cat_list) && count($cat_list) > 0) {
					$output .= '<a href="' . esc_url( $category == 0 
						? ( get_option('show_on_front')=='page' 
							? get_permalink(get_option('page_for_posts')) 
							: home_url('/')
							)
						: get_category_link($category) ) . '" class="sc_recent_news_header_category_item">'.esc_html__('All News', 'trx_utils').'</span>';
					$number = 0;
					$number_max = 3;
					foreach ($cat_list as $cat) {
						$number++;
						if ($number == $number_max)
							$output .= '<span class="sc_recent_news_header_category_item sc_recent_news_header_category_item_more">'.esc_html__('More', 'trx_utils')
										. '<span class="sc_recent_news_header_more_categories">';
						$output .= '<a href="'.esc_url(get_category_link( $cat->term_id )).'" class="sc_recent_news_header_category_item">'.esc_html($cat->name).'</a>';
					}
					if ($number >= $number_max)
						$output .= '</span></span>';
				}
				$output .= '</div>';
			}
	
			$output .= '</div><!-- /.sc_recent_news_header -->';
		}
		
		// Columns
		if ($columns > 1)
			$output .= '<div class="columns_wrap">';
	
		global $post;
	
		$args = array(
			'post_type' => $post_type,
			'post_status' => 'publish',
			'posts_per_page' => $count,
			'ignore_sticky_posts' => true,
			'order' => $order=='asc' ? 'asc' : 'desc'
		);
		
		if ($offset > 0 && empty($ids)) {
			$args['offset'] = $offset;
		}
		
		$args = insurance_ancora_query_add_sort_order($args, $orderby, $order);
		$args = insurance_ancora_query_add_posts_and_cats($args, $ids, $post_type, $category, $taxonomy);
		$query = new WP_Query( $args );
	
		$count = min($count, $query->found_posts);
		$featured = max(0, min($count, (int) $featured));
		$columns = max(1, min(12, (int) $columns));
		if (in_array($style, array('news-announce', 'news-excerpt'))) $columns = 1;
		if ($featured > 0) $columns = min($featured+1, $columns);		// Columns <= Featured + 1
		
		$post_number = 0;
				
		while ( $query->have_posts() ) { $query->the_post();
			$post_number++;
			$args = array(
				'layout' => $style,
				'show' => false,
				'number' => $post_number,
				'posts_on_page' => $count,
				'columns_count' => $columns,
				'featured' => $featured,
				'tag_id' => $id ? $id . '_' . $post_number : '',
				'tag_class' => '',
				'tag_animation' => '',
				'tag_css' => '',
				'show_counters' => $show_counters,
				'content' => false,
				'terms_list' => true
			);
			$output .= insurance_ancora_show_post_layout($args);
		}
		wp_reset_postdata();

		if ($columns > 1) $output .= '</div><!-- /.columns_wrap -->';

		$output .=  '</div><!-- /.sc_recent_news -->';

		if (empty($from_widget)) $output .=  $widget_args['after_widget'] . '</div><!-- /.sc_recent_news_wrap -->';
	
		// Add template specific scripts and styles
		do_action('insurance_ancora_action_blog_scripts', $style);

		insurance_ancora_storage_set('sc_blogger_busy', false);

		return apply_filters('insurance_ancora_shortcode_output', $output, 'trx_recent_news', $atts, $content);
	}
	add_shortcode("trx_recent_news", "insurance_ancora_sc_recent_news");
}


// Add [trx_recent_news] in the VC shortcodes list
if (!function_exists('insurance_ancora_widget_recent_news_reg_shortcodes_vc')) {
	function insurance_ancora_widget_recent_news_reg_shortcodes_vc() {
		
		$posts_types = insurance_ancora_get_list_posts_types(false);
		$categories = insurance_ancora_get_list_terms(false, insurance_ancora_get_taxonomy_categories_by_post_type('post'));
		$news_styles = insurance_ancora_get_list_templates('news');

		vc_map( array(
				"base" => "trx_recent_news",
				"name" => esc_html__("Recent News", 'trx_utils'),
				"description" => wp_kses_data( __("Insert recent news list", 'trx_utils') ),
				"category" => esc_html__('Content', 'trx_utils'),
				"icon" => 'icon_trx_recent_news',
				"class" => "trx_recent_news",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "style",
						"heading" => esc_html__("List style", 'trx_utils'),
						"description" => wp_kses_data( __("Select style to display news list", 'trx_utils') ),
						"class" => "",
						"admin_label" => true,
						"std" => 'news-magazine',
						"value" => array_flip($news_styles),
						"type" => "dropdown"
					),
					array(
						"param_name" => "scheme",
						"heading" => esc_html__("Color scheme", 'trx_utils'),
						"description" => wp_kses_data( __("Select color scheme for this block", 'trx_utils') ),
						"class" => "",
						"value" => array_flip((array)insurance_ancora_get_sc_param('schemes')),
						"type" => "dropdown"
					),
					array(
						"param_name" => "widget_title",
						"heading" => esc_html__("Widget Title", 'trx_utils'),
						"description" => wp_kses_data( __("Title for the widget (fill this field only if you want to use shortcode as widget)", 'trx_utils') ),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "title",
						"heading" => esc_html__("Title", 'trx_utils'),
						"description" => wp_kses_data( __("Title for the block", 'trx_utils') ),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "subtitle",
						"heading" => esc_html__("Subtitle", 'trx_utils'),
						"description" => wp_kses_data( __("Subtitle for the block", 'trx_utils') ),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "show_categories",
						"heading" => esc_html__("Show categories", 'trx_utils'),
						"description" => wp_kses_data( __("Show categories in the shortcode's header", 'trx_utils') ),
						"class" => "",
						"value" => array("Show categories" => "yes" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "show_counters",
						"heading" => esc_html__("Show counters", 'trx_utils'),
						"description" => wp_kses_data( __("Show counters (comments and views) in the shortcode's footer", 'trx_utils') ),
						'dependency' => array(
							'element' => 'style',
							'value' => 'news-magazine'
						),
						"class" => "",
						"value" => array("Show counters" => "yes" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "post_type",
						"heading" => esc_html__("Post type", 'trx_utils'),
						"description" => wp_kses_data( __("Select post type to show", 'trx_utils') ),
						"group" => esc_html__('Query', 'trx_utils'),
						"class" => "",
						"std" => "post",
						"value" => array_flip($posts_types),
						"type" => "dropdown"
					),
					array(
						"param_name" => "cat",
						"heading" => esc_html__("Category", 'trx_utils'),
						"description" => wp_kses_data( __("Select category to show news. If empty - select news from any category or from IDs list", 'trx_utils') ),
						"group" => esc_html__('Query', 'trx_utils'),
						"class" => "",
						"value" => array_flip((array)insurance_ancora_array_merge(array(0 => esc_html__('- Select category -', 'trx_utils')), $categories)),
						"type" => "dropdown"
					),
					array(
						"param_name" => "count",
						"heading" => esc_html__("Total posts", 'trx_utils'),
						"description" => wp_kses_data( __("How many posts will be displayed? If used IDs - this parameter ignored.", 'trx_utils') ),
						"admin_label" => true,
						"group" => esc_html__('Query', 'trx_utils'),
						"class" => "",
						"value" => "3",
						"type" => "textfield"
					),
					array(
						"param_name" => "featured",
						"heading" => esc_html__("Featured posts", 'trx_utils'),
						"description" => wp_kses_data( __("How many posts will be displayed as featured?", 'trx_utils') ),
						"admin_label" => true,
						"group" => esc_html__('Query', 'trx_utils'),
						'dependency' => array(
							'element' => 'style',
							'value' => 'news-magazine'
						),
						"class" => "",
						"value" => "3",
						"type" => "textfield"
					),
					array(
						"param_name" => "columns",
						"heading" => esc_html__("Columns", 'trx_utils'),
						"description" => wp_kses_data( __("How many columns use to show news list", 'trx_utils') ),
						"group" => esc_html__('Query', 'trx_utils'),
						"admin_label" => true,
						'dependency' => array(
							'element' => 'style',
							'value' => array('news-magazine', 'news-portfolio'),
						),
						"class" => "",
						"value" => "3",
						"type" => "textfield"
					),
					array(
						"param_name" => "offset",
						"heading" => esc_html__("Offset before select posts", 'trx_utils'),
						"description" => wp_kses_data( __("Skip posts before select next part.", 'trx_utils') ),
						"group" => esc_html__('Query', 'trx_utils'),
						"class" => "",
						"value" => "0",
						"type" => "textfield"
					),
					array(
						"param_name" => "orderby",
						"heading" => esc_html__("Post sorting", 'trx_utils'),
						"description" => wp_kses_data( __("Select desired posts sorting method", 'trx_utils') ),
						"group" => esc_html__('Query', 'trx_utils'),
						"class" => "",
						"value" => array_flip((array)insurance_ancora_get_list_sortings()),
						"type" => "dropdown"
					),
					array(
						"param_name" => "order",
						"heading" => esc_html__("Post order", 'trx_utils'),
						"description" => wp_kses_data( __("Select desired posts order", 'trx_utils') ),
						"group" => esc_html__('Query', 'trx_utils'),
						"class" => "",
						"value" => array_flip((array)insurance_ancora_get_list_orderings()),
						"type" => "dropdown"
					),
					array(
						"param_name" => "ids",
						"heading" => esc_html__("List IDs", 'trx_utils'),
						"description" => wp_kses_data( __("Comma separated list of post's ID. If set - parameters above (category, count, order, etc.) are ignored!", 'trx_utils') ),
						"group" => esc_html__('Query', 'trx_utils'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					insurance_ancora_get_vc_param('id'),
					insurance_ancora_get_vc_param('class'),
					insurance_ancora_get_vc_param('animation'),
					insurance_ancora_get_vc_param('css'),
					insurance_ancora_vc_width(),
					insurance_ancora_vc_height(),
					insurance_ancora_get_vc_param('margin_top'),
					insurance_ancora_get_vc_param('margin_bottom'),
					insurance_ancora_get_vc_param('margin_left'),
					insurance_ancora_get_vc_param('margin_right')
				)
			) );
			
		class WPBakeryShortCode_Trx_Recent_News extends WPBakeryShortCode {}

	}
}
?>