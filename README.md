# ACF User Roles Field

ACF User Roles Field is a Wordpress plugin that adds a new ACF field allowing to select user roles.

Note that this plugin doesn't manage content access. It only shows a select field with all user roles as choices.

## Installation

- Download the [latest version on GitHub](https://github.com/misaki-web/acf-user-roles-field/releases/latest/download/acf-user-roles-field.zip).

- Extract the archive and copy the folder (`acf-user-roles-field`) to the Wordpress plugins folder (`/wp-content/plugins/`).

- Go to the Wordpress plugins manager on your website (`your-website.ext/wp-admin/plugins.php`) and enable the plugin **ACF User Roles Field**. Note that you can enable auto-updates.

## Usage

### Admin

Go to the ACF administration page (`your-website.ext/wp-admin/edit.php?post_type=acf-field-group`), add a new field group and choose the field **User roles**:

### Front-end

To display the field value, the shortcode `acf_user_roles_field` can be used. By default, it'll look at custom fields for the current post where the shortcode is added. For example, the following shortcode:

	[acf_user_roles_field name="FIELD_NAME"]

is the same as this one:

	[acf_user_roles_field name="FIELD_NAME" type="post"]

To get the field value from another post, use the attribute `id`:

	[acf_user_roles_field name="FIELD_NAME" id="POST_ID"]

If the field is linked to a user, set the type `user` in the shortcode. By default, it'll look at custom fields for the current user:

	[acf_user_roles_field name="FIELD_NAME" type="user"]

To specify a specific user, set the attribute `id`:

	[acf_user_roles_field name="FIELD_NAME" type="user" id="USER_ID"]

By default, user roles are displayed as an HTML list. Example:

```html
<ul>
	<li>Author</li>
	<li>Subscriber</li>
</ul>
```

To display them as a simple text list, the attribute `separator` can be set. Example:

	[acf_user_roles_field name="FIELD_NAME" separator=", "]

User roles will be displayed as follows:

	Author, Subscriber

### Hooks for developers

The following filter hook is available:

- `acf_user_roles_field_html`: filter allowing to manipulate the HTML code before it's displayed

For example, to display the user roles with an ordered list, use the filter in your `functions.php` theme file as follows:

```php
function user_roles_in_ordered_list($html, $user_roles, $atts) {
	return str_replace(
		['<ul ', '</ul>'],
		['<ol ', '</ol>'],
		$html
	);
}
add_filter('acf_user_roles_field_html', 'user_roles_in_ordered_list', 10, 3);
```

Here's another way:

```php
function user_roles_in_ordered_list($html, $user_roles, $atts) {
	$custom_html = '<ol>';
	
	foreach ($user_roles as $user_role) {
		$custom_html .= '<li>' . $user_role . '</li>';
	}
	
	$custom_html .= '</ol>';
	
	return $custom_html;
}
add_filter('acf_user_roles_field_html', 'user_roles_in_ordered_list', 10, 3);
```

## License

ACF User Roles Field: Wordpress plugin adding a new ACF field to select user roles  
Copyright (C) 2023  Misaki F.

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <https://www.gnu.org/licenses/>.

### Third-party code

- ACF User Roles Field uses [Plugin Update Checker](https://github.com/YahnisElsts/plugin-update-checker) under the [MIT License](https://github.com/YahnisElsts/plugin-update-checker/blob/master/license.txt) in order to manage auto-updates in the Wordpress plugins manager.
