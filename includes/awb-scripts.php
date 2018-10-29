<?php

// Add our scripts

function awb_add_scripts() {
    global $awb_plugin_folder;
    global $awb_options;

    wp_enqueue_script('wab-main-script', plugins_url() . '/' . $awb_plugin_folder . '/js/main.js', array('jquery'));

    // Give the startHour and endHour variables default values
    $startHour = !empty($awb_options['startHour']) ? $awb_options['startHour'] : '8';
    $endHour = !empty($awb_options['endHour']) ? $awb_options['endHour'] : '22';
    $awb_limitHours = !empty($awb_options['limit_hours']) ? $awb_options['limit_hours'] : 0;

    // Create an array of the data we want to pass to the JS script
    $dataToBePassed = array(
        'startHour'  => $startHour,
        'endHour'    => $endHour,
        'limitHours' => $awb_limitHours
    );

    wp_localize_script('wab-main-script', 'php_vars', $dataToBePassed);
}

add_action('wp_enqueue_scripts', 'awb_add_scripts');

// Enqueue jQuery-UI draggable functionality + Touch Punch for Mobile Support
function enqueue_jquery_ui_draggable() {
    global $awb_plugin_folder;

	wp_enqueue_script( 'jquery_draggable', plugins_url() . '/' . $awb_plugin_folder . '/js/jquery-ui.drag.min.js', array('jquery'));
	wp_enqueue_script( 'jquery_touch_punch', plugins_url() . '/' . $awb_plugin_folder . '/js/jquery.ui.touch-punch.min.js', array('jquery'));
	
}
add_action('wp_enqueue_scripts', 'enqueue_jquery_ui_draggable');

//Enqueue device mockup style in Admin area only
function enqueue_device_mockups_in_admin() {
    global $awb_plugin_folder;

    if ( is_rtl() ) {
        wp_enqueue_style('device-mockups', plugins_url() . '/' . $awb_plugin_folder . '/css/awb-admin-styles-rtl.css');
    }
    else {
        wp_enqueue_style('device-mockups', plugins_url() . '/' . $awb_plugin_folder . '/css/awb-admin-styles.css');
    }
    
}
add_action( 'admin_enqueue_scripts', 'enqueue_device_mockups_in_admin' );
