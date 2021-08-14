import ModuleBase from './module-base.js';

export default class SettingsHandler extends ModuleBase {
	getSelectors() {
		return {
			whatsAppbuttonContainer: '#admin_wab_cont',
			buttonText: '#wab-text',
			buttonTypeSelect: '#awb_settings\\[button_type\\]',
			whatsAppButton: '#whatsAppButton',
			buttonIconSizeInput: '#awb_settings\\[icon_size\\]',
			buttonIconSizeMeasurementUnitInput: '#awb_settings\\[icon_size_mu\\]',
			buttonTextInput: '#awb_settings\\[button_text\\]',
			breakpointCheckbox: '#awb_settings\\[enable_breakpoint\\]',
			breakpointContainer: '#awb_breakpoint',
			hideButtonCheckbox: '#awb_settings\\[enable_hide_button\\]',
			hideButtonContainer: '#awb_hide_button',
			limitHoursCheckbox: '#awb_settings\\[limit_hours\\]',
			limitHoursContainer: '#awb_limit_hours',
			defaultMessageCheckbox: '#awb_settings\\[enable_message\\]',
			defaultMessageContainer: '#awb_enable_message',
			buttonBackground: '#awb_settings\\[button_bg_color\\]',
			buttonTextColor: '#awb_settings\\[button_text_color\\]',
			buttonLocationSelect: '#awb_settings\\[button_location\\]',
			distanceFromBottomInput: '#awb_settings\\[distance_from_bottom\\]',
			distanceFromBottomMeasurementUnitInput: '#awb_settings\\[distance_from_bottom_mu\\]',
			iconSizeSettingRow: '#iconSizeSettingRow',
			displayNone: 'awb-hide'
		};
	}

	initElements() {
		const selectors = this.selectors;

		this.elements = {
			$buttonContainer: jQuery( selectors.whatsAppbuttonContainer ),
			$buttonText: jQuery( selectors.buttonText ),
			$buttonTypeSelect: jQuery( selectors.buttonTypeSelect ),
			$buttonIconSizeInput: jQuery( selectors.buttonIconSizeInput ),
			$buttonIconSizeMeasurementUnitInput: jQuery( selectors.buttonIconSizeMeasurementUnitInput ),
			$buttonTextInput: jQuery( selectors.buttonTextInput ),
			$breakpointCheckbox: jQuery( selectors.breakpointCheckbox ),
			$breakpointContainer: jQuery( selectors.breakpointContainer ),
			$hideButtonCheckbox: jQuery( selectors.hideButtonCheckbox ),
			$hideButtonContainer: jQuery( selectors.hideButtonContainer ),
			$limitHoursCheckbox: jQuery( selectors.limitHoursCheckbox ),
			$limitHoursContainer: jQuery( selectors.limitHoursContainer ),
			$defaultMessageCheckbox: jQuery( selectors.defaultMessageCheckbox ),
			$defaultMessageContainer: jQuery( selectors.defaultMessageContainer ),
			$buttonBackground: jQuery( selectors.buttonBackground ),
			$buttonTextColor: jQuery( selectors.buttonTextColor ),
			$buttonLocationSelect: jQuery( selectors.buttonLocationSelect ),
			$distanceFromBottomInput: jQuery( selectors.distanceFromBottomInput ),
			$distanceFromBottomMeasurementUnitInput: jQuery( selectors.distanceFromBottomMeasurementUnitInput ),
			$iconSizeSettingRow: jQuery( selectors.iconSizeSettingRow ),
			$whatsAppButton: jQuery( selectors.whatsAppButton )
		};
	}

	bindEvents() {
		// Update icon size according to the size input.
		this.elements.$buttonIconSizeInput.on( 'input', () => this.updateIconSize() );
		// Update icon size according to the selected measurement unit.
		this.elements.$buttonIconSizeMeasurementUnitInput.on( 'change', () => this.updateIconSize() );
		// Change the button in the preview according to the selected button type.
		this.elements.$buttonTypeSelect.on( 'change', () => this.updateButtonType() );
		// Update button text in the preview in real time according to input value.
		this.elements.$buttonTextInput.on( 'keyup', () => this.elements.$whatsAppButton.html( this.elements.$buttonTextInput.val() ) )
		// Display breakpoint input box if breakpoint checkbox is checked, hide otherwise.
		this.elements.$breakpointCheckbox.on( 'change', () => this.elements.$breakpointContainer.toggleClass( 'awb-hide' ) );
		// Display button hide options (radio buttons) box if the 'Hide Button' checkbox is checked, hide otherwise.
		this.elements.$hideButtonCheckbox.on( 'change', () => this.elements.$hideButtonContainer.toggleClass( 'awb-hide' ) );
		// Display 'Display Times' input boxes if the "Limit Display Time" checkbox is checked, hide otherwise.
		this.elements.$limitHoursCheckbox.on( 'change', () => this.elements.$limitHoursContainer.toggleClass( 'awb-hide' ) );
		// Display Default Message Textarea if the "Default Message" checkbox is checked, hide otherwise.
		this.elements.$defaultMessageCheckbox.on( 'change', () => this.elements.$defaultMessageContainer.toggleClass( 'awb-hide' ) );
		// Update the whatsApp button's background color according to the color picker value.
		this.elements.$buttonBackground.on( 'change', () => this.elements.$whatsAppButton.css( 'background-color', this.elements.$buttonBackground.val() ) );
		// Update the button's text color in the preview when the color picker value changes.
		this.elements.$buttonTextColor.on( 'change',  () => this.updateButtonTextColor() );
		// Control the button location on the preview mockup.
		this.elements.$buttonLocationSelect.on( 'change', () => this.updateButtonLocation() );
		// Change button's distance from bottom (and whether it is determined by % or px)
		this.elements.$distanceFromBottomInput.on( 'change', () => this.updateDistanceFromBottom() );
		this.elements.$distanceFromBottomMeasurementUnitInput.on( 'change', () => this.updateDistanceFromBottom() );
	}

	updateIconSize() {
		if ( 'wab-icon-plain' !== this.elements.$buttonTypeSelect.val() ) {
			return;
		}
	
		const size = this.elements.$buttonIconSizeInput.val() + this.elements.$buttonIconSizeMeasurementUnitInput.val();
	
		this.elements.$whatsAppButton.css( 'width', size );
		this.elements.$whatsAppButton.css( 'height', size );
	}

	updateButtonType() {
		const selectedValue = this.elements.$buttonTypeSelect.val();

		this.elements.$buttonContainer.removeClass( 'wab-side-rectangle wab-bottom-rectangle wab-icon-plain' );
		this.elements.$buttonContainer.addClass( selectedValue );
		
		if ( 'wab-icon-plain' === selectedValue ) {
			// Hide the button text if the button is an icon.
			this.elements.$buttonText.addClass( this.selectors.displayNone );
			// Show the icon size control if the button is an icon.
			this.elements.$iconSizeSettingRow.removeClass( this.selectors.displayNone );
		} else {
			// Show the button text if the nutton is not an icon.
			this.elements.$buttonText.removeClass( this.selectors.displayNone );
			// Hide the icon size setting if the button is not an icon.
			this.elements.$iconSizeSettingRow.addClass( this.selectors.displayNone );
		}

		if ( 'wab-bottom-rectangle' === selectedValue ) {
			this.elements.$buttonContainer.css( 'bottom', '' );
		}
	}

	updateButtonText() {
		if ( ! this.elements.$whatsAppButton.length ) {
			this.elements.$whatsAppButton = jQuery( this.selectors.whatsAppButton );
		}

		this.elements.$whatsAppButton.html( this.elements.$buttonTextInput.value )
	}

	updateButtonTextColor() {
		if ( this.elements.$buttonTextColor.value ) {
			this.elements.$whatsAppButton.css( 'color', this.elements.$buttonTextColor.value );
		} else {
			this.elements.$whatsAppButton.css( 'color', '#ffffff' );
		}
	}

	updateButtonLocation() {
		if ( this.elements.$buttonLocationSelect.val() == 'right' ) {
			this.elements.$buttonContainer.addClass( 'wab-pull-right' );
			this.elements.$buttonContainer.removeClass( 'wab-pull-left' );
		} else if ( this.elements.$buttonLocationSelect.val() == 'left' ) {
			this.elements.$buttonContainer.addClass( 'wab-pull-left' );
			this.elements.$buttonContainer.removeClass( 'wab-pull-right' );
		}
	}

	updateDistanceFromBottom() {
		this.elements.$buttonContainer.css( 'bottom', this.elements.$distanceFromBottomInput.val() + this.elements.$distanceFromBottomMeasurementUnitInput.val() );
	}
}