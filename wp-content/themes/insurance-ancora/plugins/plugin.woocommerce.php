<?php
/* Woocommerce support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('insurance_ancora_woocommerce_theme_setup')) {
	add_action( 'insurance_ancora_action_before_init_theme', 'insurance_ancora_woocommerce_theme_setup', 1 );
	function insurance_ancora_woocommerce_theme_setup() {

		if (insurance_ancora_exists_woocommerce()) {
			
			add_theme_support( 'woocommerce' );
			// Next setting from the WooCommerce 3.0+ enable built-in image zoom on the single product page
			add_theme_support( 'wc-product-gallery-zoom' );
			// Next setting from the WooCommerce 3.0+ enable built-in image slider on the single product page
			add_theme_support( 'wc-product-gallery-slider' );
			// Next setting from the WooCommerce 3.0+ enable built-in image lightbox on the single product page
			add_theme_support( 'wc-product-gallery-lightbox' );
			
			add_action('insurance_ancora_action_add_styles', 				'insurance_ancora_woocommerce_frontend_scripts' );

			// Detect current page type, taxonomy and title (for custom post_types use priority < 10 to fire it handles early, than for standard post types)
			add_filter('insurance_ancora_filter_get_blog_type',				'insurance_ancora_woocommerce_get_blog_type', 9, 2);
			add_filter('insurance_ancora_filter_get_blog_title',			'insurance_ancora_woocommerce_get_blog_title', 9, 2);
			add_filter('insurance_ancora_filter_get_current_taxonomy',		'insurance_ancora_woocommerce_get_current_taxonomy', 9, 2);
			add_filter('insurance_ancora_filter_is_taxonomy',				'insurance_ancora_woocommerce_is_taxonomy', 9, 2);
			add_filter('insurance_ancora_filter_get_stream_page_title',		'insurance_ancora_woocommerce_get_stream_page_title', 9, 2);
			add_filter('insurance_ancora_filter_get_stream_page_link',		'insurance_ancora_woocommerce_get_stream_page_link', 9, 2);
			add_filter('insurance_ancora_filter_get_stream_page_id',		'insurance_ancora_woocommerce_get_stream_page_id', 9, 2);
			add_filter('insurance_ancora_filter_detect_inheritance_key',	'insurance_ancora_woocommerce_detect_inheritance_key', 9, 1);
			add_filter('insurance_ancora_filter_detect_template_page_id',	'insurance_ancora_woocommerce_detect_template_page_id', 9, 2);
			add_filter('insurance_ancora_filter_orderby_need',				'insurance_ancora_woocommerce_orderby_need', 9, 2);

			add_filter('insurance_ancora_filter_show_post_navi', 			'insurance_ancora_woocommerce_show_post_navi');
			add_filter('insurance_ancora_filter_list_post_types', 			'insurance_ancora_woocommerce_list_post_types');

			add_action('insurance_ancora_action_shortcodes_list', 			'insurance_ancora_woocommerce_reg_shortcodes', 20);
			if (function_exists('insurance_ancora_exists_visual_composer') && insurance_ancora_exists_visual_composer())
				add_action('insurance_ancora_action_shortcodes_list_vc',	'insurance_ancora_woocommerce_reg_shortcodes_vc', 20);

			if (is_admin()) {
				add_filter( 'insurance_ancora_filter_importer_options',				'insurance_ancora_woocommerce_importer_set_options' );
				add_action( 'insurance_ancora_action_importer_after_import_posts',	'insurance_ancora_woocommerce_importer_after_import_posts', 10, 1 );
				add_action( 'insurance_ancora_action_importer_params',				'insurance_ancora_woocommerce_importer_show_params', 10, 1 );
				add_action( 'insurance_ancora_action_importer_import',				'insurance_ancora_woocommerce_importer_import', 10, 2 );
				add_action( 'insurance_ancora_action_importer_import_fields',		'insurance_ancora_woocommerce_importer_import_fields', 10, 1 );
				add_action( 'insurance_ancora_action_importer_export',				'insurance_ancora_woocommerce_importer_export', 10, 1 );
				add_action( 'insurance_ancora_action_importer_export_fields',		'insurance_ancora_woocommerce_importer_export_fields', 10, 1 );
			}
		}

		if (is_admin()) {
			add_filter( 'insurance_ancora_filter_importer_required_plugins',		'insurance_ancora_woocommerce_importer_required_plugins', 10, 2 );
			add_filter( 'insurance_ancora_filter_required_plugins',					'insurance_ancora_woocommerce_required_plugins' );
		}
	}
}

if ( !function_exists( 'insurance_ancora_woocommerce_settings_theme_setup2' ) ) {
	add_action( 'insurance_ancora_action_before_init_theme', 'insurance_ancora_woocommerce_settings_theme_setup2', 3 );
	function insurance_ancora_woocommerce_settings_theme_setup2() {
		if (insurance_ancora_exists_woocommerce()) {
			// Add WooCommerce pages in the Theme inheritance system
			insurance_ancora_add_theme_inheritance( array( 'woocommerce' => array(
				'stream_template' => 'blog-woocommerce',		// This params must be empty
				'single_template' => 'single-woocommerce',		// They are specified to enable separate settings for blog and single wooc
				'taxonomy' => array('product_cat'),
				'taxonomy_tags' => array('product_tag'),
				'post_type' => array('product'),
				'override' => 'page'
				) )
			);

			// Add WooCommerce specific options in the Theme Options

			insurance_ancora_storage_set_array_before('options', 'partition_service', array(
				
				"partition_woocommerce" => array(
					"title" => esc_html__('WooCommerce', 'insurance-ancora'),
					"icon" => "iconadmin-basket",
					"type" => "partition"),

				"info_wooc_1" => array(
					"title" => esc_html__('WooCommerce products list parameters', 'insurance-ancora'),
					"desc" => esc_html__("Select WooCommerce products list's style and crop parameters", 'insurance-ancora'),
					"type" => "info"),
		
				"shop_mode" => array(
					"title" => esc_html__('Shop list style',  'insurance-ancora'),
					"desc" => esc_html__("WooCommerce products list's style: thumbs or list with description", 'insurance-ancora'),
					"std" => "thumbs",
					"divider" => false,
					"options" => array(
						'thumbs' => esc_html__('Thumbs', 'insurance-ancora'),
						'list' => esc_html__('List', 'insurance-ancora')
					),
					"type" => "checklist"),
		
				"show_mode_buttons" => array(
					"title" => esc_html__('Show style buttons',  'insurance-ancora'),
					"desc" => esc_html__("Show buttons to allow visitors change list style", 'insurance-ancora'),
					"std" => "yes",
					"options" => insurance_ancora_get_options_param('list_yes_no'),
					"type" => "switch"),

				"shop_loop_columns" => array(
					"title" => esc_html__('Shop columns',  'insurance-ancora'),
					"desc" => esc_html__("How many columns used to show products on shop page", 'insurance-ancora'),
					"std" => "3",
					"step" => 1,
					"min" => 1,
					"max" => 6,
					"type" => "spinner"),

				"show_currency" => array(
					"title" => esc_html__('Show currency selector', 'insurance-ancora'),
					"desc" => esc_html__('Show currency selector in the user menu', 'insurance-ancora'),
					"std" => "yes",
					"options" => insurance_ancora_get_options_param('list_yes_no'),
					"type" => "switch"),
		
				"show_cart" => array(
					"title" => esc_html__('Show cart button', 'insurance-ancora'),
					"desc" => esc_html__('Show cart button in the user menu', 'insurance-ancora'),
					"std" => "shop",
					"options" => array(
						'hide'   => esc_html__('Hide', 'insurance-ancora'),
						'always' => esc_html__('Always', 'insurance-ancora'),
						'shop'   => esc_html__('Only on shop pages', 'insurance-ancora')
					),
					"type" => "checklist"),

				"crop_product_thumb" => array(
					"title" => esc_html__("Crop product's thumbnail",  'insurance-ancora'),
					"desc" => esc_html__("Crop product's thumbnails on search results page or scale it", 'insurance-ancora'),
					"std" => "no",
					"options" => insurance_ancora_get_options_param('list_yes_no'),
					"type" => "switch")
				
				)
			);

		}
	}
}

// WooCommerce hooks
if (!function_exists('insurance_ancora_woocommerce_theme_setup3')) {
	add_action( 'insurance_ancora_action_after_init_theme', 'insurance_ancora_woocommerce_theme_setup3' );
	function insurance_ancora_woocommerce_theme_setup3() {

		if (insurance_ancora_exists_woocommerce()) {

			add_action(    'woocommerce_before_subcategory_title',		'insurance_ancora_woocommerce_open_thumb_wrapper', 9 );
			add_action(    'woocommerce_before_shop_loop_item_title',	'insurance_ancora_woocommerce_open_thumb_wrapper', 9 );

			add_action(    'woocommerce_before_subcategory_title',		'insurance_ancora_woocommerce_open_item_wrapper', 20 );
			add_action(    'woocommerce_before_shop_loop_item_title',	'insurance_ancora_woocommerce_open_item_wrapper', 20 );

			add_action(    'woocommerce_after_subcategory',				'insurance_ancora_woocommerce_close_item_wrapper', 20 );
			add_action(    'woocommerce_after_shop_loop_item',			'insurance_ancora_woocommerce_close_item_wrapper', 20 );

			add_action(    'woocommerce_after_shop_loop_item_title',	'insurance_ancora_woocommerce_after_shop_loop_item_title', 7);

			add_action(    'woocommerce_after_subcategory_title',		'insurance_ancora_woocommerce_after_subcategory_title', 10 );

			add_action(    'the_title',									'insurance_ancora_woocommerce_the_title');

			// Wrap category title into link
			add_action(		'woocommerce_shop_loop_subcategory_title',  'insurance_ancora_woocommerce_shop_loop_subcategory_title', 9, 1);

			// Remove link around product item
			remove_action('woocommerce_before_shop_loop_item',			'woocommerce_template_loop_product_link_open', 10);
			remove_action('woocommerce_after_shop_loop_item',			'woocommerce_template_loop_product_link_close', 5);
			// Remove link around product category
			remove_action('woocommerce_before_subcategory',				'woocommerce_template_loop_category_link_open', 10);
			remove_action('woocommerce_after_subcategory',				'woocommerce_template_loop_category_link_close', 10);
            // Replace product item title tag from h2 to h3
            remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
            add_action( 'woocommerce_shop_loop_item_title',    'tennisclub_woocommerce_template_loop_product_title', 10 );
		}

		if (insurance_ancora_is_woocommerce_page()) {
			
			remove_action( 'woocommerce_sidebar', 						'woocommerce_get_sidebar', 10 );					// Remove WOOC sidebar
			
			remove_action( 'woocommerce_before_main_content',			'woocommerce_output_content_wrapper', 10);
			add_action(    'woocommerce_before_main_content',			'insurance_ancora_woocommerce_wrapper_start', 10);
			
			remove_action( 'woocommerce_after_main_content',			'woocommerce_output_content_wrapper_end', 10);		
			add_action(    'woocommerce_after_main_content',			'insurance_ancora_woocommerce_wrapper_end', 10);

			add_action(    'woocommerce_show_page_title',				'insurance_ancora_woocommerce_show_page_title', 10);

			remove_action( 'woocommerce_single_product_summary',		'woocommerce_template_single_title', 5);		
			add_action(    'woocommerce_single_product_summary',		'insurance_ancora_woocommerce_show_product_title', 5 );

			add_action(    'woocommerce_before_shop_loop', 				'insurance_ancora_woocommerce_before_shop_loop', 10 );

			remove_action( 'woocommerce_after_shop_loop',				'woocommerce_pagination', 10 );
			add_action(    'woocommerce_after_shop_loop',				'insurance_ancora_woocommerce_pagination', 10 );

			add_action(    'woocommerce_product_meta_end',				'insurance_ancora_woocommerce_show_product_id', 10);

            if (insurance_ancora_param_is_on(insurance_ancora_get_custom_option('show_post_related'))) {
                add_filter('woocommerce_output_related_products_args', 'insurance_ancora_woocommerce_output_related_products_args');
                add_filter('woocommerce_related_products_args', 'insurance_ancora_woocommerce_related_products_args');
            } else {
                remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
            }

			add_filter(    'woocommerce_product_thumbnails_columns',	'insurance_ancora_woocommerce_product_thumbnails_columns' );

			add_filter(    'get_product_search_form',					'insurance_ancora_woocommerce_get_product_search_form' );

			add_filter(    'loop_shop_columns',							'insurance_ancora_woocommerce_loop_shop_columns' );
			add_filter(    'post_class',								'insurance_ancora_woocommerce_loop_shop_columns_class' );
			add_action(    'the_title',									'insurance_ancora_woocommerce_the_title');
			
			insurance_ancora_enqueue_popup();
		}
	}
}



// Check if WooCommerce installed and activated
if ( !function_exists( 'insurance_ancora_exists_woocommerce' ) ) {
	function insurance_ancora_exists_woocommerce() {
		return class_exists('Woocommerce');
	}
}

// Return true, if current page is any woocommerce page
if ( !function_exists( 'insurance_ancora_is_woocommerce_page' ) ) {
	function insurance_ancora_is_woocommerce_page() {
		$rez = false;
		if (insurance_ancora_exists_woocommerce()) {
			if (!insurance_ancora_storage_empty('pre_query')) {
				$id = insurance_ancora_storage_get_obj_property('pre_query', 'queried_object_id', 0);
				$rez = insurance_ancora_storage_call_obj_method('pre_query', 'get', 'post_type')=='product' 
						|| $id==wc_get_page_id('shop')
						|| $id==wc_get_page_id('cart')
						|| $id==wc_get_page_id('checkout')
						|| $id==wc_get_page_id('myaccount')
						|| insurance_ancora_storage_call_obj_method('pre_query', 'is_tax', 'product_cat')
						|| insurance_ancora_storage_call_obj_method('pre_query', 'is_tax', 'product_tag')
						|| insurance_ancora_storage_call_obj_method('pre_query', 'is_tax', get_object_taxonomies('product'));
						
			} else
				$rez = is_shop() || is_product() || is_product_category() || is_product_tag() || is_product_taxonomy() || is_cart() || is_checkout() || is_account_page();
		}
		return $rez;
	}
}

// Filter to detect current page inheritance key
if ( !function_exists( 'insurance_ancora_woocommerce_detect_inheritance_key' ) ) {
	function insurance_ancora_woocommerce_detect_inheritance_key($key) {
		if (!empty($key)) return $key;
		return insurance_ancora_is_woocommerce_page() ? 'woocommerce' : '';
	}
}

// Filter to detect current template page id
if ( !function_exists( 'insurance_ancora_woocommerce_detect_template_page_id' ) ) {
	function insurance_ancora_woocommerce_detect_template_page_id($id, $key) {
		if (!empty($id)) return $id;
		if ($key == 'woocommerce_cart')				$id = get_option('woocommerce_cart_page_id');
		else if ($key == 'woocommerce_checkout')	$id = get_option('woocommerce_checkout_page_id');
		else if ($key == 'woocommerce_account')		$id = get_option('woocommerce_account_page_id');
		else if ($key == 'woocommerce')				$id = get_option('woocommerce_shop_page_id');
		return $id;
	}
}

// Filter to detect current page type (slug)
if ( !function_exists( 'insurance_ancora_woocommerce_get_blog_type' ) ) {
	function insurance_ancora_woocommerce_get_blog_type($page, $query=null) {
		if (!empty($page)) return $page;
		
		if (is_shop()) 					$page = 'woocommerce_shop';
		else if ($query && $query->get('post_type')=='product' || is_product())		$page = 'woocommerce_product';
		else if ($query && $query->get('product_tag')!='' || is_product_tag())		$page = 'woocommerce_tag';
		else if ($query && $query->get('product_cat')!='' || is_product_category())	$page = 'woocommerce_category';
		else if (is_cart())				$page = 'woocommerce_cart';
		else if (is_checkout())			$page = 'woocommerce_checkout';
		else if (is_account_page())		$page = 'woocommerce_account';
		else if (is_woocommerce())		$page = 'woocommerce';
		return $page;
	}
}

// Filter to detect current page title
if ( !function_exists( 'insurance_ancora_woocommerce_get_blog_title' ) ) {
	function insurance_ancora_woocommerce_get_blog_title($title, $page) {
		if (!empty($title)) return $title;
		
		if ( insurance_ancora_strpos($page, 'woocommerce')!==false ) {
			if ( $page == 'woocommerce_category' ) {
				$term = get_term_by( 'slug', get_query_var( 'product_cat' ), 'product_cat', OBJECT);
				$title = $term->name;
			} else if ( $page == 'woocommerce_tag' ) {
				$term = get_term_by( 'slug', get_query_var( 'product_tag' ), 'product_tag', OBJECT);
				$title = esc_html__('Tag:', 'insurance-ancora') . ' ' . esc_html($term->name);
			} else if ( $page == 'woocommerce_cart' ) {
				$title = esc_html__( 'Your cart', 'insurance-ancora' );
			} else if ( $page == 'woocommerce_checkout' ) {
				$title = esc_html__( 'Checkout', 'insurance-ancora' );
			} else if ( $page == 'woocommerce_account' ) {
				$title = esc_html__( 'Account', 'insurance-ancora' );
			} else if ( $page == 'woocommerce_product' ) {
				$title = insurance_ancora_get_post_title();
			} else if (($page_id=get_option('woocommerce_shop_page_id')) > 0) {
				$title = insurance_ancora_get_post_title($page_id);
			} else {
				$title = esc_html__( 'Shop', 'insurance-ancora' );
			}
		}
		
		return $title;
	}
}

// Filter to detect stream page title
if ( !function_exists( 'insurance_ancora_woocommerce_get_stream_page_title' ) ) {
	function insurance_ancora_woocommerce_get_stream_page_title($title, $page) {
		if (!empty($title)) return $title;
		if (insurance_ancora_strpos($page, 'woocommerce')!==false) {
			if (($page_id = insurance_ancora_woocommerce_get_stream_page_id(0, $page)) > 0)
				$title = insurance_ancora_get_post_title($page_id);
			else
				$title = esc_html__('Shop', 'insurance-ancora');				
		}
		return $title;
	}
}

// Filter to detect stream page ID
if ( !function_exists( 'insurance_ancora_woocommerce_get_stream_page_id' ) ) {
	function insurance_ancora_woocommerce_get_stream_page_id($id, $page) {
		if (!empty($id)) return $id;
		if (insurance_ancora_strpos($page, 'woocommerce')!==false) {
			$id = get_option('woocommerce_shop_page_id');
		}
		return $id;
	}
}

// Filter to detect stream page link
if ( !function_exists( 'insurance_ancora_woocommerce_get_stream_page_link' ) ) {
	function insurance_ancora_woocommerce_get_stream_page_link($url, $page) {
		if (!empty($url)) return $url;
		if (insurance_ancora_strpos($page, 'woocommerce')!==false) {
			$id = insurance_ancora_woocommerce_get_stream_page_id(0, $page);
			if ($id) $url = get_permalink($id);
		}
		return $url;
	}
}

// Filter to detect current taxonomy
if ( !function_exists( 'insurance_ancora_woocommerce_get_current_taxonomy' ) ) {
	function insurance_ancora_woocommerce_get_current_taxonomy($tax, $page) {
		if (!empty($tax)) return $tax;
		if ( insurance_ancora_strpos($page, 'woocommerce')!==false ) {
			$tax = 'product_cat';
		}
		return $tax;
	}
}

// Return taxonomy name (slug) if current page is this taxonomy page
if ( !function_exists( 'insurance_ancora_woocommerce_is_taxonomy' ) ) {
	function insurance_ancora_woocommerce_is_taxonomy($tax, $query=null) {
		if (!empty($tax))
			return $tax;
		else 
			return $query!==null && $query->get('product_cat')!='' || is_product_category() ? 'product_cat' : '';
	}
}

// Return false if current plugin not need theme orderby setting
if ( !function_exists( 'insurance_ancora_woocommerce_orderby_need' ) ) {
	function insurance_ancora_woocommerce_orderby_need($need) {
		if ($need == false || insurance_ancora_storage_empty('pre_query'))
			return $need;
		else {
			return insurance_ancora_storage_call_obj_method('pre_query', 'get', 'post_type')!='product' 
					&& insurance_ancora_storage_call_obj_method('pre_query', 'get', 'product_cat')==''
					&& insurance_ancora_storage_call_obj_method('pre_query', 'get', 'product_tag')=='';
		}
	}
}

// Add custom post type into list
if ( !function_exists( 'insurance_ancora_woocommerce_list_post_types' ) ) {
	function insurance_ancora_woocommerce_list_post_types($list) {
		$list['product'] = esc_html__('Products', 'insurance-ancora');
		return $list;
	}
}


	
// Enqueue WooCommerce custom styles
if ( !function_exists( 'insurance_ancora_woocommerce_frontend_scripts' ) ) {
	function insurance_ancora_woocommerce_frontend_scripts() {
		if (insurance_ancora_is_woocommerce_page() || insurance_ancora_get_custom_option('show_cart')=='always')
			if (file_exists(insurance_ancora_get_file_dir('css/plugin.woocommerce.css')))
				wp_enqueue_style( 'insurance-ancora-plugin-woocommerce-style',  insurance_ancora_get_file_url('css/plugin.woocommerce.css'), array(), null );
	}
}

// Before main content
if ( !function_exists( 'insurance_ancora_woocommerce_wrapper_start' ) ) {
	function insurance_ancora_woocommerce_wrapper_start() {
		if (is_product() || is_cart() || is_checkout() || is_account_page()) {
			?>
			<article class="post_item post_item_single post_item_product">
			<?php
		} else {
			?>
			<div class="list_products shop_mode_<?php echo !insurance_ancora_storage_empty('shop_mode') ? insurance_ancora_storage_get('shop_mode') : 'thumbs'; ?>">
			<?php
		}
	}
}

// After main content
if ( !function_exists( 'insurance_ancora_woocommerce_wrapper_end' ) ) {
	function insurance_ancora_woocommerce_wrapper_end() {
		if (is_product() || is_cart() || is_checkout() || is_account_page()) {
			?>
			</article>	<!-- .post_item -->
			<?php
		} else {
			?>
			</div>	<!-- .list_products -->
			<?php
		}
	}
}

// Check to show page title
if ( !function_exists( 'insurance_ancora_woocommerce_show_page_title' ) ) {
	function insurance_ancora_woocommerce_show_page_title($defa=true) {
		return insurance_ancora_get_custom_option('show_page_title')=='no';
	}
}

// Check to show product title
if ( !function_exists( 'insurance_ancora_woocommerce_show_product_title' ) ) {
	function insurance_ancora_woocommerce_show_product_title() {
		if (insurance_ancora_get_custom_option('show_post_title')=='yes' || insurance_ancora_get_custom_option('show_page_title')=='no') {
			wc_get_template( 'single-product/title.php' );
		}
	}
}

// Add list mode buttons
if ( !function_exists( 'insurance_ancora_woocommerce_before_shop_loop' ) ) {
	function insurance_ancora_woocommerce_before_shop_loop() {
		if (insurance_ancora_get_custom_option('show_mode_buttons')=='yes') {
            echo '<div class="mode_buttons"><form action="' . esc_url(insurance_ancora_get_current_url()) . '" method="post">'
				. '<input type="hidden" name="insurance_ancora_shop_mode" value="'.esc_attr(insurance_ancora_storage_get('shop_mode')).'" />'
				. '<a href="#" class="woocommerce_thumbs icon-th" title="'.esc_attr__('Show products as thumbs', 'insurance-ancora').'"></a>'
				. '<a href="#" class="woocommerce_list icon-th-list" title="'.esc_attr__('Show products as list', 'insurance-ancora').'"></a>'
				. '</form></div>';
		}
	}
}


// Open thumbs wrapper for categories and products
if ( !function_exists( 'insurance_ancora_woocommerce_open_thumb_wrapper' ) ) {
	function insurance_ancora_woocommerce_open_thumb_wrapper($cat='') {
		insurance_ancora_storage_set('in_product_item', true);
		?>
		<div class="post_item_wrap">
			<div class="post_featured">
				<div class="post_thumb">
					<a class="hover_icon hover_icon_link" href="<?php echo esc_url(is_object($cat) ? get_term_link($cat->slug, 'product_cat') : get_permalink()); ?>">
		<?php
	}
}

// Open item wrapper for categories and products
if ( !function_exists( 'insurance_ancora_woocommerce_open_item_wrapper' ) ) {
	function insurance_ancora_woocommerce_open_item_wrapper($cat='') {
		?>
				</a>
			</div>
		</div>
		<div class="post_content">
		<?php
	}
}

// Close item wrapper for categories and products
if ( !function_exists( 'insurance_ancora_woocommerce_close_item_wrapper' ) ) {
	function insurance_ancora_woocommerce_close_item_wrapper($cat='') {
		?>
			</div>
		</div>
		<?php
		insurance_ancora_storage_set('in_product_item', false);
	}
}

// Add excerpt in output for the product in the list mode
if ( !function_exists( 'insurance_ancora_woocommerce_after_shop_loop_item_title' ) ) {
	function insurance_ancora_woocommerce_after_shop_loop_item_title() {
		if (insurance_ancora_storage_get('shop_mode') == 'list') {
		    $excerpt = apply_filters('the_excerpt', get_the_excerpt());
			echo '<div class="description">'.trim($excerpt).'</div>';
		}
	}
}

// Add excerpt in output for the product in the list mode
if ( !function_exists( 'insurance_ancora_woocommerce_after_subcategory_title' ) ) {
	function insurance_ancora_woocommerce_after_subcategory_title($category) {
		if (insurance_ancora_storage_get('shop_mode') == 'list')
			echo '<div class="description">' . trim($category->description) . '</div>';
	}
}

// Add Product ID for single product
if ( !function_exists( 'insurance_ancora_woocommerce_show_product_id' ) ) {
	function insurance_ancora_woocommerce_show_product_id() {
		global $post, $product;
		echo '<span class="product_id">'.esc_html__('Product ID: ', 'insurance-ancora') . '<span>' . ($post->ID) . '</span></span>';
	}
}

// Redefine number of related products
if ( !function_exists( 'insurance_ancora_woocommerce_output_related_products_args' ) ) {
	function insurance_ancora_woocommerce_output_related_products_args($args) {
		$ppp = $ccc = 0;
		if (insurance_ancora_param_is_on(insurance_ancora_get_custom_option('show_post_related'))) {
			$ccc_add = in_array(insurance_ancora_get_custom_option('body_style'), array('fullwide', 'fullscreen')) ? 1 : 0;
			$ccc =  insurance_ancora_get_custom_option('post_related_columns');
			$ccc = $ccc > 0 ? $ccc : (insurance_ancora_param_is_off(insurance_ancora_get_custom_option('show_sidebar_main')) ? 3+$ccc_add : 2+$ccc_add);
			$ppp = insurance_ancora_get_custom_option('post_related_count');
			$ppp = $ppp > 0 ? $ppp : $ccc;
		}
		$args['posts_per_page'] = $ppp;
		$args['columns'] = $ccc;
		return $args;
	}
}

// Redefine post_type if number of related products == 0
if ( !function_exists( 'insurance_ancora_woocommerce_related_products_args' ) ) {
	
	function insurance_ancora_woocommerce_related_products_args($args) {
		if ($args['posts_per_page'] == 0)
			$args['post_type'] .= '_';
		return $args;
	}
}

// Number columns for product thumbnails
if ( !function_exists( 'insurance_ancora_woocommerce_product_thumbnails_columns' ) ) {
	function insurance_ancora_woocommerce_product_thumbnails_columns($cols) {
		return 4;
	}
}

// Add column class into product item in shop streampage
if ( !function_exists( 'insurance_ancora_woocommerce_loop_shop_columns_class' ) ) {
	
	
	function insurance_ancora_woocommerce_loop_shop_columns_class($class, $class2='', $cat='') {
		global $woocommerce_loop;
		if (is_product()) {
			if (!empty($woocommerce_loop['columns']))
			$class[] = ' column-1_'.esc_attr($woocommerce_loop['columns']);
		} else if (!is_product() && !is_cart() && !is_checkout() && !is_account_page()) {
			$ccc_add = in_array(insurance_ancora_get_custom_option('body_style'), array('fullwide', 'fullscreen')) ? 1 : 0;
			$ccc =  insurance_ancora_get_custom_option('shop_loop_columns');
			$ccc = $ccc > 0 ? $ccc : (insurance_ancora_param_is_off(insurance_ancora_get_custom_option('show_sidebar_main')) ? 3+$ccc_add : 2+$ccc_add);
			$class[] = ' column-1_'.esc_attr($ccc);
		}
		return $class;
	}
}

// Number columns for shop streampage
if ( !function_exists( 'insurance_ancora_woocommerce_loop_shop_columns' ) ) {
	function insurance_ancora_woocommerce_loop_shop_columns($cols) {
		$ccc_add = in_array(insurance_ancora_get_custom_option('body_style'), array('fullwide', 'fullscreen')) ? 1 : 0;
		$ccc =  insurance_ancora_get_custom_option('shop_loop_columns');
		$ccc = $ccc > 0 ? $ccc : (insurance_ancora_param_is_off(insurance_ancora_get_custom_option('show_sidebar_main')) ? 3+$ccc_add : 2+$ccc_add);
		return $ccc;
	}
}

// Search form
if ( !function_exists( 'insurance_ancora_woocommerce_get_product_search_form' ) ) {
	function insurance_ancora_woocommerce_get_product_search_form($form) {
		return '
		<form role="search" method="get" class="search_form" action="' . esc_url(home_url('/')) . '">
			<input type="text" class="search_field" placeholder="' . esc_attr__('Search for products &hellip;', 'insurance-ancora') . '" value="' . get_search_query() . '" name="s" title="' . esc_attr__('Search for products:', 'insurance-ancora') . '" /><button class="search_button icon-search" type="submit"></button>
			<input type="hidden" name="post_type" value="product" />
		</form>
		';
	}
}

// Wrap product title into link
if ( !function_exists( 'insurance_ancora_woocommerce_the_title' ) ) {
	function insurance_ancora_woocommerce_the_title($title) {
		if (insurance_ancora_storage_get('in_product_item') && get_post_type()=='product') {
			$title = '<a href="'.esc_url(get_permalink()).'">'.($title).'</a>';
		}
		return $title;
	}
}

// Wrap category title into link
if ( !function_exists( 'insurance_ancora_woocommerce_shop_loop_subcategory_title' ) ) {
	
	function insurance_ancora_woocommerce_shop_loop_subcategory_title($cat) {
		if (insurance_ancora_storage_get('in_product_item') && is_object($cat)) {
			$cat->name = sprintf('<a href="%s">%s</a>', esc_url(get_term_link($cat->slug, 'product_cat')), $cat->name);
		}
		return $cat;
	}
}

// Replace H2 tag to H3 tag in product headings
if ( !function_exists( 'tennisclub_woocommerce_template_loop_product_title' ) ) {
    
    function tennisclub_woocommerce_template_loop_product_title() {
        echo '<h3>' . wp_kses_post( get_the_title() ) . '</h3>';
    }
}

// Show pagination links
if ( !function_exists( 'insurance_ancora_woocommerce_pagination' ) ) {
	function insurance_ancora_woocommerce_pagination() {
		$style = insurance_ancora_get_custom_option('blog_pagination');
		insurance_ancora_show_pagination(array(
			'class' => 'pagination_wrap pagination_' . esc_attr($style),
			'style' => $style,
			'button_class' => '',
			'first_text'=> '',
			'last_text' => '',
			'prev_text' => '',
			'next_text' => '',
			'pages_in_group' => $style=='pages' ? 10 : 20
			)
		);
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'insurance_ancora_woocommerce_required_plugins' ) ) {
	function insurance_ancora_woocommerce_required_plugins($list=array()) {
		if (in_array('woocommerce', (array)insurance_ancora_storage_get('required_plugins')))
			$list[] = array(
					'name' 		=> 'WooCommerce',
					'slug' 		=> 'woocommerce',
					'required' 	=> false
				);

		return $list;
	}
}

// Show products navigation
if ( !function_exists( 'insurance_ancora_woocommerce_show_post_navi' ) ) {
	function insurance_ancora_woocommerce_show_post_navi($show=false) {
		return $show || (insurance_ancora_get_custom_option('show_page_title')=='yes' && is_single() && insurance_ancora_is_woocommerce_page());
	}
}



// One-click import support
//------------------------------------------------------------------------

// Check WooC in the required plugins
if ( !function_exists( 'insurance_ancora_woocommerce_importer_required_plugins' ) ) {
	function insurance_ancora_woocommerce_importer_required_plugins($not_installed='', $list='') {
		if (insurance_ancora_strpos($list, 'woocommerce')!==false && !insurance_ancora_exists_woocommerce() )
			$not_installed .= '<br>' . esc_html__('WooCommerce', 'insurance-ancora');
		return $not_installed;
	}
}

// Set options for one-click importer
if ( !function_exists( 'insurance_ancora_woocommerce_importer_set_options' ) ) {
	function insurance_ancora_woocommerce_importer_set_options($options=array()) {
		if ( in_array('woocommerce', (array)insurance_ancora_storage_get('required_plugins')) && insurance_ancora_exists_woocommerce() ) {
			if (is_array($options['files']) && count($options['files']) > 0) {
				foreach ($options['files'] as $k => $v) {
					$options['files'][$k]['file_with_woocommerce'] = str_replace('name.ext', 'woocommerce.txt', $v['file_with_']);
				}
			}
			// Add slugs to export options for this plugin
			$options['additional_options'][]	= 'shop_%';
			$options['additional_options'][]	= 'woocommerce_%';
		}
		return $options;
	}
}

// Setup WooC pages after import posts complete
if ( !function_exists( 'insurance_ancora_woocommerce_importer_after_import_posts' ) ) {
	function insurance_ancora_woocommerce_importer_after_import_posts($importer) {
		$wooc_pages = array(						// Options slugs and pages titles for WooCommerce pages
			'woocommerce_shop_page_id' 				=> 'Shop',
			'woocommerce_cart_page_id' 				=> 'Cart',
			'woocommerce_checkout_page_id' 			=> 'Checkout',
			'woocommerce_pay_page_id' 				=> 'Checkout &#8594; Pay',
			'woocommerce_thanks_page_id' 			=> 'Order Received',
			'woocommerce_myaccount_page_id' 		=> 'My Account',
			'woocommerce_edit_address_page_id'		=> 'Edit My Address',
			'woocommerce_view_order_page_id'		=> 'View Order',
			'woocommerce_change_password_page_id'	=> 'Change Password',
			'woocommerce_logout_page_id'			=> 'Logout',
			'woocommerce_lost_password_page_id'		=> 'Lost Password'
		);
		foreach ($wooc_pages as $woo_page_name => $woo_page_title) {
			$woopage = get_page_by_title( $woo_page_title );
			if ($woopage->ID) {
				update_option($woo_page_name, $woopage->ID);
			}
		}
		// We no longer need to install pages
		delete_option( '_wc_needs_pages' );
		delete_transient( '_wc_activation_redirect' );
	}
}

// Add checkbox to the one-click importer
if ( !function_exists( 'insurance_ancora_woocommerce_importer_show_params' ) ) {
	function insurance_ancora_woocommerce_importer_show_params($importer) {
		$importer->show_importer_params(array(
			'slug' => 'woocommerce',
			'title' => esc_html__('Import WooCommerce', 'insurance-ancora'),
			'part' => 0
			));
	}
}

// Import posts
if ( !function_exists( 'insurance_ancora_woocommerce_importer_import' ) ) {
	function insurance_ancora_woocommerce_importer_import($importer, $action) {
		if ( $action == 'import_woocommerce' ) {
			$importer->response['start_from_id'] = 0;
			$importer->import_dump('woocommerce', esc_html__('WooCommerce meta', 'insurance-ancora'));
			delete_transient( 'wc_attribute_taxonomies' );
		}
	}
}

// Display import progress
if ( !function_exists( 'insurance_ancora_woocommerce_importer_import_fields' ) ) {
	function insurance_ancora_woocommerce_importer_import_fields($importer) {
		$importer->show_importer_fields(array(
			'slug' => 'woocommerce',
			'title' => esc_html__('WooCommerce meta', 'insurance-ancora')
			));
	}
}

// Export posts
if ( !function_exists( 'insurance_ancora_woocommerce_importer_export' ) ) {
	function insurance_ancora_woocommerce_importer_export($importer) {
		insurance_ancora_fpc(insurance_ancora_get_file_dir('core/core.importer/export/woocommerce.txt'), serialize( array(
			"woocommerce_attribute_taxonomies"				=> $importer->export_dump("woocommerce_attribute_taxonomies"),
			"woocommerce_downloadable_product_permissions"	=> $importer->export_dump("woocommerce_downloadable_product_permissions"),
            "woocommerce_order_itemmeta"					=> $importer->export_dump("woocommerce_order_itemmeta"),
            "woocommerce_order_items"						=> $importer->export_dump("woocommerce_order_items"),
            "woocommerce_termmeta"							=> $importer->export_dump("woocommerce_termmeta")
            ) )
        );
	}
}

// Display exported data in the fields
if ( !function_exists( 'insurance_ancora_woocommerce_importer_export_fields' ) ) {
	function insurance_ancora_woocommerce_importer_export_fields($importer) {
		$importer->show_exporter_fields(array(
			'slug' => 'woocommerce',
			'title' => esc_html__('WooCommerce', 'insurance-ancora')
			));
	}
}



// Register shortcodes to the internal builder
//------------------------------------------------------------------------
if ( !function_exists( 'insurance_ancora_woocommerce_reg_shortcodes' ) ) {
	function insurance_ancora_woocommerce_reg_shortcodes() {

		// WooCommerce - Cart
		insurance_ancora_sc_map("woocommerce_cart", array(
			"title" => esc_html__("Woocommerce: Cart", 'insurance-ancora'),
			"desc" => wp_kses_data( __("WooCommerce shortcode: show Cart page", 'insurance-ancora') ),
			"decorate" => false,
			"container" => false,
			"params" => array()
			)
		);
		
		// WooCommerce - Checkout
		insurance_ancora_sc_map("woocommerce_checkout", array(
			"title" => esc_html__("Woocommerce: Checkout", 'insurance-ancora'),
			"desc" => wp_kses_data( __("WooCommerce shortcode: show Checkout page", 'insurance-ancora') ),
			"decorate" => false,
			"container" => false,
			"params" => array()
			)
		);
		
		// WooCommerce - My Account
		insurance_ancora_sc_map("woocommerce_my_account", array(
			"title" => esc_html__("Woocommerce: My Account", 'insurance-ancora'),
			"desc" => wp_kses_data( __("WooCommerce shortcode: show My Account page", 'insurance-ancora') ),
			"decorate" => false,
			"container" => false,
			"params" => array()
			)
		);
		
		// WooCommerce - Order Tracking
		insurance_ancora_sc_map("woocommerce_order_tracking", array(
			"title" => esc_html__("Woocommerce: Order Tracking", 'insurance-ancora'),
			"desc" => wp_kses_data( __("WooCommerce shortcode: show Order Tracking page", 'insurance-ancora') ),
			"decorate" => false,
			"container" => false,
			"params" => array()
			)
		);
		
		// WooCommerce - Shop Messages
		insurance_ancora_sc_map("shop_messages", array(
			"title" => esc_html__("Woocommerce: Shop Messages", 'insurance-ancora'),
			"desc" => wp_kses_data( __("WooCommerce shortcode: show shop messages", 'insurance-ancora') ),
			"decorate" => false,
			"container" => false,
			"params" => array()
			)
		);
		
		// WooCommerce - Product Page
		insurance_ancora_sc_map("product_page", array(
			"title" => esc_html__("Woocommerce: Product Page", 'insurance-ancora'),
			"desc" => wp_kses_data( __("WooCommerce shortcode: display single product page", 'insurance-ancora') ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"sku" => array(
					"title" => esc_html__("SKU", 'insurance-ancora'),
					"desc" => wp_kses_data( __("SKU code of displayed product", 'insurance-ancora') ),
					"value" => "",
					"type" => "text"
				),
				"id" => array(
					"title" => esc_html__("ID", 'insurance-ancora'),
					"desc" => wp_kses_data( __("ID of displayed product", 'insurance-ancora') ),
					"value" => "",
					"type" => "text"
				),
				"posts_per_page" => array(
					"title" => esc_html__("Number", 'insurance-ancora'),
					"desc" => wp_kses_data( __("How many products showed", 'insurance-ancora') ),
					"value" => "1",
					"min" => 1,
					"type" => "spinner"
				),
				"post_type" => array(
					"title" => esc_html__("Post type", 'insurance-ancora'),
					"desc" => wp_kses_data( __("Post type for the WP query (leave 'product')", 'insurance-ancora') ),
					"value" => "product",
					"type" => "text"
				),
				"post_status" => array(
					"title" => esc_html__("Post status", 'insurance-ancora'),
					"desc" => wp_kses_data( __("Display posts only with this status", 'insurance-ancora') ),
					"value" => "publish",
					"type" => "select",
					"options" => array(
						"publish" => esc_html__('Publish', 'insurance-ancora'),
						"protected" => esc_html__('Protected', 'insurance-ancora'),
						"private" => esc_html__('Private', 'insurance-ancora'),
						"pending" => esc_html__('Pending', 'insurance-ancora'),
						"draft" => esc_html__('Draft', 'insurance-ancora')
						)
					)
				)
			)
		);
		
		// WooCommerce - Product
		insurance_ancora_sc_map("product", array(
			"title" => esc_html__("Woocommerce: Product", 'insurance-ancora'),
			"desc" => wp_kses_data( __("WooCommerce shortcode: display one product", 'insurance-ancora') ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"sku" => array(
					"title" => esc_html__("SKU", 'insurance-ancora'),
					"desc" => wp_kses_data( __("SKU code of displayed product", 'insurance-ancora') ),
					"value" => "",
					"type" => "text"
				),
				"id" => array(
					"title" => esc_html__("ID", 'insurance-ancora'),
					"desc" => wp_kses_data( __("ID of displayed product", 'insurance-ancora') ),
					"value" => "",
					"type" => "text"
					)
				)
			)
		);
		
		// WooCommerce - Best Selling Products
		insurance_ancora_sc_map("best_selling_products", array(
			"title" => esc_html__("Woocommerce: Best Selling Products", 'insurance-ancora'),
			"desc" => wp_kses_data( __("WooCommerce shortcode: show best selling products", 'insurance-ancora') ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"per_page" => array(
					"title" => esc_html__("Number", 'insurance-ancora'),
					"desc" => wp_kses_data( __("How many products showed", 'insurance-ancora') ),
					"value" => 4,
					"min" => 1,
					"type" => "spinner"
				),
				"columns" => array(
					"title" => esc_html__("Columns", 'insurance-ancora'),
					"desc" => wp_kses_data( __("How many columns per row use for products output", 'insurance-ancora') ),
					"value" => 4,
					"min" => 2,
					"max" => 4,
					"type" => "spinner"
					)
				)
			)
		);
		
		// WooCommerce - Recent Products
		insurance_ancora_sc_map("recent_products", array(
			"title" => esc_html__("Woocommerce: Recent Products", 'insurance-ancora'),
			"desc" => wp_kses_data( __("WooCommerce shortcode: show recent products", 'insurance-ancora') ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"per_page" => array(
					"title" => esc_html__("Number", 'insurance-ancora'),
					"desc" => wp_kses_data( __("How many products showed", 'insurance-ancora') ),
					"value" => 4,
					"min" => 1,
					"type" => "spinner"
				),
				"columns" => array(
					"title" => esc_html__("Columns", 'insurance-ancora'),
					"desc" => wp_kses_data( __("How many columns per row use for products output", 'insurance-ancora') ),
					"value" => 4,
					"min" => 2,
					"max" => 4,
					"type" => "spinner"
				),
				"orderby" => array(
					"title" => esc_html__("Order by", 'insurance-ancora'),
					"desc" => wp_kses_data( __("Sorting order for products output", 'insurance-ancora') ),
					"value" => "date",
					"type" => "select",
					"options" => array(
						"date" => esc_html__('Date', 'insurance-ancora'),
						"title" => esc_html__('Title', 'insurance-ancora')
					)
				),
				"order" => array(
					"title" => esc_html__("Order", 'insurance-ancora'),
					"desc" => wp_kses_data( __("Sorting order for products output", 'insurance-ancora') ),
					"value" => "desc",
					"type" => "switch",
					"size" => "big",
					"options" => insurance_ancora_get_sc_param('ordering')
					)
				)
			)
		);
		
		// WooCommerce - Related Products
		insurance_ancora_sc_map("related_products", array(
			"title" => esc_html__("Woocommerce: Related Products", 'insurance-ancora'),
			"desc" => wp_kses_data( __("WooCommerce shortcode: show related products", 'insurance-ancora') ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"posts_per_page" => array(
					"title" => esc_html__("Number", 'insurance-ancora'),
					"desc" => wp_kses_data( __("How many products showed", 'insurance-ancora') ),
					"value" => 4,
					"min" => 1,
					"type" => "spinner"
				),
				"columns" => array(
					"title" => esc_html__("Columns", 'insurance-ancora'),
					"desc" => wp_kses_data( __("How many columns per row use for products output", 'insurance-ancora') ),
					"value" => 4,
					"min" => 2,
					"max" => 4,
					"type" => "spinner"
				),
				"orderby" => array(
					"title" => esc_html__("Order by", 'insurance-ancora'),
					"desc" => wp_kses_data( __("Sorting order for products output", 'insurance-ancora') ),
					"value" => "date",
					"type" => "select",
					"options" => array(
						"date" => esc_html__('Date', 'insurance-ancora'),
						"title" => esc_html__('Title', 'insurance-ancora')
						)
					)
				)
			)
		);
		
		// WooCommerce - Featured Products
		insurance_ancora_sc_map("featured_products", array(
			"title" => esc_html__("Woocommerce: Featured Products", 'insurance-ancora'),
			"desc" => wp_kses_data( __("WooCommerce shortcode: show featured products", 'insurance-ancora') ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"per_page" => array(
					"title" => esc_html__("Number", 'insurance-ancora'),
					"desc" => wp_kses_data( __("How many products showed", 'insurance-ancora') ),
					"value" => 4,
					"min" => 1,
					"type" => "spinner"
				),
				"columns" => array(
					"title" => esc_html__("Columns", 'insurance-ancora'),
					"desc" => wp_kses_data( __("How many columns per row use for products output", 'insurance-ancora') ),
					"value" => 4,
					"min" => 2,
					"max" => 4,
					"type" => "spinner"
				),
				"orderby" => array(
					"title" => esc_html__("Order by", 'insurance-ancora'),
					"desc" => wp_kses_data( __("Sorting order for products output", 'insurance-ancora') ),
					"value" => "date",
					"type" => "select",
					"options" => array(
						"date" => esc_html__('Date', 'insurance-ancora'),
						"title" => esc_html__('Title', 'insurance-ancora')
					)
				),
				"order" => array(
					"title" => esc_html__("Order", 'insurance-ancora'),
					"desc" => wp_kses_data( __("Sorting order for products output", 'insurance-ancora') ),
					"value" => "desc",
					"type" => "switch",
					"size" => "big",
					"options" => insurance_ancora_get_sc_param('ordering')
					)
				)
			)
		);
		
		// WooCommerce - Top Rated Products
		insurance_ancora_sc_map("featured_products", array(
			"title" => esc_html__("Woocommerce: Top Rated Products", 'insurance-ancora'),
			"desc" => wp_kses_data( __("WooCommerce shortcode: show top rated products", 'insurance-ancora') ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"per_page" => array(
					"title" => esc_html__("Number", 'insurance-ancora'),
					"desc" => wp_kses_data( __("How many products showed", 'insurance-ancora') ),
					"value" => 4,
					"min" => 1,
					"type" => "spinner"
				),
				"columns" => array(
					"title" => esc_html__("Columns", 'insurance-ancora'),
					"desc" => wp_kses_data( __("How many columns per row use for products output", 'insurance-ancora') ),
					"value" => 4,
					"min" => 2,
					"max" => 4,
					"type" => "spinner"
				),
				"orderby" => array(
					"title" => esc_html__("Order by", 'insurance-ancora'),
					"desc" => wp_kses_data( __("Sorting order for products output", 'insurance-ancora') ),
					"value" => "date",
					"type" => "select",
					"options" => array(
						"date" => esc_html__('Date', 'insurance-ancora'),
						"title" => esc_html__('Title', 'insurance-ancora')
					)
				),
				"order" => array(
					"title" => esc_html__("Order", 'insurance-ancora'),
					"desc" => wp_kses_data( __("Sorting order for products output", 'insurance-ancora') ),
					"value" => "desc",
					"type" => "switch",
					"size" => "big",
					"options" => insurance_ancora_get_sc_param('ordering')
					)
				)
			)
		);
		
		// WooCommerce - Sale Products
		insurance_ancora_sc_map("featured_products", array(
			"title" => esc_html__("Woocommerce: Sale Products", 'insurance-ancora'),
			"desc" => wp_kses_data( __("WooCommerce shortcode: list products on sale", 'insurance-ancora') ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"per_page" => array(
					"title" => esc_html__("Number", 'insurance-ancora'),
					"desc" => wp_kses_data( __("How many products showed", 'insurance-ancora') ),
					"value" => 4,
					"min" => 1,
					"type" => "spinner"
				),
				"columns" => array(
					"title" => esc_html__("Columns", 'insurance-ancora'),
					"desc" => wp_kses_data( __("How many columns per row use for products output", 'insurance-ancora') ),
					"value" => 4,
					"min" => 2,
					"max" => 4,
					"type" => "spinner"
				),
				"orderby" => array(
					"title" => esc_html__("Order by", 'insurance-ancora'),
					"desc" => wp_kses_data( __("Sorting order for products output", 'insurance-ancora') ),
					"value" => "date",
					"type" => "select",
					"options" => array(
						"date" => esc_html__('Date', 'insurance-ancora'),
						"title" => esc_html__('Title', 'insurance-ancora')
					)
				),
				"order" => array(
					"title" => esc_html__("Order", 'insurance-ancora'),
					"desc" => wp_kses_data( __("Sorting order for products output", 'insurance-ancora') ),
					"value" => "desc",
					"type" => "switch",
					"size" => "big",
					"options" => insurance_ancora_get_sc_param('ordering')
					)
				)
			)
		);
		
		// WooCommerce - Product Category
		insurance_ancora_sc_map("product_category", array(
			"title" => esc_html__("Woocommerce: Products from category", 'insurance-ancora'),
			"desc" => wp_kses_data( __("WooCommerce shortcode: list products in specified category(-ies)", 'insurance-ancora') ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"per_page" => array(
					"title" => esc_html__("Number", 'insurance-ancora'),
					"desc" => wp_kses_data( __("How many products showed", 'insurance-ancora') ),
					"value" => 4,
					"min" => 1,
					"type" => "spinner"
				),
				"columns" => array(
					"title" => esc_html__("Columns", 'insurance-ancora'),
					"desc" => wp_kses_data( __("How many columns per row use for products output", 'insurance-ancora') ),
					"value" => 4,
					"min" => 2,
					"max" => 4,
					"type" => "spinner"
				),
				"orderby" => array(
					"title" => esc_html__("Order by", 'insurance-ancora'),
					"desc" => wp_kses_data( __("Sorting order for products output", 'insurance-ancora') ),
					"value" => "date",
					"type" => "select",
					"options" => array(
						"date" => esc_html__('Date', 'insurance-ancora'),
						"title" => esc_html__('Title', 'insurance-ancora')
					)
				),
				"order" => array(
					"title" => esc_html__("Order", 'insurance-ancora'),
					"desc" => wp_kses_data( __("Sorting order for products output", 'insurance-ancora') ),
					"value" => "desc",
					"type" => "switch",
					"size" => "big",
					"options" => insurance_ancora_get_sc_param('ordering')
				),
				"category" => array(
					"title" => esc_html__("Categories", 'insurance-ancora'),
					"desc" => wp_kses_data( __("Comma separated category slugs", 'insurance-ancora') ),
					"value" => '',
					"type" => "text"
				),
				"operator" => array(
					"title" => esc_html__("Operator", 'insurance-ancora'),
					"desc" => wp_kses_data( __("Categories operator", 'insurance-ancora') ),
					"value" => "IN",
					"type" => "checklist",
					"size" => "medium",
					"options" => array(
						"IN" => esc_html__('IN', 'insurance-ancora'),
						"NOT IN" => esc_html__('NOT IN', 'insurance-ancora'),
						"AND" => esc_html__('AND', 'insurance-ancora')
						)
					)
				)
			)
		);
		
		// WooCommerce - Products
		insurance_ancora_sc_map("products", array(
			"title" => esc_html__("Woocommerce: Products", 'insurance-ancora'),
			"desc" => wp_kses_data( __("WooCommerce shortcode: list all products", 'insurance-ancora') ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"skus" => array(
					"title" => esc_html__("SKUs", 'insurance-ancora'),
					"desc" => wp_kses_data( __("Comma separated SKU codes of products", 'insurance-ancora') ),
					"value" => "",
					"type" => "text"
				),
				"ids" => array(
					"title" => esc_html__("IDs", 'insurance-ancora'),
					"desc" => wp_kses_data( __("Comma separated ID of products", 'insurance-ancora') ),
					"value" => "",
					"type" => "text"
				),
				"columns" => array(
					"title" => esc_html__("Columns", 'insurance-ancora'),
					"desc" => wp_kses_data( __("How many columns per row use for products output", 'insurance-ancora') ),
					"value" => 4,
					"min" => 2,
					"max" => 4,
					"type" => "spinner"
				),
				"orderby" => array(
					"title" => esc_html__("Order by", 'insurance-ancora'),
					"desc" => wp_kses_data( __("Sorting order for products output", 'insurance-ancora') ),
					"value" => "date",
					"type" => "select",
					"options" => array(
						"date" => esc_html__('Date', 'insurance-ancora'),
						"title" => esc_html__('Title', 'insurance-ancora')
					)
				),
				"order" => array(
					"title" => esc_html__("Order", 'insurance-ancora'),
					"desc" => wp_kses_data( __("Sorting order for products output", 'insurance-ancora') ),
					"value" => "desc",
					"type" => "switch",
					"size" => "big",
					"options" => insurance_ancora_get_sc_param('ordering')
					)
				)
			)
		);
		
		// WooCommerce - Product attribute
		insurance_ancora_sc_map("product_attribute", array(
			"title" => esc_html__("Woocommerce: Products by Attribute", 'insurance-ancora'),
			"desc" => wp_kses_data( __("WooCommerce shortcode: show products with specified attribute", 'insurance-ancora') ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"per_page" => array(
					"title" => esc_html__("Number", 'insurance-ancora'),
					"desc" => wp_kses_data( __("How many products showed", 'insurance-ancora') ),
					"value" => 4,
					"min" => 1,
					"type" => "spinner"
				),
				"columns" => array(
					"title" => esc_html__("Columns", 'insurance-ancora'),
					"desc" => wp_kses_data( __("How many columns per row use for products output", 'insurance-ancora') ),
					"value" => 4,
					"min" => 2,
					"max" => 4,
					"type" => "spinner"
				),
				"orderby" => array(
					"title" => esc_html__("Order by", 'insurance-ancora'),
					"desc" => wp_kses_data( __("Sorting order for products output", 'insurance-ancora') ),
					"value" => "date",
					"type" => "select",
					"options" => array(
						"date" => esc_html__('Date', 'insurance-ancora'),
						"title" => esc_html__('Title', 'insurance-ancora')
					)
				),
				"order" => array(
					"title" => esc_html__("Order", 'insurance-ancora'),
					"desc" => wp_kses_data( __("Sorting order for products output", 'insurance-ancora') ),
					"value" => "desc",
					"type" => "switch",
					"size" => "big",
					"options" => insurance_ancora_get_sc_param('ordering')
				),
				"attribute" => array(
					"title" => esc_html__("Attribute", 'insurance-ancora'),
					"desc" => wp_kses_data( __("Attribute name", 'insurance-ancora') ),
					"value" => "",
					"type" => "text"
				),
				"filter" => array(
					"title" => esc_html__("Filter", 'insurance-ancora'),
					"desc" => wp_kses_data( __("Attribute value", 'insurance-ancora') ),
					"value" => "",
					"type" => "text"
					)
				)
			)
		);
		
		// WooCommerce - Products Categories
		insurance_ancora_sc_map("product_categories", array(
			"title" => esc_html__("Woocommerce: Product Categories", 'insurance-ancora'),
			"desc" => wp_kses_data( __("WooCommerce shortcode: show categories with products", 'insurance-ancora') ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"number" => array(
					"title" => esc_html__("Number", 'insurance-ancora'),
					"desc" => wp_kses_data( __("How many categories showed", 'insurance-ancora') ),
					"value" => 4,
					"min" => 1,
					"type" => "spinner"
				),
				"columns" => array(
					"title" => esc_html__("Columns", 'insurance-ancora'),
					"desc" => wp_kses_data( __("How many columns per row use for categories output", 'insurance-ancora') ),
					"value" => 4,
					"min" => 2,
					"max" => 4,
					"type" => "spinner"
				),
				"orderby" => array(
					"title" => esc_html__("Order by", 'insurance-ancora'),
					"desc" => wp_kses_data( __("Sorting order for products output", 'insurance-ancora') ),
					"value" => "date",
					"type" => "select",
					"options" => array(
						"date" => esc_html__('Date', 'insurance-ancora'),
						"title" => esc_html__('Title', 'insurance-ancora')
					)
				),
				"order" => array(
					"title" => esc_html__("Order", 'insurance-ancora'),
					"desc" => wp_kses_data( __("Sorting order for products output", 'insurance-ancora') ),
					"value" => "desc",
					"type" => "switch",
					"size" => "big",
					"options" => insurance_ancora_get_sc_param('ordering')
				),
				"parent" => array(
					"title" => esc_html__("Parent", 'insurance-ancora'),
					"desc" => wp_kses_data( __("Parent category slug", 'insurance-ancora') ),
					"value" => "",
					"type" => "text"
				),
				"ids" => array(
					"title" => esc_html__("IDs", 'insurance-ancora'),
					"desc" => wp_kses_data( __("Comma separated ID of products", 'insurance-ancora') ),
					"value" => "",
					"type" => "text"
				),
				"hide_empty" => array(
					"title" => esc_html__("Hide empty", 'insurance-ancora'),
					"desc" => wp_kses_data( __("Hide empty categories", 'insurance-ancora') ),
					"value" => "yes",
					"type" => "switch",
					"options" => insurance_ancora_get_sc_param('yes_no')
					)
				)
			)
		);
	}
}



// Register shortcodes to the VC builder
//------------------------------------------------------------------------
if ( !function_exists( 'insurance_ancora_woocommerce_reg_shortcodes_vc' ) ) {
	function insurance_ancora_woocommerce_reg_shortcodes_vc() {
	
		if (false && function_exists('insurance_ancora_exists_woocommerce') && insurance_ancora_exists_woocommerce()) {
		
			// WooCommerce - Cart
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "woocommerce_cart",
				"name" => esc_html__("Cart", 'insurance-ancora'),
				"description" => wp_kses_data( __("WooCommerce shortcode: show cart page", 'insurance-ancora') ),
				"category" => esc_html__('WooCommerce', 'insurance-ancora'),
				'icon' => 'icon_trx_wooc_cart',
				"class" => "trx_sc_alone trx_sc_woocommerce_cart",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => false,
				"params" => array(
					array(
						"param_name" => "dummy",
						"heading" => esc_html__("Dummy data", 'insurance-ancora'),
						"description" => wp_kses_data( __("Dummy data - not used in shortcodes", 'insurance-ancora') ),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					)
				)
			) );
			
			class WPBakeryShortCode_Woocommerce_Cart extends Insurance_Ancora_VC_ShortCodeAlone {}
		
		
			// WooCommerce - Checkout
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "woocommerce_checkout",
				"name" => esc_html__("Checkout", 'insurance-ancora'),
				"description" => wp_kses_data( __("WooCommerce shortcode: show checkout page", 'insurance-ancora') ),
				"category" => esc_html__('WooCommerce', 'insurance-ancora'),
				'icon' => 'icon_trx_wooc_checkout',
				"class" => "trx_sc_alone trx_sc_woocommerce_checkout",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => false,
				"params" => array(
					array(
						"param_name" => "dummy",
						"heading" => esc_html__("Dummy data", 'insurance-ancora'),
						"description" => wp_kses_data( __("Dummy data - not used in shortcodes", 'insurance-ancora') ),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					)
				)
			) );
			
			class WPBakeryShortCode_Woocommerce_Checkout extends Insurance_Ancora_VC_ShortCodeAlone {}
		
		
			// WooCommerce - My Account
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "woocommerce_my_account",
				"name" => esc_html__("My Account", 'insurance-ancora'),
				"description" => wp_kses_data( __("WooCommerce shortcode: show my account page", 'insurance-ancora') ),
				"category" => esc_html__('WooCommerce', 'insurance-ancora'),
				'icon' => 'icon_trx_wooc_my_account',
				"class" => "trx_sc_alone trx_sc_woocommerce_my_account",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => false,
				"params" => array(
					array(
						"param_name" => "dummy",
						"heading" => esc_html__("Dummy data", 'insurance-ancora'),
						"description" => wp_kses_data( __("Dummy data - not used in shortcodes", 'insurance-ancora') ),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					)
				)
			) );
			
			class WPBakeryShortCode_Woocommerce_My_Account extends Insurance_Ancora_VC_ShortCodeAlone {}
		
		
			// WooCommerce - Order Tracking
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "woocommerce_order_tracking",
				"name" => esc_html__("Order Tracking", 'insurance-ancora'),
				"description" => wp_kses_data( __("WooCommerce shortcode: show order tracking page", 'insurance-ancora') ),
				"category" => esc_html__('WooCommerce', 'insurance-ancora'),
				'icon' => 'icon_trx_wooc_order_tracking',
				"class" => "trx_sc_alone trx_sc_woocommerce_order_tracking",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => false,
				"params" => array(
					array(
						"param_name" => "dummy",
						"heading" => esc_html__("Dummy data", 'insurance-ancora'),
						"description" => wp_kses_data( __("Dummy data - not used in shortcodes", 'insurance-ancora') ),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					)
				)
			) );
			
			class WPBakeryShortCode_Woocommerce_Order_Tracking extends Insurance_Ancora_VC_ShortCodeAlone {}
		
		
			// WooCommerce - Shop Messages
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "shop_messages",
				"name" => esc_html__("Shop Messages", 'insurance-ancora'),
				"description" => wp_kses_data( __("WooCommerce shortcode: show shop messages", 'insurance-ancora') ),
				"category" => esc_html__('WooCommerce', 'insurance-ancora'),
				'icon' => 'icon_trx_wooc_shop_messages',
				"class" => "trx_sc_alone trx_sc_shop_messages",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => false,
				"params" => array(
					array(
						"param_name" => "dummy",
						"heading" => esc_html__("Dummy data", 'insurance-ancora'),
						"description" => wp_kses_data( __("Dummy data - not used in shortcodes", 'insurance-ancora') ),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					)
				)
			) );
			
			class WPBakeryShortCode_Shop_Messages extends Insurance_Ancora_VC_ShortCodeAlone {}
		
		
			// WooCommerce - Product Page
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "product_page",
				"name" => esc_html__("Product Page", 'insurance-ancora'),
				"description" => wp_kses_data( __("WooCommerce shortcode: display single product page", 'insurance-ancora') ),
				"category" => esc_html__('WooCommerce', 'insurance-ancora'),
				'icon' => 'icon_trx_product_page',
				"class" => "trx_sc_single trx_sc_product_page",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "sku",
						"heading" => esc_html__("SKU", 'insurance-ancora'),
						"description" => wp_kses_data( __("SKU code of displayed product", 'insurance-ancora') ),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "id",
						"heading" => esc_html__("ID", 'insurance-ancora'),
						"description" => wp_kses_data( __("ID of displayed product", 'insurance-ancora') ),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "posts_per_page",
						"heading" => esc_html__("Number", 'insurance-ancora'),
						"description" => wp_kses_data( __("How many products showed", 'insurance-ancora') ),
						"admin_label" => true,
						"class" => "",
						"value" => "1",
						"type" => "textfield"
					),
					array(
						"param_name" => "post_type",
						"heading" => esc_html__("Post type", 'insurance-ancora'),
						"description" => wp_kses_data( __("Post type for the WP query (leave 'product')", 'insurance-ancora') ),
						"class" => "",
						"value" => "product",
						"type" => "textfield"
					),
					array(
						"param_name" => "post_status",
						"heading" => esc_html__("Post status", 'insurance-ancora'),
						"description" => wp_kses_data( __("Display posts only with this status", 'insurance-ancora') ),
						"class" => "",
						"value" => array(
							esc_html__('Publish', 'insurance-ancora') => 'publish',
							esc_html__('Protected', 'insurance-ancora') => 'protected',
							esc_html__('Private', 'insurance-ancora') => 'private',
							esc_html__('Pending', 'insurance-ancora') => 'pending',
							esc_html__('Draft', 'insurance-ancora') => 'draft'
						),
						"type" => "dropdown"
					)
				)
			) );
			
			class WPBakeryShortCode_Product_Page extends Insurance_Ancora_VC_ShortCodeSingle {}
		
		
		
			// WooCommerce - Product
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "product",
				"name" => esc_html__("Product", 'insurance-ancora'),
				"description" => wp_kses_data( __("WooCommerce shortcode: display one product", 'insurance-ancora') ),
				"category" => esc_html__('WooCommerce', 'insurance-ancora'),
				'icon' => 'icon_trx_product',
				"class" => "trx_sc_single trx_sc_product",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "sku",
						"heading" => esc_html__("SKU", 'insurance-ancora'),
						"description" => wp_kses_data( __("Product's SKU code", 'insurance-ancora') ),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "id",
						"heading" => esc_html__("ID", 'insurance-ancora'),
						"description" => wp_kses_data( __("Product's ID", 'insurance-ancora') ),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					)
				)
			) );
			
			class WPBakeryShortCode_Product extends Insurance_Ancora_VC_ShortCodeSingle {}
		
		
			// WooCommerce - Best Selling Products
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "best_selling_products",
				"name" => esc_html__("Best Selling Products", 'insurance-ancora'),
				"description" => wp_kses_data( __("WooCommerce shortcode: show best selling products", 'insurance-ancora') ),
				"category" => esc_html__('WooCommerce', 'insurance-ancora'),
				'icon' => 'icon_trx_best_selling_products',
				"class" => "trx_sc_single trx_sc_best_selling_products",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "per_page",
						"heading" => esc_html__("Number", 'insurance-ancora'),
						"description" => wp_kses_data( __("How many products showed", 'insurance-ancora') ),
						"admin_label" => true,
						"class" => "",
						"value" => "4",
						"type" => "textfield"
					),
					array(
						"param_name" => "columns",
						"heading" => esc_html__("Columns", 'insurance-ancora'),
						"description" => wp_kses_data( __("How many columns per row use for products output", 'insurance-ancora') ),
						"admin_label" => true,
						"class" => "",
						"value" => "1",
						"type" => "textfield"
					)
				)
			) );
			
			class WPBakeryShortCode_Best_Selling_Products extends Insurance_Ancora_VC_ShortCodeSingle {}
		
		
		
			// WooCommerce - Recent Products
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "recent_products",
				"name" => esc_html__("Recent Products", 'insurance-ancora'),
				"description" => wp_kses_data( __("WooCommerce shortcode: show recent products", 'insurance-ancora') ),
				"category" => esc_html__('WooCommerce', 'insurance-ancora'),
				'icon' => 'icon_trx_recent_products',
				"class" => "trx_sc_single trx_sc_recent_products",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "per_page",
						"heading" => esc_html__("Number", 'insurance-ancora'),
						"description" => wp_kses_data( __("How many products showed", 'insurance-ancora') ),
						"admin_label" => true,
						"class" => "",
						"value" => "4",
						"type" => "textfield"

					),
					array(
						"param_name" => "columns",
						"heading" => esc_html__("Columns", 'insurance-ancora'),
						"description" => wp_kses_data( __("How many columns per row use for products output", 'insurance-ancora') ),
						"admin_label" => true,
						"class" => "",
						"value" => "1",
						"type" => "textfield"
					),
					array(
						"param_name" => "orderby",
						"heading" => esc_html__("Order by", 'insurance-ancora'),
						"description" => wp_kses_data( __("Sorting order for products output", 'insurance-ancora') ),
						"admin_label" => true,
						"class" => "",
						"value" => array(
							esc_html__('Date', 'insurance-ancora') => 'date',
							esc_html__('Title', 'insurance-ancora') => 'title'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "order",
						"heading" => esc_html__("Order", 'insurance-ancora'),
						"description" => wp_kses_data( __("Sorting order for products output", 'insurance-ancora') ),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip((array)insurance_ancora_get_sc_param('ordering')),
						"type" => "dropdown"
					)
				)
			) );
			
			class WPBakeryShortCode_Recent_Products extends Insurance_Ancora_VC_ShortCodeSingle {}
		
		
		
			// WooCommerce - Related Products
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "related_products",
				"name" => esc_html__("Related Products", 'insurance-ancora'),
				"description" => wp_kses_data( __("WooCommerce shortcode: show related products", 'insurance-ancora') ),
				"category" => esc_html__('WooCommerce', 'insurance-ancora'),
				'icon' => 'icon_trx_related_products',
				"class" => "trx_sc_single trx_sc_related_products",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "posts_per_page",
						"heading" => esc_html__("Number", 'insurance-ancora'),
						"description" => wp_kses_data( __("How many products showed", 'insurance-ancora') ),
						"admin_label" => true,
						"class" => "",
						"value" => "4",
						"type" => "textfield"
					),
					array(
						"param_name" => "columns",
						"heading" => esc_html__("Columns", 'insurance-ancora'),
						"description" => wp_kses_data( __("How many columns per row use for products output", 'insurance-ancora') ),
						"admin_label" => true,
						"class" => "",
						"value" => "1",
						"type" => "textfield"
					),
					array(
						"param_name" => "orderby",
						"heading" => esc_html__("Order by", 'insurance-ancora'),
						"description" => wp_kses_data( __("Sorting order for products output", 'insurance-ancora') ),
						"admin_label" => true,
						"class" => "",
						"value" => array(
							esc_html__('Date', 'insurance-ancora') => 'date',
							esc_html__('Title', 'insurance-ancora') => 'title'
						),
						"type" => "dropdown"
					)
				)
			) );
			
			class WPBakeryShortCode_Related_Products extends Insurance_Ancora_VC_ShortCodeSingle {}
		
		
		
			// WooCommerce - Featured Products
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "featured_products",
				"name" => esc_html__("Featured Products", 'insurance-ancora'),
				"description" => wp_kses_data( __("WooCommerce shortcode: show featured products", 'insurance-ancora') ),
				"category" => esc_html__('WooCommerce', 'insurance-ancora'),
				'icon' => 'icon_trx_featured_products',
				"class" => "trx_sc_single trx_sc_featured_products",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "per_page",
						"heading" => esc_html__("Number", 'insurance-ancora'),
						"description" => wp_kses_data( __("How many products showed", 'insurance-ancora') ),
						"admin_label" => true,
						"class" => "",
						"value" => "4",
						"type" => "textfield"
					),
					array(
						"param_name" => "columns",
						"heading" => esc_html__("Columns", 'insurance-ancora'),
						"description" => wp_kses_data( __("How many columns per row use for products output", 'insurance-ancora') ),
						"admin_label" => true,
						"class" => "",
						"value" => "1",
						"type" => "textfield"
					),
					array(
						"param_name" => "orderby",
						"heading" => esc_html__("Order by", 'insurance-ancora'),
						"description" => wp_kses_data( __("Sorting order for products output", 'insurance-ancora') ),
						"admin_label" => true,
						"class" => "",
						"value" => array(
							esc_html__('Date', 'insurance-ancora') => 'date',
							esc_html__('Title', 'insurance-ancora') => 'title'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "order",
						"heading" => esc_html__("Order", 'insurance-ancora'),
						"description" => wp_kses_data( __("Sorting order for products output", 'insurance-ancora') ),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip((array)insurance_ancora_get_sc_param('ordering')),
						"type" => "dropdown"
					)
				)
			) );
			
			class WPBakeryShortCode_Featured_Products extends Insurance_Ancora_VC_ShortCodeSingle {}
		
		
		
			// WooCommerce - Top Rated Products
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "top_rated_products",
				"name" => esc_html__("Top Rated Products", 'insurance-ancora'),
				"description" => wp_kses_data( __("WooCommerce shortcode: show top rated products", 'insurance-ancora') ),
				"category" => esc_html__('WooCommerce', 'insurance-ancora'),
				'icon' => 'icon_trx_top_rated_products',
				"class" => "trx_sc_single trx_sc_top_rated_products",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "per_page",
						"heading" => esc_html__("Number", 'insurance-ancora'),
						"description" => wp_kses_data( __("How many products showed", 'insurance-ancora') ),
						"admin_label" => true,
						"class" => "",
						"value" => "4",
						"type" => "textfield"
					),
					array(
						"param_name" => "columns",
						"heading" => esc_html__("Columns", 'insurance-ancora'),
						"description" => wp_kses_data( __("How many columns per row use for products output", 'insurance-ancora') ),
						"admin_label" => true,
						"class" => "",
						"value" => "1",
						"type" => "textfield"
					),
					array(
						"param_name" => "orderby",
						"heading" => esc_html__("Order by", 'insurance-ancora'),
						"description" => wp_kses_data( __("Sorting order for products output", 'insurance-ancora') ),
						"admin_label" => true,
						"class" => "",
						"value" => array(
							esc_html__('Date', 'insurance-ancora') => 'date',
							esc_html__('Title', 'insurance-ancora') => 'title'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "order",
						"heading" => esc_html__("Order", 'insurance-ancora'),
						"description" => wp_kses_data( __("Sorting order for products output", 'insurance-ancora') ),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip((array)insurance_ancora_get_sc_param('ordering')),
						"type" => "dropdown"
					)
				)
			) );
			
			class WPBakeryShortCode_Top_Rated_Products extends Insurance_Ancora_VC_ShortCodeSingle {}
		
		
		
			// WooCommerce - Sale Products
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "sale_products",
				"name" => esc_html__("Sale Products", 'insurance-ancora'),
				"description" => wp_kses_data( __("WooCommerce shortcode: list products on sale", 'insurance-ancora') ),
				"category" => esc_html__('WooCommerce', 'insurance-ancora'),
				'icon' => 'icon_trx_sale_products',
				"class" => "trx_sc_single trx_sc_sale_products",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "per_page",
						"heading" => esc_html__("Number", 'insurance-ancora'),
						"description" => wp_kses_data( __("How many products showed", 'insurance-ancora') ),
						"admin_label" => true,
						"class" => "",
						"value" => "4",
						"type" => "textfield"
					),
					array(
						"param_name" => "columns",
						"heading" => esc_html__("Columns", 'insurance-ancora'),
						"description" => wp_kses_data( __("How many columns per row use for products output", 'insurance-ancora') ),
						"admin_label" => true,
						"class" => "",
						"value" => "1",
						"type" => "textfield"
					),
					array(
						"param_name" => "orderby",
						"heading" => esc_html__("Order by", 'insurance-ancora'),
						"description" => wp_kses_data( __("Sorting order for products output", 'insurance-ancora') ),
						"admin_label" => true,
						"class" => "",
						"value" => array(
							esc_html__('Date', 'insurance-ancora') => 'date',
							esc_html__('Title', 'insurance-ancora') => 'title'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "order",
						"heading" => esc_html__("Order", 'insurance-ancora'),
						"description" => wp_kses_data( __("Sorting order for products output", 'insurance-ancora') ),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip((array)insurance_ancora_get_sc_param('ordering')),
						"type" => "dropdown"
					)
				)
			) );
			
			class WPBakeryShortCode_Sale_Products extends Insurance_Ancora_VC_ShortCodeSingle {}
		
		
		
			// WooCommerce - Product Category
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "product_category",
				"name" => esc_html__("Products from category", 'insurance-ancora'),
				"description" => wp_kses_data( __("WooCommerce shortcode: list products in specified category(-ies)", 'insurance-ancora') ),
				"category" => esc_html__('WooCommerce', 'insurance-ancora'),
				'icon' => 'icon_trx_product_category',
				"class" => "trx_sc_single trx_sc_product_category",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "per_page",
						"heading" => esc_html__("Number", 'insurance-ancora'),
						"description" => wp_kses_data( __("How many products showed", 'insurance-ancora') ),
						"admin_label" => true,
						"class" => "",
						"value" => "4",
						"type" => "textfield"
					),
					array(
						"param_name" => "columns",
						"heading" => esc_html__("Columns", 'insurance-ancora'),
						"description" => wp_kses_data( __("How many columns per row use for products output", 'insurance-ancora') ),
						"admin_label" => true,
						"class" => "",
						"value" => "1",
						"type" => "textfield"
					),
					array(
						"param_name" => "orderby",
						"heading" => esc_html__("Order by", 'insurance-ancora'),
						"description" => wp_kses_data( __("Sorting order for products output", 'insurance-ancora') ),
						"admin_label" => true,
						"class" => "",
						"value" => array(
							esc_html__('Date', 'insurance-ancora') => 'date',
							esc_html__('Title', 'insurance-ancora') => 'title'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "order",
						"heading" => esc_html__("Order", 'insurance-ancora'),
						"description" => wp_kses_data( __("Sorting order for products output", 'insurance-ancora') ),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip((array)insurance_ancora_get_sc_param('ordering')),
						"type" => "dropdown"
					),
					array(
						"param_name" => "category",
						"heading" => esc_html__("Categories", 'insurance-ancora'),
						"description" => wp_kses_data( __("Comma separated category slugs", 'insurance-ancora') ),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "operator",
						"heading" => esc_html__("Operator", 'insurance-ancora'),
						"description" => wp_kses_data( __("Categories operator", 'insurance-ancora') ),
						"admin_label" => true,
						"class" => "",
						"value" => array(
							esc_html__('IN', 'insurance-ancora') => 'IN',
							esc_html__('NOT IN', 'insurance-ancora') => 'NOT IN',
							esc_html__('AND', 'insurance-ancora') => 'AND'
						),
						"type" => "dropdown"
					)
				)
			) );
			
			class WPBakeryShortCode_Product_Category extends Insurance_Ancora_VC_ShortCodeSingle {}
		
		
		
			// WooCommerce - Products
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "products",
				"name" => esc_html__("Products", 'insurance-ancora'),
				"description" => wp_kses_data( __("WooCommerce shortcode: list all products", 'insurance-ancora') ),
				"category" => esc_html__('WooCommerce', 'insurance-ancora'),
				'icon' => 'icon_trx_products',
				"class" => "trx_sc_single trx_sc_products",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "skus",
						"heading" => esc_html__("SKUs", 'insurance-ancora'),
						"description" => wp_kses_data( __("Comma separated SKU codes of products", 'insurance-ancora') ),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "ids",
						"heading" => esc_html__("IDs", 'insurance-ancora'),
						"description" => wp_kses_data( __("Comma separated ID of products", 'insurance-ancora') ),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "columns",
						"heading" => esc_html__("Columns", 'insurance-ancora'),
						"description" => wp_kses_data( __("How many columns per row use for products output", 'insurance-ancora') ),
						"admin_label" => true,
						"class" => "",
						"value" => "1",
						"type" => "textfield"
					),
					array(
						"param_name" => "orderby",
						"heading" => esc_html__("Order by", 'insurance-ancora'),
						"description" => wp_kses_data( __("Sorting order for products output", 'insurance-ancora') ),
						"admin_label" => true,
						"class" => "",
						"value" => array(
							esc_html__('Date', 'insurance-ancora') => 'date',
							esc_html__('Title', 'insurance-ancora') => 'title'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "order",
						"heading" => esc_html__("Order", 'insurance-ancora'),
						"description" => wp_kses_data( __("Sorting order for products output", 'insurance-ancora') ),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip((array)insurance_ancora_get_sc_param('ordering')),
						"type" => "dropdown"
					)
				)
			) );
			
			class WPBakeryShortCode_Products extends Insurance_Ancora_VC_ShortCodeSingle {}
		
		
		
		
			// WooCommerce - Product Attribute
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "product_attribute",
				"name" => esc_html__("Products by Attribute", 'insurance-ancora'),
				"description" => wp_kses_data( __("WooCommerce shortcode: show products with specified attribute", 'insurance-ancora') ),
				"category" => esc_html__('WooCommerce', 'insurance-ancora'),
				'icon' => 'icon_trx_product_attribute',
				"class" => "trx_sc_single trx_sc_product_attribute",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "per_page",
						"heading" => esc_html__("Number", 'insurance-ancora'),
						"description" => wp_kses_data( __("How many products showed", 'insurance-ancora') ),
						"admin_label" => true,
						"class" => "",
						"value" => "4",
						"type" => "textfield"
					),
					array(
						"param_name" => "columns",
						"heading" => esc_html__("Columns", 'insurance-ancora'),
						"description" => wp_kses_data( __("How many columns per row use for products output", 'insurance-ancora') ),
						"admin_label" => true,
						"class" => "",
						"value" => "1",
						"type" => "textfield"
					),
					array(
						"param_name" => "orderby",
						"heading" => esc_html__("Order by", 'insurance-ancora'),
						"description" => wp_kses_data( __("Sorting order for products output", 'insurance-ancora') ),
						"admin_label" => true,
						"class" => "",
						"value" => array(
							esc_html__('Date', 'insurance-ancora') => 'date',
							esc_html__('Title', 'insurance-ancora') => 'title'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "order",
						"heading" => esc_html__("Order", 'insurance-ancora'),
						"description" => wp_kses_data( __("Sorting order for products output", 'insurance-ancora') ),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip((array)insurance_ancora_get_sc_param('ordering')),
						"type" => "dropdown"
					),
					array(
						"param_name" => "attribute",
						"heading" => esc_html__("Attribute", 'insurance-ancora'),
						"description" => wp_kses_data( __("Attribute name", 'insurance-ancora') ),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "filter",
						"heading" => esc_html__("Filter", 'insurance-ancora'),
						"description" => wp_kses_data( __("Attribute value", 'insurance-ancora') ),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					)
				)
			) );
			
			class WPBakeryShortCode_Product_Attribute extends Insurance_Ancora_VC_ShortCodeSingle {}
		
		
		
			// WooCommerce - Products Categories
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "product_categories",
				"name" => esc_html__("Product Categories", 'insurance-ancora'),
				"description" => wp_kses_data( __("WooCommerce shortcode: show categories with products", 'insurance-ancora') ),
				"category" => esc_html__('WooCommerce', 'insurance-ancora'),
				'icon' => 'icon_trx_product_categories',
				"class" => "trx_sc_single trx_sc_product_categories",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "number",
						"heading" => esc_html__("Number", 'insurance-ancora'),
						"description" => wp_kses_data( __("How many categories showed", 'insurance-ancora') ),
						"admin_label" => true,
						"class" => "",
						"value" => "4",
						"type" => "textfield"
					),
					array(
						"param_name" => "columns",
						"heading" => esc_html__("Columns", 'insurance-ancora'),
						"description" => wp_kses_data( __("How many columns per row use for categories output", 'insurance-ancora') ),
						"admin_label" => true,
						"class" => "",
						"value" => "1",
						"type" => "textfield"
					),
					array(
						"param_name" => "orderby",
						"heading" => esc_html__("Order by", 'insurance-ancora'),
						"description" => wp_kses_data( __("Sorting order for products output", 'insurance-ancora') ),
						"admin_label" => true,
						"class" => "",
						"value" => array(
							esc_html__('Date', 'insurance-ancora') => 'date',
							esc_html__('Title', 'insurance-ancora') => 'title'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "order",
						"heading" => esc_html__("Order", 'insurance-ancora'),
						"description" => wp_kses_data( __("Sorting order for products output", 'insurance-ancora') ),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip((array)insurance_ancora_get_sc_param('ordering')),
						"type" => "dropdown"
					),
					array(
						"param_name" => "parent",
						"heading" => esc_html__("Parent", 'insurance-ancora'),
						"description" => wp_kses_data( __("Parent category slug", 'insurance-ancora') ),
						"admin_label" => true,
						"class" => "",
						"value" => "date",
						"type" => "textfield"
					),
					array(
						"param_name" => "ids",
						"heading" => esc_html__("IDs", 'insurance-ancora'),
						"description" => wp_kses_data( __("Comma separated ID of products", 'insurance-ancora') ),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "hide_empty",
						"heading" => esc_html__("Hide empty", 'insurance-ancora'),
						"description" => wp_kses_data( __("Hide empty categories", 'insurance-ancora') ),
						"class" => "",
						"value" => array("Hide empty" => "1" ),
						"type" => "checkbox"
					)
				)
			) );
			
			class WPBakeryShortCode_Products_Categories extends Insurance_Ancora_VC_ShortCodeSingle {}
		
		}
	}
}
?>