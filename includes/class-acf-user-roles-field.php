<?php

/**
 * Defines the ACF User Roles Field class.
 */

if (!defined('ABSPATH')) {
	exit;
}

/**
 * acf_user_roles_field class.
 */
class acf_user_roles_field extends \acf_field {
	/**
	 * Controls field type visibilty in REST requests.
	 *
	 * @var bool
	 */
	public $show_in_rest = true;

	/**
	 * Environment values relating to the plugin.
	 *
	 * @var array $env Plugin context such as 'url' and 'version'.
	 */
	private $env;

	/**
	 * Constructor.
	 */
	public function __construct() {
		/**
		 * Field type reference used in PHP code.
		 *
		 * No spaces. Underscores allowed.
		 */
		$this->name = 'user_roles';

		/**
		 * Field type label.
		 *
		 * For public-facing UI. May contain spaces.
		 */
		$this->label = __('User roles', 'acf-user-roles-field');

		/**
		 * The category the field appears within in the field type picker.
		 */
		$this->category = 'choice'; // basic | content | choice | relational | jquery | layout | CUSTOM GROUP NAME

		parent::__construct();
	}

	/**
	 * Get user roles.
	 * 
	 * @return array
	 */
	private static function get_user_roles() {
		return (new WP_Roles)->get_names();
	}

	/**
	 * Settings to display when users configure a field of this type.
	 *
	 * These settings appear on the ACF “Edit Field Group” admin page when
	 * setting up the field.
	 *
	 * @param array $field
	 * @return void
	 */
	public function render_field_settings($field) {
		acf_render_field_setting(
			$field,
			[
				'name'         => 'multiple',
				'label'        => __('Multiple user roles', 'acf-user-roles-field'),
				'type'         => 'true_false',
				'default_value' => true,
				'hint'         => __('Allow to select multiple user roles.', 'acf-user-roles-field'),
			],
		);
	}

	/**
	 * HTML content to show when the field is edited.
	 *
	 * @param array $field The field settings and values.
	 * @return void
	 */
	public function render_field($field) {
		if ($field) {
			$user_roles = self::get_user_roles();
			array_unshift($user_roles, '');
			$multiple_attr = $field['multiple'] ? ' multiple' : '';
			$value = is_array($field['value']) ? $field['value'] : [];
			
			echo '<select class="acf-user-roles-field-select" name="' . esc_attr($field['name']) . '[]"' . $multiple_attr . '>';

			foreach ($user_roles as $user_role) {
				$selected = '';

				if (in_array($user_role, $value)) {
					$selected = ' selected';
				}

				echo '<option value="' . $user_role . '"' . $selected . '>' . $user_role . '</option>';
			}

			echo '</select>';
		}
	}
}
