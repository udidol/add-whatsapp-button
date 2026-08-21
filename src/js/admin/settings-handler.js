import ModuleBase from '../shared/module-base.js';

export default class SettingsHandler extends ModuleBase {
	getSelectors() {
		return {
			whatsAppbuttonContainer: '#admin_wab_cont',
			buttonText: '#wab-text',
			iconLabelText: '#wab-icon-label',
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
			limitDaysCheckbox: '#awb_settings\\[limit_days\\]',
			limitDaysContainer: '#awb_limit_days',
			defaultMessageCheckbox: '#awb_settings\\[enable_message\\]',
			defaultMessageContainer: '#awb_enable_message',
			buttonBackground: '#awb_settings\\[button_bg_color\\]',
			buttonTextColor: '#awb_settings\\[button_text_color\\]',
			buttonLocationSelect: '#awb_settings\\[button_location\\]',
			distanceFromBottomInput: '#awb_settings\\[distance_from_bottom\\]',
			distanceFromBottomMeasurementUnitInput: '#awb_settings\\[distance_from_bottom_mu\\]',
			iconSizeSettingRow: '#iconSizeSettingRow',
			iconLabelEnableRow: '#iconLabelEnableRow',
			iconLabelEnableCheckbox: '#awb_settings\\[icon_label_enable\\]',
			iconLabelRows: '.icon-label-setting-row',
			iconLabelPositionSelect: '#awb_settings\\[icon_label_position\\]',
			displayNone: 'awb-hide'
		};
	}

	initElements() {
		const selectors = this.selectors;

		this.elements = {
			$buttonContainer: jQuery( selectors.whatsAppbuttonContainer ),
			$buttonText: jQuery( selectors.buttonText ),
			$iconLabelText: jQuery( selectors.iconLabelText ),
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
			$limitDaysCheckbox: jQuery( selectors.limitDaysCheckbox ),
			$limitDaysContainer: jQuery( selectors.limitDaysContainer ),
			$defaultMessageCheckbox: jQuery( selectors.defaultMessageCheckbox ),
			$defaultMessageContainer: jQuery( selectors.defaultMessageContainer ),
			$buttonBackground: jQuery( selectors.buttonBackground ),
			$buttonTextColor: jQuery( selectors.buttonTextColor ),
			$buttonLocationSelect: jQuery( selectors.buttonLocationSelect ),
			$distanceFromBottomInput: jQuery( selectors.distanceFromBottomInput ),
			$distanceFromBottomMeasurementUnitInput: jQuery( selectors.distanceFromBottomMeasurementUnitInput ),
			$iconSizeSettingRow: jQuery( selectors.iconSizeSettingRow ),
			$iconLabelEnableRow: jQuery( selectors.iconLabelEnableRow ),
			$iconLabelEnableCheckbox: jQuery( selectors.iconLabelEnableCheckbox ),
			$iconLabelRows: jQuery( selectors.iconLabelRows ),
			$iconLabelPositionSelect: jQuery( selectors.iconLabelPositionSelect ),
			$whatsAppButton: jQuery( selectors.whatsAppButton )
		};
	}

	bindEvents() {
		this.elements.$buttonIconSizeInput.on( 'input', () => this.updateIconSize() );
		this.elements.$buttonIconSizeMeasurementUnitInput.on( 'change', () => this.updateIconSize() );
		this.elements.$buttonTypeSelect.on( 'change', () => this.updateButtonType() );
		this.elements.$buttonTextInput.on( 'keyup', () => this.updatePreviewText() );
		this.elements.$breakpointCheckbox.on( 'change', () => this.elements.$breakpointContainer.toggleClass( 'awb-hide' ) );
		this.elements.$hideButtonCheckbox.on( 'change', () => this.elements.$hideButtonContainer.toggleClass( 'awb-hide' ) );
		this.elements.$limitHoursCheckbox.on( 'change', () => this.elements.$limitHoursContainer.toggleClass( 'awb-hide' ) );
		this.elements.$limitDaysCheckbox.on( 'change', () => this.elements.$limitDaysContainer.toggleClass( 'awb-hide' ) );
		this.elements.$defaultMessageCheckbox.on( 'change', () => this.elements.$defaultMessageContainer.toggleClass( 'awb-hide' ) );
		this.elements.$buttonBackground.on( 'change', () => {
			if ( this.elements.$buttonTypeSelect.val() === 'wab-icon-plain' ) {
				return;
			}
			this.elements.$whatsAppButton.css( 'background-color', this.elements.$buttonBackground.val() );
		} );
		this.elements.$buttonTextColor.on( 'change', () => this.updateButtonTextColor() );
		this.elements.$buttonLocationSelect.on( 'change', () => this.updateButtonLocation() );
		this.elements.$distanceFromBottomInput.on( 'change', () => this.updateDistanceFromBottom() );
		this.elements.$distanceFromBottomMeasurementUnitInput.on( 'change', () => this.updateDistanceFromBottom() );
		this.elements.$iconLabelEnableCheckbox.on( 'change', () => this.toggleIconLabelRows() );
		this.elements.$iconLabelPositionSelect.on( 'change', () => this.updatePreviewLabelPosition() );
	}

	isIconType() {
		return this.elements.$buttonTypeSelect.val() === 'wab-icon-plain';
	}

	isIconLabelEnabled() {
		return this.isIconType() && this.elements.$iconLabelEnableCheckbox.is( ':checked' );
	}

	updatePreviewText() {
		const text = this.elements.$buttonTextInput.val();
		if ( this.isIconLabelEnabled() ) {
			this.elements.$iconLabelText.html( text );
		} else {
			this.elements.$buttonText.html( text );
		}
	}

	toggleIconLabelRows() {
		const labelEnabled = this.elements.$iconLabelEnableCheckbox.is( ':checked' );
		this.elements.$iconLabelRows.toggleClass( 'awb-hide', ! labelEnabled );
		this.elements.$iconLabelText.toggleClass( 'awb-hide', ! labelEnabled );
		this.elements.$buttonContainer.toggleClass( 'icon-label-active', labelEnabled );
		if ( labelEnabled ) {
			this.updatePreviewLabelPosition();
		} else {
			this.elements.$buttonContainer.css( { display: '', 'flex-direction': '', 'align-items': '', gap: '' } );
		}
	}

	updatePreviewLabelPosition() {
		if ( ! this.isIconLabelEnabled() ) {
			return;
		}
		const position = this.elements.$iconLabelPositionSelect.val();
		const location = this.elements.$buttonLocationSelect.val();

		let flexDirection;
		if ( position === 'above' ) {
			flexDirection = 'column-reverse';
		} else if ( position === 'below' ) {
			flexDirection = 'column';
		} else if ( position === 'start' ) {
			flexDirection = ( location === 'right' ) ? 'row-reverse' : 'row';
		} else {
			flexDirection = ( location === 'right' ) ? 'row' : 'row-reverse';
		}

		this.elements.$buttonContainer.css( { display: 'flex', 'flex-direction': flexDirection, 'align-items': 'center' } );
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
			this.elements.$buttonText.addClass( this.selectors.displayNone );
			this.elements.$iconSizeSettingRow.removeClass( this.selectors.displayNone );
			this.elements.$iconLabelEnableRow.removeClass( this.selectors.displayNone );
			this.elements.$whatsAppButton.css( 'background-color', '' );
		} else {
			this.elements.$buttonText.removeClass( this.selectors.displayNone );
			this.elements.$iconSizeSettingRow.addClass( this.selectors.displayNone );
			this.elements.$iconLabelEnableRow.addClass( this.selectors.displayNone );
			this.elements.$iconLabelRows.addClass( this.selectors.displayNone );
			this.elements.$iconLabelText.addClass( this.selectors.displayNone );
			this.elements.$buttonContainer.css( { display: '', 'flex-direction': '', 'align-items': '' } );
			if ( this.elements.$buttonBackground.val() ) {
				this.elements.$whatsAppButton.css( 'background-color', this.elements.$buttonBackground.val() );
			} else {
				this.elements.$whatsAppButton.css( 'background-color', '#20B038' );
			}
		}

		if ( 'wab-bottom-rectangle' === selectedValue ) {
			this.elements.$buttonContainer.css( 'bottom', '' );
		}
	}

	updateButtonText() {
		if ( ! this.elements.$whatsAppButton.length ) {
			this.elements.$whatsAppButton = jQuery( this.selectors.whatsAppButton );
		}

		this.elements.$whatsAppButton.html( this.elements.$buttonTextInput.value );
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
		if ( this.isIconLabelEnabled() ) {
			this.updatePreviewLabelPosition();
		}
	}

	updateDistanceFromBottom() {
		this.elements.$buttonContainer.css( 'bottom', this.elements.$distanceFromBottomInput.val() + this.elements.$distanceFromBottomMeasurementUnitInput.val() );
	}
}
