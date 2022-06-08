<?php
/**
 * Single post
 */
get_header(); 

$single_style = insurance_ancora_storage_get('single_style');
if (empty($single_style)) $single_style = insurance_ancora_get_custom_option('single_style');

while ( have_posts() ) { the_post();
	insurance_ancora_show_post_layout(
		array(
			'layout' => $single_style,
			'sidebar' => !insurance_ancora_param_is_off(insurance_ancora_get_custom_option('show_sidebar_main')),
			'content' => insurance_ancora_get_template_property($single_style, 'need_content'),
			'terms_list' => insurance_ancora_get_template_property($single_style, 'need_terms')
		)
	);
}

get_footer();
?>