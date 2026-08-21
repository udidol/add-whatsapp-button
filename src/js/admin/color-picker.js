import ModuleBase from '../shared/module-base.js';

export default class ColorPicker extends ModuleBase {
	getSelectors() {
		return {
			backgroundColorPicker: '.udi-bg-color-picker',
			whatsAppButtonContainer: '#admin_wab_cont',
			whatsAppButton: '#whatsAppButton',
			textColorPicker: '.udi-text-color-picker',
			labelBgColorPicker: '.awb-label-bg-color-picker',
			wrapperBgColorPicker: '.awb-wrapper-bg-color-picker',
			iconLabelText: '#wab-icon-label',
			wpColorPicker: '.wp-color-picker',
		};
	}

	initElements() {
		const selectors = this.selectors;

		this.elements = {
			$backgroundColorPicker: jQuery( selectors.backgroundColorPicker ),
			$whatsAppButtonContainer: jQuery( selectors.whatsAppButtonContainer ),
			$whatsAppButton: jQuery( selectors.whatsAppButton ),
			$textColorPicker: jQuery( selectors.textColorPicker ),
			$labelBgColorPicker: jQuery( selectors.labelBgColorPicker ),
			$wrapperBgColorPicker: jQuery( selectors.wrapperBgColorPicker ),
			$iconLabelText: jQuery( selectors.iconLabelText ),
		};
	}

	init() {
		super.init();

		this.initColorPickers();
	}

	changeButtonBackgroundColor( color ) {
		if ( this.elements.$whatsAppButtonContainer.hasClass( 'wab-icon-plain')) {
			this.elements.$whatsAppButton.css( 'background-color', '' );
			return;
		}
		this.elements.$whatsAppButton.css( 'background-color', color );
	}

	initColorPickers() {
		const selectors = this.selectors;

		this.elements.$backgroundColorPicker.wpColorPicker( {
			defaultColor: '#20B038',
			/**
			 * Listen to a change in the color picker in order to update the button background in the preview screen with the picked color
			 *
			 * @param {Event} event - standard jQuery event, produced by whichever
			 * control was changed.
			 * @param {Object} ui - standard jQuery UI object, with a color member
			 * containing a Color.js object.
			 */
			change: ( event, ui ) => {
				this.changeButtonBackgroundColor( ui.color.toString() );
			},
		
			/**
			 * Listen in case the color picker is cleared, in order to update the button preview screen with the default color.
			 *
			 * @param {Event} event - standard jQuery event, produced by "Clear"
			 * button.
			 */
			clear: ( event ) => {
				const element = jQuery( event.target ).siblings( selectors.wpColorPicker )[0];
		
				if ( element ) {
					this.changeButtonBackgroundColor( '#20B038' );
				}
			}
		} );

		this.elements.$labelBgColorPicker.wpColorPicker( {
			defaultColor: '',
			change: ( event, ui ) => {
				this.elements.$iconLabelText.css( 'background-color', ui.color.toString() );
			},
			clear: () => {
				this.elements.$iconLabelText.css( 'background-color', '' );
			}
		} );

		this.elements.$wrapperBgColorPicker.wpColorPicker( {
			defaultColor: '',
			change: ( event, ui ) => {
				this.elements.$whatsAppButtonContainer.css( 'background-color', ui.color.toString() );
			},
			clear: () => {
				this.elements.$whatsAppButtonContainer.css( 'background-color', '' );
			}
		} );

		// Change text color in preview according to input
		this.elements.$textColorPicker.wpColorPicker( {
			defaultColor: '#ffffff',
			change: ( event, ui ) => {
				var color = ui.color.toString();
		
				this.elements.$whatsAppButton.css( 'color', color );
			},
		
			clear: ( event ) => {
				var element = jQuery(event.target).siblings( selectors.wpColorPicker )[0];
		
				if ( element ) {
					this.elements.$whatsAppButton.css( 'color', '#ffffff' );
				}
			}
		} );
	}
}