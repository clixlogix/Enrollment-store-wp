<?php
/**
 * Child-Theme functions and definitions
 */


add_action('wp_footer', 'copyright_menu');

function copyright_menu(){
?>
<!-- <div id="copy-menu">
	<ul id="menu_footer-2" class="menu_footer_nav">
		<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="#"><span>Privacy Policy</span></a></li>
	    <li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="#"><span>Terms And Conditions</span></a></li>
	</ul>
</div> -->
<script type="text/javascript">
	// jQuery(document).ready(function(){
	// 	jQuery('#copy-menu').appendTo('.copyright_wrap_inner .content_wrap');
	// });
</script>
<?php
}


add_action('wp_footer', 'additional_js');

function additional_js(){
?>
<script type="text/javascript">
	jQuery(document).ready(function(){

		 jQuery('input[name="zip-code"]').keyup(function(e)
		                                {
		  if (/\D/g.test(this.value))
		  {
		    // Filter non-digits from input value.
		    this.value = this.value.replace(/\D/g, '');
		  }
		});

		jQuery('input[name="mobile"]').keyup(function(e)
		                                {
		  if (/\D/g.test(this.value))
		  {
		    // Filter non-digits from input value.
		    this.value = this.value.replace(/\D/g, '');
		  }
		});

	});
</script>

<?php
}
