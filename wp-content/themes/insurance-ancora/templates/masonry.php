<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'insurance_ancora_template_masonry_theme_setup' ) ) {
	add_action( 'insurance_ancora_action_before_init_theme', 'insurance_ancora_template_masonry_theme_setup', 1 );
	function insurance_ancora_template_masonry_theme_setup() {
		insurance_ancora_add_template(array(
			'layout' => 'masonry_2',
			'template' => 'masonry',
			'mode'   => 'blog',
			'need_isotope' => true,
			'title'  => esc_html__('Masonry tile (different height) /2 columns/', 'insurance-ancora'),
			'thumb_title'  => esc_html__('Medium image', 'insurance-ancora'),
			'w'		 => 370,
			'h_crop' => 209,
			'h'      => null
		));
		insurance_ancora_add_template(array(
			'layout' => 'masonry_3',
			'template' => 'masonry',
			'mode'   => 'blog',
			'need_isotope' => true,
			'title'  => esc_html__('Masonry tile /3 columns/', 'insurance-ancora'),
			'thumb_title'  => esc_html__('Medium image', 'insurance-ancora'),
			'w'		 => 370,
			'h_crop' => 209,
			'h'      => null
		));
		insurance_ancora_add_template(array(
			'layout' => 'masonry_4',
			'template' => 'masonry',
			'mode'   => 'blog',
			'need_isotope' => true,
			'title'  => esc_html__('Masonry tile /4 columns/', 'insurance-ancora'),
			'thumb_title'  => esc_html__('Medium image', 'insurance-ancora'),
			'w'		 => 370,
			'h_crop' => 209,
			'h'      => null
		));
		insurance_ancora_add_template(array(
			'layout' => 'classic_2',
			'template' => 'masonry',
			'mode'   => 'blog',
			'need_isotope' => true,
			'title'  => esc_html__('Classic tile (equal height) /2 columns/', 'insurance-ancora'),
			'thumb_title'  => esc_html__('Medium image (crop)', 'insurance-ancora'),
			'w'		 => 370,
			'h'		 => 209
		));
		insurance_ancora_add_template(array(
			'layout' => 'classic_3',
			'template' => 'masonry',
			'mode'   => 'blog',
			'need_isotope' => true,
			'title'  => esc_html__('Classic tile /3 columns/', 'insurance-ancora'),
			'thumb_title'  => esc_html__('Medium image (crop)Cl3', 'insurance-ancora'),
			'w'		 => 370,
			'h'		 => 189
		));
		insurance_ancora_add_template(array(
			'layout' => 'classic_4',
			'template' => 'masonry',
			'mode'   => 'blog',
			'need_isotope' => true,
			'title'  => esc_html__('Classic tile /4 columns/', 'insurance-ancora'),
			'thumb_title'  => esc_html__('Medium image (crop)', 'insurance-ancora'),
			'w'		 => 370,
			'h'		 => 209
		));
		// Add template specific scripts
		add_action('insurance_ancora_action_blog_scripts', 'insurance_ancora_template_masonry_add_scripts');
	}
}

// Add template specific scripts
if (!function_exists('insurance_ancora_template_masonry_add_scripts')) {
	function insurance_ancora_template_masonry_add_scripts($style) {
		if (in_array(insurance_ancora_substr($style, 0, 8), array('classic_', 'masonry_'))) {
			wp_enqueue_script( 'isotope', insurance_ancora_get_file_url('js/jquery.isotope.min.js'), array(), null, true );
		}
	}
}

// Template output
if ( !function_exists( 'insurance_ancora_template_masonry_output' ) ) {
	function insurance_ancora_template_masonry_output($post_options, $post_data) {
		$show_title = !in_array($post_data['post_format'], array('aside', 'chat', 'status', 'link', 'quote'));
		$parts = explode('_', $post_options['layout']);
		$style = $parts[0];
		$columns = max(1, min(12, empty($post_options['columns_count']) 
									? (empty($parts[1]) ? 1 : (int) $parts[1])
									: $post_options['columns_count']
									));
		$tag = insurance_ancora_in_shortcode_blogger(true) ? 'div' : 'article';
		?>
		<div class="isotope_item isotope_item_<?php echo esc_attr($style); ?> isotope_item_<?php echo esc_attr($post_options['layout']); ?> isotope_column_<?php echo esc_attr($columns); ?>
					<?php
					if ($post_options['filters'] != '') {
						if ($post_options['filters']=='categories' && !empty($post_data['post_terms'][$post_data['post_taxonomy']]->terms_ids))
							echo ' flt_' . join(' flt_', $post_data['post_terms'][$post_data['post_taxonomy']]->terms_ids);
						else if ($post_options['filters']=='tags' && !empty($post_data['post_terms'][$post_data['post_taxonomy_tags']]->terms_ids))
							echo ' flt_' . join(' flt_', $post_data['post_terms'][$post_data['post_taxonomy_tags']]->terms_ids);
					}
					?>">
			<<?php insurance_ancora_show_layout($tag); ?> class="post_item post_item_<?php echo esc_attr($style); ?> post_item_<?php echo esc_attr($post_options['layout']); ?>
				 <?php echo ' post_format_'.esc_attr($post_data['post_format']) 
					. ($post_options['number']%2==0 ? ' even' : ' odd') 
					. ($post_options['number']==0 ? ' first' : '') 
					. ($post_options['number']==$post_options['posts_on_page'] ? ' last' : '');
				?>">
				
				<?php if ($post_data['post_video'] || $post_data['post_audio'] || $post_data['post_thumb'] ||  $post_data['post_gallery']) { ?>
					<div class="post_featured">
						<?php
						insurance_ancora_template_set_args('post-featured', array(
							'post_options' => $post_options,
							'post_data' => $post_data
						));
						get_template_part(insurance_ancora_get_file_slug('templates/_parts/post-featured.php'));
						?>
					</div>
				<?php } ?>

				<div class="post_content isotope_item_content">
					
					<?php
					if ($show_title) {
						if (!isset($post_options['links']) || $post_options['links']) {
							?>
							<h5 class="post_title"><a href="<?php echo esc_url($post_data['post_link']); ?>"><?php insurance_ancora_show_layout($post_data['post_title']); ?></a></h5>
							<?php
						} else {
							?>
							<h5 class="post_title"><?php insurance_ancora_show_layout($post_data['post_title']); ?></h5>
							<?php
						}
					}
					
					if (!$post_data['post_protected'] && $post_options['info']) {
						$post_options['info_parts'] = array('counters'=>true, 'terms'=>false, 'author'=>false);
						insurance_ancora_template_set_args('post-info', array(
							'post_options' => $post_options,
							'post_data' => $post_data
						));
						get_template_part(insurance_ancora_get_file_slug('templates/_parts/post-info.php'));
					}
					?>

					<div class="post_descr">
						<?php
						if ($post_data['post_protected']) {
							echo trim($post_data['post_excerpt']); 
						} else {
							if ($post_data['post_excerpt']) {
								echo in_array($post_data['post_format'], array('quote', 'link', 'chat', 'aside', 'status')) ? $post_data['post_excerpt'] : '<p>'.trim(insurance_ancora_strshort($post_data['post_excerpt'], isset($post_options['descr']) ? $post_options['descr'] : insurance_ancora_get_custom_option('post_excerpt_maxlength_masonry'))).'</p>';
							}
							if (empty($post_options['readmore'])) $post_options['readmore'] = esc_html__('Read more', 'insurance-ancora');
							if (!insurance_ancora_param_is_off($post_options['readmore']) && $style=='masonry' && !in_array($post_data['post_format'], array('quote', 'link', 'chat', 'aside', 'status'))) {
								insurance_ancora_show_layout(insurance_ancora_sc_button(array('link'=>$post_data['post_link']), $post_options['readmore']));
							}
						}
						?>
					</div>

				</div>				<!-- /.post_content -->
			</<?php insurance_ancora_show_layout($tag); ?>>	<!-- /.post_item -->
		</div>						<!-- /.isotope_item -->
		<?php
	}
}
?>