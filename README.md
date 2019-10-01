# Add Chat App Button

Add Chat App Button enables adding a customizeable click-to-chat WhatsApp button.
The plugin lets you choose between a simple WhatsApp icon and a rectangle with a custom text label.

## Description

To enable the WhatsApp button, check the first box in the settings page. You will find this settings page in the admin dashboard menu, under Settings->Add Chat App Button.

You must enter an international phone number (only numbers, **NO plus sign (+), NO dashes(-)**) in order to enable the WhatsApp button. Even if you manage to save settings into the database without entering a phone number, your button might not work properly.

The plugin settings page has two tabs: "General Settings" and "Button Design".

*The General Settings tab* includes options such as limiting the button to only display under a certain screen resolution (in pixels), attaching a default message that will be populated in the user's phone when they click the button, adding a small "hide" button on the WhatsApp button in order to allow site visitors to hide the button, and more.

*The Button Design tab* includes controls for the button color, label text color, button type (side-bearing rectangle, WhatsApp icon, fixed-bottom button), and more. The Button Design tab also includes a smartphone mockup with a **live** preview screen, enabling you to see a real-time (estimated) rendering of how your button would look, on the fly, as you are changing its design.

The plugin detects whether the site visitor is using a desktop or mobile device and serves a different link for each accordingly.

## Installation

### Method 1
1. Download the plugin zip file from https://wordpress.org/plugins/add-whatsapp-button/
2. Upload the plugin files (the contents of add-whatsapp-button.zip) to the `/wp-content/plugins/add-whatsapp-button` directory, or install the plugin through the WordPress plugins screen directly.
3. Activate the plugin through the 'Plugins' screen in WordPress
4. On the WordPress Admin menu, go to Settings->Add WhatsApp Button to configure the plugin

### Method 2
1. In your WordPress dashboard, go to Plugins > Add New
2. Search for "Add Chat App Button"
3. Find this plugin in the search results and click on "Install", and then "Activate".

## Frequently Asked Questions

- I see there is a setting for limiting the display hours for the WhatsApp button. What timezone does the plugin use for this setting?

*Add Chat App Button* uses Javascript to check the time on the client's device. So it will be displayed/hidden according to the set time in each client's timezone.
