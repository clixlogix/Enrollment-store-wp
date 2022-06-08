<?php
/**
 * InsuranceAncora Framework: theme variables storage
 *
 * @package	insurance_ancora
 * @since	insurance_ancora 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Get theme variable
if (!function_exists('insurance_ancora_storage_get')) {
	function insurance_ancora_storage_get($var_name, $default='') {
		global $INSURANCE_ANCORA_STORAGE;
		return isset($INSURANCE_ANCORA_STORAGE[$var_name]) ? $INSURANCE_ANCORA_STORAGE[$var_name] : $default;
	}
}

// Set theme variable
if (!function_exists('insurance_ancora_storage_set')) {
	function insurance_ancora_storage_set($var_name, $value) {
		global $INSURANCE_ANCORA_STORAGE;
		$INSURANCE_ANCORA_STORAGE[$var_name] = $value;
	}
}

// Check if theme variable is empty
if (!function_exists('insurance_ancora_storage_empty')) {
	function insurance_ancora_storage_empty($var_name, $key='', $key2='') {
		global $INSURANCE_ANCORA_STORAGE;
		if (!empty($key) && !empty($key2))
			return empty($INSURANCE_ANCORA_STORAGE[$var_name][$key][$key2]);
		else if (!empty($key))
			return empty($INSURANCE_ANCORA_STORAGE[$var_name][$key]);
		else
			return empty($INSURANCE_ANCORA_STORAGE[$var_name]);
	}
}

// Check if theme variable is set
if (!function_exists('insurance_ancora_storage_isset')) {
	function insurance_ancora_storage_isset($var_name, $key='', $key2='') {
		global $INSURANCE_ANCORA_STORAGE;
		if (!empty($key) && !empty($key2))
			return isset($INSURANCE_ANCORA_STORAGE[$var_name][$key][$key2]);
		else if (!empty($key))
			return isset($INSURANCE_ANCORA_STORAGE[$var_name][$key]);
		else
			return isset($INSURANCE_ANCORA_STORAGE[$var_name]);
	}
}

// Inc/Dec theme variable with specified value
if (!function_exists('insurance_ancora_storage_inc')) {
	function insurance_ancora_storage_inc($var_name, $value=1) {
		global $INSURANCE_ANCORA_STORAGE;
		if (empty($INSURANCE_ANCORA_STORAGE[$var_name])) $INSURANCE_ANCORA_STORAGE[$var_name] = 0;
		$INSURANCE_ANCORA_STORAGE[$var_name] += $value;
	}
}

// Concatenate theme variable with specified value
if (!function_exists('insurance_ancora_storage_concat')) {
	function insurance_ancora_storage_concat($var_name, $value) {
		global $INSURANCE_ANCORA_STORAGE;
		if (empty($INSURANCE_ANCORA_STORAGE[$var_name])) $INSURANCE_ANCORA_STORAGE[$var_name] = '';
		$INSURANCE_ANCORA_STORAGE[$var_name] .= $value;
	}
}

// Get array (one or two dim) element
if (!function_exists('insurance_ancora_storage_get_array')) {
	function insurance_ancora_storage_get_array($var_name, $key, $key2='', $default='') {
		global $INSURANCE_ANCORA_STORAGE;
		if (empty($key2))
			return !empty($var_name) && !empty($key) && isset($INSURANCE_ANCORA_STORAGE[$var_name][$key]) ? $INSURANCE_ANCORA_STORAGE[$var_name][$key] : $default;
		else
			return !empty($var_name) && !empty($key) && isset($INSURANCE_ANCORA_STORAGE[$var_name][$key][$key2]) ? $INSURANCE_ANCORA_STORAGE[$var_name][$key][$key2] : $default;
	}
}

// Set array element
if (!function_exists('insurance_ancora_storage_set_array')) {
	function insurance_ancora_storage_set_array($var_name, $key, $value) {
		global $INSURANCE_ANCORA_STORAGE;
		if (!isset($INSURANCE_ANCORA_STORAGE[$var_name])) $INSURANCE_ANCORA_STORAGE[$var_name] = array();
		if ($key==='')
			$INSURANCE_ANCORA_STORAGE[$var_name][] = $value;
		else
			$INSURANCE_ANCORA_STORAGE[$var_name][$key] = $value;
	}
}

// Set two-dim array element
if (!function_exists('insurance_ancora_storage_set_array2')) {
	function insurance_ancora_storage_set_array2($var_name, $key, $key2, $value) {
		global $INSURANCE_ANCORA_STORAGE;
		if (!isset($INSURANCE_ANCORA_STORAGE[$var_name])) $INSURANCE_ANCORA_STORAGE[$var_name] = array();
		if (!isset($INSURANCE_ANCORA_STORAGE[$var_name][$key])) $INSURANCE_ANCORA_STORAGE[$var_name][$key] = array();
		if ($key2==='')
			$INSURANCE_ANCORA_STORAGE[$var_name][$key][] = $value;
		else
			$INSURANCE_ANCORA_STORAGE[$var_name][$key][$key2] = $value;
	}
}

// Add array element after the key
if (!function_exists('insurance_ancora_storage_set_array_after')) {
	function insurance_ancora_storage_set_array_after($var_name, $after, $key, $value='') {
		global $INSURANCE_ANCORA_STORAGE;
		if (!isset($INSURANCE_ANCORA_STORAGE[$var_name])) $INSURANCE_ANCORA_STORAGE[$var_name] = array();
		if (is_array($key))
			insurance_ancora_array_insert_after($INSURANCE_ANCORA_STORAGE[$var_name], $after, $key);
		else
			insurance_ancora_array_insert_after($INSURANCE_ANCORA_STORAGE[$var_name], $after, array($key=>$value));
	}
}

// Add array element before the key
if (!function_exists('insurance_ancora_storage_set_array_before')) {
	function insurance_ancora_storage_set_array_before($var_name, $before, $key, $value='') {
		global $INSURANCE_ANCORA_STORAGE;
		if (!isset($INSURANCE_ANCORA_STORAGE[$var_name])) $INSURANCE_ANCORA_STORAGE[$var_name] = array();
		if (is_array($key))
			insurance_ancora_array_insert_before($INSURANCE_ANCORA_STORAGE[$var_name], $before, $key);
		else
			insurance_ancora_array_insert_before($INSURANCE_ANCORA_STORAGE[$var_name], $before, array($key=>$value));
	}
}

// Push element into array
if (!function_exists('insurance_ancora_storage_push_array')) {
	function insurance_ancora_storage_push_array($var_name, $key, $value) {
		global $INSURANCE_ANCORA_STORAGE;
		if (!isset($INSURANCE_ANCORA_STORAGE[$var_name])) $INSURANCE_ANCORA_STORAGE[$var_name] = array();
		if ($key==='')
			array_push($INSURANCE_ANCORA_STORAGE[$var_name], $value);
		else {
			if (!isset($INSURANCE_ANCORA_STORAGE[$var_name][$key])) $INSURANCE_ANCORA_STORAGE[$var_name][$key] = array();
			array_push($INSURANCE_ANCORA_STORAGE[$var_name][$key], $value);
		}
	}
}

// Pop element from array
if (!function_exists('insurance_ancora_storage_pop_array')) {
	function insurance_ancora_storage_pop_array($var_name, $key='', $defa='') {
		global $INSURANCE_ANCORA_STORAGE;
		$rez = $defa;
		if ($key==='') {
			if (isset($INSURANCE_ANCORA_STORAGE[$var_name]) && is_array($INSURANCE_ANCORA_STORAGE[$var_name]) && count($INSURANCE_ANCORA_STORAGE[$var_name]) > 0) 
				$rez = array_pop($INSURANCE_ANCORA_STORAGE[$var_name]);
		} else {
			if (isset($INSURANCE_ANCORA_STORAGE[$var_name][$key]) && is_array($INSURANCE_ANCORA_STORAGE[$var_name][$key]) && count($INSURANCE_ANCORA_STORAGE[$var_name][$key]) > 0) 
				$rez = array_pop($INSURANCE_ANCORA_STORAGE[$var_name][$key]);
		}
		return $rez;
	}
}

// Inc/Dec array element with specified value
if (!function_exists('insurance_ancora_storage_inc_array')) {
	function insurance_ancora_storage_inc_array($var_name, $key, $value=1) {
		global $INSURANCE_ANCORA_STORAGE;
		if (!isset($INSURANCE_ANCORA_STORAGE[$var_name])) $INSURANCE_ANCORA_STORAGE[$var_name] = array();
		if (empty($INSURANCE_ANCORA_STORAGE[$var_name][$key])) $INSURANCE_ANCORA_STORAGE[$var_name][$key] = 0;
		$INSURANCE_ANCORA_STORAGE[$var_name][$key] += $value;
	}
}

// Concatenate array element with specified value
if (!function_exists('insurance_ancora_storage_concat_array')) {
	function insurance_ancora_storage_concat_array($var_name, $key, $value) {
		global $INSURANCE_ANCORA_STORAGE;
		if (!isset($INSURANCE_ANCORA_STORAGE[$var_name])) $INSURANCE_ANCORA_STORAGE[$var_name] = array();
		if (empty($INSURANCE_ANCORA_STORAGE[$var_name][$key])) $INSURANCE_ANCORA_STORAGE[$var_name][$key] = '';
		$INSURANCE_ANCORA_STORAGE[$var_name][$key] .= $value;
	}
}

// Call object's method
if (!function_exists('insurance_ancora_storage_call_obj_method')) {
	function insurance_ancora_storage_call_obj_method($var_name, $method, $param=null) {
		global $INSURANCE_ANCORA_STORAGE;
		if ($param===null)
			return !empty($var_name) && !empty($method) && isset($INSURANCE_ANCORA_STORAGE[$var_name]) ? $INSURANCE_ANCORA_STORAGE[$var_name]->$method(): '';
		else
			return !empty($var_name) && !empty($method) && isset($INSURANCE_ANCORA_STORAGE[$var_name]) ? $INSURANCE_ANCORA_STORAGE[$var_name]->$method($param): '';
	}
}

// Get object's property
if (!function_exists('insurance_ancora_storage_get_obj_property')) {
	function insurance_ancora_storage_get_obj_property($var_name, $prop, $default='') {
		global $INSURANCE_ANCORA_STORAGE;
		return !empty($var_name) && !empty($prop) && isset($INSURANCE_ANCORA_STORAGE[$var_name]->$prop) ? $INSURANCE_ANCORA_STORAGE[$var_name]->$prop : $default;
	}
}

// Merge two-dim array element
if (!function_exists('insurance_ancora_storage_merge_array')) {
    function insurance_ancora_storage_merge_array($var_name, $key, $arr) {
        global $INSURANCE_ANCORA_STORAGE;
        if (!isset($INSURANCE_ANCORA_STORAGE[$var_name])) $INSURANCE_ANCORA_STORAGE[$var_name] = array();
        if (!isset($INSURANCE_ANCORA_STORAGE[$var_name][$key])) $INSURANCE_ANCORA_STORAGE[$var_name][$key] = array();
        $INSURANCE_ANCORA_STORAGE[$var_name][$key] = array_merge($INSURANCE_ANCORA_STORAGE[$var_name][$key], $arr);
    }
}
?>