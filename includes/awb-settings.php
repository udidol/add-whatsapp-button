<?php
//Create menu link

function awb_options_menu_link() {
    $awb_options_page = add_options_page(
        'Add WhatsApp Button Options', // title
        'Add WhatsApp Button', // title of the menu link
        'manage_options', // capabilities credentials, at least able to X
        'awb-options', // menu URL slug
        'awb_options_content' // name of the function that displays the option page content
    );

    // Load the JS conditionally
    add_action( 'load-' . $awb_options_page, 'load_admin_cp_js' );
    add_action( 'load-' . $awb_options_page, 'load_awb_admin_styles' );
}

if ( !function_exists( 'load_admin_cp_js' ) ) {
    function load_admin_cp_js() {
        // Unfortunately we can't just enqueue our scripts here - it's too early. So register against the proper action hook to do it
        add_action( 'admin_enqueue_scripts', 'enqueue_admin_cp_js' );
    }
}

if ( !function_exists( 'load_awb_admin_styles' ) ) {
    function load_awb_admin_styles() {
        add_action( 'admin_enqueue_scripts', 'enqueue_awb_admin_styles' );
    }
}

if ( !function_exists( 'enqueue_admin_cp_js' ) ) {
    function enqueue_admin_cp_js() {
        wp_enqueue_style( 'wp-color-picker');
        wp_enqueue_script( 'admin_cp_js', plugins_url( '../js/cp.js', __FILE__ ), array( 'jquery', 'wp-color-picker' ), '', true  );
    }
}

function awb_validate_inputs( $input ) {
 
    // Reset all settings to default when reset button is clicked
    if ( isset( $_POST['reset_awb_options'] ) ) {
        delete_option('awb-options');
        add_settings_error('reset_awb_settings', esc_attr('settings_deleted'), __('Your settings have been successfully deleted and reset to defaults.', 'add-whatsapp-button'), 'updated');
        return array(); //Default settings
    }

    // Create our array for storing the validated options
    $output = array();

    // Loop through each of the incoming options
    foreach( $input as $key => $value ) {
         
        // Check to see if the current option has a value. If so, process it.
        if( isset( $input[$key] ) ) {
         
            // Sanitize phone number
            if ( $key == 'phone_number' ) {
                preg_replace('/[^0-9]/', '', $input[$key]);

                if ( !preg_match("/^\d+$/", $input[$key]) ) {
                    add_settings_error( 'awb_phone_number_invalid', esc_attr('settings_updated'), __('The value you entered in the phone number field is invalid. Please enter a valid number.', 'add-whatsapp-button') );
                    add_action( 'admin_notices', 'print_errors' );
                    $input[$key] = '';
                }
            }
            // Strip all HTML and PHP tags and properly handle quoted strings
            $output[$key] = strip_tags( stripslashes( $input[ $key ] ) );
             
        } // end if
         
    } // end foreach

    // Return the array processing any additional functions filtered by this action
    return apply_filters( 'awb_validate_inputs', $output, $input );
}

function awb_validate_limiting_hours( $hour ) {
    if ( is_numeric($hour) && $hour >= 0 && $hour <= 24 ) {
        return $hour;
    }
    else {
        return '';
    }
}

// Create options page content
function awb_options_content() {

    // Init Options Global
    global $awb_options;

    // Set default button style for Settings Page Preview
    $button_style = !empty( $awb_options['button_type'] ) ? $awb_options['button_type'] : 'wab-side-rectangle';
    // Create default button text
    $button_text = !empty( $awb_options['button_text'] ) ? sanitize_text_field( $awb_options['button_text'] ) : __('Message Us on WhatsApp', 'add-whatsapp-button');
    // Hide Text if selected button style is "Icon"
    $displayNoneIfIcon = ( $awb_options['button_type'] == 'wab-icon-plain' || $awb_options['button_type'] == 'wab-icon-styled' ) ? 'class="awb-displaynone"' : '';

    ob_start(); ?>

        <div class="wrap">
            <?php //settings_errors(); ?>

            <h2><?php _e('Add WhatsApp Button Settings', 'add-whatsapp-button') ?></h2>
            <p>
                <?php _e('Settings page for the Add WhatsApp Button plugin. Check out the preview screen in the "Button Design" tab to see how your button would look on a smartphone before saving your settings to the database.', 'add-whatsapp-button') ?><br />
                <a href="https://wordpress.org/support/plugin/add-whatsapp-button/reviews/" target="_blank"><?php _e('Rate "Add WhatsApp Button" at wordpress.org!', 'add-whatsapp-button') ?></a>
            </p>

            <form method="POST" action="options.php">
                <?php settings_fields('awb_settings_group'); ?>

                <div class="nav-tab-wrapper">
                    <a href="#" id="gstablink" class="nav-tab nav-tab-active"><?php _e('General Settings', 'add-whatsapp-button') ?></a>
                    <a href="#" id="bdtablink" class="nav-tab"><?php _e('Button Design', 'add-whatsapp-button') ?></a>
                </div>

                <div id="gstab" class="awb-tab-content-wrapper awb-tab-active">
                    <table class="form-table">
                        <tbody>
                            <tr>
                                <th colspan="2">
                                    <h2 class="awb-button-design-title"><?php _e('General Settings', 'add-whatsapp-button'); ?></h2>
                                </th>
                            </tr>
                            <tr>
                                <th scope="row"><label for="awb_settings[enable]"><?php _e('Enable WhatsApp Button', 'add-whatsapp-button') ?></label></th>
                                <td><input name="awb_settings[enable]" type="checkbox" id="awb_settings[enable]" value="1" <?php isset($awb_options['enable']) ? checked('1', $awb_options['enable']) : ''; ?>></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="awb_settings[button_text]"><?php _e('Button Text', 'add-whatsapp-button') ?></label></th>
                                <td>
                                    <input name="awb_settings[button_text]" type="text" id="awb_settings[button_text]" value="<?php echo $button_text; ?>" class="regular-text">
                                    <p class="description"><?php _e('Enter the text you want the button to show. Recommended: up to 18 characters.', 'add-whatsapp-button'); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="awb_settings[phone_number]"><?php _e('Target Phone Number', 'add-whatsapp-button') ?></label></th>
                                <td>
                                    <input required name="awb_settings[phone_number]" type="text" id="awb_settings[phone_number]" value="<?php echo sanitize_text_field( $awb_options['phone_number'] ); ?>" placeholder="12345678910" class="regular-text">
                                    <p class="description"><?php _e('Enter the phone number you want the WhatsApp message to be sent to, with your country code, WITHOUT a "+" (PLUS) SIGN. For example, if you wanted to send WhatsApp messages to the number +1-770-123-4567, you would enter: 17701234567 in the input box.', 'add-whatsapp-button'); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="awb_settings[enable_message]"><?php _e('Default Message', 'add-whatsapp-button') ?></label></th>
                                <td>
                                    <input name="awb_settings[enable_message]" type="checkbox" id="awb_settings[enable_message]" value="1" <?php isset($awb_options['enable_message']) ? checked('1', $awb_options['enable_message']) : ''; ?>>
                                    <p class="description"><?php _e('Check this box in order to set a default message to be pre-written when users click the button. For example: "Hi, I\'m interested in your product".', 'add-whatsapp-button'); ?></p>
                                    <div id="awb_enable_message" class="em-no-show">
                                        <textarea name="awb_settings[default_message]" type="number" id="awb_settings[default_message]" class="small-text"><?php echo isset($awb_options['default_message']) ? sanitize_textarea_field( $awb_options['default_message'] ) : ''; ?></textarea>
                                        <p class="description"><?php _e('Enter the message you want to pre-enter for the users when they click on your WhatsApp button.', 'add-whatsapp-button'); ?></p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="awb_settings[hide_button]"><?php _e('Add Hide Button', 'add-whatsapp-button') ?></label></th>
                                <td>
                                    <input name="awb_settings[enable_hide_button]" type="checkbox" id="awb_settings[enable_hide_button]" value="1" <?php isset($awb_options['enable_hide_button']) ? checked('1', $awb_options['enable_hide_button']) : ''; ?>>
                                    <p class="description"><?php _e('Check this box in order to add a small "Hide" button at the far right corner of the WhatsApp button.', 'add-whatsapp-button'); ?></p>
                                    <div id="awb_hide_button" class="hb-no-show">
                                        <input type="radio" name="awb_settings[hide_button]" value="full" <?php isset($awb_options['hide_button']) ? checked('full', $awb_options['hide_button']) : ''; ?> /> <strong>Full Remove</strong>
                                        <p class="description radio-description"><?php _e('Choose this option to make the WhatsApp button disappear completely on click.', 'add-whatsapp-button'); ?></p>
                                        <input type="radio" name="awb_settings[hide_button]" value="hide" <?php isset($awb_options['hide_button']) ? checked('hide', $awb_options['hide_button']) : ''; ?> /> <strong>Hide with toggle button</strong>
                                        <p class="description radio-description">
                                            <?php _e('Choose this option to make the WhatsApp button slide almost entirely off screen, while keeping the toggle button visible.', 'add-whatsapp-button'); ?><br />
                                            <?php _e('Clicking the toggle button again will slide the WhatsApp button back into view.', 'add-whatsapp-button'); ?>
                                        </p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="awb_settings[breakpoint]"><?php _e('Breakpoint', 'add-whatsapp-button') ?></label></th>
                                <td>
                                    <input name="awb_settings[enable_breakpoint]" type="checkbox" id="awb_settings[enable_breakpoint]" value="1" <?php isset($awb_options['enable_breakpoint']) ? checked('1', $awb_options['enable_breakpoint']) : ''; ?>>
                                    <p class="description"><?php _e('Check this box in order to only display the WhatsApp button up to a certain screen width.', 'add-whatsapp-button'); ?></p>
                                    <div id="awb_breakpoint" class="bp-no-show">
                                        <input name="awb_settings[breakpoint]" type="number" id="awb_settings[breakpoint]" value="<?php echo sanitize_text_field( $awb_options['breakpoint'] ); ?>" class="small-text"><?php _e('px', 'add-whatsapp-button'); ?>
                                        <p class="description"><?php _e('Enter your desired screen width breakpoint here. Default is 600px.', 'add-whatsapp-button'); ?></p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="awb_settings[limit_hours]"><?php _e('Limit Display Time', 'add-whatsapp-button') ?></label></th>
                                <td>
                                    <input name="awb_settings[limit_hours]" type="checkbox" id="awb_settings[limit_hours]" value="1" <?php isset($awb_options['limit_hours']) ? checked('1', $awb_options['limit_hours']) : ''; ?>>
                                    <p class="description"><?php _e('Check this box in order to only display the WhatsApp button in certain hours of the day.', 'add-whatsapp-button'); ?></p>
                                    <div id="awb_limit_hours" class="lh-no-show">
                                        <span class="awb-hours"><?php _e('Start Hour:', 'add-whatsapp-button'); ?> </span>
                                        <select name="awb_settings[startHour]" id="awb_settings[startHour]">
                                            <?php for ($i = 0; $i<=24; $i++) { ?>
                                                <option value="<?php echo $i; ?>" <?php selected( awb_validate_limiting_hours($awb_options['startHour']), $i ); ?>><?php echo ( strlen((string) $i) == 2 ) ? $i : '0'.$i; ?>:00</option>
                                            <?php } ?>
                                        </select>
                                        <p class="description"><?php _e('The WhatsApp button will be displayed starting this hour (24 hour clock). If no time is chosen, default is 8:00 (8AM). Make sure your starting hour is before your ending hour.', 'add-whatsapp-button'); ?></p>

                                        <span class="awb-hours"><?php _e('End Hour:', 'add-whatsapp-button'); ?> </span>
                                        <select name="awb_settings[endHour]" id="awb_settings[endHour]">
                                            <?php for ($i = 0; $i<=24; $i++) { ?>
                                                <option value="<?php echo $i; ?>" <?php selected( awb_validate_limiting_hours($awb_options['endHour']), $i ); ?>><?php echo ( strlen((string) $i) == 2 ) ? $i : '0'.$i; ?>:00</option>
                                            <?php } ?>
                                        </select>
                                        <p class="description"><?php _e('The WhatsApp button will be displayed up until this hour (24 hour clock). If no time is chosen, default is 22 (10PM).', 'add-whatsapp-button'); ?></p>
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
                                    <h2 class="awb-button-design-title"><?php _e('Button Design', 'add-whatsapp-button'); ?></h2>
                                </th>
                            </tr>
                            <tr>
                                <th scope="row"><label for="awb_settings[button_bg_color]"><?php _e('Button Background Color', 'add-whatsapp-button') ?></label></th>
                                <td>
                                    <input name="awb_settings[button_bg_color]" type="text" id="awb_settings[button_bg_color]"  value="<?php echo sanitize_text_field( $awb_options['button_bg_color'] ); ?>" class="udi-bg-color-picker" />
                                    <p class="description"><?php _e('Choose a background color for your button. Default is green (#20B038)', 'add-whatsapp-button'); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="awb_settings[button_text_color]"><?php _e('Button Text Color', 'add-whatsapp-button') ?></label></th>
                                <td>
                                    <input name="awb_settings[button_text_color]" type="text" id="awb_settings[button_text_color]"  value="<?php echo sanitize_text_field( $awb_options['button_text_color'] ); ?>" class="udi-text-color-picker" />
                                    <p class="description"><?php _e('Choose a text color for your button. Default is white (#ffffff)', 'add-whatsapp-button'); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="awb_settings[distance_from_bottom]"><?php _e('Button Distance from Bottom', 'add-whatsapp-button') ?></label></th>
                                <td>
                                    <input name="awb_settings[distance_from_bottom]" type="number" id="awb_settings[distance_from_bottom]"  value="<?php echo sanitize_text_field( $awb_options['distance_from_bottom'] ); ?>" class="small-text" />

                                    <select class="awb-mu-select" id="awb_settings[distance_from_bottom_mu]" name="awb_settings[distance_from_bottom_mu]" style="vertical-align: baseline;">
                                        <option value="%" <?php selected( $awb_options['button_location'], '%' ); ?>>%</option>
                                        <option value="px" <?php selected( $awb_options['button_location'], 'px' ); ?>>px</option>
                                    </select>

                                    <p class="description"><?php _e('Choose your button\'s Distance from the bottom of the screen, in percentages or pixels. Default is 10%.', 'add-whatsapp-button'); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="awb_settings[button_type]"><?php _e('Button Style', 'add-whatsapp-button') ?></label></th>
                                <td>
                                    <select class="awb-bt-select" id="awb_settings[button_type]" name="awb_settings[button_type]" style="vertical-align: baseline;">
                                        <option disabled selected value> -- Select Button Type -- </option>
                                        <!-- <option value="wab-icon-styled" <?php //selected( $awb_options['button_type'], 'wab-icon-styled' ); ?>>Styled WhatsApp Icon</option> -->
                                        <option value="wab-icon-plain" <?php selected( $awb_options['button_type'], 'wab-icon-plain' ); ?>>Plain WhatsApp Icon</option>
                                        <option value="wab-side-rectangle" <?php selected( $awb_options['button_type'], 'wab-side-rectangle' ); ?>>Side-Floating Rectangle with Text</option>
                                        <option value="wab-bottom-rectangle" <?php selected( $awb_options['button_type'], 'wab-bottom-rectangle' ); ?>>Fixed-Bottom Rectangle with Text</option>
                                    </select>
                                    <p class="description"><?php _e('Choose your button\'s Style: Round WhatsApp icon, a floating rectangle with text, or a full-width fixed bottom button.', 'add-whatsapp-button'); ?></p>
                                </td>
                            </tr>
                            <th scope="row"><label for="awb_settings[button_location]"><?php _e('Button Location on Screen', 'add-whatsapp-button') ?></label></th>
                                <td>
                                    <select id="awb_settings[button_location]" name="awb_settings[button_location]" style="vertical-align: baseline;">
                                        <option value="right" <?php selected( $awb_options['button_location'], 'right' ); ?>>right</option>
                                        <option value="left" <?php selected( $awb_options['button_location'], 'left' ); ?>>left</option>
                                    </select>
                                    <p class="description"><?php _e('Choose whether your button will appear on the left side or right side of the screen', 'add-whatsapp-button'); ?></p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                
                    <div class="device-wrapper"> <!-- Mockup Container -->
                    <h2><?php _e('Button Preview', 'add-whatsapp-button'); ?></h2>
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
                                <div id="admin_wab_cont" class="wab-cont <?php echo $button_style; ?> <?php echo ($button_style !== 'wab-bottom-rectangle') ? 'wab-pull-'.$awb_options['button_location'] : ''; ?>"> <!-- Button Preview HTML -->
                                    <a id="whatsAppButton" href="https://api.whatsapp.com/send?phone=<?php echo $awb_options['phone_number']; ?><?php echo ( !empty($awb_options['default_message']) && $awb_options['enable_message'] == '1' ) ? '&text='. rawurlencode($awb_options['default_message']) : ''; ?>" target="_blank"><span id="wab-text" <?php echo $displayNoneIfIcon; ?>><?php echo $button_text; ?> <!--<img src="<?php //echo plugins_url( '../img/wai.svg', __FILE__ ) ?>" style="max-width: 20px; display: inline;" />--></span></a>
                                </div>

                            </div> <!-- /screen -->
                            <div class="button">
                            <!-- You can hook the "home button" to some JavaScript events or just remove it -->
                            </div>
                        </div> <!-- /device -->
                    </div> <!-- /device-wrapper -->
                </div> <!-- /bdtab -->
                <p class="submit">
                    <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e('Save Changes', 'add-whatsapp-button') ?>">
                </p>
                <h2><?php _e('Reset All Settings', 'add-whatsapp-button') ?></h2>
                <p>
                    <?php submit_button(__('Reset All Settings', 'add-whatsapp-button'), 'secondary', 'reset_awb_options', false); ?>
                </p>
            </form>
        </div> <!-- /wrap -->
                             
        <!-- DUMP ALL PLUGIN OPTIONS TO SEE WASSAP -->
        <!-- <div dir="ltr"><?php //var_dump($awb_options); ?></div> -->

    <?php
    echo ob_get_clean();
}

add_action('admin_menu', 'awb_options_menu_link');

// Register plugin settings
function awb_register_settings() {
    register_setting('awb_settings_group', 'awb_settings', 'awb_validate_inputs');
}
add_action('admin_init', 'awb_register_settings');

// Add admin notice to give 5-star review
add_action( 'admin_notices', function() {
    if ( ! PAnD::is_admin_notice_active( 'disable-done-notice-forever' ) ) {
		return;
    }
    
    ?>
    <div data-dismissible="disable-done-notice-forever" class="notice notice-info is-dismissible">
        <p>
            <?php _e('Thanks for installing Add WhatsApp Button! Liked the plugin? We\'d really appreciate it if you could help us out with', 'add-whatsapp-button'); ?> 
            <a href="https://wordpress.org/support/plugin/add-whatsapp-button/reviews/" target="_blank"><?php _e('a 5-star rating and review!', 'add-whatsapp-button'); ?></a>
        </p>
    </div>
    <?php

});

/*
 *
 * STYLES
 *
*/

// Add the plugin CSS to the admin_head hook in the plugin settings page
function enqueue_awb_admin_styles() {

    $distance_from_bottom = isset( $awb_options['distance_from_bottom'] ) && is_numeric( $awb_options['distance_from_bottom'] ) ? $awb_options['distance_from_bottom'] : '10';
    $distance_from_bottom_mu = isset( $awb_options['distance_from_bottom_mu'] ) ? $awb_options['distance_from_bottom_mu'] : '%'; 
    $button_bg_color = !empty( $awb_options['button_bg_color'] ) ? $awb_options['button_bg_color'] : '#20B038';
    $button_text_color = !empty( $awb_options['button_text_color'] ) ? $awb_options['button_text_color'] : '#ffffff';
    $button_location = isset( $awb_options['button_location'] ) ? $awb_options['button_location'] : 'right';
    $wp_text_direction = is_rtl() ? 'rtl' : 'ltr';

    ?>
    <style type="text/css">
        .device-wrapper {
            max-width: 250px;
        }
        
        /* Side Rectangle */

        .wab-side-rectangle .wp-admin #whatsAppButton svg path {
            fill: #fff;
        } */
        
        .wab-side-rectangle.wab-pull-right, .wab-icon-styled.wab-pull-right, .wab-icon-plain.wab-pull-right {
            right: 0;
            left: initial !important;
        }

        .wab-side-rectangle.wab-pull-left, .wab-icon-styled.wab-pull-left, .wab-icon-plain.wab-pull-left {
            left: 0;
            right: initial !important;
        }

        .wp-admin .wab-side-rectangle.wab-cont {
            position: absolute;
            <?php echo $button_location; ?>: 0;
            bottom: <?php echo $distance_from_bottom; echo $distance_from_bottom_mu; ?>;
            z-index: 99999;
        }

        .wp-admin .wab-side-rectangle #whatsAppButton {
            display: block;
            position: relative;
            direction: <?php echo $wp_text_direction; ?>;
            z-index: 9999;
            cursor: pointer;
            min-width: 50px;
            max-width: 236px;
            color: <?php echo $button_text_color; ?>;
            text-align: center;
            text-decoration: none;
            padding: 10px;
            margin: 0 auto 0 auto;
            background: <?php echo $button_bg_color; ?>;
            -webkit-transition: All 0.5s ease;
            -moz-transition: All 0.5s ease;
            -o-transition: All 0.5s ease;
            -ms-transition: All 0.5s ease;
            transition: All 0.5s ease;
        }
        
        .wp-admin .wab-side-rectangle #whatsAppButton:after {
            margin-left: 5px;
            margin-right: 5px;
            /* content: url(/wp-content/themes/html5blanknew/img/whatsapp-logo2.svg); */
            max-width: 20px;
            max-height: 20px;
            fill: currentColor;
        }

        .wp-admin .wab-side-rectangle #whatsAppButton svg path {
            fill: #fff;
        }
        
        /* Bottom Rectangle */

        .wp-admin .wab-bottom-rectangle.wab-cont {
            position: absolute;
            bottom: 0;
            z-index: 99999;
            width: 100%;
        }

        .wp-admin .wab-bottom-rectangle #whatsAppButton {
            display: block;
            position: relative;
            direction: <?php echo $wp_text_direction; ?>;
            z-index: 9999;
            cursor: pointer;
            color: <?php echo $button_text_color; ?>;
            text-align: center;
            text-decoration: none;
            padding: 10px;
            margin: 0 auto 0 auto;
            background: <?php echo $button_bg_color; ?>;
        }

        /* Icon */
        
        .wp-admin .wab-icon-styled.wab-cont, .wp-admin .wab-icon-plain.wab-cont {
            position: absolute;
            <?php echo $button_location; ?>: 10px;
            bottom: <?php echo $distance_from_bottom; echo $distance_from_bottom_mu; ?>;
            z-index: 99999;
            height: 80px;
            width: 80px;
        }

        .wp-admin .wab-icon-styled #whatsAppButton, .wp-admin .wab-icon-plain #whatsAppButton {
            display: block;
            width: 80px;
            height: 80px;
            background-position: center center;
            background-size: cover;
        }
        .wp-admin .wab-icon-styled.wab-cont.wab-pull-left, .wp-admin .wab-icon-plain.wab-cont.wab-pull-left {
            left: 10px;
        }

        .wp-admin .wab-icon-styled.wab-cont.wab-pull-right, .wp-admin .wab-icon-plain.wab-cont.wab-pull-right {
            right: 10px;
        }

        /* .wp-admin .wab-icon-styled.wab-pull-left #whatsAppButton {
            background-image: url(<?php //echo plugins_url( '../img/wa-icon-left.png', __FILE__ ); ?>);
        }

        .wp-admin .wab-icon-styled.wab-pull-right #whatsAppButton {
            background-image: url(<?php //echo plugins_url( '../img/wa-icon-right.png', __FILE__ ); ?>);
        } */

        .wp-admin .wab-icon-plain.wab-pull-left #whatsAppButton, .wp-admin .wab-icon-plain.wab-pull-right #whatsAppButton {
            background-image: url(<?php echo plugins_url( '../img/wa-icon-original.png', __FILE__ ); ?>);
        }
        
        .awb-displaynone {
            display: none;
        }
    </style>

    <?php
}