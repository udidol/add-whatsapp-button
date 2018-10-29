<?php
/*
Plugin Name: Add Whatsapp Button
Description: Adds a Floating Whatsapp button to your website
Author: Udi Dollberg
Text Domain: add-whatsapp-button
Domain Path: /languages
Version: 1.0
Author URI: http://udidollberg.com/
*/

//Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Global Options Variable
$awb_options = get_option('awb_settings');

// Plugin Folder Name
$awb_plugin_folder = 'add-whatsapp-button';

// Create constants for file path references
define( 'UDI_awb__FILE__', __FILE__ );
define( 'UDI_awb_PLUGIN_BASE', plugin_basename( 'UDI_awb__FILE__' ) );
define( 'UDI_awb_PATH', plugin_dir_path( 'UDI_awb__FILE__' ) );
define( 'UDI_awb_URL', plugins_url( '/', 'UDI_awb__FILE__' ) );

// Load Scripts
require_once(plugin_dir_path(__FILE__).'/includes/awb-scripts.php'); //enqueuing plugin scripts

// Load Plugin Textdomain
function load_awb_textdomain() {
    load_plugin_textdomain( 'add-whatsapp-button', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'load_awb_textdomain' );

// Add a link to the plugin's Settings page from the Plugins Page
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'awb_plugin_action_links', 10, 5 );
function awb_plugin_action_links( $links ) {

    $settings = array('settings' => '<a href="options-general.php?page=awb-options">' . __('Settings', 'add-whatsapp-button') . '</a>');
    
    $links = array_merge($settings, $links);
    
    return $links;

}

// Load Plugin Settings in Admin Settings Page
if( is_admin() ) {
    require_once(plugin_dir_path(__FILE__).'/includes/awb-settings.php'); //including plugin settings
}

/*
*
* Add the Whatsapp Button to the website
*
*/

function awb_html() {

	global $awb_options;

	$button_text = isset( $awb_options['button_text'] ) ? sanitize_text_field( $awb_options['button_text'] ) : _e('Message Us on WhatsApp', 'add-whatsapp-button');
    $displayNoneIfIcon = ( $awb_options['button_type'] == 'wab-icon-plain' || $awb_options['button_type'] == 'wab-icon-styled' ) ? 'awb-displaynone' : '';
    $button_style = !empty( $awb_options['button_type'] ) ? $awb_options['button_type'] : 'wab-side-rectangle';
    $button_location = isset( $awb_options['button_location'] ) ? 'wab-pull-'.$awb_options['button_location'] : 'wab-pull-left';

	ob_start(); 
	?>

        <div id="wab_cont" class="wab-cont <?php echo $button_style; ?> <?php echo $button_location; ?>">
			<a id="whatsAppButton" class="ui-draggable" href="https://<?php echo wp_is_mobile() ? 'api' : 'web'; ?>.whatsapp.com/send?phone=<?php echo $awb_options['phone_number']; ?><?php echo ( !empty($awb_options['default_message']) && $awb_options['enable_message'] == '1' ) ? '&text='. rawurlencode($awb_options['default_message']) : ''; ?>" target="_blank"><span class="<?php echo $displayNoneIfIcon; ?>"><?php echo $button_text; ?></span></a>
		</div>
		
	<?php 
	echo ob_get_clean();

}

if ( $awb_options['enable'] && !is_admin() ) {
	// Add the WhatsApp button 
	add_action('wp_footer', 'awb_html');
}

// Add the plugin CSS to the wp_head hook in the front end
function enqueue_awb_styles() {

	// Init Options Global
    global $awb_options;

    $breakpoint = !empty( $awb_options['breakpoint'] ) && is_numeric( $awb_options['breakpoint'] ) ? $awb_options['breakpoint'] : '600';
    $distance_from_bottom = isset( $awb_options['distance_from_bottom'] ) && is_numeric( $awb_options['distance_from_bottom'] ) ? $awb_options['distance_from_bottom'] : '10';
    $distance_from_bottom_mu = isset( $awb_options['distance_from_bottom_mu'] ) ? $awb_options['distance_from_bottom_mu'] : '%'; 
    $button_bg_color = !empty( $awb_options['button_bg_color'] ) ? $awb_options['button_bg_color'] : '#20B038';
    $button_text_color = !empty( $awb_options['button_text_color'] ) ? $awb_options['button_text_color'] : '#ffffff';
    $button_location = isset( $awb_options['button_location'] ) ? $awb_options['button_location'] : 'right';
    $wp_text_direction = is_rtl() ? 'rtl' : 'ltr';

	ob_start();
	?>
	
    <style type="text/css">     
        <?php if( isset($awb_options['enable_breakpoint']) ) { ?>
            @media only screen and (min-width: <?php echo $breakpoint.'px'; ?>) {
				.wab-cont {
					display: none;
				}
			}
        <?php } ?>

        /* Side Rectangle */

        .wab-side-rectangle .wab-pull-right {
            right: 0;
            left: initial !important;
        }

        .wab-side-rectangle .wab-pull-left {
            left: 0;
            right: initial !important;
        }

        .wab-side-rectangle.wab-cont {
            position: fixed;
            <?php echo $button_location; ?>: 0;
            bottom: <?php echo $distance_from_bottom; echo $distance_from_bottom_mu; ?>;
            z-index: 99997;
        }
        
        .wab-side-rectangle #whatsAppButton {
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
            padding: 10px 14px;
            margin: 0 auto 0 auto;
            background: <?php echo $button_bg_color; ?>;
            -webkit-transition: All 0.5s ease;
            -moz-transition: All 0.5s ease;
            -o-transition: All 0.5s ease;
            -ms-transition: All 0.5s ease;
            transition: All 0.5s ease;
        }
        
        .wab-side-rectangle #whatsAppButton:after {
            margin-left: 5px;
            margin-right: 5px;
            /* content: url(/wp-content/themes/html5blanknew/img/whatsapp-logo2.svg); */
            max-width: 20px;
            max-height: 20px;
            fill: currentColor;
        }

        .wab-side-rectangle #whatsAppButton svg path {
            fill: #fff;
        }

        /* Bottom Rectangle */

        .wab-bottom-rectangle.wab-cont {
            position: fixed;
            bottom: 0;
            z-index: 99999;
            width: 100%;
        }

        .wab-bottom-rectangle #whatsAppButton {
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
        
        .wab-icon-styled.wab-cont, .wab-icon-plain.wab-cont {
            position: fixed;
            <?php echo $button_location; ?>: 10px;
            bottom: <?php echo $distance_from_bottom; echo $distance_from_bottom_mu; ?>;
            z-index: 99999;
            height: 80px;
            width: 80px;
        }

        .wab-icon-styled #whatsAppButton, .wab-icon-plain #whatsAppButton {
            display: block;
            width: 80px;
            height: 80px;
            background-position: center center;
            background-size: cover;
        }
        .wab-icon-styled.wab-cont.wab-pull-left, .wab-icon-plain.wab-cont.wab-pull-left {
            left: 10px;
        }

        .wab-icon-styled.wab-cont.wab-pull-right, .wab-icon-plain.wab-cont.wab-pull-right {
            right: 10px;
        }

        /* .wab-icon-styled.wab-pull-left #whatsAppButton {
            background-image: url(<?php //echo plugins_url( '/', UDI_awb__FILE__ ) . 'img/wa-icon-left.png'; ?>);
        }

        .wab-icon-styled.wab-pull-right #whatsAppButton {
            background-image: url(<?php //echo plugins_url( '/', UDI_awb__FILE__ ) . 'img/wa-icon-right.png'; ?>);
        } */

        .wab-icon-plain #whatsAppButton {
            background-image: url(<?php echo plugins_url( '/', UDI_awb__FILE__ ) . 'img/wa-icon-original.png'; ?>);
        }

        .awb-displaynone {
            display: none;
        }
	</style>

	<?php
	
	echo ob_get_clean();
}
add_action('wp_head', 'enqueue_awb_styles');

// Delete options when uninstalling (deleting) the plugin
function awb_delete_db_options() {
	delete_option('awb-options');
}
register_uninstall_hook(__FILE__, 'awb_delete_db_options');