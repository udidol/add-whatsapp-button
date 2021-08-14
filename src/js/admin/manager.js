import ModuleBase from './module-base.js';
import ColorPicker from './color-picker.js';
import SettingsHandler from './settings-handler.js';

class AdminManager extends ModuleBase {
	/**
	 * * Apply settings changes in the preview section
	 */
	 getSelectors() {
		return {
			submitButton: 'form #submit',
			generalSettingsTabButton: '#gstablink',
			designTabButton: '#bdtablink',
			generalSettingsTabContent: '#gstab',
			designTabContent: '#bdtab',
		};
	}

	initElements() {
		const selectors = this.getSelectors();

		this.elements = {
			$submitButton: jQuery( selectors.submitButton ),
			$generalSettingsTabButton: jQuery( selectors.generalSettingsTabButton ),
			$designTabButton: jQuery( selectors.designTabButton ),
			$generalSettingsTabContent: jQuery( selectors.generalSettingsTabContent ),
			$designTabContent: jQuery( selectors.designTabContent )
		};
	}

	initModules() {
		this.colorPicker = new ColorPicker();
		this.settingsHandler = new SettingsHandler();
	}

	init() {
		super.init();

		this.initModules();

		this.handleSettingsPageTabs();
	}

	bindEvents() {
		this.elements.$submitButton.on( 'keypress', ( event ) => this.preventSubmitOnEnter( event ) );
	}

	preventSubmitOnEnter( event ) {
		return event.which !== 13;
	}

	handleSettingsPageTabs() {
		 // Control Settings Tabs
		 this.elements.$generalSettingsTabButton.on( 'click', () => {
			if ( ! this.elements.$generalSettingsTabContent.hasClass('awb-tab-active') ) {
				this.elements.$generalSettingsTabContent.addClass('awb-tab-active');
				this.elements.$generalSettingsTabButton.addClass('nav-tab-active');
				this.elements.$designTabButton.removeClass('nav-tab-active');
				this.elements.$designTabContent.removeClass('awb-tab-active');
			}
		} );

		this.elements.$designTabButton.on( 'click', () => {
			if ( ! this.elements.$designTabContent.hasClass('awb-tab-active') ) {
				this.elements.$designTabContent.addClass('awb-tab-active');
				this.elements.$designTabButton.addClass('nav-tab-active');
				this.elements.$generalSettingsTabButton.removeClass('nav-tab-active');
				this.elements.$generalSettingsTabContent.removeClass('awb-tab-active');
			}
		} );
	}
}

jQuery( document ).ready( () => new AdminManager() );