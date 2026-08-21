=== Add Chat App Button ===
Contributors: udidol
Tags: whatsapp, button, whatsapp button
Tested up to: 7.1
Stable tag: 2.2
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Add Chat App Button enables adding a customizeable click-to-chat button that opens a chat on WhatsApp.
This plugin is not affiliated with WhatsApp or Facebook in any way, it just provides an easy way to integrate a WhatsApp chat button into your website.
The plugin lets you choose between a simple WhatsApp icon and a rectangle with a custom text label.

== Description ==

The *Add Chat App Button* plugin enables adding a customizable click-to-chat WhatsApp button.
The plugin lets you choose between a simple WhatsApp icon and a rectangle with a custom text label (see screenshots).

== Screenshots ==

1. The "General Settings" tab in the plugin settings page
2. The "Button Design" tab in the plugin settings page
3. An example of the side-floating rectangle button design. You can customize the text on the button, as well as the button's background and text colors, in the "Button Design" tab.
4. An example of the WhatsApp icon that can be used as the floating button
5. An example of a fixed button anchored in the bottom of the page
 
== Usage == 

To enable the WhatsApp button, check the first checkbox in the settings page. You will find the settings page in the admin dashboard menu, under Settings->Add Chat App Button.

You must enter an international phone number (only numbers, **NO plus sign (+), NO dashes(-)**) in order to enable the WhatsApp button. Even if you manage to save settings into the database without entering a phone number, your button might not work properly.

The plugin settings page has two tabs: "General Settings" and "Button Design".

*The General Settings tab* includes options such as limiting the button to only display under a certain screen resolution (in pixels), attaching a default message that will be populated in the user's phone when they click the button, and more.

*The Button Design tab* includes controls for the button color, label text color, button type (side-bearing rectangle, WhatsApp icon, fixed-bottom button), and more. The Button Design tab also includes a smartphone mockup with a **live** preview screen, enabling you to see a real-time (estimated) rendering of how your button would look, on the fly, as you are changing its design.

The plugin detects whether the site visitor is using a desktop or mobile device and serves a different link for each accordingly.

== Installation ==

1. Upload the plugin files (the contents of add-whatsapp-button.zip) to the `/wp-content/plugins/add-whatsapp-button` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. On the WordPress Admin menu, go to Settings->Add Chat App Button to configure the plugin

== Frequently Asked Questions ==

= I see there is a setting for limiting the display hours for the WhatsApp button. What timezone does the plugin use for this setting? =

*Add Chat App Button* uses Javascript to check the time on the client's device. So it will be displayed/hidden according to the set time in each client's timezone.

= Can I change the size of the rectangle-style button? =

Yes. When a rectangle style is selected in the Button Design tab, you will see width, height, padding, and font size controls. Leave any field empty to keep the default value. No custom CSS is required.

= The display-hours limit and the day-of-week limit — which timezone do they use? =

Both use the visitor's device clock, so they follow the visitor's local timezone. If your business hours are in a specific timezone, factor in the offset when setting the start and end hours.

= The "Add Hide Button" feature has a "Persistent" dismiss option. Does this use cookies? =

No. The persistent dismiss option stores a small flag in the visitor's browser `localStorage`, not in a cookie. The flag contains no personal data — only a marker indicating the visitor previously dismissed the button. If your site requires a cookie/privacy policy, you may want to mention this localStorage use.

== Changelog ==

= 2.2 =
* Added optional text label for the WhatsApp icon button style — supports above, below, left, and right positions relative to the icon, with controls for font size, padding, border radius, gap, background color, and drop shadow (Feature requests: [#1](https://wordpress.org/support/topic/feature-request-show-text-icon/), [#2](https://wordpress.org/support/topic/appreciate-if-you-could-add-button-text-for-default-whatsapp-icon-style-2/), [#3](https://wordpress.org/support/topic/insert-icon-in-button/))
* Added label wrapper styling — background color, padding, border radius, and drop shadow for the container that holds the icon and label together
* Added dismiss persistence — site owners can choose whether a visitor's button dismissal lasts for the current browser session or persists until the visitor clears site data ([feature request](https://wordpress.org/support/topic/feature-request-remember-hide-status/))
* Added day-of-week scheduling — restrict the button to specific days of the week, independently of the existing display-hours limit ([feature request](https://wordpress.org/support/topic/days-of-the-week-function/))
* Added breakpoint direction control — choose whether the breakpoint hides the button on screens narrower or wider than the set value, making it possible to show the button only on mobile ([feature request](https://wordpress.org/support/topic/how-can-i-hide-it-on-mobile/))
* Added width, height, padding, and font size controls for the rectangle button styles ([feature request](https://wordpress.org/support/topic/button-size-22/))
* Fixed the Button Design preview panel — now stays visible (sticky) while scrolling through settings on desktop
* Fixed icon label preview not updating live when changing font size, gap, padding, border radius, or drop shadow settings
* Fixed the Button Design tab content appearing below the General Settings tab content when General Settings was active
* Fixed dismissed button state not restoring correctly on page refresh when using the "Hide with toggle button" option

= 2.1.13 =
* Updated compatibility with WordPress 7.1
* Fixed the frontend script missing from the released package since 2.1.9, which broke the display hours limit, the hide/close button and button dragging

= 2.1.12 =
* Updated compatibility with WordPress 7.0.4

= 2.1.11 =
* Updated compatibility with WordPress 7.0.2

= 2.1.10 =
* Updated compatibility with WordPress 7.0

= 2.1.9 =
* Updated compatibility with WordPress 6.9.4
* Fixed some UI bugs in the button preview in admin settings.

= 2.1.7 =
* Security update.

= 2.1.6 =
* Updated compatibility with WordPress 6.7

= 2.1.5 =
* Added Settings page link in the Plugins page.

= 2.1.4 =
* Updated compatibility with WordPress 6.5.2

= 2.1.3 =
* Updated compatibility with WordPress 6.5

= 2.1.2 =
* Moved the button dragging functionality under a flag (admin setting)
* The dragging is now done by a small dragging handle instead of the entire button being draggable

= 2.1.1 =
* Fixed bug with limiting display hours

= 2.1.0 =
* Refactored all of the Javascript to ES6
* Fixed various bugs
* Updated compatibility with WordPress 6.4.1

= 2.0.5 =
* Updated compatibility with WordPress 6.0

= 2.0.3 =
* Updated compatibility with WordPress 5.9

= 2.0.2 =
* Updated compatibility with WordPress 5.8.2

= 2.0.0 =
* Complete PHP rewrite to use OOP and scoped methods instead of global functions.
* Bug fixes
* Updated compatibility with WordPress 5.8.0

= 1.2.1 =
* Bug fixes

= 1.2 =
* Changed plugin display name to comply with Facebook's trademark requirements
* Updated support for Wordpress 5.2.3

= 1.1.3 =
* Some bug fixes

= 1.1.1 =
* Updated support for WordPress 5.2

= 1.1.0 =
* Updated compatibility with WordPress 5.1.1
* Added a "Hide Button" option to the WhatsApp button. It adds a small button on the corner of the WhatsApp button that enables site visitors to hide the WhatsApp button if it bothers them. The "Hide Button" has two options: 
  * Full Remove: Completely remove the button from the page
  * Hide with Toggle Button: Slides the WhatsApp button to the side (outside page boundaries). This enables the site visitor to un-hide the WhatsApp button later, if they want.

= 1.0.4 =
* Updated compatibility with WordPress 5.1
* Minor bug fixes

= 1.0.3 =
* Updated compatibility with WordPress 5.0
* Minor bug fixes
 
= 1.0.2 =
* Minor bug fixes
 
= 1.0.1 =
* Fixed a bug with identification of the User Agent in Apple mobile devices
 
== Upgrade Notice ==
 
= 1.0.1 =
The bug fixed in this release prevented the plugin from working properly in Apple mobile devices. Please Upgrade