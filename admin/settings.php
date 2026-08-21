<?php
namespace Add_Chat_App_Button\Admin;

use Add_Chat_App_Button\Plugin;
use Add_Chat_App_Button\Includes\Style_Templates\Admin as Admin_Styles;
use PAnD;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Admin_Settings {

	public function __construct() {
		add_action( 'admin_menu', [ $this, 'options_menu_link' ] );
		add_action( 'admin_init', [ $this, 'register_settings' ] );

		// Unless the user chose to never show again, add admin notice to give 5-star review
		add_action( 'admin_notices', [ $this, 'maybe_show_five_star_review_notice' ] );
	}
	
	/**
	 * Create Admin Menu Link
	 *
	 * @since 2.0.0
	 */
	public function options_menu_link() {
		$options_page = add_options_page(
			__( 'Add WhatsApp Button Options', 'add-whatsapp-button' ), // title
			__( 'Add WhatsApp Button', 'add-whatsapp-button' ), // title of the menu link
			'manage_options', // capabilities credentials, at least able to X
			'awb-options', // menu URL slug
			[ $this, 'print_options_page_content' ] // name of the function that displays the option page content
		);
	
		// Load the JS only in the pages where it is used.
		add_action( 'load-' . $options_page, [ $this, 'load_admin_js' ] );
		add_action( 'load-' . $options_page, [ $this, 'load_admin_styles' ] );
	}

	public function load_admin_js() {
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_js' ] );
    }

	/**
	 * Load Admin Styles
	 *
	 * @since 2.0.0
	 */
	public function load_admin_styles() {
        add_action( 'admin_enqueue_scripts', [ Admin_Styles::class, 'print_styles' ] );
    }

	/**
	 * Enqueue Admin Color Picker JS and CSS
	 *
	 * @since 2.0.0
	 */
	public function enqueue_admin_js() {
        wp_enqueue_style( 'wp-color-picker' );

        wp_enqueue_script(
			'awb-admin-script',
			plugins_url( '../js/admin.js', __FILE__ ),
			array( 'jquery', 'wp-color-picker' ),
			'',
			true
		);

    }

	/**
	 * Register Settings
	 *
	 * @since 2.0.0
	 */
	public function register_settings() {
		register_setting( 'awb_settings_group', 'awb_settings', [ $this, 'sanitize_inputs' ] );
	}

	/**
	 * Validate Inputs
	 *
	 * This is a callback, receiving an array of options from the settings page, a
	 *
	 * @since 2.0.0
	 */
	public function sanitize_inputs( $input ) {
		// Reset all settings to default when reset button is clicked
		if ( isset( $_POST['reset_awb_options'] ) ) {
			update_option( 'awb_settings', [] );
	
			add_settings_error(
				'reset_awb_settings',
				esc_attr( 'settings_deleted' ),
				esc_html__( 'Your settings have been successfully deleted and reset to defaults.', 'add-whatsapp-button' ),
				'updated'
			);
	
			return array(); // Default settings
		}
	
		// Create our array for storing the validated options
		$output = array();
	
		// Loop through each of the incoming options
		foreach( $input as $key => $value ) {
			// Check to see if the current option has a value. If so, process it.
			if( isset( $input[ $key ] ) ) {
				// Sanitize phone number
				if ( $key == 'phone_number' ) {
					preg_replace('/[^0-9]/', '', $input[$key]);
	
					if ( !preg_match("/^\d+$/", $input[$key]) ) {
						add_settings_error( 'awb_phone_number_invalid', esc_attr( 'settings_updated' ), esc_html__( 'The value you entered in the phone number field is invalid. Please enter a valid number.', 'add-whatsapp-button' ) );
						add_action( 'admin_notices', 'print_errors' );
						$input[$key] = '';
					}
				}
	
				// button_text allows limited inline markup for use as icon label
				if ( $key === 'button_text' ) {
					$allowed_label_html = [ 'strong' => [], 'em' => [], 'br' => [] ];
					$output[ $key ] = wp_kses( stripslashes( $input[ $key ] ), $allowed_label_html );
				} elseif ( $key === 'active_days' ) {
					// Array of active weekday numbers submitted as awb_settings[active_days][N]
					$output[ $key ] = is_array( $input[ $key ] ) ? array_values( array_map( 'intval', array_keys( $input[ $key ] ) ) ) : [];
				} else {
					// Strip all HTML and PHP tags and properly handle quoted strings
					$output[ $key ] = strip_tags( stripslashes( $input[ $key ] ) );
				}
			} // end if
		} // end foreach
	
		// Return the array processing any additional functions filtered by this action
		return apply_filters( 'awb_sanitize_inputs', $output, $input );
	}

	/**
	 * Validate Limiting Hours
	 *
	 * @since 2.0.0
	 *
	 * @param $hour
	 */
	private function validate_limiting_hours( $hour ) {
		if ( is_numeric( $hour ) && $hour >= 0 && $hour <= 24 ) {
			return $hour;
		}
		else {
			return '';
		}
	}

	/** 
	 * Print Options Page Content
	 *
	 * Called as a callback in `add_options_page()` for the plugin's settings page.
	 *
	 * @since 2.0.0
	 */ 
	public function print_options_page_content() {
		$settings = Plugin::$instance->get_plugin_options();

		// Set default button style for Settings Page Preview
		$button_style = ! empty( $settings['button_type'] ) ? $settings['button_type'] : 'wab-side-rectangle';
		// Create default button text (allows limited inline markup)
		$allowed_label_html = [ 'strong' => [], 'em' => [], 'br' => [] ];
		$button_text = ! empty( $settings['button_text'] ) ? wp_kses( $settings['button_text'], $allowed_label_html ) : esc_html__( 'Message Us on WhatsApp', 'add-whatsapp-button' );
		// Hide Text span if selected button style is "Icon"
		$displayNoneIfIcon = ( ! empty( $settings['button_type'] ) && $settings['button_type'] == 'wab-icon-plain' ) ? 'class="awb-hide"' : '';
		// Show label rows only when icon type is selected and label is enabled
		$il_no_show_class = (
			( ! empty( $settings['button_type'] ) && 'wab-icon-plain' !== $settings['button_type'] ) ||
			empty( $settings['icon_label_enable'] )
		) ? ' class="awb-hide"' : '';
		// Set default icon size if the button type is WhatsApp icon
		$icon_size = ! empty( $settings['icon_size'] ) ? sanitize_text_field( $settings['icon_size'] ) : '80';
		// If the breakpoint setting is inactive (the "enable breakpoint" checkbox is checked), hide the breakpoint settings.
		$bp_no_show_class = empty( $settings['enable_breakpoint'] ) ? ' class="awb-hide"' : '';
		// If the 'limit hours' setting is inactive, hide the hour controls.
		$lh_no_show_class = empty( $settings['limit_hours'] ) ? ' class="awb-hide"' : '';
		// Default active days Mon–Fri (1–5) when the setting has not been saved yet.
		$active_days = isset( $settings['active_days'] ) ? (array) $settings['active_days'] : [ 0, 1, 2, 3, 4, 5, 6 ];
		$ld_no_show_class = empty( $settings['limit_days'] ) ? ' class="awb-hide"' : '';
		// If the 'Hide Button' setting is inactive, hide the radio buttons with the hiding settings.
		$hb_no_show_class = empty( $settings['enable_hide_button'] ) ? ' class="awb-hide"' : '';
		// If the 'Enable Message' setting is inactive, hide the textarea.
		$em_no_show_class = empty( $settings['enable_message'] ) ? ' class="awb-hide"' : '';
		// If the saved button type is not a WhatsApp icon, hide the icon size control.
		$is_no_show_class = ! empty( $settings['button_type'] ) && 'wab-icon-plain' !== $settings['button_type'] ? ' class="awb-hide"' : '';
		// Hide rectangle size rows when button type is icon or unset.
		$rect_no_show_class = (
			empty( $settings['button_type'] ) ||
			'wab-side-rectangle' !== $settings['button_type'] && 'wab-bottom-rectangle' !== $settings['button_type']
		) ? ' class="awb-hide"' : '';

		$button_inline_styles = '';
		// Inline Style
		if ( ! empty( $settings['button_bg_color'] ) || ! empty( $settings['button_text_color'] ) ) {
			$button_inline_styles = ' style="';

			// If there is a saved background color, add it to the button with a style tag.
			$button_is_not_plain_icon = empty( $settings['button_type'] ) || ( ! empty( $settings['button_type'] ) && 'wab-icon-plain' === $settings['button_type'] );
			if ( ! empty( $settings['button_bg_color'] ) && $button_is_not_plain_icon ) {
				$button_inline_styles .= 'background-color: ' . $settings['button_bg_color'] . ';';
			}

			// If there is a saved text color, add it to the button with a style tag.
			if ( ! empty( $settings['button_text_color'] ) ) {
				$button_inline_styles .= ' color: ' . $settings['button_text_color'] . ';';
			}

			$button_inline_styles .= '"';
		}

		ob_start(); ?>

		<div class="wrap">
			<?php //settings_errors(); ?>

			<h2><?php echo esc_html__( 'Add WhatsApp Button Settings', 'add-whatsapp-button'); ?></h2>
			<p>
				<?php echo esc_html__( 'Settings page for the Add WhatsApp Button plugin. Check out the preview screen in the "Button Design" tab to see how your button would look on a smartphone before saving your settings to the database.', 'add-whatsapp-button'); ?><br />
				<a href="https://wordpress.org/support/plugin/add-whatsapp-button/reviews/" target="_blank"><?php echo esc_html__( 'Rate "Add WhatsApp Button" at wordpress.org!', 'add-whatsapp-button'); ?></a>
			</p>

			<form method="POST" action="options.php">
				<?php settings_fields( 'awb_settings_group' ); ?>

				<div class="nav-tab-wrapper">
					<a href="#" id="gstablink" class="nav-tab nav-tab-active"><?php echo esc_html__( 'General Settings', 'add-whatsapp-button'); ?></a>
					<a href="#" id="bdtablink" class="nav-tab"><?php echo esc_html__( 'Button Design', 'add-whatsapp-button'); ?></a>
				</div>

				<div id="gstab" class="awb-tab-content-wrapper awb-tab-active">
					<table class="form-table">
						<tbody>
							<tr>
								<th colspan="2">
									<h2 class="awb-button-design-title"><?php echo esc_html__( 'General Settings', 'add-whatsapp-button'); ?></h2>
								</th>
							</tr>
							<tr>
								<th scope="row"><label for="awb_settings[enable]"><?php echo esc_html__( 'Enable WhatsApp Button', 'add-whatsapp-button'); ?></label></th>
								<td><input name="awb_settings[enable]" type="checkbox" id="awb_settings[enable]" value="1" <?php isset( $settings['enable'] ) ? checked('1', $settings['enable'] ) : ''; ?>></td>
							</tr>
							<tr>
								<th scope="row"><label for="awb_settings[button_text]"><?php echo esc_html__( 'Button Text', 'add-whatsapp-button'); ?></label></th>
								<td>
									<input name="awb_settings[button_text]" type="text" id="awb_settings[button_text]" value="<?php echo esc_attr( ! empty( $settings['button_text'] ) ? $settings['button_text'] : __( 'Message Us on WhatsApp', 'add-whatsapp-button' ) ); ?>" class="regular-text">
									<p class="description"><?php echo esc_html__( 'Enter the text you want the button to show. Recommended: up to 18 characters. Accepts &lt;strong&gt;, &lt;em&gt; and &lt;br&gt; tags for the icon label.', 'add-whatsapp-button'); ?></p>
								</td>
							</tr>
							<tr>
								<th scope="row"><label for="awb_settings[phone_number]"><?php echo esc_html__( 'Target Phone Number', 'add-whatsapp-button' ); ?></label></th>
								<td>
									<input required name="awb_settings[phone_number]" type="text" id="awb_settings[phone_number]" value="<?php echo esc_html( $settings['phone_number'] ); ?>" placeholder="12345678910" class="regular-text">
									<p class="description"><?php echo esc_html__( 'Enter the phone number you want the WhatsApp message to be sent to, with your country code, WITHOUT a "+" (PLUS) SIGN. For example, if you wanted to send WhatsApp messages to the number +1-770-123-4567, you would enter: 17701234567 in the input box.', 'add-whatsapp-button'); ?></p>
								</td>
							</tr>
							<tr>
								<th scope="row"><label for="awb_settings[enable_message]"><?php echo esc_html__( 'Default Message', 'add-whatsapp-button' ); ?></label></th>
								<td>
									<input name="awb_settings[enable_message]" type="checkbox" id="awb_settings[enable_message]" value="1" <?php isset($settings['enable_message'] ) ? checked('1', $settings['enable_message'] ) : ''; ?>>
									<p class="description"><?php echo esc_html__( 'Check this box in order to set a default message to be pre-written when users click the button. For example: "Hi, I\'m interested in your product".', 'add-whatsapp-button'); ?></p>
									<div id="awb_enable_message"<?php echo $em_no_show_class; ?>>
										<textarea name="awb_settings[default_message]" type="number" id="awb_settings[default_message]" class="small-text"><?php echo isset($settings['default_message'] ) ? sanitize_textarea_field( $settings['default_message'] ) : ''; ?></textarea>
										<p class="description"><?php echo esc_html__( 'Enter the message you want to pre-enter for the users when they click on your WhatsApp button.', 'add-whatsapp-button'); ?></p>
									</div>
								</td>
							</tr>
							<tr>
								<th scope="row"><label for="awb_settings[hide_button]"><?php echo esc_html__( 'Add Hide Button', 'add-whatsapp-button' ); ?></label></th>
								<td>
									<input name="awb_settings[enable_hide_button]" type="checkbox" id="awb_settings[enable_hide_button]" value="1" <?php isset($settings['enable_hide_button'] ) ? checked('1', $settings['enable_hide_button'] ) : ''; ?>>
									<p class="description"><?php echo esc_html__( 'Check this box in order to add a small "Hide" button at the far right corner of the WhatsApp button.', 'add-whatsapp-button'); ?></p>
									<div id="awb_hide_button"<?php echo $hb_no_show_class; ?>>
										<input type="radio" name="awb_settings[hide_button]" value="full" <?php isset($settings['hide_button'] ) ? checked('full', $settings['hide_button'] ) : ''; ?> /> <strong>Full Remove</strong>
										<p class="description radio-description"><?php echo esc_html__( 'Choose this option to make the WhatsApp button disappear completely on click.', 'add-whatsapp-button'); ?></p>
										<input type="radio" name="awb_settings[hide_button]" value="hide" <?php isset($settings['hide_button'] ) ? checked('hide', $settings['hide_button'] ) : ''; ?> /> <strong>Hide with toggle button</strong>
										<p class="description radio-description">
											<?php echo esc_html__( 'Choose this option to make the WhatsApp button slide almost entirely off screen, while keeping the toggle button visible.', 'add-whatsapp-button'); ?><br />
											<?php echo esc_html__( 'Clicking the toggle button again will slide the WhatsApp button back into view.', 'add-whatsapp-button'); ?>
										</p>
										<p style="margin-top: 12px;"><strong><?php echo esc_html__( 'Remember dismissed state', 'add-whatsapp-button' ); ?></strong></p>
										<select name="awb_settings[hide_button_persistence]" id="awb_settings[hide_button_persistence]">
											<option value="none" <?php selected( $settings['hide_button_persistence'] ?? 'none', 'none' ); ?>><?php echo esc_html__( 'No — reset on every page load', 'add-whatsapp-button' ); ?></option>
											<option value="session" <?php selected( $settings['hide_button_persistence'] ?? 'none', 'session' ); ?>><?php echo esc_html__( 'Within session — remembered while the browser tab stays open', 'add-whatsapp-button' ); ?></option>
											<option value="persistent" <?php selected( $settings['hide_button_persistence'] ?? 'none', 'persistent' ); ?>><?php echo esc_html__( 'Persistent — remembered until the visitor clears site data', 'add-whatsapp-button' ); ?></option>
										</select>
										<p class="description"><?php echo esc_html__( 'Controls how long a visitor\'s dismissal is remembered across page navigation. Persistent mode stores a value in the browser\'s localStorage — mention this in your site\'s privacy policy if applicable.', 'add-whatsapp-button' ); ?></p>
									</div>
								</td>
							</tr>
							<tr>
								<th scope="row"><label for="awb_settings[enable_dragging]"><?php echo esc_html__( 'Allow dragging button on Y axis', 'add-whatsapp-button' ); ?></label></th>
								<td>
									<input name="awb_settings[enable_dragging]" type="checkbox" id="awb_settings[enable_dragging]" value="1" <?php isset($settings['enable_dragging'] ) ? checked('1', $settings['enable_dragging'] ) : ''; ?>>
									<p class="description"><?php echo esc_html__( 'Check this box in order to add a small "dragging" handle on the top of the WhatsApp button, which will allow users to drag the button up and down. This won\'t work for the bottom-fixed button type.', 'add-whatsapp-button'); ?></p>
								</td>
							</tr>
							<tr>
								<th scope="row"><label for="awb_settings[breakpoint]"><?php echo esc_html__( 'Breakpoint', 'add-whatsapp-button' ); ?></label></th>
								<td>
									<input name="awb_settings[enable_breakpoint]" type="checkbox" id="awb_settings[enable_breakpoint]" value="1" <?php isset( $settings['enable_breakpoint'] ) ? checked('1', $settings['enable_breakpoint'] ) : ''; ?>>
									<p class="description"><?php echo esc_html__( 'Check this box in order to only display the WhatsApp button up to a certain screen width.', 'add-whatsapp-button'); ?></p>
									<div id="awb_breakpoint"<?php echo $bp_no_show_class; ?>>
										<input name="awb_settings[breakpoint]" type="number" id="awb_settings[breakpoint]" value="<?php echo sanitize_text_field( $settings['breakpoint'] ); ?>" class="small-text"><?php echo esc_html__( 'px', 'add-whatsapp-button'); ?>
										<p class="description"><?php echo esc_html__( 'Enter your desired screen width breakpoint here. Default is 600px.', 'add-whatsapp-button'); ?></p>
										<select name="awb_settings[breakpoint_direction]" id="awb_settings[breakpoint_direction]" style="margin-top: 6px;">
											<option value="hide_above" <?php selected( $settings['breakpoint_direction'] ?? 'hide_above', 'hide_above' ); ?>><?php echo esc_html__( 'Hide on screens wider than the breakpoint (default — hides on desktop)', 'add-whatsapp-button' ); ?></option>
											<option value="hide_below" <?php selected( $settings['breakpoint_direction'] ?? 'hide_above', 'hide_below' ); ?>><?php echo esc_html__( 'Hide on screens narrower than the breakpoint (hides on mobile)', 'add-whatsapp-button' ); ?></option>
										</select>
									</div>
								</td>
							</tr>
							<tr>
								<th scope="row"><label for="awb_settings[limit_hours]"><?php echo esc_html__( 'Limit Display Time', 'add-whatsapp-button' ); ?></label></th>
								<td>
									<input name="awb_settings[limit_hours]" type="checkbox" id="awb_settings[limit_hours]" value="1" <?php isset( $settings['limit_hours'] ) ? checked('1', $settings['limit_hours'] ) : ''; ?>>
									<p class="description"><?php echo esc_html__( 'Check this box in order to only display the WhatsApp button in certain hours of the day.', 'add-whatsapp-button'); ?></p>
									<div id="awb_limit_hours"<?php echo $lh_no_show_class; ?>>
										<span class="awb-hours"><?php echo esc_html__( 'Start Hour:', 'add-whatsapp-button'); ?> </span>
										<select name="awb_settings[startHour]" id="awb_settings[startHour]">
											<?php for ($i = 0; $i<=24; $i++) { ?>
												<option value="<?php echo $i; ?>" <?php selected( $this->validate_limiting_hours( $settings['startHour'] ), $i ); ?>><?php echo ( strlen( (string) $i ) == 2 ) ? $i : '0' . $i; ?>:00</option>
											<?php } ?>
										</select>
										<p class="description"><?php echo esc_html__( 'The WhatsApp button will be displayed starting this hour (24 hour clock). If no time is chosen, default is 8:00 (8AM). Make sure your starting hour is before your ending hour.', 'add-whatsapp-button'); ?></p>

										<span class="awb-hours"><?php echo esc_html__( 'End Hour:', 'add-whatsapp-button'); ?> </span>
										<select name="awb_settings[endHour]" id="awb_settings[endHour]">
											<?php for ($i = 0; $i<=24; $i++) { ?>
												<option value="<?php echo $i; ?>" <?php selected( $this->validate_limiting_hours( $settings['endHour'] ), $i ); ?>><?php echo ( strlen( (string) $i ) == 2 ) ? $i : '0' . $i; ?>:00</option>
											<?php } ?>
										</select>
										<p class="description"><?php echo esc_html__( 'The WhatsApp button will be displayed up until this hour (24 hour clock). If no time is chosen, default is 22 (10PM).', 'add-whatsapp-button'); ?></p>
										<p style="margin-top: 12px;">
											<input name="awb_settings[limit_days]" type="checkbox" id="awb_settings[limit_days]" value="1" <?php isset( $settings['limit_days'] ) ? checked( '1', $settings['limit_days'] ) : ''; ?>>
											<label for="awb_settings[limit_days]"><strong><?php echo esc_html__( 'Limit to specific days of the week', 'add-whatsapp-button' ); ?></strong></label>
										</p>
										<div id="awb_limit_days"<?php echo $ld_no_show_class; ?> style="margin-top: 8px;">
											<?php
											$day_labels = [
												0 => __( 'Sun', 'add-whatsapp-button' ),
												1 => __( 'Mon', 'add-whatsapp-button' ),
												2 => __( 'Tue', 'add-whatsapp-button' ),
												3 => __( 'Wed', 'add-whatsapp-button' ),
												4 => __( 'Thu', 'add-whatsapp-button' ),
												5 => __( 'Fri', 'add-whatsapp-button' ),
												6 => __( 'Sat', 'add-whatsapp-button' ),
											];
											foreach ( $day_labels as $day_num => $day_label ) :
											?>
											<label style="margin-right: 10px;">
												<input type="checkbox" name="awb_settings[active_days][<?php echo $day_num; ?>]" value="<?php echo $day_num; ?>" <?php checked( in_array( $day_num, $active_days, true ) ); ?>>
												<?php echo esc_html( $day_label ); ?>
											</label>
											<?php endforeach; ?>
											<p class="description"><?php echo esc_html__( 'The button will only be visible on the selected days, using the visitor\'s device clock.', 'add-whatsapp-button' ); ?></p>
										</div>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div id="bdtab" class="awb-tab-content-wrapper">
					<table class="form-table" id="awb_design_settings_wrapper">
						<tbody>
							<tr>
								<th colspan="2">
									<h2 class="awb-button-design-title"><?php echo esc_html__( 'Button Design', 'add-whatsapp-button'); ?></h2>
								</th>
							</tr>
							<tr>
								<th scope="row"><label for="awb_settings[button_bg_color]"><?php echo esc_html__( 'Button Background Color', 'add-whatsapp-button' ); ?></label></th>
								<td>
									<input name="awb_settings[button_bg_color]" type="text" id="awb_settings[button_bg_color]"  value="<?php echo sanitize_text_field( ! empty( $settings['button_bg_color'] ) ? $settings['button_bg_color'] : '#20B038' ); ?>" class="udi-bg-color-picker" />
									<p class="description"><?php echo esc_html__( 'Choose a background color for your button. Default is green (#20B038)', 'add-whatsapp-button'); ?></p>
								</td>
							</tr>
							<tr>
								<th scope="row"><label for="awb_settings[button_text_color]"><?php echo esc_html__( 'Button Text Color', 'add-whatsapp-button' ); ?></label></th>
								<td>
									<input name="awb_settings[button_text_color]" type="text" id="awb_settings[button_text_color]"  value="<?php echo sanitize_text_field( ! empty( $settings['button_text_color'] ) ? $settings['button_text_color'] : '#ffffff' ); ?>" class="udi-text-color-picker" />
									<p class="description"><?php echo esc_html__( 'Choose a text color for your button. Default is white (#ffffff)', 'add-whatsapp-button'); ?></p>
								</td>
							</tr>
							<tr>
								<th scope="row"><label for="awb_settings[distance_from_bottom]"><?php echo esc_html__( 'Button Distance from Bottom', 'add-whatsapp-button' ); ?></label></th>
								<td>
									<input name="awb_settings[distance_from_bottom]" type="number" id="awb_settings[distance_from_bottom]"  value="<?php echo sanitize_text_field( $settings['distance_from_bottom'] ); ?>" class="small-text" />

									<select class="awb-mu-select" id="awb_settings[distance_from_bottom_mu]" name="awb_settings[distance_from_bottom_mu]" style="vertical-align: baseline;">
										<option value="%" <?php selected( $settings['distance_from_bottom_mu'] ?? '', '%' ); ?>>%</option>
										<option value="px" <?php selected( $settings['distance_from_bottom_mu'] ?? '', 'px' ); ?>>px</option>
									</select>

									<p class="description"><?php echo esc_html__( 'Choose your button\'s Distance from the bottom of the screen, in percentages or pixels. Default is 10%.', 'add-whatsapp-button'); ?></p>
								</td>
							</tr>
							<tr>
								<th scope="row"><label for="awb_settings[button_type]"><?php echo esc_html__( 'Button Style', 'add-whatsapp-button' ); ?></label></th>
								<td>
									<select class="awb-bt-select" id="awb_settings[button_type]" name="awb_settings[button_type]" style="vertical-align: baseline;">
										<option disabled selected value> -- Select Button Type -- </option>
										<option value="wab-icon-plain" <?php selected( $settings['button_type'] ?? '', 'wab-icon-plain' ); ?>>WhatsApp Icon</option>
										<option value="wab-side-rectangle" <?php selected( $settings['button_type'] ?? '', 'wab-side-rectangle' ); ?>>Side-Floating Rectangle with Text</option>
										<option value="wab-bottom-rectangle" <?php selected( $settings['button_type'] ?? '', 'wab-bottom-rectangle' ); ?>>Fixed-Bottom Rectangle with Text</option>
									</select>
									<p class="description"><?php echo esc_html__( 'Choose your button\'s Style: Round WhatsApp icon, a floating rectangle with text, or a full-width fixed bottom button.', 'add-whatsapp-button'); ?></p>
								</td>
							</tr>
							<tr id="iconSizeSettingRow"<?php echo $is_no_show_class; ?>>
								<th scope="row"><label for="awb_settings[icon_size]"><?php echo esc_html__( 'Icon Button Size', 'add-whatsapp-button' ); ?></label></th>
								<td>
									<input name="awb_settings[icon_size]" type="number" id="awb_settings[icon_size]"  value="<?php echo $icon_size; ?>" class="small-text" />

									<select class="awb-mu-select" id="awb_settings[icon_size_mu]" name="awb_settings[icon_size_mu]" style="vertical-align: baseline;">
										<option value="px" <?php selected( $settings['icon_size_mu'] ?? '', 'px' ); ?>>px</option>
										<option value="em" <?php selected( $settings['icon_size_mu'] ?? '', 'em' ); ?>>em</option>
										<option value="rem" <?php selected( $settings['icon_size_mu'] ?? '', 'rem' ); ?>>rem</option>
									</select>

									<p class="description"><?php echo esc_html__( 'Choose your button\'s size, in pixels. Default is 80.', 'add-whatsapp-button'); ?></p>
								</td>
							</tr>
							<tr id="iconLabelEnableRow"<?php echo $is_no_show_class; ?>>
								<th scope="row"><label for="awb_settings[icon_label_enable]"><?php echo esc_html__( 'Show Label', 'add-whatsapp-button' ); ?></label></th>
								<td>
									<input name="awb_settings[icon_label_enable]" type="checkbox" id="awb_settings[icon_label_enable]" value="1" <?php isset( $settings['icon_label_enable'] ) ? checked( '1', $settings['icon_label_enable'] ) : ''; ?>>
									<p class="description"><?php echo esc_html__( 'Display a text label alongside the WhatsApp icon. Uses the Button Text field above.', 'add-whatsapp-button' ); ?></p>
								</td>
							</tr>
							<tr class="icon-label-setting-row"<?php echo $il_no_show_class; ?>>
								<th scope="row"><label for="awb_settings[icon_label_position]"><?php echo esc_html__( 'Label Position', 'add-whatsapp-button' ); ?></label></th>
								<td>
									<select id="awb_settings[icon_label_position]" name="awb_settings[icon_label_position]">
										<option value="left" <?php selected( $settings['icon_label_position'] ?? 'left', 'left' ); ?>><?php echo esc_html__( 'Left', 'add-whatsapp-button' ); ?></option>
										<option value="right" <?php selected( $settings['icon_label_position'] ?? 'left', 'right' ); ?>><?php echo esc_html__( 'Right', 'add-whatsapp-button' ); ?></option>
										<option value="above" <?php selected( $settings['icon_label_position'] ?? 'left', 'above' ); ?>><?php echo esc_html__( 'Above', 'add-whatsapp-button' ); ?></option>
										<option value="below" <?php selected( $settings['icon_label_position'] ?? 'left', 'below' ); ?>><?php echo esc_html__( 'Below', 'add-whatsapp-button' ); ?></option>
									</select>
									<p class="description"><?php echo esc_html__( 'Where the label appears relative to the icon.', 'add-whatsapp-button' ); ?></p>
								</td>
							</tr>
							<tr class="icon-label-setting-row"<?php echo $il_no_show_class; ?>>
								<th scope="row"><label for="awb_settings[icon_label_gap]"><?php echo esc_html__( 'Gap Between Icon and Label', 'add-whatsapp-button' ); ?></label></th>
								<td>
									<input name="awb_settings[icon_label_gap]" type="number" id="awb_settings[icon_label_gap]" value="<?php echo esc_attr( $settings['icon_label_gap'] ?? '4' ); ?>" class="small-text" />
									<select class="awb-mu-select" name="awb_settings[icon_label_gap_mu]">
										<option value="px" <?php selected( $settings['icon_label_gap_mu'] ?? 'px', 'px' ); ?>>px</option>
										<option value="em" <?php selected( $settings['icon_label_gap_mu'] ?? 'px', 'em' ); ?>>em</option>
										<option value="rem" <?php selected( $settings['icon_label_gap_mu'] ?? 'px', 'rem' ); ?>>rem</option>
									</select>
								</td>
							</tr>
							<tr class="icon-label-setting-row"<?php echo $il_no_show_class; ?>>
								<th scope="row"><?php echo esc_html__( 'Label Font Size', 'add-whatsapp-button' ); ?></th>
								<td>
									<input name="awb_settings[icon_label_font_size]" id="awb_settings[icon_label_font_size]" type="number" value="<?php echo esc_attr( $settings['icon_label_font_size'] ?? '14' ); ?>" class="small-text" />
									<select class="awb-mu-select" name="awb_settings[icon_label_font_size_mu]">
										<option value="px" <?php selected( $settings['icon_label_font_size_mu'] ?? 'px', 'px' ); ?>>px</option>
										<option value="em" <?php selected( $settings['icon_label_font_size_mu'] ?? 'px', 'em' ); ?>>em</option>
										<option value="rem" <?php selected( $settings['icon_label_font_size_mu'] ?? 'px', 'rem' ); ?>>rem</option>
									</select>
								</td>
							</tr>
							<tr class="icon-label-setting-row"<?php echo $il_no_show_class; ?>>
								<th scope="row"><label for="awb_settings[icon_label_bg_color]"><?php echo esc_html__( 'Label Background Color', 'add-whatsapp-button' ); ?></label></th>
								<td>
									<input name="awb_settings[icon_label_bg_color]" type="text" id="awb_settings[icon_label_bg_color]" value="<?php echo esc_attr( $settings['icon_label_bg_color'] ?? '' ); ?>" class="awb-label-bg-color-picker" />
									<p class="description"><?php echo esc_html__( 'Leave empty for transparent background.', 'add-whatsapp-button' ); ?></p>
								</td>
							</tr>
							<tr class="icon-label-setting-row"<?php echo $il_no_show_class; ?>>
								<th scope="row"><?php echo esc_html__( 'Label Padding', 'add-whatsapp-button' ); ?></th>
								<td>
									<input name="awb_settings[icon_label_padding]" id="awb_settings[icon_label_padding]" type="number" value="<?php echo esc_attr( $settings['icon_label_padding'] ?? '8' ); ?>" class="small-text" />
									<select class="awb-mu-select" name="awb_settings[icon_label_padding_mu]">
										<option value="px" <?php selected( $settings['icon_label_padding_mu'] ?? 'px', 'px' ); ?>>px</option>
										<option value="em" <?php selected( $settings['icon_label_padding_mu'] ?? 'px', 'em' ); ?>>em</option>
										<option value="rem" <?php selected( $settings['icon_label_padding_mu'] ?? 'px', 'rem' ); ?>>rem</option>
									</select>
								</td>
							</tr>
							<tr class="icon-label-setting-row"<?php echo $il_no_show_class; ?>>
								<th scope="row"><?php echo esc_html__( 'Label Border Radius', 'add-whatsapp-button' ); ?></th>
								<td>
									<input name="awb_settings[icon_label_radius]" id="awb_settings[icon_label_radius]" type="number" value="<?php echo esc_attr( $settings['icon_label_radius'] ?? '4' ); ?>" class="small-text" />
									<select class="awb-mu-select" name="awb_settings[icon_label_radius_mu]">
										<option value="px" <?php selected( $settings['icon_label_radius_mu'] ?? 'px', 'px' ); ?>>px</option>
										<option value="em" <?php selected( $settings['icon_label_radius_mu'] ?? 'px', 'em' ); ?>>em</option>
										<option value="rem" <?php selected( $settings['icon_label_radius_mu'] ?? 'px', 'rem' ); ?>>rem</option>
									</select>
								</td>
							</tr>
							<tr class="icon-label-setting-row"<?php echo $il_no_show_class; ?>>
								<th scope="row"><label for="awb_settings[icon_label_shadow]"><?php echo esc_html__( 'Label Drop Shadow', 'add-whatsapp-button' ); ?></label></th>
								<td>
									<input name="awb_settings[icon_label_shadow]" type="checkbox" id="awb_settings[icon_label_shadow]" value="1" <?php isset( $settings['icon_label_shadow'] ) ? checked( '1', $settings['icon_label_shadow'] ) : ''; ?>>
								</td>
							</tr>
							<tr class="icon-label-setting-row"<?php echo $il_no_show_class; ?>>
								<th scope="row"><label for="awb_settings[icon_wrapper_bg_color]"><?php echo esc_html__( 'Outer Box Background Color', 'add-whatsapp-button' ); ?></label></th>
								<td>
									<input name="awb_settings[icon_wrapper_bg_color]" type="text" id="awb_settings[icon_wrapper_bg_color]" value="<?php echo esc_attr( $settings['icon_wrapper_bg_color'] ?? '' ); ?>" class="awb-wrapper-bg-color-picker" />
									<p class="description"><?php echo esc_html__( 'Background of the box containing icon + label. Leave empty for transparent.', 'add-whatsapp-button' ); ?></p>
								</td>
							</tr>
							<tr class="icon-label-setting-row"<?php echo $il_no_show_class; ?>>
								<th scope="row"><?php echo esc_html__( 'Outer Box Padding', 'add-whatsapp-button' ); ?></th>
								<td>
									<input name="awb_settings[icon_wrapper_padding]" id="awb_settings[icon_wrapper_padding]" type="number" value="<?php echo esc_attr( $settings['icon_wrapper_padding'] ?? '0' ); ?>" class="small-text" />
									<select class="awb-mu-select" name="awb_settings[icon_wrapper_padding_mu]">
										<option value="px" <?php selected( $settings['icon_wrapper_padding_mu'] ?? 'px', 'px' ); ?>>px</option>
										<option value="em" <?php selected( $settings['icon_wrapper_padding_mu'] ?? 'px', 'em' ); ?>>em</option>
										<option value="rem" <?php selected( $settings['icon_wrapper_padding_mu'] ?? 'px', 'rem' ); ?>>rem</option>
									</select>
								</td>
							</tr>
							<tr class="icon-label-setting-row"<?php echo $il_no_show_class; ?>>
								<th scope="row"><?php echo esc_html__( 'Outer Box Border Radius', 'add-whatsapp-button' ); ?></th>
								<td>
									<input name="awb_settings[icon_wrapper_radius]" id="awb_settings[icon_wrapper_radius]" type="number" value="<?php echo esc_attr( $settings['icon_wrapper_radius'] ?? '0' ); ?>" class="small-text" />
									<select class="awb-mu-select" name="awb_settings[icon_wrapper_radius_mu]">
										<option value="px" <?php selected( $settings['icon_wrapper_radius_mu'] ?? 'px', 'px' ); ?>>px</option>
										<option value="em" <?php selected( $settings['icon_wrapper_radius_mu'] ?? 'px', 'em' ); ?>>em</option>
										<option value="rem" <?php selected( $settings['icon_wrapper_radius_mu'] ?? 'px', 'rem' ); ?>>rem</option>
									</select>
								</td>
							</tr>
							<tr class="icon-label-setting-row"<?php echo $il_no_show_class; ?>>
								<th scope="row"><label for="awb_settings[icon_wrapper_shadow]"><?php echo esc_html__( 'Outer Box Drop Shadow', 'add-whatsapp-button' ); ?></label></th>
								<td>
									<input name="awb_settings[icon_wrapper_shadow]" type="checkbox" id="awb_settings[icon_wrapper_shadow]" value="1" <?php isset( $settings['icon_wrapper_shadow'] ) ? checked( '1', $settings['icon_wrapper_shadow'] ) : ''; ?>>
								</td>
							</tr>
							<tr class="icon-label-setting-row"<?php echo $il_no_show_class; ?>>
								<th scope="row"><label for="awb_settings[icon_wrapper_align]"><?php echo esc_html__( 'Icon / Label Alignment', 'add-whatsapp-button' ); ?></label></th>
								<td>
									<select id="awb_settings[icon_wrapper_align]" name="awb_settings[icon_wrapper_align]">
										<option value="center" <?php selected( $settings['icon_wrapper_align'] ?? 'center', 'center' ); ?>><?php echo esc_html__( 'Center', 'add-whatsapp-button' ); ?></option>
										<option value="flex-start" <?php selected( $settings['icon_wrapper_align'] ?? 'center', 'flex-start' ); ?>><?php echo esc_html__( 'Start', 'add-whatsapp-button' ); ?></option>
										<option value="flex-end" <?php selected( $settings['icon_wrapper_align'] ?? 'center', 'flex-end' ); ?>><?php echo esc_html__( 'End', 'add-whatsapp-button' ); ?></option>
									</select>
									<p class="description"><?php echo esc_html__( 'Cross-axis alignment between the icon and label.', 'add-whatsapp-button' ); ?></p>
								</td>
							</tr>
							<tr class="rect-size-setting-row"<?php echo $rect_no_show_class; ?>>
								<th scope="row"><?php echo esc_html__( 'Button Width', 'add-whatsapp-button' ); ?></th>
								<td>
									<input name="awb_settings[rect_width]" type="number" id="awb_settings[rect_width]" value="<?php echo esc_attr( $settings['rect_width'] ?? '' ); ?>" class="small-text" placeholder="<?php echo esc_attr__( 'auto', 'add-whatsapp-button' ); ?>" />
									<select class="awb-mu-select" name="awb_settings[rect_width_mu]">
										<option value="px" <?php selected( $settings['rect_width_mu'] ?? 'px', 'px' ); ?>>px</option>
										<option value="%" <?php selected( $settings['rect_width_mu'] ?? 'px', '%' ); ?>>%</option>
										<option value="em" <?php selected( $settings['rect_width_mu'] ?? 'px', 'em' ); ?>>em</option>
									</select>
									<p class="description"><?php echo esc_html__( 'Leave empty to keep the default auto width.', 'add-whatsapp-button' ); ?></p>
								</td>
							</tr>
							<tr class="rect-size-setting-row"<?php echo $rect_no_show_class; ?>>
								<th scope="row"><?php echo esc_html__( 'Button Height', 'add-whatsapp-button' ); ?></th>
								<td>
									<input name="awb_settings[rect_height]" type="number" id="awb_settings[rect_height]" value="<?php echo esc_attr( $settings['rect_height'] ?? '' ); ?>" class="small-text" placeholder="<?php echo esc_attr__( 'auto', 'add-whatsapp-button' ); ?>" />
									<select class="awb-mu-select" name="awb_settings[rect_height_mu]">
										<option value="px" <?php selected( $settings['rect_height_mu'] ?? 'px', 'px' ); ?>>px</option>
										<option value="em" <?php selected( $settings['rect_height_mu'] ?? 'px', 'em' ); ?>>em</option>
									</select>
									<p class="description"><?php echo esc_html__( 'Leave empty to keep the default auto height.', 'add-whatsapp-button' ); ?></p>
								</td>
							</tr>
							<tr class="rect-size-setting-row"<?php echo $rect_no_show_class; ?>>
								<th scope="row"><?php echo esc_html__( 'Button Padding', 'add-whatsapp-button' ); ?></th>
								<td>
									<input name="awb_settings[rect_padding]" type="number" id="awb_settings[rect_padding]" value="<?php echo esc_attr( $settings['rect_padding'] ?? '' ); ?>" class="small-text" placeholder="10" />
									<select class="awb-mu-select" name="awb_settings[rect_padding_mu]">
										<option value="px" <?php selected( $settings['rect_padding_mu'] ?? 'px', 'px' ); ?>>px</option>
										<option value="em" <?php selected( $settings['rect_padding_mu'] ?? 'px', 'em' ); ?>>em</option>
									</select>
									<p class="description"><?php echo esc_html__( 'Leave empty to keep the default padding.', 'add-whatsapp-button' ); ?></p>
								</td>
							</tr>
							<tr class="rect-size-setting-row"<?php echo $rect_no_show_class; ?>>
								<th scope="row"><?php echo esc_html__( 'Button Font Size', 'add-whatsapp-button' ); ?></th>
								<td>
									<input name="awb_settings[rect_font_size]" type="number" id="awb_settings[rect_font_size]" value="<?php echo esc_attr( $settings['rect_font_size'] ?? '' ); ?>" class="small-text" placeholder="<?php echo esc_attr__( 'inherit', 'add-whatsapp-button' ); ?>" />
									<select class="awb-mu-select" name="awb_settings[rect_font_size_mu]">
										<option value="px" <?php selected( $settings['rect_font_size_mu'] ?? 'px', 'px' ); ?>>px</option>
										<option value="em" <?php selected( $settings['rect_font_size_mu'] ?? 'px', 'em' ); ?>>em</option>
										<option value="rem" <?php selected( $settings['rect_font_size_mu'] ?? 'px', 'rem' ); ?>>rem</option>
									</select>
									<p class="description"><?php echo esc_html__( 'Leave empty to inherit the page font size.', 'add-whatsapp-button' ); ?></p>
								</td>
							</tr>
							<th scope="row"><label for="awb_settings[button_location]"><?php echo esc_html__( 'Button Location on Screen', 'add-whatsapp-button' ); ?></label></th>
								<td>
									<select id="awb_settings[button_location]" name="awb_settings[button_location]" style="vertical-align: baseline;">
										<option value="right" <?php selected( $settings['button_location'] ?? '', 'right' ); ?>>right</option>
										<option value="left" <?php selected( $settings['button_location'] ?? '', 'left' ); ?>>left</option>
									</select>
									<p class="description"><?php echo esc_html__( 'Choose whether your button will appear on the left side or right side of the screen', 'add-whatsapp-button'); ?></p>
								</td>
							</tr>
						</tbody>
					</table>
				
					<div class="device-wrapper"> <!-- Mockup Container -->
					<h2><?php echo esc_html__( 'Button Preview', 'add-whatsapp-button'); ?></h2>
						<div class="device" data-device="iPhone7" data-orientation="portrait" data-color="black">
							<div class="screen">
								<div class="mockup-top-spacer"></div>
								<div class="gray-logo"></div>
								<div class="gray-menu"></div>
								<div class="gray-row"></div>
								<div class="gray-row"></div>
								<div class="gray-row-cont">
									<div class="gray-row-cont-inner">
										<div class="gray-row gray-row-half" style="margin-top: 0;"></div>
										<div class="gray-row gray-row-half"></div>
										<div class="gray-row gray-row-half"></div>
										<div class="gray-row gray-row-half"></div>
									</div>
									<div class="gray-row-cont-inner">
										<div class="gray-row-half-img"></div>
									</div>
								</div>

								<div class="gray-row gray-row-box"></div>
								<div id="admin_wab_cont" class="wab-cont <?php echo $button_style; ?> <?php echo ( $button_style !== 'wab-bottom-rectangle' ) ? 'wab-pull-' . $settings['button_location'] : ''; ?><?php echo ( ! empty( $settings['icon_label_enable'] ) && $button_style === 'wab-icon-plain' ) ? ' icon-label-active' : ''; ?>"> <!-- Button Preview HTML -->
									<a id="whatsAppButton"<?php echo $button_inline_styles; ?> href="https://wa.me/<?php echo $settings['phone_number'] . ( ! empty( $settings['default_message'] ) && $settings['enable_message'] == '1' ) ? '/?text='. rawurlencode( $settings['default_message'] ) : ''; ?>" target="_blank">
										<span id="wab-text" <?php echo $displayNoneIfIcon; ?>><?php echo $button_text; ?></span>
									</a>
									<span id="wab-icon-label" class="<?php echo ( empty( $settings['icon_label_enable'] ) || $button_style !== 'wab-icon-plain' ) ? 'awb-hide' : ''; ?>"><?php echo $button_text; ?></span>
								</div>

							</div> <!-- /screen -->
							<div class="button">
							<!-- You can hook the "home button" to some JavaScript events or just remove it -->
							</div>
						</div> <!-- /device -->
					</div> <!-- /device-wrapper -->
				</div> <!-- /bdtab -->
				<p class="submit">
					<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php echo esc_html__( 'Save Changes', 'add-whatsapp-button' ); ?>">
				</p>
				<h2><?php echo esc_html__( 'Reset All Settings', 'add-whatsapp-button' ); ?></h2>
				<p>
					<?php submit_button( esc_html__( 'Reset All Settings', 'add-whatsapp-button' ), 'secondary', 'reset_awb_options', false); ?>
				</p>
			</form>
		</div> <!-- /wrap -->

		<?php
		echo ob_get_clean();
	}

	public function maybe_show_five_star_review_notice() {
		if ( ! PAnD::is_admin_notice_active( 'disable-done-notice-forever' ) ) {
			return;
		}
		
		$screen = get_current_screen();
		
		if ( $screen->id == 'settings_page_awb-options' ) {
			?>
			<div data-dismissible="disable-done-notice-forever" class="notice notice-info is-dismissible">
				<p>
					<?php echo esc_html( 'Thanks for installing Add WhatsApp Button! Liked the plugin? We\'d really appreciate it if you could help us out with', 'add-whatsapp-button'); ?> 
					<a href="https://wordpress.org/support/plugin/add-whatsapp-button/reviews/" target="_blank"><?php echo esc_html( 'a 5-star rating and review!', 'add-whatsapp-button'); ?></a>
				</p>
			</div>
			<?php
		}
	}
}