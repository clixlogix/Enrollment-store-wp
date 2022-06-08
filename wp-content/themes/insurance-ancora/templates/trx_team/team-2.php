<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'insurance_ancora_template_team_2_theme_setup' ) ) {
	add_action( 'insurance_ancora_action_before_init_theme', 'insurance_ancora_template_team_2_theme_setup', 1 );
	function insurance_ancora_template_team_2_theme_setup() {
		insurance_ancora_add_template(array(
			'layout' => 'team-2',
			'template' => 'team-2',
			'mode'   => 'team',
			'title'  => esc_html__('Team /Style 2/', 'insurance-ancora'),
			'thumb_title'  => esc_html__('Medium square image (crop) T2', 'insurance-ancora'),
			'w' => 270,
			'h' => 280
		));
	}
}

// Template output
if ( !function_exists( 'insurance_ancora_template_team_2_output' ) ) {
	function insurance_ancora_template_team_2_output($post_options, $post_data) {
		$show_title = true;
		$parts = explode('_', $post_options['layout']);
		$style = $parts[0];
		$columns = max(1, min(12, empty($parts[1]) ? (!empty($post_options['columns_count']) ? $post_options['columns_count'] : 1) : (int) $parts[1]));
		if (insurance_ancora_param_is_on($post_options['slider'])) {
			?><div class="swiper-slide" data-style="<?php echo esc_attr($post_options['tag_css_wh']); ?>" style="<?php echo esc_attr($post_options['tag_css_wh']); ?>"><?php
		} else if ($columns > 1) {
			?><div class="column-1_<?php echo esc_attr($columns); ?> column_padding_bottom"><?php
		}
		?>
			<div<?php echo !empty($post_options['tag_id']) ? ' id="'.esc_attr($post_options['tag_id']).'"' : ''; ?>
				class="sc_team_item sc_team_item_<?php echo esc_attr($post_options['number']) . ($post_options['number'] % 2 == 1 ? ' odd' : ' even') . ($post_options['number'] == 1 ? ' first' : ''). (!empty($post_options['tag_class']) ? ' '.esc_attr($post_options['tag_class']) : ''); ?> columns_wrap"
				<?php echo (!empty($post_options['tag_css']) ? ' style="'.esc_attr($post_options['tag_css']).'"' : '') 
					. (!insurance_ancora_param_is_off($post_options['tag_animation']) ? ' data-animation="'.esc_attr(insurance_ancora_get_animation_classes($post_options['tag_animation'])).'"' : ''); ?>
			><div class="sc_team_item_avatar column-1_2">
					<?php insurance_ancora_show_layout($post_options['photo']); ?>
			</div><div class="sc_team_item_info column-1_2">
				<h4 class="sc_team_item_title"><?php echo (!empty($post_options['link']) ? '<a href="'.esc_url($post_options['link']).'">' : '') . (!empty($post_data['post_id']) ? insurance_ancora_get_post_title($post_data['post_id']) : '') . (!empty($post_options['link']) ? '</a>' : ''); ?></h4>
				<div class="sc_team_item_position"><?php echo trim($post_options['position']);?></div>
                    <div class="sc_team_item_meta">
                        <div class="sc_team_item_description"><?php echo trim($post_options['descr']);?></div>
                        <?php echo (!empty($post_options['skype']) ? '<div class="sc_team_item_skype"><span class="sc_team_descr_icon icon-skype"></span>' . trim($post_options['skype']) . '</div>' : '');?>
                        <?php echo (!empty($post_options['email']) ? '<div class="sc_team_item_mail"><span class="sc_team_descr_icon icon-mail-squared"></span>' . trim($post_options['email']) . '</div>' : '');?>
                        <?php echo (!empty($post_options['phone']) ? '<div class="sc_team_item_phone"><span class="sc_team_descr_icon icon-phone-1"></span>' . trim($post_options['phone']) . '</div>' : '');?>
                        <div class="sc_team_item_description"><?php insurance_ancora_show_layout(insurance_ancora_strshort($post_data['post_excerpt'], isset($post_options['descr']) ? $post_options['descr'] : insurance_ancora_get_custom_option('post_excerpt_maxlength_masonry'))); ?></div>
                    </div>
			</div></div>
		<?php
		if (insurance_ancora_param_is_on($post_options['slider']) || $columns > 1) {
			?></div><?php
		}
	}
}
?>