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
			iconLabelGapInput: '#awb_settings\\[icon_label_gap\\]',
			iconLabelGapMuInput: 'select[name="awb_settings[icon_label_gap_mu]"]',
			iconLabelFontSizeInput: '#awb_settings\\[icon_label_font_size\\]',
			iconLabelFontSizeMuInput: 'select[name="awb_settings[icon_label_font_size_mu]"]',
			iconLabelPaddingInput: '#awb_settings\\[icon_label_padding\\]',
			iconLabelPaddingMuInput: 'select[name="awb_settings[icon_label_padding_mu]"]',
			iconLabelRadiusInput: '#awb_settings\\[icon_label_radius\\]',
			iconLabelRadiusMuInput: 'select[name="awb_settings[icon_label_radius_mu]"]',
			iconLabelShadowCheckbox: '#awb_settings\\[icon_label_shadow\\]',
			iconWrapperPaddingInput: '#awb_settings\\[icon_wrapper_padding\\]',
			iconWrapperPaddingMuInput: 'select[name="awb_settings[icon_wrapper_padding_mu]"]',
			iconWrapperRadiusInput: '#awb_settings\\[icon_wrapper_radius\\]',
			iconWrapperRadiusMuInput: 'select[name="awb_settings[icon_wrapper_radius_mu]"]',
			iconWrapperShadowCheckbox: '#awb_settings\\[icon_wrapper_shadow\\]',
			iconWrapperAlignSelect: '#awb_settings\\[icon_wrapper_align\\]',
			rectSizeRows: '.rect-size-setting-row',
			rectWidthInput: '#awb_settings\\[rect_width\\]',
			rectWidthMuInput: 'select[name="awb_settings[rect_width_mu]"]',
			rectHeightInput: '#awb_settings\\[rect_height\\]',
			rectHeightMuInput: 'select[name="awb_settings[rect_height_mu]"]',
			rectPaddingInput: '#awb_settings\\[rect_padding\\]',
			rectPaddingMuInput: 'select[name="awb_settings[rect_padding_mu]"]',
			rectFontSizeInput: '#awb_settings\\[rect_font_size\\]',
			rectFontSizeMuInput: 'select[name="awb_settings[rect_font_size_mu]"]',
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
			$iconLabelGapInput: jQuery( selectors.iconLabelGapInput ),
			$iconLabelGapMuInput: jQuery( selectors.iconLabelGapMuInput ),
			$iconLabelFontSizeInput: jQuery( selectors.iconLabelFontSizeInput ),
			$iconLabelFontSizeMuInput: jQuery( selectors.iconLabelFontSizeMuInput ),
			$iconLabelPaddingInput: jQuery( selectors.iconLabelPaddingInput ),
			$iconLabelPaddingMuInput: jQuery( selectors.iconLabelPaddingMuInput ),
			$iconLabelRadiusInput: jQuery( selectors.iconLabelRadiusInput ),
			$iconLabelRadiusMuInput: jQuery( selectors.iconLabelRadiusMuInput ),
			$iconLabelShadowCheckbox: jQuery( selectors.iconLabelShadowCheckbox ),
			$iconWrapperPaddingInput: jQuery( selectors.iconWrapperPaddingInput ),
			$iconWrapperPaddingMuInput: jQuery( selectors.iconWrapperPaddingMuInput ),
			$iconWrapperRadiusInput: jQuery( selectors.iconWrapperRadiusInput ),
			$iconWrapperRadiusMuInput: jQuery( selectors.iconWrapperRadiusMuInput ),
			$iconWrapperShadowCheckbox: jQuery( selectors.iconWrapperShadowCheckbox ),
			$iconWrapperAlignSelect: jQuery( selectors.iconWrapperAlignSelect ),
			$rectSizeRows: jQuery( selectors.rectSizeRows ),
			$rectWidthInput: jQuery( selectors.rectWidthInput ),
			$rectWidthMuInput: jQuery( selectors.rectWidthMuInput ),
			$rectHeightInput: jQuery( selectors.rectHeightInput ),
			$rectHeightMuInput: jQuery( selectors.rectHeightMuInput ),
			$rectPaddingInput: jQuery( selectors.rectPaddingInput ),
			$rectPaddingMuInput: jQuery( selectors.rectPaddingMuInput ),
			$rectFontSizeInput: jQuery( selectors.rectFontSizeInput ),
			$rectFontSizeMuInput: jQuery( selectors.rectFontSizeMuInput ),
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
		this.elements.$iconLabelGapInput.on( 'input', () => this.updateIconWrapperStyle() );
		this.elements.$iconLabelGapMuInput.on( 'change', () => this.updateIconWrapperStyle() );
		this.elements.$iconLabelFontSizeInput.on( 'input', () => this.updateIconLabelStyle() );
		this.elements.$iconLabelFontSizeMuInput.on( 'change', () => this.updateIconLabelStyle() );
		this.elements.$iconLabelPaddingInput.on( 'input', () => this.updateIconLabelStyle() );
		this.elements.$iconLabelPaddingMuInput.on( 'change', () => this.updateIconLabelStyle() );
		this.elements.$iconLabelRadiusInput.on( 'input', () => this.updateIconLabelStyle() );
		this.elements.$iconLabelRadiusMuInput.on( 'change', () => this.updateIconLabelStyle() );
		this.elements.$iconLabelShadowCheckbox.on( 'change', () => this.updateIconLabelStyle() );
		this.elements.$iconWrapperPaddingInput.on( 'input', () => this.updateIconWrapperStyle() );
		this.elements.$iconWrapperPaddingMuInput.on( 'change', () => this.updateIconWrapperStyle() );
		this.elements.$iconWrapperRadiusInput.on( 'input', () => this.updateIconWrapperStyle() );
		this.elements.$iconWrapperRadiusMuInput.on( 'change', () => this.updateIconWrapperStyle() );
		this.elements.$iconWrapperShadowCheckbox.on( 'change', () => this.updateIconWrapperStyle() );
		this.elements.$iconWrapperAlignSelect.on( 'change', () => this.updatePreviewLabelPosition() );
		this.elements.$rectWidthInput.on( 'input', () => this.updateRectSize() );
		this.elements.$rectWidthMuInput.on( 'change', () => this.updateRectSize() );
		this.elements.$rectHeightInput.on( 'input', () => this.updateRectSize() );
		this.elements.$rectHeightMuInput.on( 'change', () => this.updateRectSize() );
		this.elements.$rectPaddingInput.on( 'input', () => this.updateRectSize() );
		this.elements.$rectPaddingMuInput.on( 'change', () => this.updateRectSize() );
		this.elements.$rectFontSizeInput.on( 'input', () => this.updateRectSize() );
		this.elements.$rectFontSizeMuInput.on( 'change', () => this.updateRectSize() );
	}

	init() {
		super.init();
		if ( this.isIconLabelEnabled() ) {
			this.updatePreviewLabelPosition();
			this.updateIconLabelStyle();
			this.updateIconWrapperStyle();
		}
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
			this.updateIconLabelStyle();
			this.updateIconWrapperStyle();
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
		const alignItems = this.elements.$iconWrapperAlignSelect.val() || 'center';
		const gap = this.elements.$iconLabelGapInput.val() + this.elements.$iconLabelGapMuInput.val();

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

		this.elements.$buttonContainer.css( { display: 'flex', 'flex-direction': flexDirection, 'align-items': alignItems, gap: gap } );
	}

	updateIconLabelStyle() {
		const fontSize = this.elements.$iconLabelFontSizeInput.val();
		const fontSizeMu = this.elements.$iconLabelFontSizeMuInput.val();
		const padding = this.elements.$iconLabelPaddingInput.val();
		const paddingMu = this.elements.$iconLabelPaddingMuInput.val();
		const radius = this.elements.$iconLabelRadiusInput.val();
		const radiusMu = this.elements.$iconLabelRadiusMuInput.val();
		const shadowEnabled = this.elements.$iconLabelShadowCheckbox.is( ':checked' );

		this.elements.$iconLabelText.css( {
			'font-size': fontSize ? fontSize + fontSizeMu : '',
			'padding': padding > 0 ? padding + paddingMu : '',
			'border-radius': radius > 0 ? radius + radiusMu : '',
			'box-shadow': shadowEnabled ? '0 2px 8px rgba(0,0,0,0.3)' : 'none'
		} );
	}

	updateIconWrapperStyle() {
		const padding = this.elements.$iconWrapperPaddingInput.val();
		const paddingMu = this.elements.$iconWrapperPaddingMuInput.val();
		const radius = this.elements.$iconWrapperRadiusInput.val();
		const radiusMu = this.elements.$iconWrapperRadiusMuInput.val();
		const shadowEnabled = this.elements.$iconWrapperShadowCheckbox.is( ':checked' );
		const gap = this.elements.$iconLabelGapInput.val();
		const gapMu = this.elements.$iconLabelGapMuInput.val();

		this.elements.$buttonContainer.css( {
			'padding': padding > 0 ? padding + paddingMu : '',
			'border-radius': radius > 0 ? radius + radiusMu : '',
			'box-shadow': shadowEnabled ? '0 2px 8px rgba(0,0,0,0.3)' : 'none',
			'gap': gap ? gap + gapMu : ''
		} );
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

		const isIcon = ( 'wab-icon-plain' === selectedValue );
		const isRect = ( 'wab-side-rectangle' === selectedValue || 'wab-bottom-rectangle' === selectedValue );

		if ( isIcon ) {
			this.elements.$buttonText.addClass( this.selectors.displayNone );
			this.elements.$iconSizeSettingRow.removeClass( this.selectors.displayNone );
			this.elements.$iconLabelEnableRow.removeClass( this.selectors.displayNone );
			this.elements.$rectSizeRows.addClass( this.selectors.displayNone );
			this.elements.$whatsAppButton.css( 'background-color', '' );
		} else {
			this.elements.$buttonText.removeClass( this.selectors.displayNone );
			this.elements.$iconSizeSettingRow.addClass( this.selectors.displayNone );
			this.elements.$iconLabelEnableRow.addClass( this.selectors.displayNone );
			this.elements.$iconLabelRows.addClass( this.selectors.displayNone );
			this.elements.$iconLabelText.addClass( this.selectors.displayNone );
			this.elements.$buttonContainer.css( { display: '', 'flex-direction': '', 'align-items': '' } );
			this.elements.$rectSizeRows.toggleClass( this.selectors.displayNone, ! isRect );
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

	updateRectSize() {
		const width = this.elements.$rectWidthInput.val();
		const height = this.elements.$rectHeightInput.val();
		const padding = this.elements.$rectPaddingInput.val();
		const fontSize = this.elements.$rectFontSizeInput.val();

		this.elements.$whatsAppButton.css( 'width', width ? width + this.elements.$rectWidthMuInput.val() : '' );
		this.elements.$whatsAppButton.css( 'height', height ? height + this.elements.$rectHeightMuInput.val() : '' );
		this.elements.$whatsAppButton.css( 'padding', padding ? padding + this.elements.$rectPaddingMuInput.val() : '' );
		this.elements.$whatsAppButton.css( 'font-size', fontSize ? fontSize + this.elements.$rectFontSizeMuInput.val() : '' );
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
