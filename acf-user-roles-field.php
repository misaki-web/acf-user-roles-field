<?php

/**
 * Plugin Name: ACF User Roles Field
 * Description: Adds a new ACF field allowing to select user roles.
 * Text Domain: acf-user-roles-field
 * Author: Misaki F.
 * Version: 1.0.1
 */

namespace AcfUserRolesField;

if (!defined('ABSPATH')) {
	return;
}

################################################################################
#
# INCLUSIONS
#
################################################################################

require_once(__DIR__ . '/includes/init.php');
require_once(__DIR__ . '/includes/plugin-update-checker/plugin-update-checker.php');

################################################################################
#
# Update checker
#
################################################################################

use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$update_checker = PucFactory::buildUpdateChecker(
	'https://github.com/misaki-web/acf-user-roles-field',
	__FILE__,
	'acf-user-roles-field'
);

$update_checker->getVcsApi()->enableReleaseAssets();

################################################################################
#
# HELPER FUNCTIONS
#
################################################################################

function is_pos_int($value, $include_zero = true) {
	$min_range = $include_zero ? 0 : 1;
	$options = [
		'options' => ['min_range' => $min_range],
	];

	return !str_starts_with($value, '+') && filter_var($value, FILTER_VALIDATE_INT, $options) !== false;
}

################################################################################
#
# SHORTCODES
#
################################################################################

# Render the shortcode "acf_user_roles_field".
function shortcode($atts = array()) {
	# Default arguments
	###################

	$default_atts = [
		'name' => '',
		'type' => 'post',
		'id' => -1,
		'separator' => '',
	];

	# Get final arguments
	#####################

	$atts = wp_parse_args($atts, $default_atts);
	extract($atts);

	if ($atts['type'] != 'post' && $atts['type'] != 'user') {
		$atts['type'] = 'post';
	}

	if (!is_pos_int($atts['id'], false)) {
		if ($atts['type'] == 'post') {
			$atts['id'] = get_the_ID();
		} else if ($atts['type'] == 'user') {
			$atts['id'] = get_current_user_id();
		}
	}

	if ($atts['type'] == 'user') {
		$atts['id'] = 'user_' . $atts['id'];
	}

	# HTML
	######

	$field = get_field_object($atts['name'], $atts['id']);

	$html = '';
	$class = 'acf-user-roles-field-container';

	if (!empty($field['value'])) {
		if ($atts['separator'] === '') {
			$html .= '<ul class="' . $class . '">';

			foreach ($field['value'] as $v) {
				$html .= "<li>$v</li>";
			}

			$html .= '</ul>';
		} else {
			$html .= '<span class="' . $class . '">' . implode($atts['separator'], $field['value']) . '</span>';
		}
	}

	return apply_filters('acf_user_roles_field_html', $html, $field['value'], $atts);
}
add_shortcode('acf_user_roles_field', __NAMESPACE__ . '\\shortcode');
