<?php
/**
 * The template for displaying the footer.
 */

				insurance_ancora_close_wrapper();	// <!-- </.content> -->

				// Show main sidebar
				get_sidebar();

				if (insurance_ancora_get_custom_option('body_style')!='fullscreen') insurance_ancora_close_wrapper();	// <!-- </.content_wrap> -->
				?>
			
			</div>		<!-- </.page_content_wrap> -->


			
			<?php

            // Footer contacts
            if (insurance_ancora_get_custom_option('show_contacts_in_footer')=='yes') {
                $footer_banner_title = insurance_ancora_get_theme_option('banner_footer_title');
                $footer_banner_image = insurance_ancora_get_theme_option('image_footer');
                $footer_banner_button_caption = insurance_ancora_get_theme_option('banner_footer_button_caption');
                $footer_banner_button_url = insurance_ancora_get_theme_option('banner_footer_button_link');
                    ?>
                    <footer class="contacts_wrap scheme_<?php echo esc_attr(insurance_ancora_get_custom_option('contacts_scheme')); ?>">
                        <div class="contacts_wrap_inner">
                            <div class="content_wrap">
                                <?php insurance_ancora_show_layout(insurance_ancora_sc_call_to_action(array('align'=>"left",'image'=>esc_attr($footer_banner_image),'title'=>esc_attr($footer_banner_title),'link'=>esc_url($footer_banner_button_url),'link_caption'=>esc_attr($footer_banner_button_caption) ))); ?>
                            </div>	<!-- /.content_wrap -->
                        </div>	<!-- /.contacts_wrap_inner -->
                    </footer>	<!-- /.contacts_wrap -->
                <?php
            }

			// Footer Testimonials stream
			if (insurance_ancora_get_custom_option('show_testimonials_in_footer')=='yes') { 
				$count = max(1, insurance_ancora_get_custom_option('testimonials_count'));
				$data = insurance_ancora_sc_testimonials(array('count'=>$count));
				if ($data) {
					?>
					<footer class="testimonials_wrap sc_section scheme_<?php echo esc_attr(insurance_ancora_get_custom_option('testimonials_scheme')); ?>">
						<div class="testimonials_wrap_inner sc_section_inner sc_section_overlay">
							<div class="content_wrap"><?php insurance_ancora_show_layout($data); ?></div>
						</div>
					</footer>
					<?php
				}
			}
			
			// Footer sidebar
			$footer_show  = insurance_ancora_get_custom_option('show_sidebar_footer');
			$sidebar_name = insurance_ancora_get_custom_option('sidebar_footer');
			if (!insurance_ancora_param_is_off($footer_show) && is_active_sidebar($sidebar_name)) { 
				insurance_ancora_storage_set('current_sidebar', 'footer');
				?>
				<footer class="footer_wrap widget_area scheme_<?php echo esc_attr(insurance_ancora_get_custom_option('sidebar_footer_scheme')); ?>">
					<div class="footer_wrap_inner widget_area_inner">
						<div class="content_wrap">
							<div class="columns_wrap"><?php
							ob_start();
							do_action( 'before_sidebar' );
                                if ( is_active_sidebar( $sidebar_name ) ) {
                                    dynamic_sidebar( $sidebar_name );
                                }
							do_action( 'after_sidebar' );
							$out = ob_get_contents();
							ob_end_clean();
							echo trim(chop(preg_replace("/<\/aside>[\r\n\s]*<aside/", "</aside><aside", $out)));
							?></div>	<!-- /.columns_wrap -->
						</div>	<!-- /.content_wrap -->
					</div>	<!-- /.footer_wrap_inner -->
				</footer>	<!-- /.footer_wrap -->
				<?php
			}


			// Footer Twitter stream
			if (insurance_ancora_get_custom_option('show_twitter_in_footer')=='yes') { 
				$count = max(1, insurance_ancora_get_custom_option('twitter_count'));
				$data = insurance_ancora_sc_twitter(array('count'=>$count));
				if ($data) {
					?>
					<footer class="twitter_wrap sc_section scheme_<?php echo esc_attr(insurance_ancora_get_custom_option('twitter_scheme')); ?>">
						<div class="twitter_wrap_inner sc_section_inner sc_section_overlay">
							<div class="content_wrap"><?php echo trim($data); ?></div>
						</div>
					</footer>
					<?php
				}
			}


			// Google map
			if ( insurance_ancora_get_custom_option('show_googlemap')=='yes' ) { 
				$map_address = insurance_ancora_get_custom_option('googlemap_address');
				$map_latlng  = insurance_ancora_get_custom_option('googlemap_latlng');
				$map_zoom    = insurance_ancora_get_custom_option('googlemap_zoom');
				$map_style   = insurance_ancora_get_custom_option('googlemap_style');
				$map_height  = insurance_ancora_get_custom_option('googlemap_height');
				if (!empty($map_address) || !empty($map_latlng)) {
					$args = array();
					if (!empty($map_style))		$args['style'] = esc_attr($map_style);
					if (!empty($map_zoom))		$args['zoom'] = esc_attr($map_zoom);
					if (!empty($map_height))	$args['height'] = esc_attr($map_height);
					echo trim(insurance_ancora_sc_googlemap($args));
				}
			}


			// Copyright area
			$copyright_style = insurance_ancora_get_custom_option('show_copyright_in_footer');
			if (!insurance_ancora_param_is_off($copyright_style)) {
				?> 
				<div class="copyright_wrap copyright_style_<?php echo esc_attr($copyright_style); ?>  scheme_<?php echo esc_attr(insurance_ancora_get_custom_option('copyright_scheme')); ?>">
					<div class="copyright_wrap_inner">
						<div class="content_wrap">
							<?php
							if ($copyright_style == 'menu') {
								if (($menu = insurance_ancora_get_nav_menu('menu_footer'))!='' && function_exists('insurance_ancora_sc_socials')) {
									echo trim($menu);
                                    echo trim(insurance_ancora_sc_socials(array('size'=>"tiny", 'shape'=>"round")));
								}
							} else if ($copyright_style == 'socials') {
                                echo trim(insurance_ancora_sc_socials(array('size'=>"tiny", 'shape'=>"round")));
							}
							?>
							<div class="copyright_text"><?php
                                $insurance_ancora_copyright = insurance_ancora_get_custom_option('footer_copyright');
                                $insurance_ancora_copyright = str_replace(array('{{Y}}', '{Y}'), date('Y'), $insurance_ancora_copyright);
                                insurance_ancora_show_layout($insurance_ancora_copyright); ?></div>
						</div>
					</div>
				</div>
				<?php
			}
			?>
			
		</div>	<!-- /.page_wrap -->

	</div>		<!-- /.body_wrap -->
	
	<?php if ( !insurance_ancora_param_is_off(insurance_ancora_get_custom_option('show_sidebar_outer')) ) { ?>
	</div>	<!-- /.outer_wrap -->
	<?php } ?>

	<?php wp_footer(); ?>

</body>
</html>