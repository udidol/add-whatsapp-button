=== Add WhatsApp Button ===
Contributors: udidol
Tags: whatsapp, button, whatsapp button
Requires at least: 4.6
Tested up to: 4.9.8
Stable tag: 1.0.2
Requires PHP: 5.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Add WhatsApp Button enables adding a customizeable click-to-chat WhatsApp button.
The plugin lets you choose between a simple WhatsApp icon and a rectangle with a custom text label.

== Description ==

Add WhatsApp Button enables adding a customizable click-to-chat WhatsApp button.
The plugin lets you choose between a simple WhatsApp icon and a rectangle with a custom text label (see screenshots).

== Screenshots ==

1. The "General Settings" tab in the plugin settings page
2. The "Button Design" tab in the plugin settings page
3. An example of the side-floating rectangle button design. You can customize the text on the button, as well as the button's background and text colors, in the "Button Design" tab.
4. An example of the plain WhatsApp icon that can be used as the floating button
5. An example of a fixed button anchored in the bottom of the page
 

== Usage == 

To enable the WhatsApp button, check the first checkbox in the settings page. You will find the settings page in the admin dashboard menu, under Settings->Add WhatsApp Button.

You must enter an international phone number (only numbers, **NO plus sign (+), NO dashes(-)**) in order to enable the WhatsApp button. Even if you manage to save settings into the database without entering a phone number, your button might not work properly.

The plugin settings page has two tabs: "General Settings" and "Button Design".

*The General Settings tab* includes options such as limiting the button to only display under a certain screen resolution (in pixels), attaching a default message that will be populated in the user's phone when they click the button, and more.

*The Button Design tab* includes controls for the button color, label text color, button type (side-bearing rectangle, WhatsApp icon, fixed-bottom button), and more. The Button Design tab also includes a smartphone mockup with a **live** preview screen, enabling you to see a real-time (estimated) rendering of how your button would look, on the fly, as you are changing its design.

The plugin detects whether the site visitor is using a desktop or mobile device and serves a different link for each accordingly.

== Installation ==

1. Upload the plugin files (the contents of add-whatsapp-button.zip) to the `/wp-content/plugins/add-whatsapp-button` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. On the WordPress Admin menu, go to Settings->Add WhatsApp Button to configure the plugin

== Frequently Asked Questions ==

= I see there is a setting for limiting the display hours for the WhatsApp button. What timezone does the plugin use for this setting? =

*Add WhatsApp Button* uses Javascript to check the time on the client's device. So it will be displayed/hidden according to the set time in each client's timezone.

== Changelog ==
 
= 1.0.1 =
* Fixed a bug with identification of the User Agent in Apple mobile devices
 
== Upgrade Notice ==
 
= 1.0.1 =
The bug fixed in this release prevented the plugin from working properly in Apple mobile devices. Please Upgrade