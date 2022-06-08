<?php

// Get theme variable
if (!function_exists('trx_utils_storage_get')) {
    function trx_utils_storage_get($var_name, $default='') {
        global $INSURANCE_ANCORA_STORAGE;
        return isset($INSURANCE_ANCORA_STORAGE[$var_name]) ? $INSURANCE_ANCORA_STORAGE[$var_name] : $default;
    }
}

// Get GET, POST value
if (!function_exists('trx_utils_get_value_gp')) {
    function trx_utils_get_value_gp($name, $defa='') {
        $rez = $defa;
        if (isset($_GET[$name])) {
            $rez = stripslashes(trim($_GET[$name]));
        } else if (isset($_POST[$name])) {
            $rez = stripslashes(trim($_POST[$name]));
        }
        return $rez;
    }
}

//Return Post Views Count
if (!function_exists('trx_utils_get_post_views')) {
    add_filter('trx_utils_filter_get_post_views', 'trx_utils_get_post_views', 10, 2);
    function trx_utils_get_post_views($default=0, $id=0){
        global $wp_query;
        if (!$id) $id = $wp_query->current_post>=0 ? get_the_ID() : $wp_query->post->ID;
        $count_key = trx_utils_storage_get('options_prefix').'_post_views_count';
        $count = get_post_meta($id, $count_key, true);
        if ($count===''){
            delete_post_meta($id, $count_key);
            add_post_meta($id, $count_key, '0');
            $count = 0;
        }
        return $count;
    }
}

//Set Post Views Count
if (!function_exists('trx_utils_set_post_views')) {
    add_action('trx_utils_filter_set_post_views', 'trx_utils_set_post_views', 10, 2);
    function trx_utils_set_post_views($id=0, $counter=-1) {
        global $wp_query;
        if (!$id) $id = $wp_query->current_post>=0 ? get_the_ID() : $wp_query->post->ID;
        $count_key = trx_utils_storage_get('options_prefix').'_post_views_count';
        $count = get_post_meta($id, $count_key, true);
        if ($count===''){
            delete_post_meta($id, $count_key);
            add_post_meta($id, $count_key, 1);
        } else {
            $count = $counter >= 0 ? $counter : $count+1;
            update_post_meta($id, $count_key, $count);
        }
    }
}

//Return Post Likes Count
if (!function_exists('trx_utils_get_post_likes')) {
    add_filter('trx_utils_filter_get_post_likes', 'trx_utils_get_post_likes', 10, 2);
    function trx_utils_get_post_likes($default=0, $id=0){
        global $wp_query;
        if (!$id) $id = $wp_query->current_post>=0 ? get_the_ID() : $wp_query->post->ID;
        $count_key = trx_utils_storage_get('options_prefix').'_post_likes_count';
        $count = get_post_meta($id, $count_key, true);
        if ($count===''){
            delete_post_meta($id, $count_key);
            add_post_meta($id, $count_key, '0');
            $count = 0;
        }
        return $count;
    }
}

//Set Post Likes Count
if (!function_exists('trx_utils_set_post_likes')) {
    add_action('trx_utils_filter_set_post_likes', 'trx_utils_set_post_likes', 10, 2);
    function trx_utils_set_post_likes($id=0, $count=0) {
        global $wp_query;
        if (!$id) $id = $wp_query->current_post>=0 ? get_the_ID() : $wp_query->post->ID;
        $count_key = trx_utils_storage_get('options_prefix').'_post_likes_count';
        update_post_meta($id, $count_key, $count);
    }
}

// AJAX: Set post likes/views count
if ( !function_exists( 'trx_utils_callback_post_counter' ) ) {
    function trx_utils_callback_post_counter() {

        if ( !wp_verify_nonce( trx_utils_get_value_gp('nonce'), admin_url('admin-ajax.php') ) )
            wp_die();

        $response = array('error'=>'');

        $id = (int) trx_utils_get_value_gpc('post_id');
        if (isset($_REQUEST['likes'])) {
            $counter = max(0, (int) $_REQUEST['likes']);
            trx_utils_set_post_likes($id, $counter);
        } else if (isset($_REQUEST['views'])) {
            $counter = max(0, (int) $_REQUEST['views']);
            trx_utils_set_post_views($id, $counter);
        }
        echo json_encode($response);
        wp_die();
    }
}


// Add scroll to top button
if (!function_exists('insurance_ancora_footer_add_scroll_to_top')) {
    function insurance_ancora_footer_add_scroll_to_top() {
        ?><a href="#" class="scroll_to_top icon-up" title="<?php esc_attr_e('Scroll to top', 'trx_utils'); ?>"></a><?php
    }
}