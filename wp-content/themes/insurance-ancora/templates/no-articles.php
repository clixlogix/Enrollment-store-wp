<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'insurance_ancora_template_no_articles_theme_setup' ) ) {
	add_action( 'insurance_ancora_action_before_init_theme', 'insurance_ancora_template_no_articles_theme_setup', 1 );
	function insurance_ancora_template_no_articles_theme_setup() {
		insurance_ancora_add_template(array(
			'layout' => 'no-articles',
			'mode'   => 'internal',
			'title'  => esc_html__('No articles found', 'insurance-ancora')
		));
	}
}

// Template output
if ( !function_exists( 'insurance_ancora_template_no_articles_output' ) ) {
	function insurance_ancora_template_no_articles_output($post_options, $post_data) {
		?>
		<article class="post_item">
			<div class="post_content">
				<h2 class="post_title"><?php esc_html_e('No posts found', 'insurance-ancora'); ?></h2>
				<p><?php esc_html_e( 'Sorry, but nothing matched your search criteria.', 'insurance-ancora' ); ?></p>
				<p><?php echo wp_kses_data( sprintf(__('Go back, or return to <a href="%s">%s</a> home page to choose a new page.', 'insurance-ancora'), esc_url(home_url('/')), get_bloginfo()) ); ?>
				<br><?php esc_html_e('Please report any broken links to our team.', 'insurance-ancora'); ?></p>
				<?php insurance_ancora_show_layout(insurance_ancora_sc_search(array('state'=>"fixed"))); ?>
			</div>	<!-- /.post_content -->
		</article>	<!-- /.post_item -->
		<?php
	}
}
?>