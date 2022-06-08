<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'insurance_ancora_template_header_1_theme_setup' ) ) {
	add_action( 'insurance_ancora_action_before_init_theme', 'insurance_ancora_template_header_1_theme_setup', 1 );
	function insurance_ancora_template_header_1_theme_setup() {
		insurance_ancora_add_template(array(
			'layout' => 'header_1',
			'mode'   => 'header',
			'title'  => esc_html__('Header 1', 'insurance-ancora'),
			'icon'   => insurance_ancora_get_file_url('templates/headers/images/1.jpg')
			));
	}
}

// Template output
if ( !function_exists( 'insurance_ancora_template_header_1_output' ) ) {
	function insurance_ancora_template_header_1_output($post_options, $post_data) {

		// WP custom header
		$header_css = '';
		if ($post_options['position'] != 'over') {
			$header_image = get_header_image();
			$header_css = $header_image!='' 
				? ' style="background-image: url('.esc_url($header_image).')"' 
				: '';
		}
		?>
		
		<div class="top_panel_fixed_wrap"></div>

		<header class="top_panel_wrap top_panel_style_1 scheme_<?php echo esc_attr($post_options['scheme']); ?>">
			<div class="top_panel_wrap_inner top_panel_inner_style_1 top_panel_position_<?php echo esc_attr(insurance_ancora_get_custom_option('top_panel_position')); ?>">
			
			<?php if (insurance_ancora_get_custom_option('show_top_panel_top')=='yes') { ?>
				<div class="top_panel_top">
					<div class="content_wrap clearfix">
						<?php
						insurance_ancora_template_set_args('top-panel-top', array(
							'top_panel_top_components' => array('contact_info', 'open_hours', 'login', 'socials', 'currency', 'bookmarks')
						));
						get_template_part(insurance_ancora_get_file_slug('templates/headers/_parts/top-panel-top.php'));
						?>
					</div>
				</div>
			<?php } ?>

			<div class="top_panel_middle" <?php insurance_ancora_show_layout($header_css); ?>>
				<div class="content_wrap">
					<div class="columns_wrap columns_fluid">
						<div class="column-2_5 contact_logo">
							<?php insurance_ancora_show_logo(); ?>
						</div><?php
						// Address
						$contact_address_1=trim(insurance_ancora_get_custom_option('contact_address_1'));
						$contact_address_2=trim(insurance_ancora_get_custom_option('contact_address_2'));
                        $contact_phone=trim(insurance_ancora_get_custom_option('contact_phone'));
                        $contact_email=trim(insurance_ancora_get_custom_option('contact_email'));
						if (!empty($contact_address_1) || !empty($contact_address_2)) {
							?><div class="column-3_5 contact_field_wrapper">
                            <div class="contact_field contact_phone">
                                <span class="contact_icon icon-phone-1"></span>
                                <span class="contact_label contact_phone">
                                	<?php insurance_ancora_show_layout( '<a href="tel:'.$contact_phone.'">'.$contact_phone.'</a>'); ?>
                                	</span>
                                	<br>
                                	<span class="header_social">
                                		<ul>
												<li><img src="<?php echo home_url()?>/wp-content/uploads/2021/09/facebook-1.png"></li>
												<li><img src="<?php echo home_url()?>/wp-content/uploads/2021/09/instagram-1.png"></li>
												<li><img src="<?php echo home_url()?>/wp-content/uploads/2021/09/linkedIn-1.png"></li>
												<!-- <li><img src="http://clixlogix.org/test/Enrollment-store-wp/wp-content/uploads/2021/09/youtube.png"></li>
												<li><img src="http://clixlogix.org/test/Enrollment-store-wp/wp-content/uploads/2021/09/unknown.png"></li> -->
											</ul>
                                	</span>

                            </div>
                            <div class="contact_field contact_address">
                                <span class="contact_icon icon-location"></span>
                                <span class="contact_address_2"><?php insurance_ancora_show_layout($contact_address_2); ?></span>
                                <span class="contact_address_1"><?php insurance_ancora_show_layout($contact_address_1); ?></span>
                            </div>
							</div><?php
						}

						?>
                    </div>
				</div>
			</div>

			<div class="top_panel_bottom">
				<div class="content_wrap clearfix">
					<nav class="menu_main_nav_area menu_hover_<?php echo esc_attr(insurance_ancora_get_theme_option('menu_hover')); ?>">
						<?php
						$menu_main = insurance_ancora_get_nav_menu('menu_main');
						if (empty($menu_main)) $menu_main = insurance_ancora_get_nav_menu();
						insurance_ancora_show_layout($menu_main);
						?>
					</nav>
					<?php
                        if (insurance_ancora_get_custom_option('show_appointments_button')=='yes' && function_exists("insurance_ancora_sc_button")) {
                            insurance_ancora_show_layout(insurance_ancora_sc_button(array('size'=>"small", 'link'=>esc_attr(insurance_ancora_get_custom_option('appointments_button_link')), 'class'=>"appointments_button"), esc_attr(insurance_ancora_get_custom_option('appointments_button_caption'))));
                        }
                        if (insurance_ancora_get_custom_option('show_search')=='yes' && function_exists('insurance_ancora_sc_search')) insurance_ancora_show_layout(insurance_ancora_sc_search(array()));
                    ?>

				</div>
			</div>

			</div>
		</header>

		<?php
		insurance_ancora_storage_set('header_mobile', array(
			 'open_hours' => false,
			 'login' => false,
			 'socials' => false,
			 'bookmarks' => false,
			 'contact_address' => false,
			 'contact_phone_email' => false,
			 'woo_cart' => false,
			 'search' => false
			)
		);
	}
}
?>