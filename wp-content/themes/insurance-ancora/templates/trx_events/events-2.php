<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'insurance_ancora_template_events_2_theme_setup' ) ) {
	add_action( 'insurance_ancora_action_before_init_theme', 'insurance_ancora_template_events_2_theme_setup', 1 );
	function insurance_ancora_template_events_2_theme_setup() {
		insurance_ancora_add_template(array(
			'layout' => 'events-2',
			'template' => 'events-2',
			'mode'   => 'events',
			'title'  => esc_html__('Events /Style 2/', 'insurance-ancora')
		));
	}
}

// Template output
if ( !function_exists( 'insurance_ancora_template_events_2_output' ) ) {
	function insurance_ancora_template_events_2_output($post_options, $post_data) {
		$show_title = true;
		$parts = explode('_', $post_options['layout']);
		$style = $parts[0];
		$columns = max(1, min(12, empty($parts[1]) ? (!empty($post_options['columns_count']) ? $post_options['columns_count'] : 1) : (int) $parts[1]));
		$start_date = explode('|', tribe_get_start_date(null, true, 'M,d|'.get_option('time_format')));
		$end_date = explode('|', tribe_get_end_date(null, true, 'M,d|'.get_option('time_format')));
		$sd = explode(',', $start_date[0]);
		if (tribe_event_is_all_day()) $start_date[1] = $end_date[1] = '';
		?>
		<div<?php echo !empty($post_options['tag_id']) ? ' id="'.esc_attr($post_options['tag_id']).'"' : ''; ?>
			class="sc_events_item sc_events_item_<?php echo esc_attr($post_options['number']) . ($post_options['number'] % 2 == 1 ? ' odd' : ' even') . ($post_options['number'] == 1 ? ' first' : '') . (!empty($post_options['tag_class']) ? ' '.esc_attr($post_options['tag_class']) : ''); ?>"
			<?php echo (!empty($post_options['tag_css']) ? ' style="'.esc_attr($post_options['tag_css']).'"' : '') 
				. (!insurance_ancora_param_is_off($post_options['tag_animation']) ? ' data-animation="'.esc_attr(insurance_ancora_get_animation_classes($post_options['tag_animation'])).'"' : ''); ?>
			>
			<span class="sc_events_item_date">
				<span class="sc_events_item_month"><?php insurance_ancora_show_layout($sd[0]); ?></span>
				<span class="sc_events_item_day"><?php insurance_ancora_show_layout($sd[1]); ?></span>
			</span><?php
			if ($show_title) {
				if ((!isset($post_options['links']) || $post_options['links']) && !empty($post_data['post_link'])) {
					?><h6 class="sc_events_item_title"><a href="<?php echo esc_url($post_data['post_link']); ?>"><?php insurance_ancora_show_layout($post_data['post_title']); ?></a></h6><?php
				} else {
					?><h6 class="sc_events_item_title"><?php insurance_ancora_show_layout($post_data['post_title']); ?></h6><?php
				}
			}
			?><span class="sc_events_item_time"><?php
				echo (trim($start_date[1]) ? $start_date[1] : esc_html__('Whole day', 'insurance-ancora'))
						. ($start_date[0]==$end_date[0] && trim($start_date[1]) && trim($end_date[1]) ? ' - ' . $end_date[1] : '');
			?></span><span class="sc_events_item_details"><?php
				if ((!isset($post_options['links']) || $post_options['links']) && !empty($post_data['post_link'])) {
					?><a href="<?php echo esc_url($post_data['post_link']); ?>"><?php insurance_ancora_show_layout($post_options['readmore']); ?></a><?php
				}
			?></span>
		</div>
		<?php
	}
}
?>